# WP Post Nav frontend baseline

Baseline version: `2.0.4`  
Baseline branch: `develop`  
Purpose: protect existing markup and visible behaviour before accessibility or rendering changes.

## Rendering modes

WP Post Nav currently has two rendering paths:

- Footer navigation uses the `wp-post-nav` wrapper and the post-type-specific templates.
- The `[wp_post_nav]` shortcode uses the `wp-post-nav-shortcode` wrapper and accepts `display_previous` and `display_next` attributes.

The current templates are:

- `public/partials/wp-post-nav-public-post.php`
- `public/partials/wp-post-nav-public-page.php`
- `public/partials/wp-post-nav-public-default.php`
- `public/partials/wp-post-nav-public-product.php`
- `public/partials/wp-post-nav-public-attachment.php`
- `public/partials/wp-post-nav-public-primary.php`

## Shared structure

Normal navigation renders:

```html
<nav class="wp-post-nav" role="navigation">
    <ul id="post-nav-previous-default|switched">...</ul>
    <ul id="post-nav-next-default|switched">...</ul>
</nav>
```

Shortcode navigation renders:

```html
<nav class="wp-post-nav-shortcode" role="navigation">
    <ul id="post-nav-previous">...</ul>
    <ul id="post-nav-next">...</ul>
</nav>
```

The exact template output varies by post type and whether previous or next content exists. Empty navigation returns no navigation output rather than an empty wrapper in the shortcode path.

## Previous and next content

Each available direction can include:

- A heading: `Previous Post`, `Next Post`, `Previous Page`, `Next Page`, `Previous Product`, or `Next Product`.
- A featured image list item with class `post-nav-image` when enabled.
- A title list item with class `post-nav-title` when enabled.
- A category list item with class `post-nav-category` when enabled.
- An excerpt list item with class `post-nav-excerpt` when enabled.
- A direction control span: `post-nav-previous-button` or `post-nav-next-button`.

The standard post and custom post type templates use `Category:` text and category terms. Product templates use WooCommerce product categories when WooCommerce is active. Attachment templates provide a `Return To Post` item with ID `wp-prev-nav` and use the attachment navigation IDs.

## Compatibility-sensitive selectors

The following selectors and attributes are public compatibility surfaces and must not be renamed without a migration plan:

- `.wp-post-nav`
- `.wp-post-nav-shortcode`
- `.post-nav-image`
- `.post-nav-title`
- `.post-nav-category`
- `.post-nav-excerpt`
- `#post-nav-previous*`
- `#post-nav-next*`
- `#post-nav-previous-button`
- `#post-nav-next-button`
- `#attachment-post-nav-previous*`
- `#wp-prev-nav`

## Behaviour baseline

- Navigation is available only on configured singular post types.
- Home, front-page, and post-type archive requests do not render normal navigation.
- The shortcode can independently suppress previous or next output with `display_previous` and `display_next`.
- If no adjacent item exists in the requested direction, that direction is omitted.
- If neither direction exists, shortcode output is an empty string.
- Footer navigation is suppressed when shortcode mode is enabled.
- Same-category, switch-side, title, category, excerpt, featured-image, fallback-image, sizing, colour, SEO primary-term, and WooCommerce stock settings influence output.
- Existing markup, classes, IDs, template paths, and text-domain usage are protected by integration tests and should be treated as stable until deliberately changed.

## Verification record

The baseline is derived from the active `2.0.4` templates and public renderer. Integration tests cover the main post, page, custom post type, attachment, shortcode, and empty-navigation scenarios when run with WordPress. Browser screenshots and accessibility assertions remain future work.
