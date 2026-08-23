<?php

/**
 * WP Post Nav public functionality.
 *
 * @link:       https://wppostnav.com
 * @since      0.0.1
 *
 * @package    wp_post_nav
 * @subpackage wp_post_nav/includes
 */

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {
  exit;
} 


class wp_post_nav_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.0.1
	 * @var      string    $name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {

		$this->name = $name;
		$this->version = $version;

		//load the next / previous navigation
		add_action('wp_footer', array ($this, 'display_wp_post_nav'));
		
	}

	/**
	 * Register the stylesheets for the front end.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_styles() {

		/*
		* Enqueue the public styles.
		 */
		wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/wp-post-nav-public.css', array(), $this->version, 'all' );
		$settings = $this->wp_post_nav_get_settings();

		$nav_background     = $settings['wp_post_nav_background_color'];
		$nav_button_width   = $settings['wp_post_nav_nav_button_width'].'px';
		$nav_button_height  = $settings['wp_post_nav_nav_button_height'].'px';
		$nav_button_offset  = '-'.$nav_button_width;

		$nav_open_background= $settings['wp_post_nav_open_background_color'];

		$nav_heading_colour = $settings['wp_post_nav_heading_color'];
		$nav_heading_size   = $settings['wp_post_nav_heading_size'] . 'px';
		$nav_title_colour   = $settings['wp_post_nav_title_color'];
		$nav_font_size      = $settings['wp_post_nav_title_size'] . 'px';
		$nav_category_colour= $settings['wp_post_nav_category_color'];
		$nav_category_size  = $settings['wp_post_nav_category_size'] . 'px';
		$nav_excerpt_colour = $settings['wp_post_nav_excerpt_color'];
		$nav_excerpt_size 	= $settings['wp_post_nav_excerpt_size'] . 'px';

		$nav_css = ".wp-post-nav #post-nav-previous-default,
								.wp-post-nav #post-nav-previous-switched {
						    	background: $nav_background;
								}

								.wp-post-nav #post-nav-previous-default #post-nav-previous-button {
								  background:$nav_background;
								  line-height: $nav_button_height;
								  width: $nav_button_width;
								  height: $nav_button_height;
								  right: $nav_button_offset;
								}

								.wp-post-nav #post-nav-previous-switched #post-nav-previous-button {
									background:$nav_background;
								  line-height: $nav_button_height;
								  width: $nav_button_width;
								  height: $nav_button_height;
								  left: $nav_button_offset;
								}

								.wp-post-nav #post-nav-previous-default:hover,
								.wp-post-nav #post-nav-previous-switched:hover {
									background:$nav_open_background;
								}

								.wp-post-nav #post-nav-previous-default:hover #post-nav-previous-button,
								.wp-post-nav #post-nav-previous-switched:hover #post-nav-previous-button {
									background:$nav_open_background;
								}

								.wp-post-nav #post-nav-next-default,
								.wp-post-nav #post-nav-next-switched {
									background: $nav_background;
								}

								.wp-post-nav #post-nav-next-default #post-nav-next-button {
									background:$nav_background;
									line-height: $nav_button_height;
									width: $nav_button_width;
									height: $nav_button_height;
									left: $nav_button_offset;
								}

								.wp-post-nav #post-nav-next-switched #post-nav-next-button {
									background:$nav_background;
									line-height: $nav_button_height;
									width: $nav_button_width;
									height: $nav_button_height;
									right: $nav_button_offset;
								}

								.wp-post-nav #post-nav-next-default:hover,
								.wp-post-nav #post-nav-next-switched:hover {
									background:$nav_open_background;
								}

								.wp-post-nav #post-nav-next-default:hover #post-nav-next-button,
								.wp-post-nav #post-nav-next-switched:hover #post-nav-next-button {
									background:$nav_open_background;
								}

								.wp-post-nav h4 {
									text-align:center;
									font-weight:600;
								  color:$nav_heading_colour;
								  font-size:$nav_heading_size;
								}

								.wp-post-nav .post-nav-title {
								  color:$nav_title_colour;
								  font-size:$nav_font_size;
								}

								.wp-post-nav .post-nav-category {
									color:$nav_category_colour;
									font-size:$nav_category_size;
								}

								.wp-post-nav .post-nav-excerpt {
									color:$nav_excerpt_colour;
									font-size:$nav_excerpt_size;
								}

								.wp-post-nav #attachment-post-nav-previous-default {
									background: $nav_background;
									color:$nav_title_colour;
								}

								.wp-post-nav #attachment-post-nav-previous-default:after {
									background:$nav_background;
									line-height: $nav_button_height;
									width: $nav_button_width;
									height: $nav_button_height;
									right: $nav_button_offset;
								}

								@media only screen and 
								(max-width: 48em) {
								  .wp-post-nav #post-nav-next-default .post-nav-title,
								  .wp-post-nav #post-nav-next-switched .post-nav-title {
								    color:$nav_title_colour; 
								  }

								  .wp-post-nav #post-nav-previous-default .post-nav-title,
								  .wp-post-nav #post-nav-previous-switched .post-nav-title {
								    color:$nav_title_colour;
								  }       
								}";

		wp_add_inline_style( $this->name, $nav_css );

	}

	/**
	 * Register the JavaScript for the front end.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts() {

		/*
		* Enqueue the public scripts.  Not used in Version 0.0.1 so we dont enqueue it
		 */

		//wp_enqueue_script( $this->name, plugin_dir_url( __FILE__ ) . 'js/wp-post-nav-public.js', array( 'jquery' ), $this->version, FALSE );

	}

	//get all the settings from the admin panel and build an array of the options
	public function wp_post_nav_get_settings() {
	  $settings = get_option ('wp_post_nav_options');
    return $settings;
	}

	//get the post categories for the current displayed post type
	public function get_post_categories() {
		$category =  get_queried_object();
    $category_post_type = $category->post_type;
    $taxonomies = get_object_taxonomies($category_post_type);

    switch ( $category ) {
		case 'product':
        	$term = 'product_cat';
		break;

		default:
			if ( $taxonomies ){
				$i = 0;
				foreach( $taxonomies as $terms ) {
				  //we only want the first term in the array so bail after getting it
				  if ($i == 0) {
				    $term = $terms;
				  }
				  $i++;
			  } 
			}
	    else {
	    	$term = false;
	    }
	}
    return $term; 
	}

	//create the excerpt function
	public function wp_post_nav_excerpt($id) {
		$settings = $this->wp_post_nav_get_settings();
			
			if (array_key_exists('wp_post_nav_excerpt_length', $settings)) {
		    $excerpt_length = $settings['wp_post_nav_excerpt_length'];    
		  }

		  //allow devcelopers to override how this is done
		  $over_ride = true;
		  $over_ride = apply_filters( 'wp-post-nav-excerpt', $over_ride);

		  //if the developer hasnt overridden this, use post content and allow altering it
		  if ($over_ride == true ) {

		    $content = get_post($id);
				$excerpt = $content->post_content;
				$excerpt = strip_tags($excerpt);
				$excerpt = substr($excerpt, 0, $excerpt_length);
				$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
				$excerpt = $excerpt;
			}

			//use wordpress default built in post excerpt function
			else {
				$excerpt = get_the_excerpt($id);
			}

		return $excerpt;
	}

	//the main call to make the WP Post Nav display
	public function display_wp_post_nav() {
    
    $settings = $this->wp_post_nav_get_settings();
    
    if (array_key_exists('wp_post_nav_post_types', $settings)) {
	    $post_types = $settings["wp_post_nav_post_types"];
	  }
	  else {
	  	return;
	  }
	  
		if (array_key_exists('wp_post_nav_same_category', $settings)) {
			$same_category = 'yes';  
    }
    else {
    	$same_category = 'no';
    }
		
		if (array_key_exists('wp_post_nav_switch_nav', $settings)) {
			$switch_nav = '-switched';   
    }
    else {
    	$switch_nav = '-default';
    }

		if (array_key_exists('wp_post_nav_show_title', $settings)) {
			$show_title = 'yes';  
    }
    else {
    	$show_title = 'no';
    }
		
		if (array_key_exists('wp_post_nav_show_category', $settings)) {
			$show_category = 'yes';  
    }
    else {
    	$show_category = 'no';
    }

		if (array_key_exists('wp_post_nav_show_post_excerpt', $settings)) {
			$show_excerpt = 'yes';    
    }
    else {
    	$show_excerpt = 'no';
    }

		if (array_key_exists('wp_post_nav_show_featured_image', $settings)) {
			$show_featured = 'yes'; 
    }
    else {
    	$show_featured = 'no';
    }

		if (array_key_exists('wp_post_nav_fallback_image', $settings)) {
			$fallback = $settings["wp_post_nav_fallback_image"];
		}

		//add in the additional options for yoast and woocommerce
		if (array_key_exists('wp_post_nav_yoast_seo', $settings)) {
			$yoast_primary = 'yes';
		}
		else {
			$yoast_primary = 'no';
		}

		if (array_key_exists('wp_post_nav_out_of_stock', $settings)) {
			$out_of_stock = 'yes';
		}
		else {
			$out_of_stock = 'no';
		}

    //If there are no post types selected or were not on a singular post type page were allowing, exit.  Also exclude home page and blog pages
    if (!$post_types || !in_array(is_singular($post_types), $post_types) || is_home() || is_front_page() || is_post_type_archive()) {
        return;
    }
    
    $current_page = get_queried_object();
		$current = $current_page->post_type;

    //switch the display depending on which type of post is displayed
    switch ( $current ) {
			case 'page':
	      include_once( 'partials/wp-post-nav-public-page.php' );
			break;

			case 'post':
	      include_once( 'partials/wp-post-nav-public-post.php' );
			break;

			case 'attachment':
				include_once( 'partials/wp-post-nav-public-attachment.php' );
			break;

			case 'product':
				include_once( 'partials/wp-post-nav-public-product.php' );
			break;
			
			default:
				include_once( 'partials/wp-post-nav-public-default.php' );		
		}	   
	}
}
