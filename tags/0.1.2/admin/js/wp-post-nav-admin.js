/*
 * The Admin JS file of WP Post Nav
 *
 * @link:      https://wppostnav.com
 * @since      0.0.1
 * @package    wp_post_nav
 */

(function( $ ) {
	'use strict';

	 $(function() {
	 		//set a default color for the colorpickers
				var myOptions = {
				    defaultColor: '#8358b0',
				    clear: function() {
				    	defaultColor: '#8358b0'
				    }
				   
				   
				};
				$('.color-field').wpColorPicker(myOptions);	
		});
})( jQuery );
