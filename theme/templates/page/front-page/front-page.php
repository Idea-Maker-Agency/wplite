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

get_template_part('templates/page/front-page/sections/hero', 'banner');
get_template_part('templates/page/front-page/sections/intro');
get_template_part('templates/page/front-page/sections/features');
get_template_part('templates/page/front-page/sections/faqs');
get_template_part('templates/page/front-page/sections/testimonials');

get_footer();
