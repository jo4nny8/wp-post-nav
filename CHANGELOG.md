# Changelog

## Unreleased

- 2026-10-16: Consolidated the 2.1.0 work onto one branch: merged
  `claude/overnight-review-20261014`, which already contains the four
  `feature/release-2.1.0` release-preparation commits, into `develop`. Not
  released; WordPress.org is unchanged.
- 2026-10-15: Release packages now leave out the agent and project-record files
  (`CLAUDE.md`, `CURRENT_STATE.md`, `FILESYSTEM_MAP.md`,
  `DEVELOPMENT_CONTEXT.md`, `PROJECT_HANDOVER.md`, `ROADMAP.md`). Checked by building the
  package and listing its contents.
- 2026-10-15: Adopted the agreed project documentation standard: AGENTS.md now
  points to the global agents file and holds project rules only; CLAUDE.md and
  CODEX.md are pointers; added CLAUDE.md, CURRENT_STATE.md and
  FILESYSTEM_MAP.md. Also restructured README.md and corrected the retired
  working-copy path in PROJECT_HANDOVER.md. Documentation only; no plugin code,
  version or README.txt change.

## Unreleased (2026-10-14) - Claude overnight review

Not released or deployed. No version, `Stable tag` or `Tested up to` change.

- Fixed: ticked checkboxes saved from the Settings > WP Post Nav page (posted
  as `array( 'Yes' => 'Yes' )`) were stored as off, and the 2.0.4 -> 2.1.0
  migration switched off every ticked option saved through the 2.0.x screen.
  `WPPN_Settings::sanitize()` now accepts that legacy format.
- Fixed: the `[wp_post_nav]` shortcode ignored unticked same-category, title,
  category, excerpt and featured-image settings, and linked with a hard-coded
  same-term flag. It now follows the settings like the footer navigation.
- Fixed: posts without a featured image showed an empty image instead of the
  bundled default fallback image when no custom fallback was saved.
- Fixed: undefined `$options_markup` warning on the settings page when no
  public post types are returned.
- Removed the unused duplicate bootstrap `includes/class-wp-post-nav-shortcode.php`.
- WP-08: corrected constructor PHPDoc tags and the legacy admin class reference
  case without changing public hooks, options or behaviour; PHPStan findings
  reduced from 20 to 17. Corrected the loader's action/filter parameter tags in
  the next bounded batch, reducing the total to 15. Corrected the loader's
  collection helper parameter/return contract in a third batch, reducing the
  total to 11. Removed three provably unreachable/redundant admin branches in a
  fourth batch, reducing the total to 8 without changing rendered settings.
  Aligned the Customizer control arguments with WordPress's singular-setting
  contract and included the custom control in analysis, reducing the total to 5.
  Corrected adjacent-primary-term validation and exclusion argument shapes in a
  sixth batch, resolving the remaining findings.
- Build: `bin/build-package.sh` excludes `CLAUDE.md`, `CLAUDE.local.md` and
  `.claude/`; `.gitignore` ignores local Claude files. Added `CLAUDE.md`.
- Docs: handover, AGENTS, CODEX and roadmap now name `feature/release-2.1.0`
  as the release branch; roadmap suggestions added.
- Checks run: PHP lint, PHPUnit unit suite (18 tests, 54 assertions), PHPStan
  level 5 (30 -> 0 findings with the 2.1.0 phar), package dry run. Integration
  tests and a real-browser check are still required on the Mac.

## 2026-09-05T16:45:00+01:00 - Keep public metadata at production release

- Restored `README.txt` metadata and public changelog scope to the published
  WordPress.org 2.0.3 release.
- Kept unreleased 2.0.4 and 2.1.0 work exclusively in the internal
  development history.

## 2026-09-05T16:40:27+01:00 - Separate public and internal changelog scope

- Kept `README.txt` limited to concise production release notes for the
  WordPress.org listing.
