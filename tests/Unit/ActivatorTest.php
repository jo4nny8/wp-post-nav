<?php

use PHPUnit\Framework\TestCase;

final class ActivatorTest extends TestCase {

	protected function setUp(): void {
		$GLOBALS['wppn_test_options'] = array();
		$GLOBALS['wppn_test_transients'] = array();
	}

	public function test_fresh_activation_creates_default_options_and_version(): void {
		wp_post_nav_Activator::activate();

		$this->assertIsArray( get_option( 'wp_post_nav_options' ) );
		$this->assertSame( 'post', get_option( 'wp_post_nav_options' )['wp_post_nav_post_types']['post'] );
		$this->assertSame( '2.0.4', get_option( 'wp_post_nav_version' ) );
	}

	public function test_reactivation_with_current_version_does_not_replace_options(): void {
		$existing = array( 'wp_post_nav_post_types' => array( 'book' => 'book' ) );
		$GLOBALS['wppn_test_options']['wp_post_nav_options'] = $existing;
		$GLOBALS['wppn_test_options']['wp_post_nav_version'] = '2.0.4';

		wp_post_nav_Activator::activate();

		$this->assertSame( $existing, get_option( 'wp_post_nav_options' ) );
	}

	public function test_deactivation_completes_without_error(): void {
		$this->assertNull( wp_post_nav_Deactivator::deactivate() );
	}
}
