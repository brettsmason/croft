jQuery(document).foundation();

( function( $ ) {

	// Add aria-label attributes to pagination.
	var pagination = $( '.pagination .page-numbers' );
	$.each( pagination, function() {
		$(this).attr( 'aria-label', this.text );
	});

} )( jQuery );
