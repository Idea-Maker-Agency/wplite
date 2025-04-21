<?php
/**
 * The template for displaying category pages.
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
      <?php the_archive_title() ?>
    </h1>

    <?php if (have_posts()) { ?>
      <div class="row mb-4">
        <?php while (have_posts()) { ?>
          <?php the_post() ?>

          <div class="col-12 col-sm-6 col-lg-4">
            <?php wplite_article_card($post) ?>
          </div>
        <?php } ?>

        <?php wp_reset_postdata() ?>
      </div>

      <?php the_posts_pagination([
        'mid_size' => 2,
        'type' => 'list',
        'class' => '',
      ]) ?>
    <?php } else { ?>
      <p class="mb-0">
        <?php _e('No posts found.', THEME_TEXT_DOMAIN) ?>
      </p>
    <?php } ?>
  </div>
</section>

<?php
get_footer();
