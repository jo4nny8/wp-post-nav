<?php

/**
 *
 * WP Post Nav product display page.
 *
 * @link:      https://wppostnav.com
 * @since      0.0.1
 *
 * @package    wp_post_nav
 * @subpackage wp_post_nav/public/partials
 */
?>

<?php 
// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {
  exit;
} 

if ($out_of_stock == 'yes') {
      
      add_filter( 'get_previous_post_where', 'wppostnav_outofstock' );
      add_filter( 'get_next_post_where', 'wppostnav_outofstock' );
      
      function wppostnav_outofstock($where) {
        global $wpdb;
        return $where . " AND p.ID IN ( 
                          SELECT p.ID FROM $wpdb->posts p 
                          LEFT JOIN $wpdb->postmeta m ON p.ID = m.post_id 
                          WHERE m.meta_key = '_stock_status' 
                          AND m.meta_value = 'instock' )";
      }
}

//setup the excluded term array.  If yoast primary term is selected we need to only use that for getting terms
$excluded_terms = [];
if ($yoast_primary == 'yes') {
  if ( class_exists('WPSEO_Primary_Term') ) {
     // Show the post's 'Primary' category, if this Yoast feature is available, & one is set
    $wpseo_primary_term = new WPSEO_Primary_Term( 'product_cat', get_the_id() );
    $wpseo_primary_term = $wpseo_primary_term->get_primary_term();
    $term = get_term( $wpseo_primary_term );
    //no primary term selected so bail
     if ( !is_wp_error( $term ) ) {
      $excluded_terms = get_terms( array(
            'taxonomy' => $term->taxonomy,
            'hide_empty' => false,
            'exclude' => $term->term_id,
            'fields'   => 'ids'
        ) );
      }
  }
}   

switch ( $same_category ) {
	case 'yes':
      $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post(true, $excluded_terms, true, 'product_cat' );
      $next = get_adjacent_post(true, $excluded_terms, false, 'product_cat' );
	break;

	default:
		//fetch previous and next posts
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_previous_post();
    $next = get_next_post();		
	}

//if there arent any next AND previous posts, leave.
if ( !$previous && !$next) {
    return;
}

