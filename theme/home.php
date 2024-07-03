<?php
/**
 * Template: Blog
 *
 * @since 1.0.0
 */
?>

<?php get_header(); ?>

<main>
  <section class="py-5">
    <div class="container">
      <h1 class="mb-5 fw-bold text-center">
        <?php echo get_the_title( get_option( 'page_for_posts', true ) ); ?>
      </h1>

      <?php if ( have_posts() ) : ?>
        <div class="row mb-4">
          <?php while ( have_posts() ) : the_post(); ?>
            <div class="col-12 col-sm-6 col-lg-4">
              <?php wplite_article_card( $post ); ?>
            </div>
          <?php endwhile; ?>
        </div>

        <?php
        the_posts_pagination([
          'mid_size'  => 2,
          'type' => 'list',
          'class' => '',
        ]);
        ?>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>