- Moved development, testing and release-process detail to `CHANGELOG.md` and
  the project documentation.
- Updated the public compatibility marker to WordPress 7.1 after staging
  validation.

## 2026-09-05T16:29:47+01:00 - Enable WordPress integration testing

- Added PHPUnit Polyfills and aligned the Composer test runner with the
  PHPUnit version required by the WordPress integration suite.
- Loaded the Polyfills dependency from the plugin integration bootstrap.
- Corrected integration fixtures for WordPress's empty adjacent-post return
  value and isolated single-post shortcode behaviour.
- Verified against the `plugins.test` WordPress 7.1 installation using the
  dedicated `wppn_tests_` table prefix: 11 tests, 19 assertions and 3 skips.

## 2026-09-05T16:18:26+01:00 - Prepare release validation tooling

- Excluded Git metadata and internal development documents from the
  WordPress.org distribution package.
- Increased the PHPStan analysis memory limit so the project analysis command
  completes and reports its existing legacy findings.
- Validation completed: Composer validation, PHP syntax lint, 16 PHPUnit tests
  with 47 assertions, package ZIP integrity and `git diff --check`.
- WordPress integration testing remains dependent on the local MAMP database
  service and an isolated test database.

## 2026-08-31T15:18:32+01:00 - Add project roadmap

- Added the canonical project roadmap and linked it from the agent, handover and
  README entry points.
- Recorded static-analysis, WordPress 7.1 validation and release-candidate work
  without changing plugin behaviour or publication state.
- Testing completed: documentation/state review, diff check and focused secret
  scan.

## 2026-08-30T23:26:24+01:00 - Add project handover

- Added the canonical repository, branch, runtime and NAS reference map.
- Added a repeatable task startup and completion checklist for Codex work.
- Testing completed: documentation review and `git diff --check`.
- Known limitations remain unchanged.

## 2026-08-30T23:01:47+01:00 — Declare legacy runtime properties

- Declared the core plugin name and administration state properties that were
  previously created dynamically at runtime.
- Removed PHP 8.2+ dynamic-property deprecation warnings without changing
  stored settings, public APIs, hooks or rendering behaviour.
- Verified against the updated `plugins.test` WordPress 7.1 environment.
- Tests completed: PHP syntax, 16 unit tests with 47 assertions, package ZIP
  validation, runtime loading and secret scan.
- Known limitation: PHPStan still reports 30 pre-existing legacy findings,
  including the separately documented duplicate shortcode bootstrap file.

## 2026-08-23T19:18:00Z — Improve Customizer guidance and safe controls

- Clarified that excerpt length is measured in words.
- Replaced the free-text post-type field with safe checkboxes matching the existing Settings page.
- Replaced the fallback image URL field with the WordPress media upload control.
- Added explanatory documentation to every Customizer section and the key controls.
- Ensured checkbox selections continue to save as the existing compatible post-type array.

## 2026-08-23T19:02:00Z — Refresh all Customizer preview settings

- Changed all WP Post Nav Customizer controls to refresh the live preview when changed.
- Ensured visibility, excerpt, image, navigation, colour, typography and layout changes are rendered through the existing frontend code before publishing.
- Preserved the existing settings option, public output structure and compatibility-sensitive keys.

## 2026-08-23T18:49:00Z — Harden Customizer preview initialisation

- Prevented the Customizer preview script from throwing when WordPress has not exposed a matching live setting in the preview context.
- Preserved live CSS updates where the Customizer setting API is available.
- Bumped the preview asset version so existing browser caches receive the corrected script.

## 2026-08-23T18:43:00Z — Fix Customizer post-type control fatal

- Fixed the Customizer post-type control fatal caused by passing the compatible post-type array directly to WordPress’s string textarea renderer.
- Added a dedicated control that displays post types as newline-separated text while retaining the existing array storage format.
- Confirmed the PHP 8.2/8.3 dynamic-property notices and WooCommerce null-offset notices are separate issues and remain unchanged.

