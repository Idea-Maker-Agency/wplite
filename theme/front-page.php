<?php
/**
 * The template for displaying front-page.
 *
 * @package    WPLite
 * @subpackage Templates
 * @author     Idea Maker
 * @since      1.0.0
 */

use IdeaMaker\WPLite\Component;

get_header();
?>

<?php Component::render( 'button', 'test', [ 'class' => [ 'test' ] ] ) ?>
<?php Component::render( 'link', 'test', 'https://google.com' ) ?>

<?php
get_footer();
