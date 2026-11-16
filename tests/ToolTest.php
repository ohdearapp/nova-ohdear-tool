<?php

use Laravel\Nova\Nova;
use OhDear\OhDearTool\OhDearTool;
use OhDear\PhpSdk\Requests\BrokenLinks\GetBrokenLinksRequest;
use OhDear\PhpSdk\Requests\CertificateHealth\GetCertificateHealthRequest;
use OhDear\PhpSdk\Requests\Checks\DisableCheckRequest;
use OhDear\PhpSdk\Requests\Checks\EnableCheckRequest;
use OhDear\PhpSdk\Requests\Checks\RequestCheckRunRequest;
use OhDear\PhpSdk\Requests\Downtime\GetDowntimeRequest;
use OhDear\PhpSdk\Requests\MixedContent\GetMixedContentRequest;
use OhDear\PhpSdk\Requests\Monitors\GetMonitorRequest;
use OhDear\PhpSdk\Requests\Uptime\GetUptimeRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

beforeEach(function () {
    $this->check = [
        'id' => 73,
        'type' => 'uptime',
        'label' => 'Uptime',
        'enabled' => true,
        'latest_run_result' => 'succeeded',
        'settings' => ['http_client_headers' => ['Authorization' => 'private-header']],
    ];

    $this->monitor = [
        'id' => 42,
        'team_id' => 3,
        'url' => 'https://example.com',
        'checks' => [$this->check],
        'crawler_headers' => ['Authorization' => 'private-header'],
    ];
});

it('returns only the configured monitor and public check data', function () {
    MockClient::global([
        GetMonitorRequest::class => MockResponse::make($this->monitor),
    ]);

    $this->getJson('/nova-vendor/ohdearapp/oh-dear-tool/monitor')
        ->assertOk()
        ->assertJsonPath('monitor.id', 42)
        ->assertJsonPath('monitor.checks.0.latest_run_result', 'succeeded')
        ->assertJsonMissingPath('monitor.crawlerHeaders')
        ->assertJsonMissingPath('monitor.checks.0.settings')
        ->assertDontSee('private-header');
});

it('protects every API endpoint with the registered tool visibility', function (string $method, string $path) {
    Nova::$tools = [(new OhDearTool)->canSee(fn () => false)];

    $this->json($method, "/nova-vendor/ohdearapp/oh-dear-tool/{$path}")->assertForbidden();
})->with([
    ['GET', 'monitor'], ['GET', 'uptime'], ['GET', 'broken-links'],
    ['GET', 'mixed-content'], ['GET', 'certificate-health'],
    ['POST', 'checks/73/enable'], ['POST', 'checks/73/disable'], ['POST', 'checks/73/request-run'],
]);

it('requires authentication', function () {
    auth()->forgetGuards();

    $this->getJson('/nova-vendor/ohdearapp/oh-dear-tool/monitor')->assertUnauthorized();
});

it('requires Nova access even when the tool is visible', function () {
    Nova::auth(fn () => false);

    $this->getJson('/nova-vendor/ohdearapp/oh-dear-tool/monitor')->assertForbidden();
});

it('does not expose an unregistered tool', function () {
    Nova::$tools = [];

    $this->getJson('/nova-vendor/ohdearapp/oh-dear-tool/monitor')->assertNotFound();
});

it('protects the Inertia pages with tool visibility', function (string $path) {
    Nova::$tools = [(new OhDearTool)->canSee(fn () => false)];

    $this->get("/nova/oh-dear{$path}")->assertForbidden();
})->with(['', '/uptime', '/broken-links', '/mixed-content', '/certificate-health']);

it('uses the current SDK to update checks belonging to the monitor', function (string $action, string $requestClass) {
    MockClient::global([
        GetMonitorRequest::class => MockResponse::make($this->monitor),
        $requestClass => MockResponse::make($this->check),
    ]);

    $this->postJson("/nova-vendor/ohdearapp/oh-dear-tool/checks/73/{$action}")->assertNoContent();
})->with([
    ['enable', EnableCheckRequest::class],
    ['disable', DisableCheckRequest::class],
    ['request-run', RequestCheckRunRequest::class],
]);

it('cannot update checks from another monitor', function (string $action) {
    MockClient::global([GetMonitorRequest::class => MockResponse::make($this->monitor)]);

    $this->postJson("/nova-vendor/ohdearapp/oh-dear-tool/checks/74/{$action}")->assertNotFound();
})->with(['enable', 'disable', 'request-run']);

it('returns actionable configuration errors', function (string $key, mixed $value, string $message) {
    config(["nova-ohdear-tool.{$key}" => $value]);

    $this->getJson('/nova-vendor/ohdearapp/oh-dear-tool/monitor')
        ->assertStatus(503)
        ->assertJsonPath('message', $message);
})->with([
    ['api_token', null, 'Set OH_DEAR_API_TOKEN in your environment to connect to Oh Dear.'],
    ['monitor_id', null, 'Set OH_DEAR_MONITOR_ID to a valid monitor ID in your environment.'],
    ['monitor_id', 'not-an-id', 'Set OH_DEAR_MONITOR_ID to a valid monitor ID in your environment.'],
    ['monitor_id', 0, 'Set OH_DEAR_MONITOR_ID to a valid monitor ID in your environment.'],
]);

