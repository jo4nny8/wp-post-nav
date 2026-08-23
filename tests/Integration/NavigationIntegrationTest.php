<?php

use PHPUnit\Framework\TestCase;

require_once dirname( __DIR__ ) . '/Fixtures/ContentFactory.php';

if ( class_exists( 'WP_UnitTestCase' ) ) {
	final class NavigationIntegrationTest extends WP_UnitTestCase {

		private static int $category_id;
		private static int $term_id;
		private static array $posts;

		public static function setUpBeforeClass(): void {
			parent::setUpBeforeClass();
			WPPN_Test_Content_Factory::register_test_content_types();
			self::$category_id = self::factory()->term->create( array( 'taxonomy' => 'category' ) );
			self::$term_id = self::factory()->term->create( array( 'taxonomy' => 'wppn_test_category' ) );
			self::$posts = array(
				'first'  => WPPN_Test_Content_Factory::post( 'WPPN First Post', '2024-01-01 10:00:00', self::$category_id ),
				'middle' => WPPN_Test_Content_Factory::post( 'WPPN Middle Post', '2024-01-02 10:00:00', self::$category_id ),
				'last'   => WPPN_Test_Content_Factory::post( 'WPPN Last Post', '2024-01-03 10:00:00', self::$category_id ),
			);
		}

		public function test_previous_and_next_post_navigation_uses_known_order(): void {
			$this->go_to( get_permalink( self::$posts['middle'] ) );

			$previous = get_adjacent_post( false, array(), true );
			$next = get_adjacent_post( false, array(), false );

			$this->assertSame( self::$posts['first'], $previous->ID );
			$this->assertSame( self::$posts['last'], $next->ID );
		}

		public function test_first_and_last_posts_have_one_empty_navigation_direction(): void {
			$this->go_to( get_permalink( self::$posts['first'] ) );
			$this->assertNull( get_adjacent_post( false, array(), true ) );
			$this->assertSame( self::$posts['middle'], get_adjacent_post( false, array(), false )->ID );

			$this->go_to( get_permalink( self::$posts['last'] ) );
			$this->assertSame( self::$posts['middle'], get_adjacent_post( false, array(), true )->ID );
			$this->assertNull( get_adjacent_post( false, array(), false ) );
		}

		public function test_shortcode_renders_previous_and_next_post_markup(): void {
			update_option(
				'wp_post_nav_options',
				array(
					'wp_post_nav_show_title'          => 'yes',
					'wp_post_nav_show_category'       => 'yes',
					'wp_post_nav_show_post_excerpt'   => 'no',
					'wp_post_nav_show_featured_image' => 'no',
					'wp_post_nav_fallback_image'      => '',
				)
			);
			$this->go_to( get_permalink( self::$posts['middle'] ) );

			$output = do_shortcode( '[wp_post_nav]' );

			$this->assertStringContainsString( 'class="wp-post-nav-shortcode"', $output );
			$this->assertStringContainsString( 'Previous Post', $output );
			$this->assertStringContainsString( 'Next Post', $output );
		}

		public function test_shortcode_returns_empty_for_a_post_without_adjacent_posts(): void {
			$single = WPPN_Test_Content_Factory::post( 'WPPN Single Post', '2025-01-01 10:00:00', self::$category_id );
			$this->go_to( get_permalink( $single ) );

			$this->assertSame( '', do_shortcode( '[wp_post_nav]' ) );
		}

		public function test_page_parent_and_child_fixtures_are_created(): void {
			$parent = WPPN_Test_Content_Factory::page( 'WPPN Parent Page', '2024-02-01 10:00:00' );
			$child = WPPN_Test_Content_Factory::page( 'WPPN Child Page', '2024-02-02 10:00:00', $parent );

			$this->assertSame( $parent, (int) get_post_field( 'post_parent', $child ) );
			$this->assertSame( 'page', get_post_type( $child ) );
		}

		public function test_custom_post_type_navigation_is_taxonomy_aware(): void {
			$first = WPPN_Test_Content_Factory::test_item( 'WPPN First Item', '2024-03-01 10:00:00', self::$term_id );
			$last = WPPN_Test_Content_Factory::test_item( 'WPPN Last Item', '2024-03-02 10:00:00', self::$term_id );
			$this->go_to( get_permalink( $last ) );

			$previous = get_adjacent_post( true, array(), true, 'wppn_test_category' );

			$this->assertSame( $first, $previous->ID );
		}

		public function test_attachment_fixture_preserves_return_to_post_parent(): void {
			$attachment = WPPN_Test_Content_Factory::attachment( self::$posts['middle'] );

			$this->assertSame( self::$posts['middle'], (int) wp_get_post_parent_id( $attachment ) );
			$this->assertSame( 'attachment', get_post_type( $attachment ) );
		}

		public function test_multiple_shortcode_calls_return_independent_output(): void {
			$this->go_to( get_permalink( self::$posts['middle'] ) );

			$first_output = do_shortcode( '[wp_post_nav display_previous="true" display_next="false"]' );
			$second_output = do_shortcode( '[wp_post_nav display_previous="false" display_next="true"]' );

			$this->assertStringContainsString( 'Previous Post', $first_output );
			$this->assertStringNotContainsString( 'Next Post', $first_output );
			$this->assertStringContainsString( 'Next Post', $second_output );
			$this->assertStringNotContainsString( 'Previous Post', $second_output );
		}
	}
} else {
	final class NavigationIntegrationTest extends TestCase {

		public function test_wordpress_integration_environment_is_required(): void {
			$this->markTestSkipped( 'Set WP_TESTS_DIR to run WordPress integration fixtures.' );
		}
	}
}
