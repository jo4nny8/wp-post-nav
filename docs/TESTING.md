# WP Post Nav testing guide

## Current testing position

WP Post Nav now has a Composer-managed PHPUnit 10 framework. The repository contains isolated unit tests for lifecycle contracts, settings defaults and validation, hook registration, shortcode registration, and template availability. Integration tests are present as explicit placeholders and require a real WordPress installation.

Phase 3 adds a WordPress test-library bootstrap, reusable content factories, and integration tests for posts, pages, a test custom post type, attachments, shortcode output, empty navigation, and multiple shortcode calls. The current frontend markup contract is recorded in `FRONTEND-BASELINE.md`.

The project also provides PHP syntax checks, PHPCS, PHPStan, and distribution package validation. PHPCS and PHPStan currently report legacy findings; those findings are recorded in `DEVELOPMENT-ASSESSMENT.md` and are not hidden by a baseline.

## Local MAMP Pro setup

1. Install MAMP Pro with PHP 8.1 or later available to the command line. The current Composer test dependency requires PHP 8.1+; the verified local runner uses PHP 8.5.3.
2. Create a local WordPress site in MAMP Pro using the plugin directory at `wp-content/plugins/wp-post-nav`.
3. Use WordPress `6.8` for the current compatibility run. The plugin declares WordPress `6.0` as its minimum version.
4. Activate WP Post Nav and configure representative settings for posts, pages, a custom post type, and products if WooCommerce is installed.
5. For integration testing, install the WordPress test suite and set `WP_TESTS_DIR` to its location. The PHPUnit bootstrap loads WordPress before integration tests can exercise queries, templates, shortcodes, and database state.

## Recommended test plugins

The core test suite does not require optional plugins. Install these when testing their compatibility paths:

- WooCommerce, for product navigation and stock-status filtering.
- Yoast SEO, for primary-term navigation behaviour.
- The SEO Framework, for primary-term navigation behaviour.

Run separate test passes with each SEO plugin active and with neither active. Do not assume both SEO plugins are active together in production.

## Test commands

From the plugin directory:

```bash
composer validate --no-check-publish
composer run test
composer run lint:php
composer run lint:phpcs
composer run analyse
composer run build
unzip -t wp-post-nav.zip
git diff --check
```

To run only the current isolated unit tests:

```bash
vendor/bin/phpunit --configuration tests/phpunit.xml --testsuite 'WP Post Nav unit tests'
```

To run integration tests after WordPress has been bootstrapped:

```bash
WP_TESTS_DIR=/path/to/wordpress-tests-lib composer run test:integration
```

The integration suite requires a MySQL database configured for the WordPress test library. The exact installation command depends on the local WordPress test installation; the bootstrap expects the standard `tests/phpunit/includes/functions.php` and `tests/phpunit/includes/bootstrap.php` files.

## Expected results

- Composer validation passes.
- Unit tests pass without test failures. Tests requiring WordPress or optional plugins are skipped until their dependencies exist.
- Integration tests pass when run with the WordPress test library and MySQL database.
- PHP syntax checks pass for the active tree. Historical tags may emit known PHP deprecation notices.
- Package creation and ZIP integrity pass, with tests, Composer files, development documentation, and repository metadata excluded from the distribution archive.
- PHPCS and PHPStan currently report known legacy findings and should be reviewed as maintenance work progresses. PHPStan runs in debug/serial mode so it also works in restricted local environments that do not permit its parallel worker socket.

## Coverage currently provided

- Fresh activation creates the expected option structure and version value.
- Reactivation with the current version preserves saved options.
- Deactivation completes without an exception.
- Default and saved settings load.
- Valid settings are retained, unknown settings are removed, invalid numeric and colour values fall back, and checkbox presence is preserved.
- The loader registers actions and filters.
- The public class keeps the `wp_post_nav` shortcode registration.
- Default, primary taxonomy, attachment, and WooCommerce template files remain available.

## Coverage gaps and limitations

- Unit stubs do not reproduce WordPress queries, hooks, escaping, settings API, template loading, or database semantics.
- Post, page, custom post type, attachment, product, ordering, empty-navigation, shortcode rendering, and output-buffering tests require WordPress fixtures and remain planned integration coverage.
- Product fixture coverage remains conditional because WooCommerce is not installed in the default test environment; the product template and stock-filter path are documented for an optional-plugin test job.
- Yoast SEO and The SEO Framework paths require their plugins and representative primary-term data.
- Browser accessibility, keyboard, touch, focus, responsive layout, and screen-reader checks are not automated.
- The current admin settings test records pre-existing warnings caused by an invalid legacy settings section and dynamic properties. These are documented findings, not changes made by the test foundation.

## Future testing requirements

Before architectural refactoring, add WordPress integration fixtures for every supported content type and public compatibility point. Add browser checks for rendered navigation and accessibility, then make the relevant PHPUnit, PHPCS, PHPStan, and package checks required for pull requests.
