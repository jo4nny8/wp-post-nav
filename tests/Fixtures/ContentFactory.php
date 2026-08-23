<?php

/**
 * Factories for reusable WordPress integration fixtures.
 */
final class WPPN_Test_Content_Factory {

	public static function register_test_content_types(): void {
		register_post_type(
			'wppn_test_item',
			array(
				'public'       => true,
				'show_ui'      => false,
				'supports'     => array( 'title', 'editor' ),
				'taxonomies'   => array( 'wppn_test_category' ),
				'has_archive'  => false,
			)
		);

		register_taxonomy(
			'wppn_test_category',
			'wppn_test_item',
			array(
				'public'       => true,
				'show_ui'      => false,
				'hierarchical' => true,
			)
		);
	}

	public static function post( string $title, string $date, int $category_id ): int {
		$post_id = self::insert(
			array(
				'post_type'    => 'post',
				'post_title'   => $title,
				'post_content' => 'Fixture content for ' . $title,
				'post_date'    => $date,
			)
		);

		wp_set_post_categories( $post_id, array( $category_id ) );
		return $post_id;
	}

	public static function page( string $title, string $date, int $parent = 0 ): int {
		return self::insert(
			array(
				'post_type'   => 'page',
				'post_title'  => $title,
				'post_date'   => $date,
				'post_parent' => $parent,
			)
		);
	}

	public static function test_item( string $title, string $date, int $term_id ): int {
		$post_id = self::insert(
			array(
				'post_type'  => 'wppn_test_item',
				'post_title' => $title,
				'post_date'  => $date,
			)
		);

		wp_set_object_terms( $post_id, array( $term_id ), 'wppn_test_category' );
		return $post_id;
	}

	public static function attachment( int $parent ): int {
		return self::insert(
			array(
				'post_type'      => 'attachment',
				'post_title'     => 'WP Post Nav fixture attachment',
				'post_parent'    => $parent,
				'post_mime_type' => 'image/jpeg',
				'post_status'    => 'inherit',
			)
		);
	}

	private static function insert( array $args ): int {
		$post_id = wp_insert_post(
			array_merge(
				array(
					'post_status' => 'publish',
				),
				$args
			),
			true
		);

		if ( is_wp_error( $post_id ) ) {
			throw new RuntimeException( $post_id->get_error_message() );
		}

		return (int) $post_id;
	}
}
