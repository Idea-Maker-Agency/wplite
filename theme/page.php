<?php
/**
 * The template for displaying all pages.
 *
 * @package    WPLite
 * @subpackage Templates
 * @author     Idea Maker
 * @since      1.0.0
 */

get_header();
?>

<section
  id=""
  class="py-5 position-relative">
  <div class="container position-relative z-1">
    <?php the_content() ?>
  </div>
</section>

<?php
get_footer();
