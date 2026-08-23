<?php

/**
 * WP Post Nav activiation settings.
 *
 * @link:      https://wppostnav.com
 * @since      0.0.1
 *
 * @package    wp_post_nav
 * @subpackage wp_post_nav/includes
 */

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {
  exit;
} 

class wp_post_nav_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    0.0.1
	 */
	public static function activate() {
		//get one of the options to see if the plugin has previously been activated or installed
		$post_types = 'wp_post_nav_post_types';

		if ( get_option( $post_types ) !== false ) {
			//Option exists = plugin has previously been activated.
		    return;

		} 

		//this is a first setup, or reinstall - set default options
		else {
			$deprecated = null;
		    $autoload = 'no';
		    
		    $defaults = [];

		    //display settings
			$defaults['wp_post_nav_post_types'] = array('post' => 'post');
			$defaults['wp_post_nav_same_category'] = 'yes';
			$defaults['wp_post_nav_show_title'] = 'yes';
			$defaults["wp_post_nav_show_category"] = 'yes';
			$defaults["wp_post_nav_show_post_excerpt"] = 'yes';
			$defaults["wp_post_nav_excerpt_length"] = '300';
			$defaults["wp_post_nav_show_featured_image"] = 'yes';
			$defaults["wp_post_nav_fallback_image"] = plugin_dir_path( __FILE__ ).'public/images/default_fallback.jpg';

			//style settings
			$defaults['wp_post_nav_nav_button_width'] = '70';
			$defaults['wp_post_nav_nav_button_height'] = '100';
			$defaults['wp_post_nav_background_color'] = '#8358b0';
			$defaults['wp_post_nav_open_background_color'] = '#8358b0';
			$defaults['wp_post_nav_title_color'] = '#ffffff';
			$defaults['wp_post_nav_title_size'] = '14';
			$defaults['wp_post_nav_category_color'] = '#ffffff';
			$defaults['wp_post_nav_category_size'] = '13';
			$defaults['wp_post_nav_excerpt_color'] = '#ffffff';
			$defaults['wp_post_nav_excerpt_size'] = '12';		
			
			foreach ($defaults as $default => $value) {

				add_option ($default, $value, $deprecated, $autoload);
			}   
		}
	}
}
