<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
  return;
}
?>

<div id="comments" class="comments">

  <?php if ( have_comments() ) : ?>
    <h2 class="comments__comments-heading comments-heading">
      <?php
      printf( _x( 'Discussion [%s]', 'comments title', 'notebook-ph' ), get_comments_number() );
      ?> (<a class="js-show-discussion" href="#">show</a>)
    </h2>

    <ol class="comments__comment-list comment-list">
      <?php
        wp_list_comments( array(
          'avatar_size' => 100,
          'style'       => 'ol',
          'short_ping'  => true,
          'reply_text'  => __( 'Reply', 'twentyseventeen' ),
        ) );
      ?>
    </ol>

    <?php the_comments_pagination( array(
      'prev_text' => '<span class="screen-reader-text">' . __( 'Previous', 'twentyseventeen' ) . '</span>',
      'next_text' => '<span class="screen-reader-text">' . __( 'Next', 'twentyseventeen' ) . '</span>',
    ) );

  endif; // Check for have_comments().

  // If comments are closed and there are comments, let's leave a little note, shall we?
  if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

    <p class="no-comments"><?php _e( 'Discussion is closed.', 'notebook-ph' ); ?></p>
  <?php
  endif;

  comment_form();
  ?>

</div>
