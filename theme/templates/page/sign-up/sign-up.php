<?php
/**
 * The template for displaying sign-up page.
 *
 * @package    WPLite
 * @subpackage Templates
 * @author     Idea Maker
 * @since      1.0.0
 */

use WPLite\Core\Template;

$template = new Template();
$template->use_component('Auth/sign-up-form');

get_header();
?>

<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-5">
        <h1 class="mb-4 fw-bold">
          <?= get_the_title() ?>
        </h1>

        <?php $template->get_component('Auth/sign-up-form') ?>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
