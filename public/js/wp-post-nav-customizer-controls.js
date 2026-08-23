(function ( api, $ ) {
	'use strict';

	if ( ! api || ! $ ) {
		return;
	}

	function bindPostTypeControl() {
		$( '.wppn-post-type-checkboxes' ).each( function () {
			var container = $( this );
			var settingId = container.attr( 'data-wppn-setting' );
			var setting = api( settingId );

			if ( ! setting || typeof setting.set !== 'function' ) {
				return;
			}

			container.off( 'change.wppn' ).on( 'change.wppn', '.wppn-post-type-checkbox', function () {
				var values = {};
				container.find( '.wppn-post-type-checkbox:checked' ).each( function () {
					values[ this.value ] = this.value;
				} );
				setting.set( values );
			} );
		} );
	}

	$( bindPostTypeControl );
	api.bind( 'ready', bindPostTypeControl );
}( window.wp.customize, window.jQuery ));
