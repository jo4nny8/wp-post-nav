# WP Post Nav

WP Post Nav provides previous and next navigation for posts, pages and supported custom post types.

## Configuration

The preferred interface is Appearance → Customise → WP Post Nav. The existing Settings → WP Post Nav page remains available for compatibility.

Version 2.1.0 stores validated settings in `wppn_settings`. On upgrade from 2.0.4, the plugin imports the existing `wp_post_nav_options` values, verifies the new option, records the migration marker and only then removes obsolete options.

## Development

See [docs/DEVELOPMENT.md](docs/DEVELOPMENT.md) and [docs/TESTING.md](docs/TESTING.md) for the development workflow and validation commands.
