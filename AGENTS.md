# WP Post Nav Agent Entry Point

On every task, before any other step, read these afresh (not from a summary
of an earlier session):

1. the global agents file (`development_project_framework/agents/global_agents.md`)
   and the Authority Matrix (`development_project_framework/CODEX_AUTHORITY_MATRIX.md`).
   They set the rules, approvals, working modes, Git process, house rules and
   reporting style for every project;
2. this file, for this project's own rules; and
3. for any coding or development work, the development standards in
   `jo4nny8/jo4nny8-development-standards`: its `AGENTS.md` and the
   `standards/` folder, which say how code is written, checked and documented
   (Mac: `~/Development/Personal/jo4nny8-development-standards`; NAS:
   `/volume2/Development/Work/personal/jo4nny8-development-standards`).

This file covers this project only and cannot widen the global file or the
Authority Matrix; if this file or the standards disagree with those two,
those two win. Changes that affect other projects or the global rules go through the
Master Project (global file section 3.7).

## Project

- Purpose: a public WordPress plugin that adds previous and next navigation to
  posts, pages, products and supported custom post types, published on
  WordPress.org as `wp-post-nav`.
- Owner: John Bosworth (personal)
- Repository: `jo4nny8/wp-post-nav` (public)
- Default branch: `develop` is the integration branch; `main` is the
  production branch holding the published WordPress.org 2.0.3 import. GitHub's
  default branch is still the legacy `master`, so always target `develop`
  explicitly when opening pull requests.
- Canonical Mac working copy:
  `/Users/johnbosworth/Development/websites/plugins.test/wp-content/plugins/wp-post-nav`
- NAS reference copy:
  `/volume2/Development/Repositories/personal/checkouts/wp-post-nav`
- Runtime and environments: the local MAMP PRO site `plugins.test`; the
  public release channel is the WordPress.org plugin directory (SVN).
