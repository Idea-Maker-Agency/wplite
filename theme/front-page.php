<?php
/**
 * Template: Front-page
 *
 * @since 1.0.0
 */

use IdeaMaker\WPLite\Component;
?>

<?php get_header(); ?>

<?php Component::render( 'button', 'test', [ 'class' => [ 'test' ] ] ); ?>
<?php Component::render( 'link', 'test', 'https://google.com' ); ?>

<?php get_footer(); ?>
