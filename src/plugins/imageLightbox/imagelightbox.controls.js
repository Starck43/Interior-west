// ImageLightbox controls

$( function()
{
	var
		// ACTIVITY INDICATOR

		activityIndicatorOn = function()
		{
			$( '<div id="imagelightbox-loading"><div></div></div>' ).appendTo( 'body' );
		},
		activityIndicatorOff = function()
		{
			$( '#imagelightbox-loading' ).remove();
		},


		// OVERLAY

		overlayOn = function()
		{
			$( '<div id="imagelightbox-overlay"></div>' ).appendTo( 'body' );
		},
		overlayOff = function()
		{
			$( '#imagelightbox-overlay' ).remove();
		},


		// CLOSE BUTTON

		closeButtonOn = function( instance )
		{
			$( '<div class="close-button" id="imagelightbox-close" title="Закрыть"></div>' )
			.appendTo( 'body' )
			.on( 'click touchend', function() {
				$( this ).remove(); 
				instance.quitImageLightbox(); 
				return false;
			});
		},

		closeButtonOff = function() {
			$( '#imagelightbox-close' ).remove();
		},


		// NAVIGATION

		navigationOn = function( instance, selector )
		{
			var images = $( selector );
			if( images.length )
			{
				var nav = $( '<div id="imagelightbox-nav"></div>' )
					.appendTo( '#imagelightbox-container' )
					.on( 'click touchend', function() { return false; });

				for( var i = 0; i < images.length; i++ )
					nav.append( '<div class="nav-dot"></div>' );

				var navItems = nav.find( 'div' )
					.on( 'click touchend', function()
					{
						var $this = $( this );
						if( images.eq( $this.index() ).attr( 'href' ) != $( '#imagelightbox' ).attr( 'src' ) )
							instance.switchImageLightbox( $this.index() );

						navItems.removeClass( 'active' );
						navItems.eq( $this.index() ).addClass( 'active' );

						return false;
					})
					.on( 'touchend', function() { return false; });
			}
		},
		navigationUpdate = function( selector )
		{
			var items = $( '#imagelightbox-nav .nav-dot' );
			items.removeClass( 'active' );
			items.eq( $( selector ).filter( '[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"]' ).index( selector ) ).addClass( 'active' );
		},
		navigationOff = function()
		{
			$( '#imagelightbox-nav' ).remove();
		},


		// ARROWS

		arrowsOn = function( instance, selector )
		{
			var $arrows = $('<a href="#" class="imagelightbox-arrow prev"><i class="fa icon arrow-left"></i></a>'+
							'<a href="#" class="imagelightbox-arrow next"><i class="fa icon arrow-right"></i></a>' );

			$arrows.appendTo( 'body' );

			$arrows.on( 'click touchend', function( e )
			{
				e.preventDefault();

				var $this	= $( this ),
					$target	= $( selector + '[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"]' ),
					index	= $target.index( selector );

				if( $this.hasClass( 'prev' ) )
				{
					index = index - 1;
					if( !$( selector ).eq( index ).length )
						index = $( selector ).length;
				}
				else
				if( $this.hasClass( 'next' ) )
				{
					index = index + 1;
					if( !$( selector ).eq( index ).length )
						index = 0;
				}

				instance.switchImageLightbox( index );
				return false;
			});
		},
		arrowsOff = function()
		{
			$( '.imagelightbox-arrow' ).remove();
		},


		// CAPTION

		captionOn = function()
		{
			var description = $( 'a[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"] img' ).attr( 'alt' );
			if( description.length > 0 )
				$( '<div id="imagelightbox-caption">' + description + '</div>' ).appendTo( '#imagelightbox-container' );
		},
		captionOff = function()
		{
			$( '#imagelightbox-caption' ).remove();
		};


	var el = '#gallery a';
	var lightbox = $( el ).imageLightbox({	
		animationSpeed: 200,   // integer;
		quitOnEnd:      true,  // bool; quit after viewing the last image
		quitOnImgClick: false, // bool; quit when the viewed image is clicked
		quitOnDocClick: true,  // bool; quit when anything but the viewed image is clicked
		onStart:		function() { 
							overlayOn(); 
							closeButtonOn( lightbox );
							arrowsOn( lightbox, el ); 
							navigationOn( lightbox, el );
						},
		onEnd:			function() { 
							overlayOff(); 
							captionOff(); closeButtonOff(); 
							arrowsOff(); 
							activityIndicatorOff(); navigationOff(); 
						},
		onLoadStart: 	function() { 
							captionOff(); 
							activityIndicatorOn();
						},
		onLoadEnd:	 	function() {
							captionOn(); 
							activityIndicatorOff(); 
							navigationUpdate( el );
						}
	});


});