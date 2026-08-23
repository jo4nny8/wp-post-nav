(function ( api ) {
	'use strict';

	var variables = {
		'background_color': '--wppn-background-color',
		'open_background_color': '--wppn-open-background-color',
		'heading_color': '--wppn-heading-color',
		'title_color': '--wppn-title-color',
		'category_color': '--wppn-category-color',
		'excerpt_color': '--wppn-excerpt-color',
		'heading_size': '--wppn-heading-size',
		'title_size': '--wppn-title-size',
		'category_size': '--wppn-category-size',
		'excerpt_size': '--wppn-excerpt-size',
	};

	Object.keys( variables ).forEach( function ( key ) {
		api( 'wppn_settings[wp_post_nav_' + key + ']' ).bind( function ( value ) {
			document.documentElement.style.setProperty( variables[ key ], value + ( key.indexOf( '_size' ) !== -1 ? 'px' : '' ) );
		} );
	} );
}( window.wp.customize ));
