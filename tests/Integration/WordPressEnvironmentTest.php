<?php

use PHPUnit\Framework\TestCase;

final class WordPressEnvironmentTest extends TestCase {

	public function test_wordpress_integration_environment_is_available(): void {
		if ( ! defined( 'WP_TESTS_DIR' ) || ! function_exists( 'wp_insert_post' ) ) {
			$this->markTestSkipped( 'Set WP_TESTS_DIR and bootstrap WordPress to run integration tests.' );
		}

		$this->assertTrue( function_exists( 'wp_insert_post' ) );
	}

	/**
	 * Integration coverage placeholder for posts, pages, custom post types,
	 * attachments, products, and empty navigation states.
	 */
	public function test_navigation_behaviour_requires_wordpress_fixtures(): void {
		$this->markTestSkipped( 'WordPress fixture coverage is planned for the integration environment.' );
	}

	public function test_optional_seo_and_woocommerce_integrations_require_dependencies(): void {
		$this->markTestSkipped( 'Yoast SEO, The SEO Framework, and WooCommerce coverage requires those plugins.' );
	}
}
