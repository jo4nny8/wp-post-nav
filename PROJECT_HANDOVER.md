# WP Post Nav Project Handover

Updated: 2026-10-14 (branch and state corrected from the 13 October 2026 repository capture)

## Project identity

- Product: WP Post Nav
- Type: public WordPress plugin
- Repository: `jo4nny8/wp-post-nav`
- Canonical Mac working copy: `/Users/johnbosworth/Sync Folder/Dev/plugins.test/wp-content/plugins/wp-post-nav`
- Development site: `plugins.test`
- Active release branch: `feature/release-2.1.0` (branched from `develop`; at
  the 13 October 2026 capture it was at `f55c5ca` with no GitHub upstream, so its
  four release-preparation commits existed only on the Mac until pushed)
- Integration branch: `develop` (`206a001`)
- Production branch: `main` (`c3463be`, the WordPress.org 2.0.3 import)
- GitHub default branch: origin/HEAD still points to the legacy `master`
  (`e5e25b4`, "Initial commit"); retiring it is a separate decision
- NAS reference: `/volume2/Development/Repositories/personal/checkouts/wp-post-nav`

## Start every task

1. Read `AGENTS.md`, `CODEX.md`, `ROADMAP.md` and this handover.
2. Check the working tree and preserve unrelated changes.
3. Fetch GitHub and confirm work starts from the correct branch.
4. Review `CHANGELOG.md` and the relevant document under `docs/`.
5. Keep compatibility-sensitive hooks, options, markup and identifiers stable.

## Current state

- Development version: `2.1.0`.
- Current release-candidate revision: `feature/release-2.1.0` @ `f55c5ca`
  (supersedes the earlier `97cb66d` on `develop`).
- WordPress 7.1 runtime loading passes; unit tests and WordPress integration
  tests (`wppn_tests_` prefix on `plugins.test`) pass.
- PHPStan findings: 30 at the capture; the overnight patch set and six focused
  WP-08 batches resolve all findings (see `CHANGELOG.md`).
- The 2.1.0 Customizer, settings migration and front end still need a
  real-browser WordPress 7.1 acceptance test before any release decision.
- WordPress.org publication is a separate explicit release decision.

## Finish every task

- Run the checks appropriate to the change.
- Update `CHANGELOG.md` with an ISO 8601 completion timestamp.
- Review the diff and secret scan before committing.
- Push the approved branch to GitHub.
- Synchronise the approved GitHub revision to the NAS reference checkout.
- Report revisions, checks and any remaining limitation.
