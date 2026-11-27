# Feature Specification: Clean release package

**Feature Branch**: `agents/spec-kit-trial` (Spec Kit's own `001-…` branch naming is not used here)

**Created**: 2026-11-27

**Status**: Implemented 2026-11-27

**Input**: User description: "Make sure the plugin ZIP that goes to WordPress.org contains only the plugin, never our development notes or agent tools, and stops if something slips in." Taken from open issue #6, item 2 ("confirm the release package build excludes them").

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Only the plugin goes in the package (Priority: P1)

When John builds the release package, it contains only the files a WordPress
site needs to run WP Post Nav and the files WordPress.org expects (the public
readme, licence, translations and developer examples). Development notes,
agent instruction files, Spec Kit records and tool folders are left out.

**Why this priority**: the repository is public and the package goes to every
site that installs the plugin. Shipping internal notes looks careless and can
expose private working detail.

**Independent Test**: build the package and list its contents.

**Acceptance Scenarios**:

1. **Given** the repository as it stands today, **When** the package is built,
   **Then** it contains no `README.md`, `CHANGELOG.md`, `.claude/`,
   `.specify/` or `specs/` entries.
2. **Given** the package is built, **When** it is compared with the
   published 2.0.3 release, **Then** every top-level item it contains was
   also in that release (or is a deliberate plugin file).

---

### User Story 2 - The build stops if a development file slips in (Priority: P2)

If someone later adds a new development folder or note and forgets to exclude
it, the build refuses to finish and names the file, instead of quietly putting
it in the package.

**Why this priority**: the exclusion list has already fallen behind once
(installing Spec Kit added 29 files that went straight into the package). A
check stops that happening again without anyone remembering.

**Independent Test**: add a stray development file, build, and confirm the
build fails and names it.

**Acceptance Scenarios**:

1. **Given** a new file `NOTES.md` at the top of the repository, **When** the
   package is built, **Then** it is simply left out (only agreed top-level
   items are ever copied).
2. **Given** a stray `STRAY.md` or hidden `.env` inside an allowed folder,
   **When** the package is built, **Then** the build fails and names it.
3. **Given** no stray files, **When** the package is built, **Then** the build
   succeeds as before.

### Edge Cases

- A stray file inside an allowed folder (for example a `.md` file in
  `includes/`) must also stop the build.
- Hidden files (names starting with a dot) must not reach the package, except
  `public/css/.htaccess`, which the plugin has always shipped. *(Corrected
  during implementation: the first draft said "never", which would have
  dropped a real plugin file. Found by comparing the before and after file
  lists, not by the spec checklist.)*
- An existing package from an earlier build must not be mixed into the new one.

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: The package MUST contain only the plugin's runtime files plus
  `README.txt`, `LICENSE.txt`, `Examples.txt` and the `languages/` folder.
- **FR-002**: The package MUST NOT contain any root development document
  (`README.md`, `CHANGELOG.md`, `AGENTS.md`, `CLAUDE.md`, `CODEX.md`,
  `CURRENT_STATE.md`, `FILESYSTEM_MAP.md`, `ROADMAP.md`,
  `PROJECT_HANDOVER.md`, `DEVELOPMENT_CONTEXT.md`, assessments), any hidden
  file other than `public/css/.htaccess`, or the `specs/` folder.
- **FR-003**: The build MUST fail, naming each offending file, when the staged
  package holds anything outside an agreed list of allowed top-level items or
  any Markdown file.
- **FR-004**: The plugin's behaviour, version and `Stable tag` MUST NOT change.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: The built package holds 0 development or tool files (down from
  31 today: 29 Spec Kit files, `README.md` and `CHANGELOG.md`).
- **SC-002**: A deliberately added stray file stops the build every time.
- **SC-003**: The package's plugin files are identical to those built before
  the change.

## Assumptions

- `Examples.txt` stays in the package: it was in the published 2.0.3 release
  and documents the public filters for developers.
- The WordPress.org banner and icon images in `assets/` stay out of the ZIP,
  as now; WordPress.org takes them through SVN separately.
- No release is made as part of this work.
