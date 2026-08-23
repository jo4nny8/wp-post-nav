# WP Post Nav Customizer implementation plan

This is a staged implementation plan. Phase 4A documents the design only; no production settings or rendering code is changed until the relevant tests exist.

## Phase 1 — Create settings abstraction

- Add `WPPN_Settings` in `includes/class-wppn-settings.php`.
- Define one schema for defaults, types, allow-lists, sanitisation, and compatibility keys.
- Route existing admin reads and writes through the abstraction without changing the current settings page.
- Add tests for defaults, saved values, invalid values, checkbox absence, unknown keys, and option failures.
- Keep `wp_post_nav_options` as the canonical storage option.

## Phase 2 — Create Customizer sections and controls

- Add `WPPN_Customizer` in `includes/class-wppn-customizer.php`.
- Register the `WP Post Nav` panel and General, Navigation, Layout, Colours, Typography, Images, and Advanced sections.
- Map controls to existing canonical keys through the settings layer.
- Add capability checks, setting sanitisation, stable control IDs, and translation strings.
- Keep the existing settings page available and functional.
- Add integration tests for control registration and save callbacks.

## Phase 3 — Implement live preview

- Start with selective refresh for isolated, testable regions.
- Use preview JavaScript for control changes that can update CSS variables or classes without changing markup.
- Use CSS custom properties only when generated values, selectors, fallbacks, and sanitisation remain equivalent.
- Use a selective-refresh partial where the current renderer can return stable, complete markup.
- Fall back to a full refresh for query-dependent, SEO-dependent, WooCommerce-dependent, or otherwise unsafe changes.
- Test saved and unsaved preview states independently.

## Phase 4 — Move dynamic CSS generation

- Extract dynamic CSS value preparation from the current public class behind a renderer/settings boundary.
- Preserve `sanitize_hex_color()`, `absint()`, fallback values, enqueue order, selectors, and inline-style output.
- Compare representative generated CSS before and after the move.
- Add tests for colours, dimensions, missing values, invalid values, and shortcode output.
- Do not change CSS or markup as part of the extraction.

## Phase 5 — Deprecate the old settings page safely

- Keep the old settings page as a compatibility and recovery path for at least one planned release cycle.
- Display a clear migration/status notice only after the new path is verified.
- Document the Customizer as the preferred editor while preserving direct access to legacy settings.
- Remove or disable the old page only after usage, migration, rollback, and support impact have been reviewed.
- Never remove old options until the version-specific migration has completed successfully and its marker is verified.

## Migration sequence

1. Detect the current version and any historical standalone options.
2. Read values without assuming that any option exists.
3. Convert values to the canonical settings schema.
4. Apply and validate defaults.
5. Sanitise values at the new storage boundary.
6. Save the canonical structure.
7. Read it back and verify representative values.
8. Record `wppn_migration_210_complete` or the appropriate version marker.
9. Remove obsolete entries only after verification.
10. Preserve the old data and report an actionable error if any step fails.

Migrations must be version-specific and idempotent. They must not run destructively on every request or be inferred solely from `wp_post_nav_version`.

## Testing gates

Before each implementation phase is merged:

- Unit tests cover the settings schema and sanitisation.
- WordPress integration tests cover options, Customizer registration, save behaviour, and migration markers.
- Existing settings-page tests remain passing.
- Frontend baseline tests remain passing.
- PHPUnit, PHP syntax, PHPCS, PHPStan, package, and CI checks are recorded.
- Failed migration tests prove that old data remains recoverable.

## Recommended implementation order

Implement Phase 1 first, then the migration service and tests, then Phase 2 Customizer controls, followed by live preview and CSS extraction. Defer deprecating the existing settings page until the new path has been exercised against real upgraded data and representative frontend scenarios.