it('does not leak upstream error responses', function (int $upstreamStatus, int $status, string $message) {
    MockClient::global([
        GetMonitorRequest::class => MockResponse::make(['message' => 'sensitive upstream information'], $upstreamStatus),
    ]);

    $this->getJson('/nova-vendor/ohdearapp/oh-dear-tool/monitor')
        ->assertStatus($status)
        ->assertJsonPath('message', $message)
        ->assertDontSee('sensitive upstream information');
})->with([
    [401, 502, 'Could not connect to Oh Dear. Check your API token and monitor ID, then try again.'],
    [422, 422, 'Oh Dear could not complete this request. The check may be disabled or may not have run yet.'],
]);

it('serializes every page of broken links from the current SDK', function () {
    $link = [
        'status_code' => null,
        'crawled_url' => 'https://example.net/missing',
        'relative_crawled_url' => '/missing',
        'found_on_url' => 'https://example.com',
        'relative_found_on_url' => '/',
        'link_text' => 'Missing page',
        'internal' => false,
    ];

    MockClient::global([
        GetMonitorRequest::class => MockResponse::make($this->monitor),
        GetBrokenLinksRequest::class => function (PendingRequest $request) use ($link) {
            $page = $request->query()->get('page');

            return MockResponse::make([
                'data' => [$page === 1 ? $link : array_replace($link, ['status_code' => 404])],
                'meta' => ['current_page' => $page, 'last_page' => 2],
            ]);
        },
    ]);

    $this->getJson('/nova-vendor/ohdearapp/oh-dear-tool/broken-links')
        ->assertOk()
        ->assertJsonCount(2, 'brokenLinks')
        ->assertJsonPath('brokenLinks.0.statusCode', null)
        ->assertJsonPath('brokenLinks.1.statusCode', 404);
});

it('returns uptime and ongoing downtime using UTC date ranges and SDK split enums', function () {
    $this->travelTo(now()->setTimezone('UTC')->setDate(2026, 11, 16)->setTime(13, 45));
    config(['app.timezone' => 'Europe/Brussels']);

    MockClient::global([
        GetMonitorRequest::class => MockResponse::make($this->monitor),
        GetUptimeRequest::class => function (PendingRequest $request) {
            $query = $request->query()->all();
            expect($query['filter']['ended_at'])->toBe('20261116134500');

            if ($query['split'] === 'day') {
                expect($query['filter']['started_at'])->toBe('20261109134500');

                return MockResponse::make([['datetime' => '2026-11-15 00:00:00', 'uptime_percentage' => 97.25]]);
            }

            expect($query['split'])->toBe('month')
                ->and($query['filter']['started_at'])->toBe('20251116134500');

            return MockResponse::make([['datetime' => '2026-10-01 00:00:00', 'uptime_percentage' => 99.8]]);
        },
        GetDowntimeRequest::class => MockResponse::make(['data' => [
            ['id' => 4, 'started_at' => '2026-11-16 13:40:00', 'ended_at' => null],
        ]]),
    ]);

    $this->getJson('/nova-vendor/ohdearapp/oh-dear-tool/uptime')
        ->assertOk()
        ->assertJsonPath('uptimePastWeek.0.uptimePercentage', 97.25)
        ->assertJsonPath('uptimePastYear.0.uptimePercentage', 99.8)
        ->assertJsonPath('downtimePeriods.0.endedAt', null);
});

it('returns mixed content and certificate details', function () {
    MockClient::global([
        GetMonitorRequest::class => MockResponse::make($this->monitor),
        GetMixedContentRequest::class => MockResponse::make(['data' => [
            ['element_name' => 'img', 'mixed_content_url' => 'http://example.com/image.jpg', 'found_on_url' => 'https://example.com'],
        ]]),
        GetCertificateHealthRequest::class => MockResponse::make([
            'certificate_details' => ['issuer' => 'Test issuer'],
            'certificate_checks' => [['label' => 'Not expired', 'passed' => false]],
            'certificate_chain_issuers' => ['Test root'],
        ]),
    ]);

    $this->getJson('/nova-vendor/ohdearapp/oh-dear-tool/mixed-content')
        ->assertOk()->assertJsonPath('mixedContent.0.elementName', 'img');

    $this->getJson('/nova-vendor/ohdearapp/oh-dear-tool/certificate-health')
        ->assertOk()
        ->assertJsonPath('certificateHealth.certificateDetails.issuer', 'Test issuer')
        ->assertJsonPath('certificateHealth.certificateChecks.0.passed', false);
});
