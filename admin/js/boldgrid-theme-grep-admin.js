(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).ready(function($) {
//		$('.bgthgr-code').each( function() {
//			var $textarea = $( this );
//
//			wp.codeEditor.initialize( $textarea, cm_settings);
//		});

		$( '.bgthgr-heading .dashicons-arrow-down-alt2' ).on( 'click', function(){
			var $arrow = $( this ),
				$code = $arrow.closest( '.bgthgr-file-container' ).find( '.bgthgr-code' );

			// bgthgrBindNotices();

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

//		$( '.notice' ).sticky({
//			topSpacing: 33,
//			zIndex: 3,
//			// stopper: '.bgthgr-item-container'
//		});

		bgthgrBindNotices();



		//echo '<div class="bgthgr-heading">' .
		//'<span class="dashicons dashicons-arrow-down-alt2"></span> ' .
	  //wp.codeEditor.initialize($('.bgthgr-code'), cm_settings);
	} )

	/**
	 *
	 */
	function bgthgrBindNotices() {





		$( '.notice' ).each( function(){
			var $notice = jQuery( this ),
				id = $notice.attr('id'),
				count = parseInt( id.replace( 'bgthgr-notice-', '' ) ),
				stopId = 'bgthgr-notice-' + ( count + 1 ),
				prevId = 'bgthgr-notice-' + ( count - 1 ),
				$grepContainer = $notice.closest( '.bgthgr-item-container' ).find( '.bgthgr-grep-container' );

			$notice.sticky({
				topSpacing: 27,
				zIndex: 3,
				stopper: '#' + stopId,
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
