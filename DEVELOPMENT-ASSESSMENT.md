# WP Post Nav Development Assessment

Assessment date: 2026-08-23
Current plugin version: 2.0.4
Plugin type: WordPress plugin (not a theme)

## Current architecture

WP Post Nav uses the WordPress boilerplate-style structure:

- `wp-post-nav.php` loads activation/deactivation classes and starts the plugin.
- `includes/class-wp-post-nav.php` creates the loader, translation, admin, and public components.
- `admin/class-wp-post-nav-admin.php` defines the Settings API screen, settings fields, validation, and media picker.
- `public/class-wp-post-nav-public.php` registers assets, the footer renderer, and the `[wp_post_nav]` shortcode.
- `public/partials/` contains separate rendering templates for posts, pages, products, attachments, custom post types, and primary-taxonomy navigation.
- `includes/class-wp-post-nav-activator.php` creates and migrates the single `wp_post_nav_options` option.
- `uninstall.php` removes plugin options.

The public renderer currently duplicates most markup and data preparation across six templates. A future rendering refactor should be a separate release because it has a high compatibility surface.

## Existing functionality

The plugin currently provides:

- Previous/next navigation for selected public post types.
- Same-taxonomy navigation.
- A shortcode alternative to footer navigation.
- Optional title, category, excerpt, and featured-image output.
- Configurable colours, dimensions, and fallback images.
- Attachment return navigation.
- Optional WooCommerce out-of-stock filtering.
- Optional Yoast SEO and SEO Framework primary-term integrations.
- Developer filters for post-type selection and excerpt behaviour.

## Phase 1 findings

### Critical

- Automatic display checks a boolean result from `is_singular()` against post-type names, so automatic navigation can be suppressed incorrectly.
- Shortcode mode uses option-key existence rather than a true setting value.
- The deactivation callback is registered as an activation hook.
- Version upgrades write the current version to an option named after the old version.
- Attachment navigation calls the undefined `___()` function.
- The SEO Framework primary-term branch contains reversed empty checks, undefined variables, and an unconditional Yoast class reference.
- Settings may be false or incomplete, causing unsafe array access on PHP 8+.

### Security and correctness

- Settings validation has a typo that leaves the open-background colour unchecked and omits heading colour/size validation.
- Dynamic CSS and HTML values need context-appropriate escaping and sanitization.
- Fallback-image validation checks only a URL extension.
- Unknown submitted option keys are accepted.
- Excerpt trimming is not multibyte-safe and can produce invalid offsets for short content.
- Custom-post-type category selection assumes the first registered taxonomy is the intended one.
- The custom-post-type template prints the previous category for the next item.

### Accessibility and presentation

- Navigation is revealed primarily through hover and has limited keyboard/touch support.
- List markup contains non-list children and fallback images use `<image>` instead of `<img>`.
- Navigation lacks a descriptive `aria-label` and robust focus states.
- Fixed panels and high z-index values can conflict with themes, menus, and overlays.

### Maintainability

- Classes and identifiers use inconsistent naming conventions.
- Settings defaults are duplicated between the activator and admin field definitions.
- Public templates duplicate data preparation and markup.
- No automated tests, static analysis configuration, or CI checks are present.
- The distributed ZIP contains `.DS_Store` and `__MACOSX` entries.
- `languages/wp-post-nav.pot` is empty and documentation is tested only up to WordPress 6.3.

## Potential breaking changes

The following should be treated as compatibility-sensitive:

1. Changing option truthiness could alter sites that rely on malformed or legacy option values.
2. Escaping titles/excerpts may change rendered markup where themes currently depend on raw HTML.
3. Correct taxonomy selection may change the order of custom-post navigation.
4. Replacing duplicated templates may affect CSS selectors and developer filters.
5. Changing primary-term integrations may alter navigation results when both SEO plugins are active.

Each behaviour change should be documented in the changelog and tested against a legacy settings array.

## Recommended development phases

### Phase 1: Safe maintenance

- Fix critical conditionals, hooks, upgrade handling, fatal errors, and undefined-variable paths.
- Normalize settings and add defensive defaults.
- Sanitize settings and escape newly touched output.
- Add assessment and changelog documentation.
- Establish syntax/static checks.

### Phase 2: Test harness

- Add WordPress integration tests for posts, pages, custom post types, attachments, shortcode output, empty states, and settings migration.
- Add compatibility fixtures for WooCommerce, Yoast SEO, and SEO Framework.
- Add WordPress Coding Standards and PHPStan/Psalm checks.

### Phase 3: Rendering refactor

- Extract a shared navigation data model and renderer.
- Preserve existing hooks, CSS classes, IDs, and shortcode attributes where possible.
- Add escaping and semantic markup during the refactor.

### Phase 4: Accessibility and frontend modernisation

- Replace hover-only interaction with keyboard/touch-accessible controls.
- Add responsive layout improvements, focus states, labels, and reduced-motion support.

### Phase 5: Packaging and release

- Generate a clean distribution ZIP.
- Update POT translations and compatibility metadata.
- Test activation, upgrade, deactivation, uninstall, and rollback behaviour.

## Testing requirements

Required before a production release:

- PHP lint across every PHP file.
- WordPress posts, pages, attachments, and custom post types.
- Automatic mode with enabled and disabled post types.
- Shortcode mode and both shortcode display overrides.
- Empty previous/next states.
- Same-taxonomy and unrestricted navigation.
- Settings validation with invalid colours, dimensions, URLs, and unknown keys.
- Upgrade from legacy individual options and version `2.0.3`.
- WooCommerce product and stock-status behaviour where WooCommerce is installed.
- Yoast SEO and SEO Framework behaviour independently and together.
- Keyboard, touch, responsive, and screen-reader checks.

## Current limitations

- Git metadata is not available in the plugin directory, so the current branch, status, history, and commits cannot be verified or changed.
- A complete WordPress runtime test was not available as part of the initial audit; PHP lint is the first verification baseline.
- The rendering duplication remains intentionally unchanged in Phase 1.
