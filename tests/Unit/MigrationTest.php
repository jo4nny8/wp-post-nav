<?php

use PHPUnit\Framework\TestCase;

final class MigrationTest extends TestCase {

	protected function setUp(): void {
		$GLOBALS['wppn_test_options'] = array();
		$GLOBALS['wppn_test_transients'] = array();
	}

	public function test_204_settings_are_migrated_and_legacy_options_are_removed(): void {
		$GLOBALS['wppn_test_options']['wp_post_nav_options'] = array(
			'wp_post_nav_show_title'       => '',
			'wp_post_nav_background_color' => '#123456',
		);

		$this->assertTrue( WPPN_Migrations::migrate_2_0_4_to_2_1_0() );
		$this->assertSame( '', get_option( 'wppn_settings' )['wp_post_nav_show_title'] );
		$this->assertSame( '#123456', get_option( 'wppn_settings' )['wp_post_nav_background_color'] );
		$this->assertSame( '2.1.0', get_option( 'wppn_migration_210_complete' ) );
		$this->assertFalse( get_option( 'wp_post_nav_options', false ) );
	}

	public function test_migration_is_idempotent_and_does_not_replace_new_settings(): void {
		$GLOBALS['wppn_test_options']['wppn_settings'] = WPPN_Settings::get_defaults();
		$GLOBALS['wppn_test_options']['wppn_settings']['wp_post_nav_title_color'] = '#010101';
		$GLOBALS['wppn_test_options']['wp_post_nav_options'] = array( 'wp_post_nav_title_color' => '#ffffff' );
		$GLOBALS['wppn_test_options']['wppn_migration_210_complete'] = '2.1.0';

		$this->assertTrue( WPPN_Migrations::migrate_2_0_4_to_2_1_0() );
		$this->assertSame( '#010101', get_option( 'wppn_settings' )['wp_post_nav_title_color'] );
	}

	public function test_existing_new_settings_take_precedence_over_legacy_values(): void {
		$GLOBALS['wppn_test_options']['wppn_settings'] = array( 'wp_post_nav_title_color' => '#010101' );
		$GLOBALS['wppn_test_options']['wp_post_nav_options'] = array( 'wp_post_nav_title_color' => '#ffffff' );

		$this->assertTrue( WPPN_Migrations::migrate_2_0_4_to_2_1_0() );
		$this->assertSame( '#010101', get_option( 'wppn_settings' )['wp_post_nav_title_color'] );
	}
}
