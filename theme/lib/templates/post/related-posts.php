<?php
$args = wp_parse_args( $args, [
  'posts_per_page' => 6,
  'post__not_in' => [ $post->ID ],
  'category__in' => wp_get_post_categories( $post->ID ),
  'orderby' => 'date',
] );

$query = new WP_Query( $args );
?>

<?php if ( $query->have_posts() ) : ?>
  <div class="row">
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
      <div class="col-12 col-sm-6 col-lg-4">
        <?php wplite_article_card( $post ); ?>
      </div>
    <?php endwhile; ?>
  </div>
<?php else : ?>
  <p class="mb-0"><?php _e( 'No related posts found.', THEME_TEXT_DOMAIN ); ?></p>
<?php endif; ?>
