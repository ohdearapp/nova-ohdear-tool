# Upgrading from 1.x to 2.x

Version 2 targets the current Laravel Nova tool APIs. It is not compatible with Nova 1, 2, 3, or 4.

## Update your application first

Upgrade to PHP 8.4+, Laravel 13, and Nova 5.11.1+ before updating this package. Follow Nova's own upgrade guide for changes to your application and other Nova packages. Laravel 12's Testbench cannot run Pest 5 because their Symfony Process requirements conflict.

```sh
composer require ohdearapp/nova-ohdear-tool:^2.0 --with-all-dependencies
```

The package now requires Oh Dear PHP SDK 4.8+. If your application uses the SDK directly, update those calls to the SDK's current monitor API as well.

## Rename the monitor configuration

Replace `OH_DEAR_SITE_ID` with `OH_DEAR_MONITOR_ID`. The API token variable remains `OH_DEAR_API_TOKEN`.

If you previously published `config/nova-ohdear-tool.php`, replace its `site_id` key with `monitor_id`:

```php
'monitor_id' => env('OH_DEAR_MONITOR_ID'),
```

Use the ID of the same monitor in Oh Dear. The configuration is now merged automatically, so publishing it is optional for new installations. Clear cached configuration after changing it:

```sh
php artisan config:clear
```

## Check tool registration and visibility

Keep `new OhDearTool` in `NovaServiceProvider::tools()`. Remove custom references to the old tool navigation Blade view or Vue Router routes. The menu now uses Nova's `MenuSection`; pages use Inertia beneath Nova's configured base path.

The existing `canSee` callback now protects API access as well as navigation. Confirm the intended users have Nova access and can see the tool. They can enable, disable, and rerun checks for the configured monitor only.

## Reapply frontend customizations

Vue 2 components, the legacy JavaScript models, Moment, and Laravel Mix have been removed. Reapply any customizations to the Vue 3 components in `resources/js` and rebuild with `npm ci && npm run build`.

The package registers its compiled assets directly. Applications do not need to publish or rebuild the package's assets unless they customize them.

## Internal endpoints changed

The private tool API now serves `GET /nova-vendor/ohdearapp/oh-dear-tool/monitor`, without a caller-supplied monitor ID. Report endpoints also use the configured monitor. Mutations use `POST /nova-vendor/ohdearapp/oh-dear-tool/checks/{checkId}/{enable|disable|request-run}` and return HTTP 204 on success. Update any custom clients that called the old internal endpoints.
