<?php
/**
 * The template for display blog posts page.
 *
 * @package    WPLite
 * @subpackage Templates
 * @author     Idea Maker
 * @since      1.0.0
 */

get_header();
?>

<section class="py-5">
  <div class="container">
    <h1 class="mb-5 fw-bold text-center">
      <?php echo get_the_title( get_option( 'page_for_posts', true ) ) ?>
    </h1>

    <?php if ( have_posts() ) : ?>
      <div class="row mb-4 justify-content-center justify-content-sm-start">
        <?php while ( have_posts() ) : the_post(); ?>
          <div class="col-12 col-sm-6 col-lg-4">
            <?php wplite_article_card( $post ) ?>
          </div>
        <?php endwhile; ?>
      </div>

      <?php
      the_posts_pagination( [
        'mid_size'  => 2,
        'type' => 'list',
        'class' => '',
      ] )
      ?>
    <?php else : ?>
      <p class="mb-0">
        <?php _e( 'No posts found.', THEME_TEXT_DOMAIN ) ?>
      </p>
    <?php endif; ?>
  </div>
</section>

<?php
get_footer();
