<?php

use PHPUnit\Framework\TestCase;

final class PluginContractsTest extends TestCase {

	protected function setUp(): void {
		$GLOBALS['wppn_test_hooks'] = array();
		$GLOBALS['wppn_test_shortcodes'] = array();
	}

	public function test_loader_registers_actions_and_filters(): void {
		$loader = new wp_post_nav_Loader();
		$component = new stdClass();
		$loader->add_action( 'wp_footer', $component, 'render' );
		$loader->add_filter( 'the_content', $component, 'filter_content', 20, 2 );
		$loader->run();

		$this->assertSame( 'wp_footer', $GLOBALS['wppn_test_hooks']['actions'][0]['hook'] );
		$this->assertSame( 'the_content', $GLOBALS['wppn_test_hooks']['filters'][0]['hook'] );
	}

	public function test_public_class_keeps_shortcode_registration(): void {
		$public = new wp_post_nav_Public( 'wp-post-nav', '2.0.4' );

		$this->assertArrayHasKey( 'wp_post_nav', $GLOBALS['wppn_test_shortcodes'] );
		$this->assertSame( array( $public, 'wp_post_nav_shortcode_display' ), $GLOBALS['wppn_test_shortcodes']['wp_post_nav'] );
	}

	public function test_supported_template_files_remain_available(): void {
		$templates = array(
			'wp-post-nav-public-default.php',
			'wp-post-nav-public-primary.php',
			'wp-post-nav-public-attachment.php',
			'wp-post-nav-public-product.php',
		);

		foreach ( $templates as $template ) {
			$this->assertFileExists( dirname( __DIR__, 2 ) . '/public/partials/' . $template );
		}
	}
}
