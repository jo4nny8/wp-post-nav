<?php

/**
 * Versioned settings migrations for WP Post Nav.
 *
 * @package wp_post_nav
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Migrates legacy settings into the 2.1.0 settings store.
 */
class WPPN_Migrations {
	const COMPLETE_OPTION = 'wppn_migration_210_complete';

	/**
	 * Run the 2.0.4 to 2.1.0 migration once.
	 *
	 * @return bool Whether the migration completed successfully.
	 */
	public static function migrate_2_0_4_to_2_1_0() {
		if ( get_option( self::COMPLETE_OPTION, false ) ) {
			return true;
		}

		$existing = get_option( WPPN_Settings::OPTION_NAME, array() );
		$legacy = is_array( $existing ) && ! empty( $existing )
			? $existing
			: get_option( WPPN_Settings::LEGACY_OPTION_NAME, array() );
		if ( ! is_array( $legacy ) ) {
			$legacy = array();
		}
		$standalone = array(
			'wp_post_nav_post_types', 'wp_post_nav_same_category', 'wp_post_nav_yoast_seo',
			'wp_post_nav_seo_framework', 'wp_post_nav_exclude_primary', 'wp_post_nav_out_of_stock',
			'wp_post_nav_switch_nav', 'wp_post_nav_show_title', 'wp_post_nav_show_category',
			'wp_post_nav_show_post_excerpt', 'wp_post_nav_excerpt_length', 'wp_post_nav_show_featured_image',
			'wp_post_nav_fallback_image', 'wp_post_nav_nav_button_width', 'wp_post_nav_nav_button_height',
			'wp_post_nav_background_color', 'wp_post_nav_open_background_color', 'wp_post_nav_heading_color',
			'wp_post_nav_heading_size', 'wp_post_nav_title_color', 'wp_post_nav_title_size',
			'wp_post_nav_category_color', 'wp_post_nav_category_size', 'wp_post_nav_excerpt_color',
			'wp_post_nav_excerpt_size', 'wp_post_nav_shortcode',
		);
		foreach ( $standalone as $key ) {
			$value = get_option( $key, null );
			if ( null !== $value && ! array_key_exists( $key, $legacy ) ) {
				$legacy[ $key ] = $value;
			}
		}

		$settings = WPPN_Settings::sanitize( $legacy );
		if ( false === WPPN_Settings::save( $settings ) ) {
			return false;
		}
		if ( get_option( WPPN_Settings::OPTION_NAME, array() ) !== $settings ) {
			return false;
		}
		if ( ! update_option( self::COMPLETE_OPTION, '2.1.0' ) ) {
			return false;
		}

		delete_option( WPPN_Settings::LEGACY_OPTION_NAME );
		foreach ( $standalone as $key ) {
			delete_option( $key );
		}
		update_option( 'wp_post_nav_version', '2.1.0' );
		set_transient( 'wp-post-nav', true, 5 );
		return true;
	}
}
