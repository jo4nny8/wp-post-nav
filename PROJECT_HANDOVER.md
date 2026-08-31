# WP Post Nav Project Handover

Updated: 2026-08-30T23:26:24+01:00

## Project identity

- Product: WP Post Nav
- Type: public WordPress plugin
- Repository: `jo4nny8/wp-post-nav`
- Canonical Mac working copy: `/Users/johnbosworth/Sync Folder/Dev/plugins.test/wp-content/plugins/wp-post-nav`
- Development site: `plugins.test`
- Active development branch: `develop`
- Production branch: `main`
- NAS reference: `/volume2/Development/Repositories/personal/checkouts/wp-post-nav`

## Start every task

1. Read `AGENTS.md`, `CODEX.md`, `ROADMAP.md` and this handover.
2. Check the working tree and preserve unrelated changes.
3. Fetch GitHub and confirm work starts from the correct branch.
4. Review `CHANGELOG.md` and the relevant document under `docs/`.
5. Keep compatibility-sensitive hooks, options, markup and identifiers stable.

## Current state

- Development version: `2.1.0`.
- Current approved development revision: `97cb66d`.
- WordPress 7.1 runtime loading and 16 tests with 47 assertions pass.
- Thirty pre-existing PHPStan findings remain documented.
- WordPress.org publication is a separate explicit release decision.

## Finish every task

- Run the checks appropriate to the change.
- Update `CHANGELOG.md` with an ISO 8601 completion timestamp.
- Review the diff and secret scan before committing.
- Push the approved branch to GitHub.
- Synchronise the approved GitHub revision to the NAS reference checkout.
- Report revisions, checks and any remaining limitation.
