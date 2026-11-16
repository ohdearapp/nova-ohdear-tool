# Changelog

All notable changes to `nova-ohdear-tool` will be documented in this file

## 2.1.0 - 2026-11-16

- Add application-health reports with individual results and per-check status history.
- Add paginated scheduled-task reports with schedules, timezones, heartbeat results, and grace periods. Exclude heartbeat credentials and arbitrary health metadata from browser responses.

## 2.0.0 - 2026-11-16

- Require PHP 8.4+, Laravel 13, Nova 5.11.1+, and Oh Dear PHP SDK 4.8+.
- Replace the Nova 1/2 integration with Nova 5 menu sections, Inertia pages, and Vue 3.
- Rebuild the overview and reports with light/dark themes, loading and error states, accessible controls, and narrow layouts.
- Show all monitor checks, with detailed uptime, broken link, mixed content, and certificate reports.
- Use the current monitor API, paginated broken links, and UTC uptime ranges. Rename `site_id` / `OH_DEAR_SITE_ID` to `monitor_id` / `OH_DEAR_MONITOR_ID`.
- Protect API routes with Nova access and tool visibility, restrict mutations to the configured monitor, and omit private monitor/check settings from responses.
- Replace Laravel Mix, Moment, and the old Yarn dependency tree with Vite and npm. This supersedes the security fixes proposed by Dependabot in #56 and #57.
- Add Pest 5 tests, PHPStan, Pint, and GitHub Actions for PHP 8.4/8.5/8.6 and Laravel 13.
- Thanks to @bram-pkg for reporting the Nova compatibility gap in #53, and Dependabot for the security reports.

## 1.1.3 - 2021-04-26

- add tool page title (#31)

## 1.1.2 - 2019-09-22

- remove nova dep

## 1.1.1 - 2019-09-04

- fix import of exception

## 1.1.0 - 2019-02-27

- support for Laravel 5.8 and Nova 2.0

## 1.0.0 - 2018-11-13

- initial release
