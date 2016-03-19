<?php

function search_posts( $query ) {
  if( is_admin() )
  return;

  if( $query->is_search ) {
    $query->set( 'post_type', 'post' );
  }
  return $query;
}

add_filter( 'pre_get_posts', 'search_posts' );
