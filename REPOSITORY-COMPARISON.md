# WordPress.org Repository Comparison

Comparison date: 2026-08-23

## Upstream identity

- Plugin: WP Post Nav
- Slug: `wp-post-nav`
- WordPress.org: <https://wordpress.org/plugins/wp-post-nav/>
- SVN repository: <https://plugins.svn.wordpress.org/wp-post-nav/>
- Fetched SVN revision: `3661533`
- Published version: `2.0.3`
- Latest tag: `2.0.3`
- Author: `Jo4nny8`

The WordPress.org page and plugin header identify the same plugin. The official page reports WordPress 6.0+ and PHP 8.0+ support.

## Repository structure

The official repository contains `trunk/`, `tags/`, `branches/`, and `assets/`. Tags run from `0.0.1` through `2.0.3`. The repository assets contain the directory banner, icons, and four screenshots.

## Local versus upstream trunk

The upstream trunk contains 36 source files. The local Phase 1 tree contains the same core layout plus the modernisation documentation and changes.

Upstream-only source retained in the Git import:

- `includes/class-wp-post-nav-shortcode.php`

Files changed by the Phase 1 modernisation include:

- `wp-post-nav.php`
- `includes/class-wp-post-nav.php`
- `includes/class-wp-post-nav-activator.php`
- `admin/class-wp-post-nav-admin.php`
- `public/class-wp-post-nav-public.php`
- `public/partials/wp-post-nav-public-attachment.php`
- `public/partials/wp-post-nav-public-default.php`
- `public/partials/wp-post-nav-public-primary.php`
- `README.txt`

The local-only modernisation documents are `DEVELOPMENT-ASSESSMENT.md` and `CHANGELOG.md`.

## Import decision

The official trunk was committed as the 2.0.3 baseline before the local modernisation was copied back. The official `tags/` and `assets/` directories remain available for historical reference. No upstream-only source was removed.
