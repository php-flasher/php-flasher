# CHANGELOG for 2.x

## [Unreleased](https://github.com/php-flasher/php-flasher/compare/v2.1.4...2.x)

* feature [Laravel] Improve Laravel Octane support by resetting FallbackSession static storage between requests to prevent notification leakage
* feature [Symfony] Add FrankenPHP/Swoole/RoadRunner support with WorkerListener that implements ResetInterface and is tagged with kernel.reset
* feature [Symfony] Add reset() method to FallbackSession for long-running process support
* feature [Flasher] Add Hotwire/Turbo Drive support with turbo:before-cache event listener to clean up notifications before page caching
* fix [Flasher] Fix potential runtime error in Envelope::toArray() when no PresentableStampInterface stamps exist
* fix [Flasher] Use more specific \Random\RandomException in IdStamp instead of broad \Exception
* fix [Flasher] Update Livewire navigation cleanup to use correct .fl-wrapper selector instead of unused .fl-no-cache class
* feature [Flasher] Add event dispatching system for all notification adapters and themes with Livewire integration:
  - [Toastr] Dispatch events: `flasher:toastr:click`, `flasher:toastr:close`, `flasher:toastr:show`, `flasher:toastr:hidden`
  - [Noty] Dispatch events: `flasher:noty:click`, `flasher:noty:close`, `flasher:noty:show`, `flasher:noty:hover`
  - [Notyf] Dispatch events: `flasher:notyf:click`, `flasher:notyf:dismiss`
  - [Themes] Dispatch events: `flasher:theme:click` (generic) and `flasher:theme:{name}:click` (specific)
  - [Laravel] Add LivewireListener classes for all adapters and themes to enable Livewire event handling
* fix [Flasher] Fix FilterCriteria uninitialized property error when constructed with empty array
* fix [Flasher] Fix null comparison issues in PriorityCriteria, HopsCriteria, and DelayCriteria that relied on PHP's implicit null-to-0 coercion
* fix [Flasher] Add type validation for callable factory return values in NotificationFactoryLocator with descriptive error messages
* fix [Flasher] Add error handling for invalid regex patterns in ResponseExtension::isPathExcluded()
* fix [Flasher] Fix ContentSecurityPolicyHandler parsing of CSP headers with trailing semicolons creating empty directive keys
* fix [Flasher] Add reset() method to ContentSecurityPolicyHandler to fix CSP state leak in long-running processes (Octane, FrankenPHP)
* fix [Flasher] Fix FilterEvent::setFilter() type inconsistency - now accepts FilterInterface instead of concrete Filter class
* fix [Flasher] Remove redundant callable check in FlasherContainer::getContainer()
* fix [Flasher] Fix NotificationStorageMethods::resolveResourceName() return type from ?string to string (never returns null)
* fix [Flasher] Fix parameter name inconsistency in NotificationBuilderInterface::options() - changed $merge to $append to match implementation
* fix [Flasher] Add type validation for callable presenter return values in ResponseManager with descriptive error messages
* fix [Flasher] Fix FlasherPlugin::normalizePlugins() losing scripts/styles when both top-level and plugin-level configs are provided - replaced array union operator with array_merge
* fix [Flasher] Simplify FlasherPlugin::normalizeFlashBag() by replacing redundant array union with direct array_merge
* fix [Flasher] Standardize exception message format in PresetNotFoundException to use brackets like other exceptions
* fix [Flasher] Standardize exception message wording in CriteriaNotRegisteredException to use "not found" instead of "is not found"

## [v2.1.3](https://github.com/php-flasher/php-flasher/compare/v2.1.2...v2.1.3) - 2025-01-25

