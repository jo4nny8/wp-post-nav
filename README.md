# WP Post Nav

## Purpose

WP Post Nav provides previous and next navigation for posts, pages and supported custom post types, including WooCommerce products and attachments, for WordPress site owners. It is published on WordPress.org as [`wp-post-nav`](https://wordpress.org/plugins/wp-post-nav/).

## Ownership

- Owner: John Bosworth (`jo4nny8`)
- Repository: `jo4nny8/wp-post-nav`
- Visibility: public
- Licence: GPL-2.0-or-later (see `LICENSE.txt`)

## Configuration

The preferred interface is Appearance → Customise → WP Post Nav. The existing Settings → WP Post Nav page remains available for compatibility.

Version 2.1.0 stores validated settings in `wppn_settings`. On upgrade from 2.0.4, the plugin imports the existing `wp_post_nav_options` values, verifies the new option, records the migration marker and only then removes obsolete options.

## Architecture

- `wp-post-nav.php` loads the settings, migration, activation and deactivation classes and starts the plugin.
- `includes/` holds the core class, loader, settings, migrations, Customizer and shortcode code.
- `admin/` holds the legacy Settings page; `public/` holds front-end rendering, templates and assets.
- Development uses the local MAMP PRO site `plugins.test`. Releases are packaged with `bin/build-package.sh` and published separately to WordPress.org SVN.

## Boundaries

- `README.txt` is the public WordPress.org readme; `CHANGELOG.md` is the development changelog.
- `tags/` and `assets/` are historical WordPress.org material kept for reference and excluded from the package.
- Composer dependencies, built ZIPs, local WordPress files and secrets do not belong in this repository.

## Development

See [docs/DEVELOPMENT.md](docs/DEVELOPMENT.md) and [docs/TESTING.md](docs/TESTING.md) for the development workflow and validation commands.
See [ROADMAP.md](ROADMAP.md) for the current maintenance and release sequence.

## Getting Started

Read `AGENTS.md` first. Use `DEVELOPMENT_CONTEXT.md` for warm continuations when one exists; read `CURRENT_STATE.md` and `ROADMAP.md` on a cold start or when context is stale.