- Putting a branch on the Mac for John to test: check out the branch in the
  canonical Mac working copy (the MAMP PRO site `plugins.test` serves this
  folder), reload `http://plugins.test/wp-admin/plugins.php` and confirm the
  plugin version and the changed behaviour (global file section 3.1, "Ready
  means on the Mac").

## Tools

- PHP and JavaScript readers; also search hook names as plain text, because
  WordPress wires code up by name.
- `/security-review` before asking John to make a change official.
- Python, Swift, Xcode and the ads connectors (company tools) are not used
  here. CodeGraph is not used.

## Read First

- Cold start: `README.md`, `CURRENT_STATE.md`, `ROADMAP.md`, then
  `FILESYSTEM_MAP.md` to find the files for the task. `PROJECT_HANDOVER.md`,
  `docs/DEVELOPMENT.md` and `docs/TESTING.md` hold the detailed workflow and
  test guidance.
- Warm continuation of the same feature: `DEVELOPMENT_CONTEXT.md`, refreshing
  only stale facts. None exists yet; create it from the starter set when a
  sustained feature batch begins.

## Project Rules

### Identity

- Type: WordPress plugin. WordPress.org slug and text domain: `wp-post-nav`.
- Project prefix for new code: `wppn`. New procedural functions use `wppn_`
  (for example `wppn_render_navigation()`); new classes use `WPPN_` (for
  example `WPPN_Public`).
- Source of record for published releases: the WordPress.org Plugin
  Repository. Development workflow: Jo4nny8.

### Compatibility

- Do not rename or remove existing public functions, classes, hooks, filters,
  the `[wp_post_nav]` shortcode, options, database values, CSS classes, IDs or
  template paths without a documented, backwards-compatible migration.
- Legacy names such as `wp_post_nav_*` and `wp_post_nav_*_color` are
  compatibility-sensitive and must stay unchanged. Only new code uses the
  `wppn_` / `WPPN_` prefix.
- Settings: since 2.1.0, `WPPN_Settings` (option `wppn_settings`) is the single
  validation and formatting boundary for the Settings page, Customizer and
  front end. `WPPN_Migrations` imports the 2.0.4 `wp_post_nav_options`
  structure, verifies the new option, records `wppn_migration_210_complete`
  and only then removes obsolete options. Keep the migration idempotent and
  non-destructive if persistence cannot be verified.
- Preserve WooCommerce, Yoast SEO and The SEO Framework integration behaviour.

### Uninstall and stored data

- `uninstall.php` removes `wp_post_nav_options`, `wppn_settings`,
  `wppn_migration_210_complete` and `wp_post_nav_version`. Any new stored
  option must be added there in the same change.

### Branches

- `main` stays aligned with production (the published WordPress.org release);
  `develop` is for active work. Start `feature/<name>` or `fix/<name>` branches
  from `develop`, and promote only reviewed releases to `main`.
- Keep documentation, audit findings, tooling, bug fixes and releases in
  separate, focused commits.

### Public repository

- This repository is public. Review every push for secrets, private paths
  beyond those already recorded here, and private material.
- Do not commit generated packages, Composer dependencies, IDE metadata,
  temporary files or local environment files.

### WordPress.org release

- WordPress.org SVN is a separate publishing destination. GitHub and
  WordPress.org publication are separate decisions. Never commit to SVN, tag,
  or change the version or `Stable tag` without an explicit release decision.
- A release needs a reviewed version update, synchronised documentation
  (including `README.txt`, the WordPress.org readme and changelog), a clean
  package, validation, and an explicit decision to publish.
- `CHANGELOG.md` is the development changelog; `README.txt` carries the
  public WordPress.org changelog.
- Build the distribution archive with `composer run build`
  (`bin/build-package.sh`) and inspect it with `unzip -l wp-post-nav.zip`
  before any release. The script copies only an allow list of plugin files
  and folders (plus `README.txt`, `LICENSE.txt` and `Examples.txt`) and stops,
  naming the file, if a Markdown file or unexpected hidden file reaches the
  package. A new plugin folder or top-level file must be added to that list
  on purpose.

### Validation

Run the checks appropriate to the change:

- `composer validate --no-check-publish`
- `composer run lint:php`
- `composer run test` (unit) and, with the WordPress test library,
  `WP_TESTS_DIR=… composer run test:integration`
- `composer run build` then `unzip -t wp-post-nav.zip`
- `git diff --check`

`composer run lint:phpcs` and `composer run analyse` (PHPStan) are available.
Their legacy findings are documented in `DEVELOPMENT-ASSESSMENT.md`; do not
hide them by adding a baseline without review.

## Project files

This project's shared files in claude.ai follow John's project files
standard. The master copy is
[`standards/project-files.md`](https://github.com/jo4nny8/jo4nny8-development-standards/blob/main/standards/project-files.md)
in `jo4nny8/jo4nny8-development-standards`. Git stays the master for
everything in this repository.

- Folders, with nothing at the top level:
  1. `01-PROJECT-INFO`: the standard, plus copies of this repository's
     `AGENTS.md`, `ROADMAP.md`, `CHANGELOG.md`, `CURRENT_STATE.md` and
     `README.md`.
  2. `02-MODULES/<module>/`: `reports`, `plans`, `notes`, `screenshots` and a
     `README.md`. Folder names match this project's own module names.
  3. `03-KNOWLEDGE`: background and reference.
  4. `04-SCREENSHOTS`: whole-project screenshots only.
  5. `999-HANDOVER`: old handovers, kept for history.
- File names: `WHAT-IT-IS-YYYY-MM-DD.ext` in capitals, for example
  `SEO-AUDIT-2026-10-19.md`. A newer version gets a new date and the old one
  stays.
- Threads: titles start with their module, for example "Marketing: monthly
  SEO check". Every project has five starter threads: "<Project>: Design",
  "<Project>: Roadmap", "<Project>: Issues", "<Project>: Releases" and
  "<Project>: Health check".
- Talking to John: plain English, with no pull request numbers, branch names
  or Git terms unless he asks. Describe each change in one plain sentence and
  ask "OK to make this official?" (John, 19 October 2026).
- Company files, photos and data belong in the project files, never in Git.

## Records To Keep Current

When a change set is agreed (global file section 4.1), update the affected
`CHANGELOG.md`, `ROADMAP.md`, `CURRENT_STATE.md`, `FILESYSTEM_MAP.md` and
`README.md` here, plus the Project Registry and global file if the project's
location, routing or operation changed. Keep `README.txt` in step only as part
of an agreed WordPress.org release.

## Issues

Things to fix are GitHub issues in this repository, using the shared labels;
`ROADMAP.md` is what to build next. Check open issues at the start of work and
record unrelated findings as issues (global agents file section 6.4).
