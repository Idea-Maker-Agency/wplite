<?php
/**
 * The template for displaying front-page.
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
    <?php wplite_button( 'Test Button', 'success', 'sm', false, false, [ 'id' => 'test' ] ) ?>
    <?php wplite_link( 'test link', 'https://google.com', 'success', 'sm', true, false, false, [ 'id' => 'test' ] ) ?>
  </div>
</section>

<?php
get_footer();
