# WP Post Nav Customizer architecture

Status: design only. No Customizer or rendering code is introduced by this document.

## Proposed data flow

```text
WordPress Customizer
        |
        v
WPPN Customizer Class
        |
        v
WPPN Settings Layer
        |
        v
WordPress Options Database
        |
        v
WPPN Renderer adapter
        |
        v
Existing frontend templates and output
```

The first implementation should preserve `wp_post_nav_options` as the canonical option. This avoids a split between `theme_mods`, Customizer-specific values, and the existing settings page. A later storage redesign must use a versioned migration and retain compatibility reads.

## Proposed classes

### `WPPN_Settings`

Planned location: `includes/class-wppn-settings.php`.

Responsibilities:

- Define the canonical defaults and field schema.
- Read the canonical option safely.
- Read legacy values through a compatibility adapter during migration.
- Validate and sanitise values consistently for the settings page and Customizer.
- Preserve option key names and value semantics.
- Expose normalised values to existing frontend code without changing rendering in this phase.
- Provide a single save path with error reporting and migration-aware version checks.

New procedural helpers, if required, must use the `wppn_` prefix. Existing `wp_post_nav_*` public names remain unchanged.

### `WPPN_Customizer`

Planned location: `includes/class-wppn-customizer.php`.

Responsibilities:

- Register the `WP Post Nav` panel and proposed sections.
- Register controls using stable setting IDs mapped to the canonical settings layer.
- Use appropriate control types, transport modes, capability checks, and sanitisation callbacks.
- Register selective-refresh partials only where output can be guaranteed equivalent.
- Enqueue preview JavaScript without changing the normal frontend asset path.
- Fall back to a full refresh when a partial or CSS-only update is not safe.

### `WPPN_Migrations`

Planned location: `includes/class-wppn-migrations.php`.

Responsibilities:

- Detect legacy standalone options and the current canonical version.
- Execute version-specific, idempotent migrations.
- Validate and sanitise converted values.
- Save and verify the new structure before removing obsolete entries.
- Record completion with a project-prefixed marker, for example `wppn_migration_210_complete`.
- Preserve old data and report failures without marking a migration complete.

## Proposed Customizer sections

Panel: `WP Post Nav`

### General

- Enable navigation.
- Supported post types.
- Display locations and shortcode mode.

### Navigation

- Previous/next behaviour.
- Ordering.
- Same-taxonomy filtering.
- Primary-term and exclusion behaviour.
- Product stock filtering where WooCommerce is active.

### Layout

- Position and side switching.
- Alignment and display style.
- Responsive behaviour.
- Button dimensions.

### Colours

- Background and open-state background.
- Heading, title, category, and excerpt colours.
- Future border and accent values, only after a compatible schema is agreed.

### Typography

- Heading, title, category, and excerpt sizes.

### Images

- Featured-image visibility.
- Fallback image.
- Future image-size control after output compatibility is tested.

### Advanced

- Developer-facing settings only where there is a clear use case.
- Custom classes or debug mode must not be introduced without a security and compatibility review.

## Settings and storage model

The Customizer should initially map controls to existing keys inside `wp_post_nav_options`. The mapping must be explicit, for example:

```text
Customizer control: wppn_background_colour
Canonical storage: wp_post_nav_options[wp_post_nav_background_color]
```

The control label may use British English, but the stored `_color` key must remain unchanged. The settings layer, rather than individual controls, must perform validation, sanitisation, defaults, and writes.

The existing admin page must call the same settings layer before it can be retired. During the transition, either editor must produce equivalent canonical data and neither editor may delete the other editor’s state.

## Compatibility boundaries

- Existing option names, values, public functions, hooks, filters, shortcode attributes, CSS classes, IDs, and template paths remain supported.
- Existing footer and shortcode renderers remain the output authority until a separate renderer migration is approved.
- The Customizer must not assume an active singular query during control registration or non-preview requests.
- Optional SEO and WooCommerce integrations must be detected safely and must not be required for core settings to load.
- Migration failures must preserve the old option and must not mark completion.
