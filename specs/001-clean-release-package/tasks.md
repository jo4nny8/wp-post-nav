# Tasks: Clean release package

**Input**: Design documents from `/specs/001-clean-release-package/`

**Prerequisites**: plan.md, spec.md, research.md, quickstart.md

**Tests**: no automated test tasks (not requested); each story is checked by
the quickstart steps.

## Phase 1: Setup

- [x] T001 Record the current package contents as the "before" list (31 development or tool files found: 29 from Spec Kit, `README.md`, `CHANGELOG.md`)

## Phase 2: Foundational

None.

## Phase 3: User Story 1 - Only the plugin goes in the package (Priority: P1) MVP

**Goal**: the ZIP holds only plugin files plus the WordPress.org readme, licence, translations and examples.

**Independent Test**: quickstart steps 1 to 3.

- [x] T002 [US1] Replace the exclude list with an allow list of top-level items in `bin/build-package.sh`
- [x] T003 [US1] Build and list the package; confirm the plugin files match the "before" build in `wp-post-nav.zip` (not committed)

## Phase 4: User Story 2 - The build stops if a development file slips in (Priority: P2)

**Goal**: any hidden file, Markdown file or unknown top-level item stops the build and is named.

**Independent Test**: quickstart step 4.

- [x] T004 [US2] Add the guard check before zipping in `bin/build-package.sh`
- [x] T005 [US2] Build with a stray `includes/STRAY.md`; confirm failure and the file is named, then remove it

## Phase 5: Polish

- [x] T006 [P] Correct the out-of-date note about package exclusions in `AGENTS.md` ("WordPress.org release")
- [x] T007 [P] Add an Unreleased entry in `CHANGELOG.md`
- [x] T008 Run `git diff --check`, `sh -n bin/build-package.sh` and a secret scan of the diff

## Dependencies

T001 → T002 → T003 → T004 → T005; T006 and T007 can run alongside any of them; T008 last.

## Implementation Strategy

User Story 1 alone already fixes today's package. User Story 2 keeps it fixed.
