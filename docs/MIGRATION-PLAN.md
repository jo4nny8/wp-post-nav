# WP Post Nav migration plan

This plan prepares WP Post Nav for safe future maintenance without changing behaviour during the workflow migration. All new code must use the `wppn_` function prefix or `WPPN_` class prefix.

## Phase 1 - Workflow compliance

Status: complete

- Import the official WordPress.org repository baseline.
- Preserve `main`, `develop`, historical tags, and repository assets.
- Map the project to `jo4nny8/wp-post-nav`.
- Add project guidance, development documentation, audit records, and a repeatable package build.
- Configure Composer, PHP_CodeSniffer, WordPress Coding Standards, PHPCompatibility, and PHPStan.
- Establish British English as the standard for new and maintained project prose.
- Keep the WordPress.org SVN publishing path separate from GitHub development.

## Phase 2 - Maintenance improvements

Prerequisite: create a compatibility inventory and initial integration tests.

- Add tests for activation, deactivation, upgrade migration, uninstall, settings validation, shortcode output, and empty navigation states.
- Test posts, pages, custom post types, attachments, products, and relevant SEO integrations.
- Review capability checks, nonces, sanitisation, validation, escaping, translation functions, and error handling.
- Reduce PHPStan findings in small, reviewable groups.
- Resolve high-value PHPCS findings without renaming public interfaces.
- Update documentation and regenerate translations when behaviour or strings change.

## Phase 3 - Architecture improvements

Prerequisite: Phase 2 regression coverage and a documented public-interface map.

- Consolidate duplicated bootstrap and shortcode structures where safe.
- Separate settings, navigation querying, data preparation, and rendering responsibilities.
- Reduce inline CSS and duplicated templates while preserving existing markup hooks and override paths where possible.
- Introduce `WPPN_` classes and `wppn_` helpers only for new or migrated internals.
- Provide deprecated wrappers or adapters for any public interface that must eventually move.
- Improve extensibility through documented filters and stable data objects.

## Phase 4 - Future features

Potential future work should be proposed and reviewed separately from maintenance:

- Accessibility enhancements and semantic navigation improvements.
- More flexible rendering and template overrides.
- Improved editor or block integration.
- Additional navigation rules for custom content relationships.
- Optional asset build improvements, including SCSS or another documented approach.

Each feature requires a defined compatibility impact, tests, documentation, changelog entry, and release decision.

## Backwards-compatibility rules

Do not remove or rename existing public functions, hooks, filters, shortcodes, options, database values, CSS classes, IDs, or template override paths during migration. If a rename becomes necessary, provide a deprecated wrapper, migration function, or adapter, document the transition, and retain the old interface for an appropriate release period.

## Release gates

Before promoting a release from `develop` to `main`:

- Confirm the version in the plugin header and documentation is synchronised.
- Update `CHANGELOG.md` with an ISO 8601 timestamp.
- Run PHP syntax, Composer, package, and ZIP checks.
- Review PHPCS and PHPStan changes.
- Run the available integration and browser tests.
- Inspect the final ZIP for unwanted files.
- Obtain an explicit decision before publishing to WordPress.org SVN.
