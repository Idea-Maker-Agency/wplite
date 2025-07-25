<?php
/**
 * The template for displaying front-page.
 *
 * @package    WPLite
 * @subpackage Templates
 * @author     Idea Maker
 * @since      1.0.0
 */

use WPLite\Utils\Helpers;

get_header();

Helpers::get_template_part('hero-banner');
Helpers::get_template_part('intro');
Helpers::get_template_part('features');
Helpers::get_template_part('faqs');
Helpers::get_template_part('testimonials');

get_footer();
