<?php

/**
 * WordPress Customizer integration for WP Post Nav.
 *
 * @package wp_post_nav
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the preferred visual settings interface while retaining legacy keys.
 */
class WPPN_Customizer {
	const PANEL = 'wppn_panel';

	/**
	 * Register lifecycle hooks immediately during plugin bootstrap.
	 *
	 * The Customizer manager is created from the `plugins_loaded` lifecycle and
	 * fires `customize_register` later. Keeping this hook direct avoids relying
	 * on a second, unrelated loader to register Customizer components.
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'register' ), 10, 1 );
		add_action( 'customize_preview_init', array( $this, 'preview_init' ), 10, 1 );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'controls_scripts' ) );
	}

	/**
	 * Register controls against the consolidated option.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager.
	 * @return void
	 */
	public function register( $wp_customize ) {
		// WP_Customize_Control is loaded by WordPress immediately before this hook.
		if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'WPPN_Customizer_Post_Types_Control' ) ) {
			require_once __DIR__ . '/class-wppn-customizer-post-types-control.php';
		}

		$wp_customize->add_panel(
			self::PANEL,
			array(
				'title'       => __( 'WP Post Nav', 'wp-post-nav' ),
				'description' => __( 'Configure navigation behaviour and appearance.', 'wp-post-nav' ),
				'priority'    => 160,
			)
		);

		$sections = array(
			'general'    => array( __( 'General', 'wp-post-nav' ), __( 'Choose which navigation content is visible. Excerpt length is measured in words.', 'wp-post-nav' ) ),
			'navigation' => array( __( 'Navigation', 'wp-post-nav' ), __( 'Choose the public post types and category rules used by the previous and next links.', 'wp-post-nav' ) ),
			'layout'     => array( __( 'Layout', 'wp-post-nav' ), __( 'Set the dimensions of the floating navigation buttons in pixels.', 'wp-post-nav' ) ),
			'colours'    => array( __( 'Colours', 'wp-post-nav' ), __( 'Choose the navigation background and text colours. Changes are previewed before publishing.', 'wp-post-nav' ) ),
			'typography' => array( __( 'Typography', 'wp-post-nav' ), __( 'Set heading, title, category and excerpt font sizes in pixels.', 'wp-post-nav' ) ),
			'images'     => array( __( 'Images', 'wp-post-nav' ), __( 'Choose whether featured images appear and upload a fallback image for posts without one.', 'wp-post-nav' ) ),
			'advanced'   => array( __( 'Advanced', 'wp-post-nav' ), __( 'Use shortcode mode when you need to place navigation manually in a template or page.', 'wp-post-nav' ) ),
		);
		foreach ( $sections as $id => $section ) {
			$wp_customize->add_section( 'wppn_' . $id, array( 'title' => $section[0], 'description' => $section[1], 'panel' => self::PANEL ) );
		}

		$controls = array(
			'wp_post_nav_switch_nav'            => array( 'section' => 'general', 'label' => __( 'Switch navigation sides', 'wp-post-nav' ), 'type' => 'checkbox' ),
			'wp_post_nav_show_title'            => array( 'section' => 'general', 'label' => __( 'Show titles', 'wp-post-nav' ), 'type' => 'checkbox' ),
			'wp_post_nav_show_category'         => array( 'section' => 'general', 'label' => __( 'Show categories', 'wp-post-nav' ), 'type' => 'checkbox' ),
			'wp_post_nav_show_post_excerpt'     => array( 'section' => 'general', 'label' => __( 'Show excerpts', 'wp-post-nav' ), 'type' => 'checkbox' ),
			'wp_post_nav_excerpt_length'        => array( 'section' => 'general', 'label' => __( 'Excerpt length (words)', 'wp-post-nav' ), 'description' => __( 'The maximum number of words shown in the excerpt.', 'wp-post-nav' ), 'type' => 'number' ),
			'wp_post_nav_same_category'         => array( 'section' => 'navigation', 'label' => __( 'Limit navigation to the same category', 'wp-post-nav' ), 'type' => 'checkbox' ),
			'wp_post_nav_post_types'            => array( 'section' => 'navigation', 'label' => __( 'Post types', 'wp-post-nav' ), 'description' => __( 'Tick the post types where WP Post Nav should appear.', 'wp-post-nav' ), 'type' => 'post_types' ),
			'wp_post_nav_nav_button_width'      => array( 'section' => 'layout', 'label' => __( 'Navigation button width (px)', 'wp-post-nav' ), 'type' => 'number' ),
			'wp_post_nav_nav_button_height'     => array( 'section' => 'layout', 'label' => __( 'Navigation button height (px)', 'wp-post-nav' ), 'type' => 'number' ),
			'wp_post_nav_background_color'      => array( 'section' => 'colours', 'label' => __( 'Background colour', 'wp-post-nav' ), 'type' => 'color' ),
			'wp_post_nav_open_background_color' => array( 'section' => 'colours', 'label' => __( 'Open background colour', 'wp-post-nav' ), 'type' => 'color' ),
			'wp_post_nav_heading_color'         => array( 'section' => 'colours', 'label' => __( 'Heading colour', 'wp-post-nav' ), 'type' => 'color' ),
			'wp_post_nav_title_color'           => array( 'section' => 'colours', 'label' => __( 'Title colour', 'wp-post-nav' ), 'type' => 'color' ),
			'wp_post_nav_category_color'        => array( 'section' => 'colours', 'label' => __( 'Category colour', 'wp-post-nav' ), 'type' => 'color' ),
			'wp_post_nav_excerpt_color'         => array( 'section' => 'colours', 'label' => __( 'Excerpt colour', 'wp-post-nav' ), 'type' => 'color' ),
			'wp_post_nav_heading_size'          => array( 'section' => 'typography', 'label' => __( 'Heading size (px)', 'wp-post-nav' ), 'type' => 'number' ),
			'wp_post_nav_title_size'            => array( 'section' => 'typography', 'label' => __( 'Title size (px)', 'wp-post-nav' ), 'type' => 'number' ),
			'wp_post_nav_category_size'         => array( 'section' => 'typography', 'label' => __( 'Category size (px)', 'wp-post-nav' ), 'type' => 'number' ),
			'wp_post_nav_excerpt_size'          => array( 'section' => 'typography', 'label' => __( 'Excerpt size (px)', 'wp-post-nav' ), 'type' => 'number' ),
			'wp_post_nav_show_featured_image'   => array( 'section' => 'images', 'label' => __( 'Show featured images', 'wp-post-nav' ), 'type' => 'checkbox' ),
			'wp_post_nav_fallback_image'        => array( 'section' => 'images', 'label' => __( 'Fallback image', 'wp-post-nav' ), 'description' => __( 'Upload an image used when a post has no featured image. The default image is used when this is empty.', 'wp-post-nav' ), 'type' => 'image' ),
			'wp_post_nav_shortcode'             => array( 'section' => 'advanced', 'label' => __( 'Use shortcode mode', 'wp-post-nav' ), 'type' => 'checkbox' ),
		);

		foreach ( $controls as $key => $control ) {
			$setting_id = WPPN_Settings::OPTION_NAME . '[' . $key . ']';
			$default    = WPPN_Settings::get_defaults()[ $key ];
			$wp_customize->add_setting(
				$setting_id,
				array(
					'type'                => 'option',
					'default'             => $default,
					'sanitize_callback'   => function ( $value ) use ( $key ) {
						if ( 'wp_post_nav_post_types' === $key && ! is_array( $value ) ) {
							$value = preg_split( '/\r?\n/', (string) $value );
						}
						return WPPN_Settings::sanitize_value( $key, $value );
					},
					// Every setting affects rendered navigation or its CSS. Refreshing the
					// preview keeps titles, excerpts, images, colours and layout in sync.
					'transport'           => 'refresh',
				)
			);
			$value = $default;
			$control_args = array_merge( $control, array( 'settings' => $setting_id, 'section' => 'wppn_' . $control['section'], 'value' => $value ) );
			if ( 'wp_post_nav_post_types' === $key && class_exists( 'WPPN_Customizer_Post_Types_Control' ) ) {
				$wp_customize->add_control( new WPPN_Customizer_Post_Types_Control( $wp_customize, $setting_id, $control_args ) );
			} elseif ( 'wp_post_nav_fallback_image' === $key && class_exists( 'WP_Customize_Image_Control' ) ) {
				$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $setting_id, $control_args ) );
			} else {
				$wp_customize->add_control( $setting_id, $control_args );
			}
		}
	}

	/**
	 * Enqueue the checkbox control behaviour in the Customizer controls frame.
	 *
	 * @return void
	 */
	public function controls_scripts() {
		wp_enqueue_script( 'wppn-customizer-controls', plugin_dir_url( dirname( __FILE__ ) ) . 'public/js/wp-post-nav-customizer-controls.js', array( 'customize-controls', 'jquery' ), '2.1.0.3', true );
	}

	/**
	 * Enqueue preview JavaScript for immediate colour and dimension feedback.
	 *
	 * @return void
	 */
	public function preview_init() {
		wp_enqueue_script( 'wppn-customizer-preview', plugin_dir_url( dirname( __FILE__ ) ) . 'public/js/wp-post-nav-customizer.js', array( 'customize-preview' ), '2.1.0.2', true );
	}
}
