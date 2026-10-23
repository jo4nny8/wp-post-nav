<?php
/**
 * The uninstall process of WP Post Nav
 * Removes any of the options created by the plugin and cleans up all after itself
 *
 * @link:       https://en-gb.wordpress.org/plugins/wp-post-nav/
 * @since      0.0.1
 * @package    wp_post_nav
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) || ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Remove WP Post Nav's options and notice transient from the current site.
 */
function wppn_uninstall_site() {
	delete_option( 'wp_post_nav_options' );
	delete_option( 'wppn_settings' );
	delete_option( 'wppn_migration_210_complete' );
	delete_option( 'wp_post_nav_version' );
	delete_transient( 'wp-post-nav' );
}

// On multisite, options are stored per site, so clean every site.
if ( is_multisite() ) {
	foreach ( get_sites(
		array(
			'fields' => 'ids',
			'number' => 0,
		)
	) as $wppn_site_id ) {
		switch_to_blog( $wppn_site_id );
		wppn_uninstall_site();
		restore_current_blog();
	}
} else {
	wppn_uninstall_site();
}
