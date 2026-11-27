# Implementation Plan: Clean release package

**Branch**: `agents/spec-kit-trial` | **Date**: 2026-11-27 | **Spec**: [spec.md](spec.md)

**Input**: Feature specification from `/specs/001-clean-release-package/spec.md`

## Summary

Change `bin/build-package.sh` from a list of things to leave out to a short
list of things to put in, then check the staged package before zipping and
stop with the offending names if anything unexpected is there.

## Technical Context

**Language/Version**: POSIX `sh`, as the script is today

**Primary Dependencies**: `rsync` and `zip` (already used by the script)

**Storage**: N/A

**Testing**: build the package and list it; build again with a stray file and
confirm it fails. No PHP test change: plugin code is untouched.

**Target Platform**: John's Mac and the NAS (macOS and Linux `sh`)

**Project Type**: WordPress plugin; this change is to its build script only

**Performance Goals**: N/A

**Constraints**: must keep working on macOS's BSD tools (no GNU-only flags)

**Scale/Scope**: one script, about 40 lines

## Constitution Check

*GATE: Must pass before Phase 0 research. Re-check after Phase 1 design.*

| Principle | Result |
|---|---|
| I. Existing rules first | Pass: follows `AGENTS.md` "WordPress.org release" and issue #6 item 2 |
| II. Compatibility | Pass: no plugin code, option, hook or file path changes |
| III. Literal scope | Pass: build script and its records only; other findings go to issues |
| IV. Proportionate checks | Pass: build, list, stray-file failure, `git diff --check` |
| V. Publishing separate | Pass: no version, tag, SVN or upload |

Re-checked after design: still passes.

## Project Structure

### Documentation (this feature)

```text
specs/001-clean-release-package/
├── plan.md        # This file
├── research.md    # Phase 0 output
├── quickstart.md  # Phase 1 output (how to check it)
└── tasks.md       # Phase 2 output
```

No `data-model.md` (no data) and no `contracts/` (the script has no outside
interface beyond `composer run build`, which is unchanged).

### Source Code (repository root)

```text
bin/build-package.sh   # the only source file changed
AGENTS.md              # correct the out-of-date note about what the build leaves out
CHANGELOG.md           # Unreleased entry
```

**Structure Decision**: single script change; no new files in the plugin.

## Complexity Tracking

None.
