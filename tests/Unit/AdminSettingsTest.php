<?php

use PHPUnit\Framework\TestCase;

final class AdminSettingsTest extends TestCase {

	private wp_post_nav_admin $admin;

	protected function setUp(): void {
		$GLOBALS['wppn_test_options'] = array();
		$GLOBALS['wppn_test_settings_errors'] = array();
		$this->admin = new wp_post_nav_admin( 'wp-post-nav', '2.1.0' );
		$this->admin->init();
	}

	public function test_default_settings_are_created_when_missing(): void {
		$options = $this->admin->get_options();

		$this->assertSame( 'yes', $options['wp_post_nav_show_title'] );
		$this->assertSame( '#8358b0', $options['wp_post_nav_background_color'] );
	}

	public function test_saved_settings_are_returned(): void {
		$saved = array( 'wp_post_nav_show_title' => 'no' );
		$GLOBALS['wppn_test_options']['wppn_settings'] = $saved;

		$this->assertSame( 'no', $this->admin->get_options()['wp_post_nav_show_title'] );
	}

	public function test_valid_settings_are_preserved_and_unknown_settings_are_rejected(): void {
		$validated = $this->admin->validate_fields(
			array(
				'wp_post_nav_background_color' => '#123456',
				'wp_post_nav_show_title'       => 'yes',
				'unknown_setting'              => 'must not be saved',
			)
		);

		$this->assertSame( '#123456', $validated['wp_post_nav_background_color'] );
		$this->assertSame( 'yes', $validated['wp_post_nav_show_title'] );
		$this->assertArrayNotHasKey( 'unknown_setting', $validated );
	}

	public function test_invalid_numeric_and_colour_values_fall_back_to_saved_values(): void {
		$GLOBALS['wppn_test_options']['wppn_settings'] = array(
			'wp_post_nav_excerpt_length'   => '300',
			'wp_post_nav_background_color' => '#8358b0',
		);

		$validated = $this->admin->validate_fields(
			array(
				'wp_post_nav_excerpt_length'   => 'not numeric',
				'wp_post_nav_background_color' => 'not a colour',
			)
		);

		$this->assertSame( '300', $validated['wp_post_nav_excerpt_length'] );
		$this->assertSame( '#8358b0', $validated['wp_post_nav_background_color'] );
		$this->assertNotEmpty( $GLOBALS['wppn_test_settings_errors'] );
	}

	public function test_checkbox_is_retained_when_checked_and_absent_when_unchecked(): void {
		$validated = $this->admin->validate_fields(
			array( 'wp_post_nav_show_title' => 'yes' )
		);

		$this->assertSame( 'yes', $validated['wp_post_nav_show_title'] );
		$this->assertSame( '', $validated['wp_post_nav_show_category'] );
	}
}
