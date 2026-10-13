# CLAUDE.md: WP Post Nav (public WordPress.org plugin)

Read these first. They are this repository's rules; this file only adds Claude Code notes and never widens them. The Codex Authority Matrix in `development_project_framework` is the sole authority source.

@AGENTS.md
@CODEX.md

This file must stay out of distribution ZIPs: confirm the build script excludes `CLAUDE.md` and `.claude/` before building.

## Ground rules (all repos)

- Use British English in prose, comments, commit messages and docs.
- Never run `git reset --hard`, `git clean`, `git checkout -- .`/`git restore` over others' changes, `git stash drop`/`clear`, `git branch -D` on unmerged work, a rebase of pushed history, or any force-push.
- Keep uncommitted and untracked work exactly as found. Stage only your own files (`git add -p` when a file is already modified). If existing work is in the way, stop and ask.
- No deploy, publish, release, tag, WordPress.org SVN commit, TestFlight/App Store upload, NAS/Pilot/Production change, or message to anyone without John's explicit say-so in the current conversation. Merging is not deploying.
- Never put secrets, credentials, customer data, databases, uploads or logs in Git or in your output.
- Personal (`jo4nny8`) and Aquarius company work stay separate: never copy code, branding or data across.
- Finish by reporting branch, commit, checks actually run, version/changelog changes, deployment status (normally "not deployed") and what is still unverified.

## Must-knows for this repository

- Personal repo `jo4nny8/wp-post-nav` at `~/Sync Folder/Dev/plugins.test/wp-content/plugins/wp-post-nav`. Release work is on `feature/release-2.1.0`; check whether it has an upstream before relying on GitHub. `develop` and `main` (the 2.0.3 import) are older; origin/HEAD still points to legacy `master`.
- Published on WordPress.org as 2.0.3. Never commit to SVN, tag, change `Stable tag` or publish: John does releases.
- Compatibility-locked: legacy `wp_post_nav_*` options, hooks, the `[wp_post_nav]` shortcode, CSS classes and templates. New code uses the `wppn_`/`WPPN_` prefix.
- Settings: `WPPN_Settings` (option `wppn_settings`) is the single read/write path; `WPPN_Migrations` imports `wp_post_nav_options` once, verifies, then deletes the legacy option. Legacy checkbox values arrive as `array( 'Yes' => 'Yes' )`; keep that format accepted.
- Checks: `composer lint:php`, `lint:phpcs`, `analyse` (legacy PHPStan findings; fix in small batches, no baseline), `test`, `test:integration` (uses the `plugins.test` DB with the `wppn_tests_` prefix; back up first), `build` then `unzip -l wp-post-nav.zip`.
- The 2.1.0 Customizer has never been accepted in a real browser (John saw it fail to load once). Don't call it working without a manual test.
- Uncommitted Apple Notes import drafts (`docs/import_drafts/`, `docs/imports/`) and their `ROADMAP.md` Ideas line await John's decision. Don't commit or delete them.
