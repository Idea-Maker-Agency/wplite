<?php
/**
 * The template for displaying 404 page.
 *
 * @package    WPLite
 * @subpackage Templates
 * @author     Idea Maker
 * @since      1.0.0
 */

use IdeaMaker\WPLite\Component;

get_header();
?>

<section class="py-5">
  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-12 col-md-8 col-lg-6">
        <h1 class="fw-bold lh-1 display-1">
          <?php _e( '404', THEME_TEXT_DOMAIN ) ?>
        </h1>

        <p>
          <?php _e( 'Page not found', THEME_TEXT_DOMAIN ) ?>
        </p>

        <?php Component::render( 'link', 'Return Home', site_url(), [ 'is-button' => true ] ) ?>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
