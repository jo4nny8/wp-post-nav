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
		$nav_background     = get_option('wp_post_nav_background_color' );
		$nav_button_width   = get_option('wp_post_nav_nav_button_width').'px';
		$nav_button_height  = get_option('wp_post_nav_nav_button_height').'px';
		$nav_button_offset  = '-'.$nav_button_width;

		$nav_open_background= get_option('wp_post_nav_open_background_color');
		$nav_colour         = get_option('wp_post_nav_css_nav_colour').'px';

		$nav_title_colour   = get_option('wp_post_nav_title_color');
		$nav_font_size      = get_option('wp_post_nav_title_size') . 'px';
		$nav_category_colour   = get_option('wp_post_nav_category_color');
		$nav_category_size      = get_option('wp_post_nav_category_size') . 'px';
		$nav_excerpt_colour = get_option('wp_post_nav_excerpt_color');
		$nav_excerpt_size = get_option('wp_post_nav_excerpt_size') . 'px';

		$nav_css = ".wp-post-nav #post-nav-previous {
						    	background: $nav_background;
								}

								.wp-post-nav #post-nav-previous-button {
								  background:$nav_background;
								  line-height: $nav_button_height;
								  width: $nav_button_width;
								  height: $nav_button_height;
								  right: $nav_button_offset;
								}

								.wp-post-nav #post-nav-previous:hover {
									background:$nav_open_background;
								}

								.wp-post-nav #post-nav-previous:hover #post-nav-previous-button {
									background:$nav_open_background;
								}

								.wp-post-nav #post-nav-next {
									background: $nav_background;
								}

								.wp-post-nav #post-nav-next-button {
									background:$nav_background;
									line-height: $nav_button_height;
									width: $nav_button_width;
									height: $nav_button_height;
									left: $nav_button_offset;
								}

								.wp-post-nav #post-nav-next:hover {
									background:$nav_open_background;
								}

								.wp-post-nav #post-nav-next:hover #post-nav-next-button {
									background:$nav_open_background;
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

								.wp-post-nav #attachment-post-nav-previous {
									background: $nav_background;
									color:$nav_title_colour;
								}

								.wp-post-nav #attachment-post-nav-previous:after {
									background:$nav_background;
									line-height: $nav_button_height;
									width: $nav_button_width;
									height: $nav_button_height;
									right: $nav_button_offset;
								}

								@media only screen and 
								(max-width: 48em) {
								  .wp-post-nav #post-nav-next .post-nav-title {
								    color:$nav_title_colour; 
								  }

								  .wp-post-nav #post-nav-previous .post-nav-title {
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
		if (!$post_types = get_option ('wp_post_nav_post_types')) {
	    return;
	    }

	    //if post types have been selected, build the array
	    else {
	    	$post_types = get_option ('wp_post_nav_post_types' );
	    }

	    //are we excluding out of stock woocommerce products
	    if ($outofstock = get_option ('wp_post_nav_out_of_stock')) {
	      $outofstock = 'yes';   
	    }
	    else {
	    	$outofstock = 'no';
	    }

	    //are we showing in same category
	    if ($same_category = get_option ('wp_post_nav_same_category')) {
	        $same_category = 'yes';   
	    }
	    else {
	    	$same_category = 'no';
	    }

	    //are we showing titles
	    if ($show_title = get_option ('wp_post_nav_show_title')) {
	        $show_title = 'yes';  
	    }
	    else {
	    	$show_title = 'no';
	    }

	    //are we showing category
	    if ($show_category = get_option ('wp_post_nav_show_category')) {
	        $show_category = 'yes';  
	    }
	    else {
	    	$show_category = 'no';
	    }

	    //are we showing excerpts
	    if ($show_excerpt = get_option ('wp_post_nav_show_post_excerpt')) {
	        $show_excerpt = 'yes';    
	    }
	    else {
	    	$show_excerpt = 'no';
	    }

	    //excerpt length
	    if (!$excerpt_length = get_option ('wp_post_nav_excerpt_length')) {
	        $excerpt_length = get_option ('wp_post_nav_excerpt_length');    
	    }
	    
	    //are we showing images
	    if ($show_featured = get_option ('wp_post_nav_show_featured_image')) {
	        $show_featured = 'yes'; 
	    }
	    else {
	    	$show_featured = 'no';
	    }

	    //get fallback image
	    if (!$fallback = get_option ('wp_post_nav_fallback_image')) {
	    	$fallback = get_option ('wp_post_nav_fallback_image');    
		}

	    $settings = [];
	    $settings["post_types"] = $post_types;
	    $settings["outofstock"] = $outofstock;
	    $settings["same_category"] = $same_category;
	    $settings["show_title"] = $show_title;
	    $settings["show_category"] = $show_category;
	    $settings["show_excerpt"] = $show_excerpt;
	    $settings["excerpt_length"] = $excerpt_length;
	    $settings["show_featured"] = $show_featured;
	    $settings["fallback_image"] = $fallback;
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
	public function wp_post_nav_excerpt( $id) {
			
			if (!$excerpt_length = get_option ('wp_post_nav_excerpt_length')) {
		        $excerpt_length = get_option ('wp_post_nav_excerpt_length');    
		    }

		    $content = get_post($id);
				$excerpt = $content->post_content;
				$excerpt = strip_tags($excerpt);
				$excerpt = substr($excerpt, 0, $excerpt_length);
				$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
				$excerpt = $excerpt;
		
		return $excerpt;
	}

	//the main call to make the WP Post Nav display
	public function display_wp_post_nav() {
    
    $settings 		= $this->wp_post_nav_get_settings();
    $post_types 	= $settings["post_types"];
		$outofstock 	= $settings["outofstock"];
		$same_category 	= $settings["same_category"];
		$show_title 	= $settings["show_title"];
		$show_category 	= $settings["show_category"];
		$show_excerpt 	= $settings["show_excerpt"];
		$show_featured 	= $settings["show_featured"];
		$fallback 		= $settings["fallback_image"];
    
    //If there are no post types selected or were not on a singular post type page, exit.  Also exclude home page and blog pages
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
