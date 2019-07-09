(function( $ ) {
	'use strict';

	$( document ).ready( function($) {
		// Allow minimizing of a file.
		$( '.bgthgr-heading .dashicons-arrow-down-alt2' ).on( 'click', function(){
			var $arrow = $( this ),
				$code = $arrow.closest( '.bgthgr-file-container' ).find( '.bgthgr-code' );

			if ( $arrow.hasClass( 'dashicons-arrow-down-alt2' ) ) {
				$arrow
					.removeClass( 'dashicons-arrow-down-alt2' )
					.addClass( 'dashicons-arrow-up-alt2' );

				$code.hide();
			} else {
				$arrow
					.addClass( 'dashicons-arrow-down-alt2' )
					.removeClass( 'dashicons-arrow-up-alt2' );

				$code.show();
			}
		});

		bgthgrBindNotices();
	});

	/**
	 * Bind Notices.
	 *
	 * Make notices sticky.
	 *
	 * @since 1.0.0
	 */
	function bgthgrBindNotices() {
		// Remove all notices that are not bgthgr notices. Otherwise, they will mess up the js.
		$( '.notice:not([id^="bgthgr-notice-"])' ).remove();

		$( '.notice' ).each( function(){
			var $notice = $( this ),
				count = parseInt( $notice.attr('id').replace( 'bgthgr-notice-', '' ) ),
				prevId = 'bgthgr-notice-' + ( count - 1 );

			$notice.sticky({
				topSpacing: 27,
				zIndex: 3,
				className: 'bgthgr-sticky-notice'
			});

			// Hook into the start and end events and make sure the sticky notices don't stack.
			$notice.on( 'sticky-start', function() {
				$( '.notice' ).show();
				$( '.bgthgr-sticky-notice .notice').not( this ).hide();
			});
			$notice.on( 'sticky-end', function() {
				$( '#' + prevId ).show();
			});
		});
	}
})( jQuery );
