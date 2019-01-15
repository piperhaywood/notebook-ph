(function( $ ) {
  "use strict";

  wp.customize( 'nph_rainbow', function( setting ) {
    setting.bind( function( to ) {
      false === to ? $('body').removeClass('rainbow') : $('body').addClass('rainbow');
    } );
  } );

  wp.customize( 'nph_display_authors', function( setting ) {
    setting.bind( function( to ) {
      false === to ? $( '.post__author' ).hide() : $( '.post__author' ).show();
    } );
  } );

  wp.customize( 'nph_display_credit', function( setting ) {
    setting.bind( function( to ) {
      console.log(to);
      false === to ? $( '.credit' ).hide() : $( 'p.credit' ).show();
    } );
  } );
})( jQuery );