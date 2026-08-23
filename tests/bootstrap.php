<?php

/**
 * Lightweight WordPress boundary stubs for isolated compatibility tests.
 *
 * Integration tests must run against a real WordPress installation instead of
 * extending these stubs.
 */

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

$GLOBALS['wppn_test_options'] = array();
$GLOBALS['wppn_test_transients'] = array();
$GLOBALS['wppn_test_hooks'] = array();
$GLOBALS['wppn_test_shortcodes'] = array();
$GLOBALS['wppn_test_settings_errors'] = array();

if ( ! function_exists( 'get_option' ) ) {
	function get_option( $option, $default = false ) {
		return array_key_exists( $option, $GLOBALS['wppn_test_options'] )
			? $GLOBALS['wppn_test_options'][ $option ]
			: $default;
	}
}

if ( ! function_exists( 'add_option' ) ) {
	function add_option( $option, $value = '' ) {
		if ( ! array_key_exists( $option, $GLOBALS['wppn_test_options'] ) ) {
			$GLOBALS['wppn_test_options'][ $option ] = $value;
		}

		return true;
	}
}

if ( ! function_exists( 'update_option' ) ) {
	function update_option( $option, $value ) {
		$GLOBALS['wppn_test_options'][ $option ] = $value;
		return true;
	}
}

if ( ! function_exists( 'delete_option' ) ) {
	function delete_option( $option ) {
		unset( $GLOBALS['wppn_test_options'][ $option ] );
		return true;
	}
}

if ( ! function_exists( 'set_transient' ) ) {
	function set_transient( $transient, $value, $expiration ) {
		$GLOBALS['wppn_test_transients'][ $transient ] = $value;
		return true;
	}
}

if ( ! function_exists( 'get_transient' ) ) {
	function get_transient( $transient ) {
		return $GLOBALS['wppn_test_transients'][ $transient ] ?? false;
	}
}

if ( ! function_exists( 'delete_transient' ) ) {
	function delete_transient( $transient ) {
		unset( $GLOBALS['wppn_test_transients'][ $transient ] );
		return true;
	}
}

if ( ! function_exists( 'add_action' ) ) {
	function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
		$GLOBALS['wppn_test_hooks']['actions'][] = compact( 'hook', 'callback', 'priority', 'accepted_args' );
		return true;
	}
}

if ( ! function_exists( 'add_filter' ) ) {
	function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
		$GLOBALS['wppn_test_hooks']['filters'][] = compact( 'hook', 'callback', 'priority', 'accepted_args' );
		return true;
	}
}

if ( ! function_exists( 'apply_filters' ) ) {
	function apply_filters( $hook, $value ) {
		return $value;
	}
}

if ( ! function_exists( 'add_shortcode' ) ) {
	function add_shortcode( $tag, $callback ) {
		$GLOBALS['wppn_test_shortcodes'][ $tag ] = $callback;
		return true;
	}
}

if ( ! function_exists( 'has_filter' ) ) {
	function has_filter( $hook, $callback = false ) {
		return false;
	}
}

if ( ! function_exists( '__' ) ) {
	function __( $text, $domain = 'default' ) {
		return $text;
	}
}

if ( ! function_exists( '_e' ) ) {
	function _e( $text, $domain = 'default' ) {
		echo $text;
	}
}

if ( ! function_exists( 'sanitize_hex_color' ) ) {
	function sanitize_hex_color( $color ) {
		return preg_match( '/^#[a-f0-9]{6}$/i', $color ) ? $color : null;
	}
}

if ( ! function_exists( 'sanitize_text_field' ) ) {
	function sanitize_text_field( $value ) {
		return trim( strip_tags( (string) $value ) );
	}
}

if ( ! function_exists( 'absint' ) ) {
	function absint( $value ) {
		return abs( (int) $value );
	}
}

if ( ! function_exists( 'wp_parse_args' ) ) {
	function wp_parse_args( $args, $defaults = array() ) {
		return array_merge( $defaults, is_array( $args ) ? $args : array() );
	}
}

if ( ! function_exists( 'sanitize_key' ) ) {
	function sanitize_key( $key ) {
		return preg_replace( '/[^a-z0-9_\-]/', '', strtolower( (string) $key ) );
	}
}

if ( ! function_exists( 'esc_url_raw' ) ) {
	function esc_url_raw( $url ) {
		return filter_var( (string) $url, FILTER_SANITIZE_URL );
	}
}

if ( ! function_exists( 'add_settings_error' ) ) {
	function add_settings_error( $setting, $code, $message, $type = 'error' ) {
		$GLOBALS['wppn_test_settings_errors'][] = compact( 'setting', 'code', 'message', 'type' );
		return $code;
	}
}

if ( ! function_exists( 'register_setting' ) ) {
	function register_setting( $option_group, $option_name, $args = array() ) {
		$GLOBALS['wppn_test_hooks']['settings'][] = compact( 'option_group', 'option_name', 'args' );
	}
}

if ( ! function_exists( 'add_settings_section' ) ) {
	function add_settings_section( $id, $title, $callback, $page ) {}
}

if ( ! function_exists( 'add_settings_field' ) ) {
	function add_settings_field( $id, $title, $callback, $page, $section, $args = array() ) {}
}

if ( ! function_exists( 'plugin_dir_path' ) ) {
	function plugin_dir_path( $file ) {
		return rtrim( dirname( $file ), DIRECTORY_SEPARATOR ) . DIRECTORY_SEPARATOR;
	}
}

if ( ! function_exists( 'plugin_dir_url' ) ) {
	function plugin_dir_url( $file ) {
		return 'https://example.test/wp-content/plugins/wp-post-nav/';
	}
}

if ( ! function_exists( 'plugin_basename' ) ) {
	function plugin_basename( $file ) {
		return basename( $file );
	}
}

require_once dirname( __DIR__ ) . '/includes/class-wppn-settings.php';
require_once dirname( __DIR__ ) . '/includes/class-wppn-migrations.php';
require_once dirname( __DIR__ ) . '/includes/class-wppn-customizer.php';
require_once dirname( __DIR__ ) . '/includes/class-wp-post-nav-activator.php';
require_once dirname( __DIR__ ) . '/includes/class-wp-post-nav-deactivator.php';
require_once dirname( __DIR__ ) . '/includes/class-wp-post-nav-loader.php';
require_once dirname( __DIR__ ) . '/admin/class-wp-post-nav-admin.php';
require_once dirname( __DIR__ ) . '/public/class-wp-post-nav-public.php';
