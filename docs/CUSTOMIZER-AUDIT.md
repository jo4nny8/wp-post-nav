# WP Post Nav Customizer audit

Audit date: `2026-08-23`  
Plugin version: `2.0.4`  
Branch: `develop`  
Scope: architecture and migration planning only; no runtime changes were made.

## Current settings architecture

The current settings UI is a custom admin page implemented by `wp_post_nav_admin` in `admin/class-wp-post-nav-admin.php`.

- The plugin registers an admin menu under Settings.
- Settings sections and fields are assembled by `settings_fields()`.
- The option is registered during `admin_init` with `register_setting()`.
- The option name is `wp_post_nav_options`.
- Validation is performed by `validate_fields()`.
- The settings page displays tabs, fields, instructions, and a sidebar.
- The frontend reads the option directly through `wp_post_nav_Public::wp_post_nav_get_settings()`.
- The existing settings page must remain available throughout the Customizer transition.

The version marker is stored separately as `wp_post_nav_version` and is checked by `wp_post_nav::version_control()`.

## Current database options

### Canonical option

`wp_post_nav_options` is an associative array containing the current configuration. The active field inventory is:

| Group | Existing keys | Current role |
| --- | --- | --- |
| Content and filtering | `wp_post_nav_post_types`, `wp_post_nav_same_category`, `wp_post_nav_yoast_seo`, `wp_post_nav_seo_framework`, `wp_post_nav_exclude_primary`, `wp_post_nav_out_of_stock` | Select supported content, taxonomy restrictions, SEO primary terms, and product stock behaviour. |
| Navigation and display | `wp_post_nav_switch_nav`, `wp_post_nav_show_title`, `wp_post_nav_show_category`, `wp_post_nav_show_post_excerpt`, `wp_post_nav_excerpt_length` | Control side, metadata, and excerpt output. |
| Images | `wp_post_nav_show_featured_image`, `wp_post_nav_fallback_image` | Control featured images and fallback image URLs. |
| Dimensions | `wp_post_nav_nav_button_width`, `wp_post_nav_nav_button_height` | Set navigation button dimensions. |
| Colours | `wp_post_nav_background_color`, `wp_post_nav_open_background_color`, `wp_post_nav_heading_color`, `wp_post_nav_title_color`, `wp_post_nav_category_color`, `wp_post_nav_excerpt_color` | Set inline navigation colours. The `_color` spelling is a compatibility-sensitive option key and must not be changed. |
| Typography | `wp_post_nav_heading_size`, `wp_post_nav_title_size`, `wp_post_nav_category_size`, `wp_post_nav_excerpt_size` | Set heading, title, category, and excerpt sizes. |
| Shortcode | `wp_post_nav_shortcode` | Enable or configure shortcode mode. |

### Version marker

`wp_post_nav_version` stores the plugin configuration version. It is currently updated by activation and version-control code rather than by a dedicated migration service.

### Historical standalone options

The activator checks and migrates older standalone options, including:

- `wp_post_nav_post_types`
- `wp_post_nav_same_category`
- `wp_post_nav_show_title`
- `wp_post_nav_show_category`
- `wp_post_nav_show_post_excerpt`
- `wp_post_nav_excerpt_length`
- `wp_post_nav_show_featured_image`
- `wp_post_nav_fallback_image`
- `wp_post_nav_out_of_stock`
- `wp_post_nav_switch_nav`
- `wp_post_nav_nav_button_width`
- `wp_post_nav_nav_button_height`
- `wp_post_nav_background_color`
- `wp_post_nav_open_background_color`
- `wp_post_nav_title_color`
- `wp_post_nav_title_size`
- `wp_post_nav_category_color`
- `wp_post_nav_category_size`
- `wp_post_nav_excerpt_color`
- `wp_post_nav_excerpt_size`

These keys are historical compatibility data. They must not be deleted or renamed until a verified migration has copied them into the canonical structure and recorded completion.

## Defaults and validation

Fresh activation creates defaults including:

- `post` as the initial selected post type.
- `#8358b0` for navigation backgrounds.
- White text colours.
- Button dimensions of `70` by `100`.
- Typography sizes of `20`, `13`, `13`, and `12`.
- Featured images and excerpt output enabled.

The admin validator currently:

- Intersects submitted keys with the known field list.
- Preserves recognised checkbox values when submitted.
- Validates numeric fields with `is_numeric()` and `sanitize_text_field()`.
- Validates six-digit hexadecimal colours with `check_color()` and `sanitize_hex_color()`.
- Validates fallback image extensions using the existing allow-list.
- Falls back to previously saved values for some invalid fields.

The future settings layer must retain these behaviours or document an intentional, tested compatibility change.

## Frontend consumers

The public renderer consumes settings in three main areas:

1. `wp_post_nav_get_settings()` reads `wp_post_nav_options`.
2. `display_wp_post_nav()` uses content, display, SEO, WooCommerce, and shortcode settings to choose whether and how to render navigation.
3. `wp_post_nav_shortcode_display()` uses the same option for shortcode output, adjacent-post selection, metadata, images, excerpts, and optional SEO filtering.

`enqueue_styles()` reads colour and dimension values, sanitises them, constructs dynamic inline CSS, and attaches it with `wp_add_inline_style()`. The Customizer design must preserve the current CSS selectors and output values while moving the source of preview changes behind a controlled settings layer.

## Settings requiring migration

The first implementation must migrate and expose the existing canonical keys without changing their stored meaning:

- Content and filtering keys must retain post-type arrays, checkbox semantics, taxonomy choices, and optional SEO/WooCommerce values.
- Display and shortcode keys must retain empty/checked behaviour, including the distinction between a missing checkbox and a stored value.
- Numeric values must remain compatible with the current string-based storage format until a conversion is proven safe.
- Colour option keys must retain their `_color` names even though maintained prose uses British English `colour`.
- Fallback image URLs must retain their existing value and validation semantics.
- `wp_post_nav_version` must remain readable during the transition and must not be treated as proof that a new migration completed unless a dedicated marker exists.

## Compatibility risks

### High risk

- Accidentally creating a second source of truth between Customizer settings, the existing settings page, and `wp_post_nav_options`.
- Deleting historical options before verifying the new structure.
- Changing checkbox absence semantics, which currently influence whether features are enabled.
- Renaming `_color` option keys or existing hooks, shortcode names, CSS selectors, and template paths.
- Moving dynamic CSS without preserving sanitisation, enqueue timing, selectors, or fallback values.

### Medium risk

- Customizer controls saving values with a different type or nested array shape.
- Preview requests running in a context where the current queried post, taxonomy, SEO plugin, or WooCommerce state is incomplete.
- Customizer selective refresh returning markup that differs from the existing footer or shortcode renderer.
- Running migrations on every request or under both the old and new settings entry points.

### Low risk

- Reorganising labels and sections while retaining the old field IDs and stored values.
- Introducing CSS custom properties as an internal implementation detail if generated output remains equivalent and the fallback path is tested.

## Audit conclusion

The safest architecture is an adapter-based migration. Keep `wp_post_nav_options` as the canonical option initially, put all reads and writes behind a new settings layer, retain the current admin page as a compatibility editor, and add the Customizer as a second editor using the same validated data path. Only consider a new option shape after migration tests and rollback behaviour are established.
