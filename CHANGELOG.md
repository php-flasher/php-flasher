# CHANGELOG for 2.x

## [Unreleased](https://github.com/php-flasher/php-flasher/compare/v2.0.1...2.x)

## [v2.0.1](https://github.com/php-flasher/php-flasher/compare/v2.0.0...v2.0.1) - 2024-05-23

* bug [#176](https://github.com/php-flasher/php-flasher/issues/176) [Laravel]: Correctly disable FlasherMiddleware when `inject_assets` is set to false. See [PR #177](https://github.com/php-flasher/php-flasher/pull/177).
* bug [#176](https://github.com/php-flasher/php-flasher/issues/176) [Flasher]: Ensure global `timeout` option applies to all requests. See [PR #180](https://github.com/php-flasher/php-flasher/pull/180).
* bug [#176](https://github.com/php-flasher/php-flasher/issues/176) [Laravel]: Allow disabling of default flash replacement by setting `flash_bag` to false. See [PR #181](https://github.com/php-flasher/php-flasher/pull/181).
* bug [#176](https://github.com/php-flasher/php-flasher/issues/176) [Flasher]: Ensure `flash_bag` option overrides default values instead of appending. See [PR #182](https://github.com/php-flasher/php-flasher/pull/182).
