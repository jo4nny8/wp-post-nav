# WP Post Nav Roadmap

Updated: 2026-08-31T15:18:32+01:00

## Next Up

1. Classify and resolve the 30 documented PHPStan findings in small
   compatibility-preserving batches.
2. Complete a focused WordPress 7.1 manual test of the version `2.1.0`
   Customizer, settings migration and front-end navigation behaviour.
3. Decide whether the resulting `develop` revision is ready for a deliberate
   WordPress.org release candidate.

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
