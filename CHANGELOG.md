# Changelog

## 2026-08-23T08:51:12Z — Development workflow established

- Imported the official WordPress.org SVN baseline at revision `3661533`.
- Added the historical `tags/` and directory `assets/` snapshots.
- Added Git `main` and `develop` branches and the `wordpress-org-2.0.3` baseline tag.
- Added `.gitignore`, Composer development dependencies, PHP_CodeSniffer configuration, PHPStan configuration, and the clean package build script.
- Package builds exclude Git/development metadata, historical tags, repository assets, and temporary files.
- Added `REPOSITORY-COMPARISON.md` documenting upstream/local differences.
- No plugin functionality was changed as part of repository setup.
- PHP lint and package validation are required before release; full WordPress integration tests remain outstanding.

## 2026-08-23T07:36:15Z — Version 2.0.4

### Summary

Phase 1 modernization and safe maintenance release.

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

- Sanitized dynamic CSS colors and dimensions before inline CSS generation.
- Added heading color and size validation.
- Corrected open-background color validation.
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
