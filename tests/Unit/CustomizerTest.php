<?php

use PHPUnit\Framework\TestCase;

final class WPPN_Customizer_Manager_Double {
	public array $panels = array();
	public array $sections = array();
	public array $settings = array();
	public array $controls = array();

	public function add_panel( $id, $args ) { $this->panels[ $id ] = $args; }
	public function add_section( $id, $args ) { $this->sections[ $id ] = $args; }
	public function add_setting( $id, $args ) { $this->settings[ $id ] = $args; }
	public function add_control( $id, $args ) { $this->controls[ $id ] = $args; }
}

final class CustomizerTest extends TestCase {
	public function test_customizer_registers_the_documented_sections_and_settings(): void {
		$manager = new WPPN_Customizer_Manager_Double();
		( new WPPN_Customizer() )->register( $manager );

		$this->assertArrayHasKey( 'wppn_panel', $manager->panels );
		$this->assertCount( 7, $manager->sections );
		$this->assertArrayHasKey( 'wppn_settings[wp_post_nav_background_color]', $manager->settings );
		$this->assertSame( '#8358b0', WPPN_Settings::sanitize_value( 'wp_post_nav_background_color', '#8358b0' ) );
		$this->assertSame( '#8358b0', WPPN_Settings::sanitize_value( 'wp_post_nav_background_color', 'not-a-colour' ) );
		$this->assertSame( array( 'post' => 'post' ), WPPN_Settings::sanitize_value( 'wp_post_nav_post_types', array( 'post' => 'post' ) ) );
	}

	public function test_customizer_attaches_its_lifecycle_hooks_during_construction(): void {
		$GLOBALS['wppn_test_hooks'] = array();
		new WPPN_Customizer();

		$hooks = array_column( $GLOBALS['wppn_test_hooks']['actions'], 'hook' );
		$this->assertContains( 'customize_register', $hooks );
		$this->assertContains( 'customize_preview_init', $hooks );
	}
}