//We have posts - lets do this
else {
    
    //get all the information

    //if theres a previous post, get its details
	if ($previous) {       
	    //are we showing featured images?
    	switch ( $show_featured ) {
				case 'yes':
			    	if (!$previous_image = get_the_post_thumbnail( $previous->ID, 'thumbnail' )) 
		                {
		                    $previous_image = $fallback;
		                    $previous_image = '<li class="post-nav-image"><image src="'.$previous_image.'"/></li>';   
		                }

		            else {
		                    $previous_image = get_the_post_thumbnail( $previous->ID, 'thumbnail' );
		                    $previous_image = $previous_image ? '<li class="post-nav-image">' . $previous_image . '</li>' : '';
		            }
		        break;
		        default:
		        	$previous_image = '';
            }

        //are we showing the post title
    	switch ( $show_title ) {
				case 'yes':
					$previous_title = get_the_title( $previous->ID );
					$previous_post_title = 
                             		'<li class="post-nav-title">'
                                    	.$previous_title.
                                    '</li>';
            	break;
		        default:
		        	$previous_post_title = '';
		    } 

	    //are we showing the post category
	    switch ( $show_category ) {
				case 'yes':
					if ($previous_categories = get_the_terms( $previous->ID, 'product_cat' )) {
            		$previous_category 		= $previous_categories[0]->name;
            		}

            		else {
            			$previous_category = '';
            		}

					$previous_post_category = 
                             		'<li class="post-nav-category">'.
	                                     __('Category: ', 'wp-post-nav')
	                                    .$previous_category.
	                                    '</strong>'.
		                            '</li>';
            	break;
		        default:
		        	$previous_post_category = '';
		       
		    }

	    //are we showing the post excerpt?
	    switch ( $show_excerpt ) {
				case 'yes':
					$post_excerpt 	= $this->wp_post_nav_excerpt( $previous->ID );

					$previous_post_excerpt = 
                             		'<li class="post-nav-excerpt">'
                                    .$post_excerpt.
		                            '</li>';
            	break;
		        default:
		        	$previous_post_excerpt = '';
		       
		    }                   
    }

    //if theres a next post, get its details
	if ($next) {       
    	//are we showinf featured images?
    	switch ( $show_featured ) {
				case 'yes':
			    	if (!$next_image = get_the_post_thumbnail( $next->ID, 'thumbnail' )) 
		                {
		                    $next_image = $fallback;
		                    $next_image = '<li class="post-nav-image"><image src="'.$next_image.'"/></li>';   
		                }

		            else {
		                    $next_image = get_the_post_thumbnail( $next->ID, 'thumbnail' );
		                    $next_image = $next_image ? '<li class="post-nav-image">' . $next_image . '</li>' : '';
		            }
		        break;
		        default:
		        	$next_image = '';
            }

        //are we showing the post title
    	switch ( $show_title ) {
				case 'yes':
					$next_title = get_the_title( $next->ID );
					$next_post_title = 
                             		'<li class="post-nav-title">'
                                    	.$next_title.
                                    '</li>';
            	break;
		        default:
		        	$next_post_title = '';
		    } 

	    //are we showing the post category
	    switch ( $show_category ) {
				case 'yes':
					if ($next_categories = get_the_terms ($next->ID, 'product_cat')) {
            		$next_category 	 = $next_categories[0]->name;
            		}

            		else {
            			$next_category = '';
            		}
            		
					$next_post_category = 
                             		'<li class="post-nav-category">'.
	                                     __('Category: ', 'wp-post-nav')
	                                    .$next_category.
	                                    '</strong>'.
		                            '</li>';
            	break;
		        default:
		        	$next_post_category = '';
		       
		    }

	    //are we showing the post excerpt?
	    switch ( $show_excerpt ) {
				case 'yes':
					$post_excerpt = $this->wp_post_nav_excerpt( $next->ID );

					$next_post_excerpt = 
                             		'<li class="post-nav-excerpt">'
                                    .$post_excerpt.
		                            '</li>';
            	break;
		        default:
		        	$next_post_excerpt = '';
		       
		    }                   
    }    
  
    //lets build the nav links             
	echo '<nav class="wp-post-nav" role="navigation">'; 
	//use a different query if the same category checkbox is checked
    
	switch ( $same_category ) {
		case 'yes':
	    	if ($previous) {
	            
	            $prev_link = previous_post_link( 
                    '%link', 
                    '<ul id="post-nav-previous'.$switch_nav.'">'
                    . '<h4>' . __('Previous Product', 'wp-post-nav') . '</h4>'
                    .$previous_image
                    .$previous_post_title
                    .$previous_post_category
                    .$previous_post_excerpt. 
                    '<span id="post-nav-previous-button"></span></ul>'
                    ,true,'','product_cat' );
	            }

	        if ($next) {
	            
	            $next_link = next_post_link( 
	                '%link', 
                    '<ul id="post-nav-next'.$switch_nav.'">'.
                    '<span id="post-nav-next-button"></span>'
                    . '<h4>' . __('Next Product', 'wp-post-nav') . '</h4>'
                    .$next_image
                    .$next_post_title
                    .$next_post_category
                    .$next_post_excerpt. 
                    '</ul>'
                    ,true,'','product_cat' );
	            }
		break;
		default:
			if ($previous) {

	            $prev_link = previous_post_link( 
                    '%link', 
                    '<ul id="post-nav-previous'.$switch_nav.'">'
                    . '<h4>' . __('Previous Product', 'wp-post-nav') . '</h4>'
                    .$previous_image
                    .$previous_post_title
                    .$previous_post_category
                    .$previous_post_excerpt. 
                    '<span id="post-nav-previous-button"></span></ul>'
                    ,false,
                    '');
	            }
	        if ($next) {
	        
	        	$next_link = next_post_link( 
	                '%link', 
                    '<ul id="post-nav-next'.$switch_nav.'">'.
                    '<span id="post-nav-next-button"></span>'
                    . '<h4>' . __('Next Product', 'wp-post-nav') . '</h4>'
                    .$next_image
                    .$next_post_title
                    .$next_post_category
                    .$next_post_excerpt. 
                    '</ul>'
                    ,false,
                    ''
                    );
	        	}		
		}
        
	      
        if ($previous) {
            echo $prev_link;
        }
        if ($next) {
            echo $next_link;
        }
	echo '</nav>'; 
}
?>