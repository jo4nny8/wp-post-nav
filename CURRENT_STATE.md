# Current State

**Verified:** 2026-10-15T13:10:52+01:00 (from the GitHub branches and the
repository files; the local site and WordPress.org were not inspected)

## Status

- Published on WordPress.org: version `2.0.3` (WordPress.org comparison of
  2026-08-23, `REPOSITORY-COMPARISON.md`).
- `main` (`c3463be`): the published WordPress.org 2.0.3 import.
- `develop` (`206a001`): integration branch with the `2.1.0` settings
  abstraction, Customizer migration, development tooling, handover and
  roadmap.
- `feature/release-2.1.0` (`f55c5ca`, now on GitHub): four 2.1.0
  release-preparation commits not yet merged into `develop`.
- `claude/overnight-review-20261014` (`a1cbe6d`, on GitHub): unmerged review
  work including PHPStan fixes and package-exclusion changes.
- GitHub's default branch is still the legacy `master` (`e5e25b4`, 2018).
- Local development site: `plugins.test` (MAMP PRO).
- WordPress.org publication of 2.1.0 has not been decided.

## Versions

- Plugin header version on `develop`: `2.1.0`.
- `README.txt` on `develop`: requires WordPress 6.0 and PHP 8.0; tested up to
  WordPress 6.8; `Stable tag: 2.1.0`.
- Development tooling: PHPUnit 10, PHPCS with WordPress Coding Standards,
  PHPStan 2 (Composer `require-dev`). GitHub Actions runs Composer
  validation, PHP syntax and unit tests on pull requests and on pushes to
  `main` and `develop`.

## Known Limitations

- `PROJECT_HANDOVER.md` (2026-08-30) recorded 16 unit tests with 47
  assertions passing and WordPress 7.1 runtime loading on `plugins.test`.
- 30 pre-existing PHPStan findings were documented on `develop`; the unmerged
  overnight review branch reports them resolved.
- The 2.1.0 Customizer, settings migration and front-end navigation still need
  a focused manual WordPress 7.1 test (`ROADMAP.md`).
- The `develop` package script does not exclude every root development
  document from the distribution ZIP (see `AGENTS.md`).
