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

get_template_part('templates/page/home/sections/hero', 'banner');
get_template_part('templates/page/home/sections/intro');
get_template_part('templates/page/home/sections/features');
get_template_part('templates/page/home/sections/faqs');
get_template_part('templates/page/home/sections/testimonials');

get_footer();
