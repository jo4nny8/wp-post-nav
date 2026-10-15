# Filesystem Map

Use this as the first routing table for implementation work. Keep entries
specific and operational. Do not duplicate design history or general project
documentation here.

## Task Routes

| Task or area | Primary files | Supporting files | Build or refresh | Focused verification |
| --- | --- | --- | --- | --- |
| Plugin bootstrap and header | `wp-post-nav.php` | `includes/class-wp-post-nav.php`, `includes/class-wp-post-nav-loader.php` | Reload WordPress admin | Plugin loads on `plugins.test`; `composer run lint:php` |
| Activation, deactivation and upgrade | `includes/class-wp-post-nav-activator.php`, `includes/class-wp-post-nav-deactivator.php` | `includes/class-wppn-migrations.php` | Reactivate the plugin | `tests/Unit/ActivatorTest.php`, `tests/Unit/MigrationTest.php` |
| Settings storage and validation | `includes/class-wppn-settings.php` | `includes/class-wppn-migrations.php` | None | `tests/Unit/AdminSettingsTest.php`, `tests/Unit/MigrationTest.php` |
| Customizer panel and controls | `includes/class-wppn-customizer.php`, `includes/class-wppn-customizer-post-types-control.php` | `public/js/wp-post-nav-customizer.js`, `public/js/wp-post-nav-customizer-controls.js` | Reload Appearance → Customise | `tests/Unit/CustomizerTest.php`; manual Customizer check |
| Legacy Settings page (admin) | `admin/class-wp-post-nav-admin.php` | `admin/partials/`, `admin/css/wp-post-nav-admin.css`, `admin/js/wp-post-nav-admin.js`, `admin/images/` | Reload Settings → WP Post Nav | `tests/Unit/AdminSettingsTest.php` |
| Front-end navigation (public) | `public/class-wp-post-nav-public.php` | `public/partials/` (post, page, product, attachment, primary, default), `public/css/wp-post-nav-public.css`, `public/js/wp-post-nav-public.js`, `public/images/` | Reload a post on `plugins.test` | `tests/Integration/NavigationIntegrationTest.php`; `docs/FRONTEND-BASELINE.md` |
| Shortcode `[wp_post_nav]` | `public/class-wp-post-nav-public.php` | `includes/class-wp-post-nav-shortcode.php` (upstream file retained from the import) | Reload a page using the shortcode | `tests/Unit/PluginContractsTest.php` |
| Translations | `languages/wp-post-nav.pot` | `includes/class-wp-post-nav-i18n.php` | None | Text domain `wp-post-nav` |
| Uninstall | `uninstall.php` | `includes/class-wppn-settings.php` | None | Every stored option is listed |
| Tests | `tests/Unit/`, `tests/Integration/` | `tests/bootstrap.php`, `tests/integration-bootstrap.php`, `tests/Fixtures/ContentFactory.php`, `tests/phpunit.xml`, `tests/phpunit-integration.xml` | `composer install` | `composer run test`; `composer run test:integration` |
| Static analysis and CI | `phpcs.xml.dist`, `phpstan.neon.dist` | `.github/workflows/quality.yml`, `composer.json` | None | `composer run lint:phpcs`; `composer run analyse` |
| Distribution package | `bin/build-package.sh` | `.gitignore` | `composer run build` | `unzip -t wp-post-nav.zip`; `unzip -l wp-post-nav.zip` |
| WordPress.org readme and changelog | `README.txt` | `assets/` (directory banner, icons, screenshots) | None | Release decision only |
| Development documentation | `docs/` | `DEVELOPMENT-ASSESSMENT.md`, `REPOSITORY-COMPARISON.md`, `PROJECT_HANDOVER.md`, `Examples.txt` | None | Review |
| Historical WordPress.org releases | `tags/` | None | None | Reference only; do not edit |

## Global Design Controls

| Change | Direct file | Named control |
| --- | --- | --- |
| Navigation colours, typography and layout | `includes/class-wppn-settings.php` (defaults and validation) | `wppn_settings` keys, edited through the Customizer |
| Front-end base styles | `public/css/wp-post-nav-public.css` | Existing selectors are compatibility-sensitive |

## Runtime Routes

| Environment | Location or URL | Start, refresh or inspect |
| --- | --- | --- |
| Development | `plugins.test` (MAMP PRO), plugin at `wp-content/plugins/wp-post-nav` | Check MAMP PRO is running, then reload the site |
| Release | WordPress.org plugin directory (SVN) | Only after an explicit release decision |

## Rules

- Go directly to a valid mapped route instead of rediscovering it.
- Search narrowly only when the task is absent or the mapped file no longer
  exists.
- Add stable discoveries that will save future inspection time.
- Never record passwords, tokens, customer data or transient machine state.
- Target 60 seconds for a mapped Development-only visual change: edit once,
  refresh or build once, inspect once and stop.
