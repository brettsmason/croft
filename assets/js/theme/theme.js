jQuery(document).foundation();

( function( $ ) {

	// Add aria-label attributes to pagination.
	var pagination = $( '.pagination .page-numbers' );
	$.each( pagination, function() {
		$(this).attr( 'aria-label', this.text );
	});

	// Wrap each video iframe in a flex-video div
	var allVideos = $( 'iframe[src*="youtube.com"], iframe[src*="vimeo.com"]' );
	$.each(allVideos, function() {

		var aspectRatio = ( this.width / this.height );
		var containerClass = "flex-video";

		// Add .vimeo to Vimeo videos
		if(this.src.indexOf( 'vimeo' ) != -1 )
			containerClass += ' vimeo';

		// Add .widescreen to widescreen ratio videos
		if( aspectRatio >= 1.7 )
			containerClass += ' widescreen';

		// Wrap iframe with div container
		$(this).wrap( '<div class="' + containerClass + '" />' );

	});

} )( jQuery );
