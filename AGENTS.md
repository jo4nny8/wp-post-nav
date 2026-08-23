# WP Post Nav agent guidance

## Project definition

- Project: WP Post Nav
- Type: WordPress plugin
- WordPress.org slug: `wp-post-nav`
- Text domain: `wp-post-nav`
- Project prefix for new code: `wppn`
- Repository: `jo4nny8/wp-post-nav`
- Source: WordPress.org Plugin Repository
- Development workflow: Jo4nny8

## Working rules

- Use British English in new comments, documentation, changelogs, and user-facing prose.
- Use `wppn_` for new procedural functions, and `WPPN_` for new classes.
- Do not rename or remove existing public functions, hooks, filters, shortcodes, options, database values, CSS classes, or template paths without a documented compatibility layer.
- Keep `main` aligned with production and use `develop` for active work. Feature and fix branches should start from `develop`.
- Do not commit generated packages, Composer dependencies, IDE metadata, temporary files, or local environment files.
- Do not publish to WordPress.org SVN without an explicit release decision and a reviewed package.

## Validation

Before completing a change, run the checks appropriate to its scope:

- `composer validate --no-check-publish`
- `composer run lint:php`
- `composer run build`
- `unzip -t wp-post-nav.zip`
- `git diff --check`

PHPCS and PHPStan are available. Existing legacy findings are documented and should not be hidden by adding a baseline without review.

## Compatibility boundary

The current plugin contains legacy names such as `wp_post_nav_*` and `wp_post_nav_*_color`. These are compatibility-sensitive and must remain unchanged. New code should use `wppn_` or `WPPN_` as specified above.
