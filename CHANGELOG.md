# Changelog

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
