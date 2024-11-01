jQuery( document ).ready(function( $ ) {

    $( '.st-sticky-note-wrapper.close #st-title' ).on( 'click', function() {
        $('.st-sticky-note-wrapper').removeClass( 'close' ).addClass( 'open' );
    } );

    $( '.st-sticky-note-wrapper div.overlay' ).on( 'click', function(e) {
        event.preventDefault();
        $('.st-sticky-note-wrapper').removeClass( 'open' ).addClass( 'close' );
    } );

    $( '.st-sticky-note' ).imagesLoaded( function() {
        $( '.st-sticky-note' ).packery({
            itemSelector: '.grid-item'
        });
    });  

});