# WP Post Nav standards audit

Audit date: 2026-08-23  
Version reviewed: `2.0.4`  
Branch reviewed: `develop`  
Source baseline: WordPress.org SVN revision `3661533`, with the local `2.0.4` modernisation applied.

## Project definition

- Project: WP Post Nav
- Type: WordPress plugin
- WordPress.org slug: `wp-post-nav`
- Text domain: `wp-post-nav`
- Project prefix for new code: `wppn`
- Repository: `jo4nny8/wp-post-nav`

## Passed

### Repository and release structure

- Git repository is established and mapped to GitHub.
- `main` preserves the WordPress.org `2.0.3` production baseline.
- `develop` contains the active `2.0.4` development line.
- Historical WordPress.org tags and repository assets are retained in Git.
- A repeatable package build script exists and excludes development-only content.

### WordPress.org compatibility

- The plugin header identifies WP Post Nav, version `2.0.4`, text domain `wp-post-nav`, and `/languages`.
- `README.txt` contains the required plugin metadata, description, installation, FAQ, changelog, and upgrade sections.
- The official WordPress.org stable release remains `2.0.3`; the local `2.0.4` line is maintained on `develop` until it is deliberately released.
- The package contains the translation directory and POT file.
- The stable WordPress.org baseline and local changes are documented in `REPOSITORY-COMPARISON.md`.
- The plugin name and slug are consistent with the existing WordPress.org listing. No new trademark claim is introduced by this migration.

### Documentation and language

- `README.txt`, `CHANGELOG.md`, development documentation, and maintained comments use British English for new and revised prose.
- Compatibility-sensitive identifiers such as WordPress API names, CSS properties, option keys, and literal data attributes are preserved.
- A project definition, development guide, audit, and staged migration plan are now present.

### Tooling and validation

- Composer dependencies are locked for reproducible local analysis.
- PHP_CodeSniffer is configured with WordPress Coding Standards and PHPCompatibility.
- PHPStan is configured with WordPress stubs and a scoped analysis set.
- Current PHP syntax checks pass for the active plugin tree.
- Composer validation and distribution ZIP integrity checks pass.

## Needs improvement

### Coding standards and architecture

- PHPCS reports a substantial legacy backlog involving formatting, naming, escaping, documentation, and modern WordPress conventions.
- Classes and functions use historic `wp_post_nav_*` naming and inconsistent capitalisation. These must be addressed only through a compatibility-aware, staged migration.
- Several files have limited or incomplete PHPDoc and inconsistent spacing, comparison style, and function-call formatting.
- `includes/class-wp-post-nav-shortcode.php` duplicates the main plugin bootstrap structure and should be investigated before any consolidation.

### Static analysis and testing

- PHPStan reports existing findings, including type uncertainty around WordPress values and legacy code paths.
- No automated PHPUnit or WordPress integration test suite is currently committed.
- Upgrade, activation, deactivation, uninstall, shortcode, attachment, custom post type, and WooCommerce paths need integration coverage.

### Security and WordPress practices

- Settings validation has been improved, but the admin code still needs a systematic review of escaping, nonce handling, capability checks, and input/output boundaries.
- Some legacy output uses older translation and escaping patterns and should be reviewed incrementally.
- The shortcode implementation uses `extract()` and has duplicated rendering logic; this is a maintenance and data-boundary risk requiring tests before change.

### Frontend and accessibility

- CSS is delivered as hand-maintained CSS; there is no SCSS source or CodeKit configuration.
- The public renderer contains large inline CSS and duplicated templates, which makes responsive and accessibility improvements harder to verify.
- Keyboard, touch, focus, contrast, semantic navigation, and screen-reader behaviour require browser-based testing.
- Asset loading and stylesheet scope should be reviewed to minimise unnecessary frontend output.

### Documentation

- `README.txt` and the admin instructions contain legacy grammar, wording, and examples that should be corrected as part of a dedicated documentation pass.
- The POT file should be regenerated when translatable strings change.
- Release notes should continue to use ISO 8601 timestamps and record validation results.

## Legacy concerns

The following are deliberately not changed in this audit:

- Existing public functions, classes, hooks, filters, shortcode name, option names, database values, CSS classes, IDs, and template paths.
- Existing WordPress.org tags and historical snapshots.
- Existing option keys containing `_color`, even when maintained prose uses British `colour`.
- Large rendering and template structures, because refactoring them without integration tests could change output or third-party compatibility.
- The official WordPress.org release line, which remains a separate publishing target.

## Recommended priority

### Critical

- Add integration tests for activation, upgrades, settings persistence, shortcode output, and representative post types before architectural refactoring.
- Review all admin input and output boundaries for capability checks, nonces, sanitisation, validation, and escaping.

### High

- Reduce PHPStan findings in the active runtime path.
- Resolve the most important PHPCS security and WordPress errors.
- Map all public hooks, filters, shortcodes, options, and template override points in compatibility documentation.
- Replace duplicated rendering paths incrementally behind regression tests.

### Medium

- Improve PHPDoc and naming consistency without renaming public interfaces.
- Add a maintained frontend source strategy, choosing SCSS or documented CSS-only maintenance based on project needs.
- Add browser checks for keyboard access, focus, responsive layouts, contrast, and screen readers.
- Regenerate and review translation files as strings change.

### Low

- Correct remaining non-functional wording and examples.
- Consider automated release packaging and a CI workflow after local checks are stable.
- Review whether CodeKit compatibility adds value before introducing project-specific build complexity.

## Audit conclusion

The repository is ready for controlled maintenance under the Jo4nny8 workflow. It is not yet ready for a broad refactor or a zero-warning quality gate. The next safe step is to establish compatibility-focused integration tests and a public-interface inventory.