## 2026-08-23T18:31:00Z — Fix Customizer registration lifecycle

- Registered the WP Post Nav Customizer hooks directly when `WPPN_Customizer` is constructed.
- Removed the indirect loader registration that could leave the panel unavailable before `customize_register` fired on a live WordPress site.
- Added a regression assertion for the Customizer lifecycle hooks.
- Existing PHP 8.2/8.3 dynamic-property deprecations in legacy classes remain documented and unchanged.

## 2026-08-23T18:12:00Z — Version 2.1.0 Customizer settings migration

- Added `WPPN_Settings` as the shared settings, sanitisation and compatibility layer.
- Added `WPPN_Migrations` for a verified, idempotent migration from 2.0.4 to the `wppn_settings` option.
- Added the WP Post Nav Customizer panel with General, Navigation, Layout, Colours, Typography, Images and Advanced sections.
- Added live preview CSS variables for colours and typography while preserving existing selectors and markup.
- Routed the existing Settings page and frontend settings getter through the new settings layer.
- Added migration and settings compatibility tests, and documented upgrade behaviour in `README.md`, `README.txt`, `docs/DEVELOPMENT.md` and `docs/TESTING.md`.
- Version updated to 2.1.0. Historical SVN tags remain unchanged.

## 2026-08-23T17:47:16Z — Phase 4A Customizer architecture and migration standards

- Added `docs/CUSTOMIZER-AUDIT.md` documenting the current settings page, options, validation, frontend consumers, dynamic CSS, and compatibility risks.
- Added `docs/CUSTOMIZER-ARCHITECTURE.md` defining the proposed `WPPN_Settings`, `WPPN_Customizer`, and `WPPN_Migrations` responsibilities.
- Added `docs/CUSTOMIZER-IMPLEMENTATION-PLAN.md` with staged settings abstraction, Customizer, live-preview, CSS, and deprecation phases.
- Documented mandatory settings and database migration rules in the central `jo4nny8/jo4nny8-development-standards` repository.
- No plugin runtime code, settings, database options, public APIs, rendering logic, or frontend output was changed.

## 2026-08-23T16:37:49Z — Phase 3 WordPress integration testing and CI

- Added a WordPress test-library bootstrap with a separate integration PHPUnit configuration.
- Added reusable post, page, custom post type, taxonomy, and attachment fixtures.
- Added integration coverage for adjacent navigation ordering, shortcode output, empty navigation, pages, custom post types, attachments, and repeated shortcode calls.
- Added `docs/FRONTEND-BASELINE.md` documenting compatibility-sensitive markup, selectors, and current rendering behaviour.
- Added `.github/workflows/quality.yml` for Composer, syntax, PHPUnit, PHPCS, PHPStan, package, and WordPress integration validation.
- Updated `docs/TESTING.md` with WordPress test-library and MySQL setup instructions.
- No production plugin code, public interface, frontend markup, CSS, or runtime behaviour was changed.

## 2026-08-23T14:53:21Z — Phase 2 compatibility testing foundation

- Added Composer-managed PHPUnit 10 and the `tests/` unit and integration test structure.
- Added lifecycle, settings, hook, shortcode-registration, and template-availability compatibility tests.
- Added `docs/TESTING.md` covering MAMP Pro, WordPress, optional plugin dependencies, commands, expected results, and coverage gaps.
- Updated package generation to exclude tests and development documentation from the WordPress.org distribution archive.
- No plugin runtime behaviour, public interface, hook, filter, option, shortcode, or rendering structure was changed.

## 2026-08-23T13:20:59Z — Jo4nny8 workflow migration audit

