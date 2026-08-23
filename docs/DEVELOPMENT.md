# WP Post Nav development guide

## Project definition

| Field | Value |
| --- | --- |
| Project | WP Post Nav |
| Type | WordPress plugin |
| WordPress.org slug | `wp-post-nav` |
| Text domain | `wp-post-nav` |
| New-code prefix | `wppn` / `WPPN_` |
| GitHub repository | `jo4nny8/wp-post-nav` |
| Official source | WordPress.org Plugin Repository |
| Current development version | `2.0.4` |

## Local workflow

1. Start from an up-to-date `develop` branch.
2. Create a focused `feature/` or `fix/` branch.
3. Preserve existing public interfaces and document any compatibility concern.
4. Use British English for new comments, documentation, changelogs, and user-facing prose.
5. Run validation appropriate to the change.
6. Review the package contents before merging or publishing.
7. Merge completed work into `develop`; promote only reviewed releases to `main`.

## Required checks

```bash
composer validate --no-check-publish
composer run lint:php
composer run build
unzip -t wp-post-nav.zip
git diff --check
```

`composer run lint:phpcs` and `composer run analyse` are also available. Their current legacy findings are recorded in `DEVELOPMENT-ASSESSMENT.md`; they are useful for measuring improvement but are not yet zero-failure gates.

## Packaging

Run `bin/build-package.sh` to create the distribution archive. The package excludes Git metadata, development documentation, Composer files, dependencies, historical tags, repository assets, build output, and temporary archives. The plugin’s `README.txt`, `languages/`, runtime files, and required assets remain included.

## Compatibility

Do not rename existing `wp_post_nav_*` functions, classes, options, hooks, filters, shortcode names, CSS classes, IDs, or template paths. New interfaces should use `wppn_` or `WPPN_` and should be introduced with documentation and tests.
