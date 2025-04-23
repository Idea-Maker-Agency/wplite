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

<?php get_template_part('templates/front-page/components/hero', 'banner') ?>
<?php get_template_part('templates/front-page/components/intro') ?>
<?php get_template_part('templates/front-page/components/features') ?>
<?php get_template_part('templates/front-page/components/faqs') ?>
<?php get_template_part('templates/front-page/components/testimonials') ?>

<?php
get_footer();