- Added `AGENTS.md`, `CODEX.md`, and `docs/DEVELOPMENT.md` with project conventions and development workflow guidance.
- Added `docs/STANDARDS-AUDIT.md` covering coding, WordPress, frontend, documentation, compatibility, and release standards.
- Added `docs/MIGRATION-PLAN.md` with staged maintenance, architecture, and future-feature phases.
- Confirmed that no plugin functionality or existing public interfaces were changed during this audit.

## 2026-08-23T09:48:47Z — British English standardisation

- Standardised maintained comments, documentation, changelog prose, and user-facing text to British English.
- Preserved WordPress and API identifiers, compatibility-sensitive option keys, CSS properties, and literal data attributes.
- Rechecked PHP syntax, Composer configuration, package generation, and ZIP integrity after the text-only changes.

## 2026-08-23T09:44:46Z — GitHub remote connected

- Configured `https://github.com/jo4nny8/wp-post-nav.git` as the Git `origin` remote.
- Published the `main` and `develop` branches and the `wordpress-org-2.0.3` tag.
- Left the pre-existing GitHub `master` branch unchanged.
- WordPress.org SVN remains a separate release-publishing destination.

## 2026-08-23T08:51:12Z — Development workflow established

- Imported the official WordPress.org SVN baseline at revision `3661533`.
- Added the historical `tags/` and directory `assets/` snapshots.
- Added Git `main` and `develop` branches and the `wordpress-org-2.0.3` baseline tag.
- Added `.gitignore`, Composer development dependencies, PHP_CodeSniffer configuration, PHPStan configuration, and the clean package build script.
- Added `composer.lock` and WordPress stubs for reproducible local static analysis.
- Package builds exclude Git/development metadata, historical tags, repository assets, and temporary files.
- Added `REPOSITORY-COMPARISON.md` documenting upstream/local differences.
- No plugin functionality was changed as part of repository setup.
- PHP lint and package validation are required before release; full WordPress integration tests remain outstanding.
- PHPCS and PHPStan now run and report existing legacy violations; they are intentionally not suppressed with a baseline.

## 2026-08-23T07:36:15Z — Version 2.0.4

### Summary

Phase 1 modernisation and safe maintenance release.

### Bug fixes

- Corrected automatic navigation detection for selected post types.
- Corrected shortcode-mode detection to use setting values.
- Registered the deactivation callback with `register_deactivation_hook()`.
- Corrected version migration to update `wp_post_nav_version`.
- Fixed the fatal undefined translation function in attachment navigation.
- Fixed SEO Framework primary-term logic and removed an invalid Yoast dependency from that branch.
- Fixed custom-post-type next-category output.
- Made excerpt trimming safer for short content and multibyte text.
- Added defensive handling for missing or malformed settings.

### Security and compatibility improvements

- Sanitised dynamic CSS colours and dimensions before inline CSS generation.
- Added heading colour and size validation.
- Corrected open-background colour validation.
- Rejected unknown submitted settings keys.
- Added queried-object checks for shortcode contexts.

### Files affected

- `wp-post-nav.php`
- `includes/class-wp-post-nav.php`
- `includes/class-wp-post-nav-activator.php`
- `admin/class-wp-post-nav-admin.php`
- `public/class-wp-post-nav-public.php`
- `public/partials/wp-post-nav-public-attachment.php`
- `public/partials/wp-post-nav-public-default.php`
- `public/partials/wp-post-nav-public-primary.php`
- `README.txt`
- `DEVELOPMENT-ASSESSMENT.md`
- `CHANGELOG.md`

### Compatibility considerations

- Existing public hooks, filters, shortcode name, option name, CSS classes, and template paths were retained.
- The rendering duplication was intentionally not refactored in this release.
- Full WordPress integration testing remains required, especially for WooCommerce, Yoast SEO, SEO Framework, and legacy option migrations.

### Testing completed

- PHP syntax lint completed for all PHP files.
- Static source review completed for the Phase 1 critical paths.
- Full WordPress integration tests were not available in the task environment.
- Git status, branch, and commit history could not be verified because this plugin directory is not a Git repository.
