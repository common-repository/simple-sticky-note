jQuery( document ).ready(function( $ ) {

    // add and view
    $( '.st-sticky-note-wrapper div.overlay' ).on( 'click', function(e) {
        e.preventDefault();
        tinymce.triggerSave();
        var title = $( '#st-title' ).val();
        var content = $( '#st-content' ).val();
        var nonce = $( '#st_sticky_note_create_nonce_field' ).val();

        if ( title.length !== 0 ) {
            $.ajax({
                type: "POST",
                dataType:"json",
                url: st_sticky_note.ajaxurl,
                data: {
                    action: 'st_sticky_note_insert',
                    title: title,
                    content: content,
                    nonce: nonce,
                },
                error: function(jqXHR, textStatus, errorThrown){                                        
                    console.log("The following error occured: " + textStatus, errorThrown);                                                       
                },
                success: function(response) { 
                    if ( response == 'success' ) {
                        $('form#st-sticky-note-form').trigger('reset');
                        $.post({
                            dataType: "html",
                            url: st_sticky_note.ajaxurl,
                            data: {
                                action: 'st_sticky_note_new_added',
                            },
                            error: function(jqXHR, textStatus, errorThrown){                                        
                                console.log("The following error occured: " + textStatus, errorThrown);                                                       
                            },
                            success: function(data) { 
                                $( '.st-sticky-note' ).prepend( data);
                                $('.st-sticky-note-wrapper').removeClass( 'open' ).addClass( 'close' );
                                $( '.st-sticky-note' ).imagesLoaded( function() {
                                    $( '.st-sticky-note' ).packery( 'appended', '.grid-item' ).packery('reloadItems').packery( 'layout' );
                                } );
                                
                            } 
                        });                          
                    }
                } 

            } );
        }
    });

    // update form
    $( document ).on( 'dblclick', '.st-sticky-note article.grid-item', function() {
        var id = $(this).data('id');
        var title = $(this).find('h4.entry-title').html();
        var content = $(this).find('div.entry-content').html();
        $.post({
            dataType: "html",
            url: st_sticky_note.ajaxurl,
            data: {
                action: 'st_sticky_note_update_form',
                id: id,
                title: title,
                content: content,
            },
            error: function(jqXHR, textStatus, errorThrown){                                        
                console.log("The following error occured: " + textStatus, errorThrown);                                                       
            },
            success: function(data) {
                if ( data != 0 ) {
                    $( '.st-sticky-note-wrapper' ).prepend( data);
                    tinymce.execCommand( 'mceRemoveEditor', false, 'st-update-content' );
                    tinymce.execCommand( 'mceAddEditor', false, 'st-update-content' );
                    $('.st-sticky-note-wrapper').removeClass( 'close' ).addClass( 'update-open' );
                }
            } 
        });    
    });

    // update and view
    $( '.st-sticky-note-wrapper div.update-overlay' ).on( 'click', function(e) {
        e.preventDefault();
        tinymce.triggerSave();
        var id = $( '#st-update-id' ).val();
        var title = $( '#st-update-title' ).val();
        var content = $( '#st-update-content' ).val();
        var nonce = $( '#st_sticky_note_create_nonce_field' ).val();

        if ( typeof id !== 'undefined' && id.length !== 0 ) {
            $.ajax({
                type: "POST",
                dataType:"json",
                url: st_sticky_note.ajaxurl,
                data: {
                    action: 'st_sticky_note_update',
                    id: id,
                    title: title,
                    content: content,
                    nonce: nonce,
                },
                error: function(jqXHR, textStatus, errorThrown){                                        
                    console.log("The following error occured: " + textStatus, errorThrown);                                                       
                },
                success: function(response) { 
                    if ( response == 'success' ) {
                        $.post({
                            dataType: "html",
                            url: st_sticky_note.ajaxurl,
                            data: {
                                action: 'st_sticky_note_updated_post',
                                id: id,
                            },
                            error: function(jqXHR, textStatus, errorThrown){                                        
                                console.log("The following error occured: " + textStatus, errorThrown);                                                       
                            },
                            success: function(data) { 
                                var beforeItem = $('.st-sticky-note-item[data-id="'+ id +'"]').prev('article');
                                $('.st-sticky-note-item[data-id="'+ id +'"]').remove();

                                if( ! beforeItem.length ) {
                                    $( '.st-sticky-note' ).prepend( data);
                                } else {
                                    beforeItem.after( data);
                                }

                                $('.st-sticky-note-wrapper').removeClass( 'update-open' ).addClass( 'close' );
                                $('#st-sticky-note-update-form').remove();
                                $( '.st-sticky-note' ).imagesLoaded( function() {
                                    $( '.st-sticky-note' ).packery( 'appended', '.grid-item' ).packery('reloadItems').packery( 'layout' );
                                } );
                            } 
                        });    

                    }
                } 

            } );
        }
    });

    // delete
    $( document ).on( 'click', '#st-sticky-note-delete', function(e) {
        e.preventDefault();
        var check = confirm( st_sticky_note.delete_confirm );

        if ( check !== true ) {
            return;
        }

        var id = $(this).data('id');
        var nonce = $( '#st_sticky_note_create_nonce_field' ).val();

        $.ajax({
            type: 'POST',
            dataType: "json",
            url: st_sticky_note.ajaxurl,
            data: {
                action: 'st_sticky_note_delete',
                id: id,
                nonce: nonce,
            },
            error: function(jqXHR, textStatus, errorThrown){                                        
                console.log("The following error occured: " + textStatus, errorThrown);                                                       
            },
            success: function(response) { 
                if ( response == 'success' ) {
                    $('.st-sticky-note-item[data-id="'+ id +'"]').remove();
                    $('.st-sticky-note-wrapper').removeClass( 'update-open' ).addClass( 'close' );
                    $('#st-sticky-note-update-form').remove();
                    $( '.st-sticky-note' ).imagesLoaded( function() {
                        $( '.st-sticky-note' ).packery('reloadItems').packery( 'layout' );
                    } );
                }
            } 
        });    
    });

});