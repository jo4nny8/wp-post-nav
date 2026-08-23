<?php

/**
 * Central settings service for WP Post Nav.
 *
 * @package wp_post_nav
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Provides one validated settings path for the admin, Customizer and frontend.
 */
class WPPN_Settings {

	const OPTION_NAME = 'wppn_settings';
	const LEGACY_OPTION_NAME = 'wp_post_nav_options';

	/**
	 * Return the complete default settings set.
	 *
	 * @return array
	 */
	public static function get_defaults() {
		return array(
			'wp_post_nav_post_types'              => array( 'post' => 'post' ),
			'wp_post_nav_same_category'           => '',
			'wp_post_nav_yoast_seo'               => '',
			'wp_post_nav_seo_framework'           => '',
			'wp_post_nav_exclude_primary'         => '',
			'wp_post_nav_out_of_stock'            => '',
			'wp_post_nav_switch_nav'              => '',
			'wp_post_nav_show_title'              => 'yes',
			'wp_post_nav_show_category'           => 'yes',
			'wp_post_nav_show_post_excerpt'       => 'yes',
			'wp_post_nav_excerpt_length'          => '300',
			'wp_post_nav_show_featured_image'     => 'yes',
			'wp_post_nav_fallback_image'          => '',
			'wp_post_nav_nav_button_width'        => '70',
			'wp_post_nav_nav_button_height'       => '100',
			'wp_post_nav_background_color'        => '#8358b0',
			'wp_post_nav_open_background_color'   => '#8358b0',
			'wp_post_nav_heading_color'           => '#ffffff',
			'wp_post_nav_heading_size'            => '20',
			'wp_post_nav_title_color'             => '#ffffff',
			'wp_post_nav_title_size'              => '13',
			'wp_post_nav_category_color'          => '#ffffff',
			'wp_post_nav_category_size'           => '13',
			'wp_post_nav_excerpt_color'           => '#ffffff',
			'wp_post_nav_excerpt_size'            => '12',
			'wp_post_nav_shortcode'               => '',
		);
	}

	/**
	 * Load settings, falling back to the legacy option during upgrades.
	 *
	 * @return array
	 */
	public static function get() {
		$settings = get_option( self::OPTION_NAME, array() );
		if ( ! is_array( $settings ) || empty( $settings ) ) {
			$settings = get_option( self::LEGACY_OPTION_NAME, array() );
		}

		return wp_parse_args( is_array( $settings ) ? $settings : array(), self::get_defaults() );
	}

	/**
	 * Validate and save settings.
	 *
	 * @param mixed $input Submitted settings.
	 * @return array|false Sanitised settings or false when persistence fails.
	 */
	public static function save( $input ) {
		$settings = self::sanitize( $input );
		if ( ! update_option( self::OPTION_NAME, $settings ) ) {
			$saved = get_option( self::OPTION_NAME, array() );
			if ( $saved !== $settings ) {
				return false;
			}
		}

		return $settings;
	}

	/**
	 * Sanitise the supported settings without accepting unknown keys.
	 *
	 * @param mixed $input Submitted settings.
	 * @return array
	 */
	public static function sanitize( $input ) {
		$input    = is_array( $input ) ? $input : array();
		$defaults = self::get_defaults();
		$output   = $defaults;
		$checkboxes = array(
			'wp_post_nav_same_category', 'wp_post_nav_yoast_seo', 'wp_post_nav_seo_framework',
			'wp_post_nav_exclude_primary', 'wp_post_nav_out_of_stock', 'wp_post_nav_switch_nav',
			'wp_post_nav_show_title', 'wp_post_nav_show_category', 'wp_post_nav_show_post_excerpt',
			'wp_post_nav_show_featured_image', 'wp_post_nav_shortcode',
		);
		$numbers = array(
			'wp_post_nav_excerpt_length', 'wp_post_nav_nav_button_width', 'wp_post_nav_nav_button_height',
			'wp_post_nav_heading_size', 'wp_post_nav_title_size', 'wp_post_nav_category_size',
			'wp_post_nav_excerpt_size',
		);
		$colours = array(
			'wp_post_nav_background_color', 'wp_post_nav_open_background_color', 'wp_post_nav_heading_color',
			'wp_post_nav_title_color', 'wp_post_nav_category_color', 'wp_post_nav_excerpt_color',
		);

		foreach ( $defaults as $key => $default ) {
			if ( ! array_key_exists( $key, $input ) ) {
				continue;
			}

			$value = $input[ $key ];
			if ( in_array( $key, $checkboxes, true ) ) {
				$output[ $key ] = ( 'yes' === $value || true === $value || 1 === $value ) ? 'yes' : '';
			} elseif ( in_array( $key, $numbers, true ) ) {
				$output[ $key ] = is_numeric( $value ) ? (string) absint( $value ) : $default;
			} elseif ( in_array( $key, $colours, true ) ) {
				$output[ $key ] = sanitize_hex_color( $value ) ?: $default;
			} elseif ( 'wp_post_nav_post_types' === $key ) {
				$output[ $key ] = array();
				if ( is_array( $value ) ) {
					foreach ( $value as $post_type ) {
						$post_type = sanitize_key( $post_type );
						if ( $post_type ) {
							$output[ $key ][ $post_type ] = $post_type;
						}
					}
				}
			} elseif ( 'wp_post_nav_fallback_image' === $key ) {
				$output[ $key ] = esc_url_raw( $value );
			} else {
				$output[ $key ] = sanitize_text_field( $value );
			}
		}
		foreach ( $checkboxes as $key ) {
			if ( ! array_key_exists( $key, $input ) ) {
				$output[ $key ] = '';
			}
		}

		return $output;
	}

	/**
	 * Sanitise one Customizer value using the same rules as option saves.
	 *
	 * @param string $key   Setting key.
	 * @param mixed  $value Setting value.
	 * @return mixed
	 */
	public static function sanitize_value( $key, $value ) {
		$settings = self::sanitize( array( $key => $value ) );
		return array_key_exists( $key, $settings ) ? $settings[ $key ] : null;
	}
}
