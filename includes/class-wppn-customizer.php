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
	 * Register controls against the consolidated option.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager.
	 * @return void
	 */
	public function register( $wp_customize ) {
		$wp_customize->add_panel(
			self::PANEL,
			array(
				'title'       => __( 'WP Post Nav', 'wp-post-nav' ),
				'description' => __( 'Configure navigation behaviour and appearance.', 'wp-post-nav' ),
				'priority'    => 160,
			)
		);

		$sections = array(
			'general'    => __( 'General', 'wp-post-nav' ),
			'navigation' => __( 'Navigation', 'wp-post-nav' ),
			'layout'     => __( 'Layout', 'wp-post-nav' ),
			'colours'    => __( 'Colours', 'wp-post-nav' ),
			'typography' => __( 'Typography', 'wp-post-nav' ),
			'images'     => __( 'Images', 'wp-post-nav' ),
			'advanced'   => __( 'Advanced', 'wp-post-nav' ),
		);
		foreach ( $sections as $id => $title ) {
			$wp_customize->add_section( 'wppn_' . $id, array( 'title' => $title, 'panel' => self::PANEL ) );
		}

		$controls = array(
			'wp_post_nav_switch_nav'            => array( 'section' => 'general', 'label' => __( 'Switch navigation sides', 'wp-post-nav' ), 'type' => 'checkbox' ),
			'wp_post_nav_show_title'            => array( 'section' => 'general', 'label' => __( 'Show titles', 'wp-post-nav' ), 'type' => 'checkbox' ),
			'wp_post_nav_show_category'         => array( 'section' => 'general', 'label' => __( 'Show categories', 'wp-post-nav' ), 'type' => 'checkbox' ),
			'wp_post_nav_show_post_excerpt'     => array( 'section' => 'general', 'label' => __( 'Show excerpts', 'wp-post-nav' ), 'type' => 'checkbox' ),
			'wp_post_nav_excerpt_length'        => array( 'section' => 'general', 'label' => __( 'Excerpt length', 'wp-post-nav' ), 'type' => 'number' ),
			'wp_post_nav_same_category'         => array( 'section' => 'navigation', 'label' => __( 'Limit navigation to the same category', 'wp-post-nav' ), 'type' => 'checkbox' ),
			'wp_post_nav_post_types'            => array( 'section' => 'navigation', 'label' => __( 'Post types (one per line)', 'wp-post-nav' ), 'type' => 'textarea' ),
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
			'wp_post_nav_fallback_image'        => array( 'section' => 'images', 'label' => __( 'Fallback image URL', 'wp-post-nav' ), 'type' => 'url' ),
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
						if ( 'wp_post_nav_post_types' === $key ) {
							$value = preg_split( '/\r?\n/', (string) $value );
						}
						return WPPN_Settings::sanitize_value( $key, $value );
					},
					'transport'           => 'postMessage',
				)
			);
			$value = $default;
			if ( 'textarea' === $control['type'] ) {
			$value = implode( "\n", array_keys( WPPN_Settings::get()[ $key ] ) );
				$control['input_attrs'] = array( 'rows' => 4 );
			}
			$wp_customize->add_control( $setting_id, array_merge( $control, array( 'settings' => $setting_id, 'section' => 'wppn_' . $control['section'], 'value' => $value ) ) );
		}
	}

	/**
	 * Enqueue preview JavaScript for immediate colour and dimension feedback.
	 *
	 * @return void
	 */
	public function preview_init() {
		wp_enqueue_script( 'wppn-customizer-preview', plugin_dir_url( dirname( __FILE__ ) ) . 'public/js/wp-post-nav-customizer.js', array( 'customize-preview' ), '2.1.0', true );
	}
}
