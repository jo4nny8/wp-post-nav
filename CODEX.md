# WP Post Nav Codex workflow

## Project definition

```text
Project: WP Post Nav
Type: WordPress Plugin
Slug: wp-post-nav
Text Domain: wp-post-nav
Project Prefix: wppn
Repository: jo4nny8/wp-post-nav
Source: WordPress.org Plugin Repository
Development Workflow: Jo4nny8
```

## Branch model

- `main` is the production branch and currently represents the official WordPress.org `2.0.3` baseline.
- `develop` is the active development branch and currently contains the local `2.0.4` modernisation and development tooling.
- Use `feature/<name>` or `fix/<name>` branches from `develop` for isolated work.

## Commit model

Use small, focused commits. Documentation, audit findings, tooling, bug fixes, and releases should be separable. Commit messages should use imperative English, for example:

```text
Add WP Post Nav workflow documentation
Create WP Post Nav standards audit
Document WP Post Nav migration plan
```

## Development conventions

New functions must use the `wppn_` prefix, for example `wppn_render_navigation()`. New classes must use the `WPPN_` prefix, for example `WPPN_Public`. Existing public APIs remain unchanged until a backwards-compatible migration is designed.

## Release boundary

WordPress.org SVN is a separate publishing destination. A release requires a reviewed version update, synchronised documentation, a clean package, validation, and an explicit decision to publish.
