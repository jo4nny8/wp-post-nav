# WP Post Nav Roadmap

What to build next. Faults and things to fix are GitHub issues in this
repository (labels `bug`, `fix-next`, `blocked`, `from-field-test`,
`standards-repair`), not roadmap items.

Updated: 2026-08-31T15:18:32+01:00

## Next Up

1. Classify and resolve the 30 documented PHPStan findings in small
   compatibility-preserving batches.
2. Complete a focused WordPress 7.1 manual test of the version `2.1.0`
   Customizer, settings migration and front-end navigation behaviour.
3. Decide whether the resulting `feature/release-2.1.0` revision is ready for a
   deliberate WordPress.org release candidate.

## Planned

- Preserve upgrade compatibility for existing options, hooks, shortcodes,
  selectors and templates.
- Maintain WooCommerce, Yoast SEO and SEO Framework integration behaviour.
- Expand regression coverage as legacy findings are corrected.
- Keep package generation and WordPress.org assets reproducible.

## Ideas

- Explore block-editor controls only after the Customizer migration is stable.
- Consider additional navigation layouts without changing existing defaults.
- Improve accessibility and live-preview behaviour where compatibility permits.

## Recently Completed

- Implemented the `2.1.0` settings abstraction and Customizer migration.
- Added unit/integration foundations with 16 tests and 47 assertions.
- Corrected PHP dynamic-property deprecations and verified WordPress 7.1 load.

## Suggested (Claude review 2026-10-14)

Suggestions only; none is approved work until John moves it into Next Up or
Planned.

- Include the legacy checkbox format (`array( 'Yes' => 'Yes' )`) and a real
  2.0.3 options snapshot in the WordPress 7.1 manual migration test.
- Decide whether the 2.1.0 migration should keep a backup of
  `wp_post_nav_options` (for example until 2.2) instead of deleting it after
  verification, so a rollback to 2.0.3 keeps the site's settings.
- Fresh 2.0.x installs stored `public/images/default_fallback.jpg`, but the
  bundled file is `.png`. Consider mapping that stored URL to the bundled
  default during migration.
- Fix the upgrade admin notice in `wp_post_nav::version_control()`: wrong text
  domain (`wp_post_nav`), HTML inside a translatable string, and an unescaped
  URL.
- Remaining 20 PHPStan findings (PHPStan 2.1.0 phar here; recheck with the
  locked 2.2.x): PHPDoc in the loader, `is_wp_error()` checks after
  `get_term()` in the Yoast path, `get_terms()` argument types and one class
  name case mismatch.
- Delete `includes/class-wp-post-nav-shortcode.php` from WordPress.org SVN
  `trunk/` at the next deliberate release.
