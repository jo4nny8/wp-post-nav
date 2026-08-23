<?php

/**
 * WP Post Nav admin functionality.
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

class wp_post_nav_Admin {

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
	 * @var      string    $name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {

		$this->name = $name;
		$this->version = $version;

		add_action( 'admin_init', array( $this, 'setup_admin_sections' ) );
		add_action( 'admin_init', array( $this, 'setup_admin_fields' ) );

		add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );
		add_action( 'admin_footer', array( $this, 'media_fields' ) );
		
	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_styles() {

		/*
		* Enqueue the admin styles.  Not used in Version 0.1.0 so we dont enqueue it
		 */

		//wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/wp-post-nav-admin.css', array(), $this->version, 'all' );
    	
		//the color picker styles (built in from WordPress)
  	wp_enqueue_style( 'wp-color-picker' );
  }

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts() {

		//Admin JS
		wp_enqueue_script( $this->name, plugin_dir_url( __FILE__ ) . 'js/wp-post-nav-admin.js', array( 'jquery' ), $this->version, FALSE );
    	
  	//Colorpicker JS
  	wp_enqueue_script( 'wp-color-picker' ); 
		
	}

	/**
     * Add admin menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu() {

        $plugin_screen_hook_suffix = add_options_page( __('WP Post Nav Settings', $this->name ), 'WP Post Nav', 'manage_options', $this->name, array($this, 'display_plugin_setup_page')
        );
    }

    /**
     * Get settings page.
     *
     * @since    1.0.0
     */
    public function display_plugin_setup_page() {
        include_once( 'partials/wp-post-nav-admin-display.php' );
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */
    public function add_action_links( $links ) {

        return array_merge(
            array(
                'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->name ) . '">' . __( 'Settings', $this->name ) . '</a>'
            ),
            $links
        );

    }

    //setup the sections for each part of the page - likely well move this over to tabs in future version
	public function setup_admin_sections() {
		add_settings_section( 'post_type_settings', 'Post Types', array ($this , 'post_type_settings_callback'), 'wp_post_nav' );
		add_settings_section( 'post_type_options', 'Display Settings', array($this, 'post_type_options_callback'), 'wp_post_nav' );
		add_settings_section( 'post_type_styles', 'Style Settings', array($this, 'post_type_styles_callback'), 'wp_post_nav' );
	}

	//show the output for the post type settings section
	public function post_type_settings_callback( $arg ) {
		echo '<p>Choose which post types you wish to show the next and previous navigation on.</p>';
		echo '<hr>';	
	}

	//show the output for the post options settings section
	public function post_type_options_callback( $arg ) {
		echo '<p>Choose the display settings for the next / previous navigation.</p>';
		echo '<hr>';
	}

	//show the output for the stle settings section
	public function post_type_styles_callback( $arg ) {
		echo '<p>Change the default styling of the next / previous navigation</p>';
		echo '<hr>';	
	}
	
	//create the fields for the settings page
	public function setup_admin_fields() {
		$fields = array(
			array(
				'label' => 'Post Types',
				'id' => 'wp_post_nav_post_types',
				'type' => 'checkbox',
				'section' => 'post_type_settings',
				'desc' => 'Select The Post Types To Display WP Post Nav On.',
			),
			array(
				'label' => 'Exclude Out Of Stock Products?',
				'id' => 'wp_post_nav_out_of_stock',
				'type' => 'checkbox',
				//'class' => 'hidden', - preparing for a future update
				'section' => 'post_type_options',
				'options' => array(
					'Yes' => 'Yes',
				),
				'desc' => 'Exclude WooCommerce Products Which Are Out Of Stock?. Please Note: Navigation will not show on these products, and they will be excluded from the next / prev navigation.',
			),
			array(
				'label' => 'Same Category',
				'id' => 'wp_post_nav_same_category',
				'type' => 'checkbox',
				'section' => 'post_type_options',
				'options' => array(
					'Yes' => 'Yes',
				),
				'desc' => 'Show Previous / Next Posts From The Same Category?',
			),
			array(
				'label' => 'Switch Display',
				'id' => 'wp_post_nav_switch_nav',
				'type' => 'checkbox',
				'section' => 'post_type_options',
				'options' => array(
					'Yes' => 'Yes',
				),
				'desc' => 'Switch The Next / Previous Display Side?  By default, the NEXT post is shown on the left (latest post) and the PREVIOUS post is shown on the right (older post) - This options swops the display side',
			),
			array(
				'label' => 'Show Title',
				'id' => 'wp_post_nav_show_title',
				'type' => 'checkbox',
				'section' => 'post_type_options',
				'options' => array(
					'Yes' => 'Yes',
				),
				'desc' => 'Show The Post Title?',
			),
			array(
				'label' => 'Show Category',
				'id' => 'wp_post_nav_show_category',
				'type' => 'checkbox',
				'section' => 'post_type_options',
				'options' => array(
					'Yes' => 'Yes',
				),
				'desc' => 'Show The Post Category?',
			),
			array(
				'label' => 'Show Post Excerpt',
				'id' => 'wp_post_nav_show_post_excerpt',
				'type' => 'checkbox',
				'section' => 'post_type_options',
				'options' => array(
					'Yes' => 'Yes',
				),
				'desc' => 'Show The Post Excerpt?',
			),
			array(
				'label' => 'Excerpt Length',
				'id' => 'wp_post_nav_excerpt_length',
				'type' => 'number',
				'section' => 'post_type_options',
				'desc' => 'Choose the length (characters) of the post excerpt.',
				'default'=> '300',
			),
			array(
				'label' => 'Show Featured Image',
				'id' => 'wp_post_nav_show_featured_image',
				'type' => 'checkbox',
				'section' => 'post_type_options',
				'options' => array(
					'Yes' => 'Yes',
				),
				'desc' => 'Show The Featured Image?',
			),
			array(
				'label' => 'FallBack Image',
				'id' => 'wp_post_nav_fallback_image',
				'type' => 'media',
				'section' => 'post_type_options',
				'desc' => 'Select A Fallback Image For Posts Without An Image.  A default fallback image is used if you dont change this.',
				'default' => plugin_dir_url( __FILE__ ) . 'public/images/default_fallback.png',
			),
			array(
				'label' => 'Nav Button Width',
				'id' => 'wp_post_nav_nav_button_width',
				'type' => 'number',
				'section' => 'post_type_styles',
				'desc' => 'Choose The Width Of The Nav Button.',
				'default'=> '100',
			),
			array(
				'label' => 'Nav Button Height',
				'id' => 'wp_post_nav_nav_button_height',
				'type' => 'number',
				'section' => 'post_type_styles',
				'desc' => 'Choose The Height Of The Nav Button.',
				'default' => '100',
			),
			array(
				'label' => 'Nav Background',
				'id' => 'wp_post_nav_background_color',
				'type' => 'color',
				'section' => 'post_type_styles',
				'desc' => 'Choose The Background Colour Of The Button.',
				'default' => '#8358b0', 
			),
			array(
				'label' => 'Nav Open Background',
				'id' => 'wp_post_nav_open_background_color',
				'type' => 'color',
				'section' => 'post_type_styles',
				'desc' => 'Choose The Background Colour When Open.',
				'default' => '#8358b0', 
			),
			array(
				'label' => 'Title Font Colour',
				'id' => 'wp_post_nav_title_color',
				'type' => 'color',
				'section' => 'post_type_styles',
				'desc' => 'Choose The Title Colour.',
				'default' => '#8358b0', 
			),
			array(
				'label' => 'Title Font Size',
				'id' => 'wp_post_nav_title_size',
				'type' => 'number',
				'section' => 'post_type_styles',
				'desc' => 'Choose The Title Font Size.',
				'default' => '13',
			),
			array(
				'label' => 'Category Font Colour',
				'id' => 'wp_post_nav_category_color',
				'type' => 'color',
				'section' => 'post_type_styles',
				'desc' => 'Choose The Category Colour.',
				'default' => '#8358b0', 
			),
			array(
				'label' => 'Category Font Size',
				'id' => 'wp_post_nav_category_size',
				'type' => 'number',
				'section' => 'post_type_styles',
				'desc' => 'Choose The Category Font Size.',
				'default' => '13',
			),
			array(
				'label' => 'Excerpt Font Colour',
				'id' => 'wp_post_nav_excerpt_color',
				'type' => 'color',
				'section' => 'post_type_styles',
				'desc' => 'Choose The Excerpt Colour.',
				'default' => '#8358b0', 
			),
			array(
				'label' => 'Excerpt Font Size',
				'id' => 'wp_post_nav_excerpt_size',
				'type' => 'number',
				'section' => 'post_type_styles',
				'desc' => 'Choose The Excerpt Font Size.',
				'default' => '12',
			),

		);
		foreach( $fields as $field ){
			$validation = $field['id'].'_validation';	
			add_settings_field( $field['id'], $field['label'], array( $this, 'wp_post_nav_callback' ), 'wp_post_nav', $field['section'], $field );
			register_setting( 'wp_post_nav', $field['id'], array($this, $validation));
		}
	}

	public function wp_post_nav_nav_button_width_validation( $input) {

		$default = get_option( '[wp_post_nav_nav_button_width' );

	    // check the new
	    if (preg_match('#[A-Z]#',$input)){

	        add_settings_error( 'wp_post_nav_settings', 'wp_post_nav_error', 'Nav Button Width Must Be A Number', 'error' );
	            // if not ok save the old value
	           return $default;
	    }else{
	        return sanitize_text_field($input);

	    }
	}

	public function wp_post_nav_nav_button_height_validation($input) {

		$default = get_option( '[wp_post_nav_nav_button_height' );

	    // check the new
	    if (preg_match('#[A-Z]#',$input)){

	        add_settings_error( 'wp_post_nav_settings', 'wp_post_nav_error', 'Nav Button Height Must Be A Number', 'error' );
	            // if not ok save the old value
	           return $default;
	    }else{
	        return sanitize_text_field($input);

	    }
	}
	
	//validate same category selection
	public function wp_post_nav_same_category_validation( $checked) {
	    
	    if (isset($checked)) {
	    	$value = "Yes";
	    }

	    else {
	    	$value = '';
	    }
	    return apply_filters( 'wp_post_nav_same_category_validation', $value, $value);
	}

	//validate show title selection
	public function wp_post_nav_show_title_validation( $checked) {
	    
	    if (isset($checked)) {
	    	$value = "Yes";
	    }

	    else {
	    	$value = '';
	    }
	    return apply_filters( 'wp_post_nav_show_title_validation', $value, $value);
	}

	//validate show category
	public function wp_post_nav_show_category_validation( $checked) {
	    
	    if (isset($checked)) {
	    	$value = "Yes";
	    }

	    else {
	    	$value = '';
	    }
	    return apply_filters( 'wp_post_nav_show_category_validation', $value, $value);
	}

	//validate switching navigation sides
	public function wp_post_nav_switch_nav_validation( $checked) {
	    
	    if (isset($checked)) {
	    	$value = "Yes";
	    }

	    else {
	    	$value = '';
	    }
	    return apply_filters( 'wp_post_nav_switch_nav_validation', $value, $value);
	}

	//validate showing out of stock products
	public function wp_post_nav_out_of_stock_validation( $checked) {
	    
	    if (isset($checked)) {
	    	$value = "Yes";
	    }

	    else {
	    	$value = '';
	    }
	    return apply_filters( 'wp_post_nav_out_of_stock_validation', $value, $value);
	}

	//validate show excerpt
	public function wp_post_nav_show_post_excerpt_validation( $checked) {
	    
	    if (isset($checked)) {
	    	$value = "Yes";
	    }

	    else {
	    	$value = '';
	    }
	    return apply_filters( 'wp_post_nav_show_post_excerpt_validation', $value, $value);
	}

	//validate show featured image
	public function wp_post_nav_show_featured_image_validation( $checked) {
	    
	    if (isset($checked)) {
	    	$value = "Yes";
	    }

	    else {
	    	$value = '';
	    }
	    return apply_filters( 'wp_post_nav_show_featured_image_validation', $value, $value);
	}

	//excerpt length validation
	public function wp_post_nav_excerpt_length_validation( $input) {

		$default = get_option( 'wp_post_nav_excerpt_length' );

	    // check the new
	    if (preg_match('#[A-Z]#',$input)){

	        add_settings_error( 'wp_post_nav_settings', 'wp_post_nav_error', 'Excerpt Length Must Be A Number', 'error' );
	            // if not ok save the old value
	           return $default;
	    }else{
	        return sanitize_text_field($input);

	    }
	}

	public function wp_post_nav_title_size_validation( $input) {

		$default = get_option( 'wp_post_nav_title_size' );

	    // check the new
	    if (preg_match('#[A-Z]#',$input)){

	        add_settings_error( 'wp_post_nav_settings', 'wp_post_nav_error', 'Title Size Must Be A Number', 'error' );
	            // if not ok save the old value
	           return $default;
	    }else{
	        return sanitize_text_field($input);

	    }
	}

	public function wp_post_nav_excerpt_size_validation( $input) {

		$default = get_option( 'wp_post_nav_excerpt_size' );

	    // check the new
	    if (preg_match('#[A-Z]#',$input)){

	        add_settings_error( 'wp_post_nav_settings', 'wp_post_nav_error', 'Excerpt Size Must Be A Number', 'error' );
	            // if not ok save the old value
	           return $default;
	    }else{
	        return sanitize_text_field($input);

	    }
	}

	public function wp_post_nav_category_size_validation( $input) {

		$default = get_option( 'wp_post_nav_category_size' );

	    // check the new
	    if (preg_match('#[A-Z]#',$input)){

	        add_settings_error( 'wp_post_nav_settings', 'wp_post_nav_error', 'Category Size Must Be A Number', 'error' );
	            // if not ok save the old value
	           $value =  $default;
	    }else{
	        $value =  sanitize_text_field($input);

	    }
	    return apply_filters( 'wp_post_nav_category_size_validation', $value, $value);
	}

	//background colour validation
	public function wp_post_nav_background_color_validation($input) {
     	$default = get_option('wp_post_nav_background_color');
	    $color = trim( $input );
	    $color = strip_tags( stripslashes( $color ) );
	     
	    // Check if is a valid hex color
	    if( FALSE === $this->check_color( $color ) ) {
	        // Set the error message
	        add_settings_error( 'wp_post_nav_settings', 'wp_post_nav_error', 'The Background Colour Is Invalid', 'error' );
	        $value = $default;
	     
	    } 

	    else {
	        $value = $color;  
	    }
	     
	    return apply_filters( 'wp_post_nav_background_color_validation', $value, $color);
	}


	//open vbackground colour validation
	public function wp_post_nav_open_background_color_validation($input) {
     	$default = get_option('wp_post_nav_open_background_color');
	    $color = trim( $input );
	    $color = strip_tags( stripslashes( $color ) );
	     
	    // Check if is a valid hex color
	    if( FALSE === $this->check_color( $color ) ) {
	        // Set the error message
	        add_settings_error( 'wp_post_nav_settings', 'wp_post_nav_error', 'The Open Background Colour Is Invalid', 'error' );
	        $value = $default;
	     
	    } 

	    else {
	        $value = $color;  
	    }
	     
	    return apply_filters( 'wp_post_nav_open_background_color_validation', $value, $color);
	}

	//title colour validation
	public function wp_post_nav_title_color_validation($input) {
     	$default = get_option('wp_post_nav_title_color');
	    $color = trim( $input );
	    $color = strip_tags( stripslashes( $color ) );
	     
	    // Check if is a valid hex color
	    if( FALSE === $this->check_color( $color ) ) {
	        // Set the error message
	        add_settings_error( 'wp_post_nav_settings', 'wp_post_nav_error', 'The Title Colour Is Invalid', 'error' );
	        $value = $default;
	     
	    } 

	    else {
	        $value = $color;  
	    }
	     
	    return apply_filters( 'wp_post_nav_title_color_validation', $value, $color);
	}

	//category colour validation
	public function wp_post_nav_category_color_validation($input) {
     	$default = get_option('wp_post_nav_category_color');
	    $color = trim( $input );
	    $color = strip_tags( stripslashes( $color ) );
	     
	    // Check if is a valid hex color
	    if( FALSE === $this->check_color( $color ) ) {
	        // Set the error message
	        add_settings_error( 'wp_post_nav_settings', 'wp_post_nav_error', 'The Category Colour Is Invalid', 'error' );
	        $value = $default;
	     
	    } 

	    else {
	        $value = $color;  
	    }
	     
	    return apply_filters( 'wp_post_nav_category_color_validation', $value, $color);
	}

	//excerpt colour validation
	public function wp_post_nav_excerpt_color_validation($input) {
     	
     	$default = get_option('wp_post_nav_excerpt_color');
	    $color = trim( $input );
	    $color = strip_tags( stripslashes( $color ) );
	     
	    // Check if is a valid hex color
	    if( FALSE === $this->check_color( $color ) ) {
	        // Set the error message
	        add_settings_error( 'wp_post_nav_settings', 'wp_post_nav_error', 'The Excerpt Colour Is Invalid', 'error' );
	        $value = $default;
	     
	    } 

	    else {
	        $value = $color;  
	    }
	     
	    return apply_filters( 'wp_post_nav_excerpt_color_validation', $value, $color);
	}
	 
	//check input is valid hex color
	public function check_color( $value ) { 
	     
	    if ( preg_match( '/^#[a-f0-9]{6}$/i', $value ) ) { // if user insert a HEX color with #     
	        return true;
	    }
	     
	    return false;
	}

	public function wp_post_nav_fallback_image_validation($input) {
	    
	    $image = $input;

		$file_parts = pathinfo($image, PATHINFO_EXTENSION);
		$allowed_extensions = array('jpg','png','gif');

		if (in_array($file_parts, $allowed_extensions)){
		    $value = $image;
		}
		 else {
		    
		if (empty($input)) {
		    $default = plugin_dir_url(dirname(__FILE__ )) . 'public/images/default_fallback.jpg';
		    add_settings_error( 'wp_post_nav_settings', 'wp_post_nav_error', 'Your Image Field Was Blank, The Default FallBack Image Will Be Used', 'updated' );
		}

    	else {
     		$default = get_option('wp_post_nav_fallback_image');
     		add_settings_error( 'wp_post_nav_settings', 'wp_post_nav_error', 'Images must be PNG / JPG or GIF', 'error' );
     	}
		    
	        $value = $default;
		}

	    return apply_filters( 'wp_post_nav_excerpt_color_validation', $value, $value);
	}
	 
	// callback function for rendering each field
	public function wp_post_nav_callback( $field ) {
		$value = get_option( $field['id'] );
		//get the post types from the database
		if ($field['id'] == 'wp_post_nav_post_types'  ) {
				
					$args = array(
					                    'public'   => true,
					                    //'_builtin' => true,
					                  );             
					   

					$output = 'names'; // names or objects,
					$operator = 'and'; // 'and' or 'or'

					$post_types = get_post_types( $args, $output, $operator ); 
	    			
	    			//firstly check that there are post types available
					if ( ! empty( $post_types ) ) {

						//required for initial setup to stop displaying errors.  even though on inital activation, we set the default post type as 'post', it throws an error as its searching for an array that doesnt yet exist.
						if (empty($value)) {
							$options_markup = '';
							$iterator = 0;
							    
							foreach( $post_types as $key => $label ) {
										
										$checked = '';
										
										$iterator++;
										$options_markup.= 
										sprintf(
											'<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s['.$label.']" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>',
											$field['id'],
											$field['type'],
											$key,
											$checked,
											$label,
											$iterator
										);
									}//end
									printf( '<fieldset>%s</fieldset>',$options_markup);
							}
						else {
						  	$options_markup = '';
							$iterator = 0;
							    
							foreach( $post_types as $key => $label ) {
										
										$v = array_search($label, $value);
										
										if ($v !== false) {
											    $checked = 'checked';
											} else {
											    $checked = '';
											}
										
										$iterator++;
										$options_markup.= 
										sprintf(
											'<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s['.$label.']" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>',
											$field['id'],
											$field['type'],
											$key,
											$checked,
											$label,
											$iterator
										);
									}//end
									printf( '<fieldset>%s</fieldset>',$options_markup);

									if( $desc = $field['desc'] ) {
										printf( '<p class="description">%s </p>', $desc );
									}
							}
						}//end if
		}//end if field is

		//callbacks for different types of field
		switch ( $field['type'] ) {
				//media field, notice the callback to an interior function for displaying the images
				case 'media':
					
					if (!empty($value)) {
						$value = $value;
					}

					else {
						$value = $field['default'];
					}

					printf(
						'<input style="width: 40%%" id="%s" name="%s" type="text" value="%s"> <input style="width: 19%%" class="button wp_post_nav_media" id="%s_button" name="%s_button" type="button" value="Upload" />',
						$field['id'],
						$field['id'],
						$value,
						$field['id'],
						$field['id']
					);
					if( $desc = $field['desc'] ) {
						printf( '<p class="description">%s </p>', $desc );
					}
				break;

				//standard checkbox fields
				case 'checkbox':
					if( ! empty ( $field['options'] ) && is_array( $field['options'] ) ) {
						$options_markup = '';
						$iterator = 0;
						foreach( $field['options'] as $key => $label ) {
								if (!empty($value)) {
									$checked = 'checked';
								}

								else {
										$checked = '';
								}

								$options_markup.= sprintf('<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s['.$label.']" type="%2$s" value="%3$s" %4$s/></label> %7$s<br/>',
								$field['id'],
								$field['type'],
								$key,
								$checked,
								$label,
								$iterator,
								$field['desc']

								);
								if ($iterator++ == 1) break;
							}
							printf( '<fieldset>%s</fieldset>',$options_markup);
					}
					break;
				//color picker field - class needs to be added to make the built in colorpicker work
				case 'color':
					printf( '<input name="%1$s" id="%1$s" type="%2$s" class="color-field" value="%3$s" />',
					$field['id'],
					$field['type'],
					$value
				);
					if( $desc = $field['desc'] ) {
						printf( '<p class="description">%s </p>', $desc );
					}
				break;
				default:

				if (!empty($value)) {
					$value = $value;
				}

				else {
					$value = $field['default'];
				}

				printf( '<input name="%1$s" id="%1$s" type="%2$s" value="%3$s" />',
					$field['id'],
					$field['type'],
					$value
				);
				
				if( $desc = $field['desc'] ) {
			printf( '<p class="description">%s </p>', $desc );
		}
		}
		
	}	

	//function for adding and updating media fields of image uploads
	public function media_fields() {
		?><script>
			jQuery(document).ready(function($){
				if ( typeof wp.media !== 'undefined' ) {
					var _custom_media = true,
					_orig_send_attachment = wp.media.editor.send.attachment;
					$('.wp_post_nav_media').click(function(e) {
						var send_attachment_bkp = wp.media.editor.send.attachment;
						var button = $(this);
						var id = button.attr('id').replace('_button', '');
						_custom_media = true;
							wp.media.editor.send.attachment = function(props, attachment){
							if ( _custom_media ) {
								$('input#'+id).val(attachment.url);
							} else {
								return _orig_send_attachment.apply( this, [props, attachment] );
							};
						}
						wp.media.editor.open(button);
						return false;
					});
					$('.add_media').on('click', function(){
						_custom_media = false;
					});
				}
			});

			
		</script><?php
	}
}
