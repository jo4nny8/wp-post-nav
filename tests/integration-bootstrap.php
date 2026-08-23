<?php

$wordpress_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( $wordpress_tests_dir && file_exists( $wordpress_tests_dir . '/includes/functions.php' ) ) {
	require_once $wordpress_tests_dir . '/includes/functions.php';

	tests_add_filter(
		'muplugins_loaded',
		static function () {
			// Seed the current version so the plugin bootstrap does not run its legacy upgrade path.
			update_option( 'wp_post_nav_version', '2.0.4' );
			require_once dirname( __DIR__ ) . '/wp-post-nav.php';
		}
	);

	require_once $wordpress_tests_dir . '/includes/bootstrap.php';
	return;
}

// Permit the integration suite to report a useful skip when no WordPress test library is installed locally.
require_once __DIR__ . '/bootstrap.php';