* bug [#208](https://github.com/php-flasher/php-flasher/issues/208) [Flasher] Add GitHub workflow for automatic publishing of assets to NPM. See [PR #211](https://github.com/php-flasher/php-flasher/pull/211) by [ToshY](https://github.com/ToshY)

## [v2.1.2](https://github.com/php-flasher/php-flasher/compare/v2.1.1...v2.1.2) - 2025-01-18

* bug [#208](https://github.com/php-flasher/php-flasher/issues/208) [Flasher] Allow `main_script` to be nullable. See [PR #209](https://github.com/php-flasher/php-flasher/pull/209) by [yoeunes](https://github.com/yoeunes)

## [v2.1.1](https://github.com/php-flasher/php-flasher/compare/v2.1.0...v2.1.1) - 2024-10-20

* feature [Laravel] Add `excluded_paths` option. See [PR #203](https://github.com/php-flasher/php-flasher/pull/203) by [yoeunes](https://github.com/yoeunes)

## [v2.1.0](https://github.com/php-flasher/php-flasher/compare/v2.0.4...v2.1.0) - 2024-10-19

* feature [Flasher] Update laravel and symfony configuration documentation . See [PR #201](https://github.com/php-flasher/php-flasher/pull/201) by [yoeunes](https://github.com/yoeunes)
* feature [Flasher] Improve Type Safety and IDE Support with Enhanced PHPDoc Annotations and Stricter PHPStan Validations. See [PR #200](https://github.com/php-flasher/php-flasher/pull/200) by [yoeunes](https://github.com/yoeunes)
* feature [Symfony] Improve configuration descriptions and add examples. See [PR #199](https://github.com/php-flasher/php-flasher/pull/199) by [yoeunes](https://github.com/yoeunes)
* feature [Symfony] Add Symfony Profiler integration for PHPFlasher. See [PR #198](https://github.com/php-flasher/php-flasher/pull/198) by [yoeunes](https://github.com/yoeunes)

## [v2.0.4](https://github.com/php-flasher/php-flasher/compare/v2.0.3...v2.0.4) - 2024-09-22

* bug [laravel] Changed HttpKernel import from `Illuminate\Foundation\Http\Kernel` to `Illuminate\Contracts\Http\Kernel` to use the contract interface instead of the concrete implementation. See [PR #197](https://github.com/php-flasher/php-flasher/pull/197) by [yoeunes](https://github.com/yoeunes)

## [v2.0.3](https://github.com/php-flasher/php-flasher/compare/v2.0.2...v2.0.3) - 2024-09-21

* remove border from flasher container by [yoeunes](https://github.com/yoeunes) 

## [v2.0.2](https://github.com/php-flasher/php-flasher/compare/v2.0.1...v2.0.2) - 2024-09-19

* feature [Flasher] add escapeHtml option for secure HTML escaping in notifications. See [PR #196](https://github.com/php-flasher/php-flasher/pull/196) by [yoeunes](https://github.com/yoeunes)
* feature [Flasher] add Default configuration options. See [PR #183](https://github.com/php-flasher/php-flasher/pull/183) by [AhmedGamal](https://github.com/AhmedGamal)
* feature [Laravel] Refactor middleware to use Symfony's base response class, addressing compatibility issues. See [PR #184](https://github.com/php-flasher/php-flasher/pull/184) by [yoeunes](https://github.com/yoeunes)

## [v2.0.1](https://github.com/php-flasher/php-flasher/compare/v2.0.0...v2.0.1) - 2024-05-23

* bug [#176](https://github.com/php-flasher/php-flasher/issues/176) [Laravel] Correctly disable FlasherMiddleware when `inject_assets` is set to false. See [PR #177](https://github.com/php-flasher/php-flasher/pull/177) by [yoeunes](https://github.com/yoeunes)
* bug [#176](https://github.com/php-flasher/php-flasher/issues/176) [Flasher] Ensure global `timeout` option applies to all requests. See [PR #180](https://github.com/php-flasher/php-flasher/pull/180) by [yoeunes](https://github.com/yoeunes)
* bug [#176](https://github.com/php-flasher/php-flasher/issues/176) [Laravel] Allow disabling of default flash replacement by setting `flash_bag` to false. See [PR #181](https://github.com/php-flasher/php-flasher/pull/181) by [yoeunes](https://github.com/yoeunes)
* bug [#176](https://github.com/php-flasher/php-flasher/issues/176) [Flasher] Ensure `flash_bag` option overrides default values instead of appending. See [PR #182](https://github.com/php-flasher/php-flasher/pull/182) by [yoeunes](https://github.com/yoeunes)
