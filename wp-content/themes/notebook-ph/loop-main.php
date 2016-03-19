<?php if( have_posts() ) : ?>
  <?php while( have_posts() ) : the_post(); ?>
    <article <?php post_class( 'post' ); ?>>
      <?php get_template_part( 'content', get_post_format() ); ?>

      <footer>
        <div class="meta">
          <?php $meta = nph_postmeta( false ); ?>
          <p class="thepermalink"><?php echo $meta; ?></p>
          <?php $tags = get_the_tags(); ?>
          <?php if( !empty( $tags ) ) : ?>
            <ul class="post-tags">
              <?php foreach( $tags as $tag ) : ?>
                <li class="tag_<?php echo $tag->slug; ?>">
                  <a href="<?php echo get_tag_link( $tag->term_id ); ?>"><?php echo $tag->name; ?></a>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>

        <?php wp_link_pages(); ?>
      </footer>
    </article>
  <?php endwhile; ?>

    <nav class="pagination">
      <p>
        <?php if( is_home() || is_archive() ) : ?>
          <?php previous_posts_link( __( 'Newer posts', 'notebook-ph' ) ); ?>
        <?php elseif( is_singular( 'post' ) ) : ?>
          <?php previous_post_link( '%link', __( 'Previous post', 'notebook-ph' ) ); ?>
        <?php endif; ?>
      </p>
      <p>
        <?php if( is_home() || is_archive() ) : ?>
          <?php next_posts_link( __( 'Older posts', 'notebook-ph' ) ); ?>
        <?php elseif( is_singular( 'post' ) ) : ?>
          <?php next_post_link( '%link', __( 'Next post', 'notebook-ph' ) ); ?>
        <?php endif; ?>
      </p>
    </nav>
<?php else : ?>

  <article class="post type-<?php echo get_post_type(); ?>">
    <div class="content">
      <p>No content has been found for this query. </p>
      <?php get_search_form(); ?>
    </div>
  </article>

<?php endif; ?>