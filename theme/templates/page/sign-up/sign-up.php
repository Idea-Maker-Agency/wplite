<?php
/**
 * The template for displaying sign-up page.
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
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-5">
        <h1 class="mb-4 fw-bold">
          <?= get_the_title() ?>
        </h1>

        <?php get_template_part('templates/page/sign-up/components/sign-up', 'form') ?>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
