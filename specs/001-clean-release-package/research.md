# Research: Clean release package

## Allow list or deny list

- **Decision**: copy an allow list of top-level items (`admin/`, `includes/`,
  `languages/`, `public/`, `index.php`, `uninstall.php`, `wp-post-nav.php`,
  `README.txt`, `LICENSE.txt`, `Examples.txt`).
- **Rationale**: the deny list fell behind twice: `README.md` and
  `CHANGELOG.md` were never on it, and installing Spec Kit added 29 files that
  went straight into the ZIP. New development files appear far more often than
  new plugin folders.
- **Alternatives considered**: keep the deny list and add the missing names
  (fixes today, breaks again with the next tool).

## Guard check

- **Decision**: after staging, fail if the package holds any `.md` file, any
  top-level item outside the allow list, or any hidden file other than
  `public/css/.htaccess` (the plugin's CSS rewrite rule, shipped since 0.1.1),
  listing each one.
- **Rationale**: catches a stray note inside an allowed folder too (spec edge
  case). Uses only `find`, which behaves the same on macOS and Linux.
- **Alternatives considered**: comparing with the 2.0.3 file list (would block
  legitimate new plugin files).

## What stays in

- `Examples.txt` was in the published 2.0.3 release (checked against `main`),
  so it stays. `assets/` (WordPress.org banners) stays out, as now.
