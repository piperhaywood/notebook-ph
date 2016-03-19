(function( $ ) {
    "use strict";
    
    wp.customize( 'aught_header_color', function( value ) {
        
        value.bind( function( hex ) {
            var r = parseInt(hex.substring(1,3), 16),
            g = parseInt(hex.substring(3,5), 16),
            b = parseInt(hex.substring(5,7), 16),
            result = 'rgba('+r+','+g+','+b+','+0.8+')';
            
            $( '.drawer' ).css( 'background', result );
        } );
    });
    
    wp.customize( 'aught_display_authors', function( value ) {
        value.bind( function( to ) {
            false === to ? $( 'span.author' ).hide() : $( 'span.author' ).show();
        } );
    } );
    
    wp.customize( 'aught_display_categories', function( value ) {
        value.bind( function( to ) {
            false === to ? $( 'span.categories' ).hide() : $( 'span.categories' ).show();
        } );
    } );
    
    wp.customize( 'aught_display_credit', function( value ) {
        value.bind( function( to ) {
            console.log(to);
            false === to ? $( 'p.credit' ).hide() : $( 'p.credit' ).show();
        } );
    } );
    
})( jQuery );