<?php

/**
 * The uninstall process of WP Post Nav
 * Removes any of the options created by the plugin and cleans up all after itself
 *
 * @link:       https://wppostnav.com
 * @since      0.0.1
 * @package    wp_post_nav
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN') || ! defined( 'ABSPATH' )) {				
	exit;
}

	//build options array
	$defaults = [];
	$defaults[] = 'wp_post_nav_custom_post_types';
	$defaults[] = 'wp_post_nav_post_types';
	$defaults[] = 'wp_post_nav_out_of_stock';
	$defaults[] = 'wp_post_nav_same_category'; 
	$defaults[] = 'wp_post_nav_show_title';
	$defaults[] = 'wp_post_nav_show_category';
	$defaults[] = 'wp_post_nav_show_post_excerpt';
	$defaults[] = 'wp_post_nav_excerpt_length';
	$defaults[] = 'wp_post_nav_show_featured_image';
	$defaults[] = 'wp_post_nav_fallback_image';	
	$defaults[] = 'wp_post_nav_nav_button_width';
	$defaults[] = 'wp_post_nav_nav_button_height';
	$defaults[] = 'wp_post_nav_background_color';
	$defaults[] = 'wp_post_nav_open_background_color';
	$defaults[] = 'wp_post_nav_title_color';
	$defaults[] = 'wp_post_nav_title_size';
	$defaults[] = 'wp_post_nav_category_color';
	$defaults[] = 'wp_post_nav_category_size';
	$defaults[] = 'wp_post_nav_excerpt_color';
	$defaults[] = 'wp_post_nav_excerpt_size';

	foreach ($defaults as $default) {
		delete_option ($default);
	}   
