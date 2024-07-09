<?php
/**
 * The template for displaying the header.
 *
 * @package    WPLite
 * @subpackage Templates
 * @author     Idea Maker
 * @since      1.0.0
 */
?>

<!DOCTYPE html>
<html <?php language_attributes() ?>>
    <head>
        <meta
          charset="<?php bloginfo( 'charset' ) ?>" />
		    <meta
          name="viewport"
          content="width=device-width, initial-scale=1">

        <?php if ( is_single() ) : ?>
          <meta
            name="description"
            content="<?php echo wp_strip_all_tags( get_the_excerpt() , true ) ?>" />
        <?php endif; ?>

        <title>
          <?php wp_title( ' | ', true, 'right' ) ?> <?php echo bloginfo( 'name' ) ?>
        </title>

        <link
          rel="profile"
          href="http://gmpg.org/xfn/11" />
        <link
          rel="pingback"
          href="<?php bloginfo( 'pingback_url' ) ?>" />

        <?php if ( is_singular() && get_option( 'thread_comments' ) ) : ?>
            <?php wp_enqueue_script( 'comment-reply' ) ?>
        <?php endif; ?>

        <link
          rel="preconnect"
          href="https://fonts.googleapis.com">
        <link
          rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>
        <link
          href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap"
          rel="stylesheet">

        <link
          rel="stylesheet"
          href="<?php bloginfo( 'stylesheet_url' ) ?>">

        <?php wp_head() ?>
    </head>

    <body <?php body_class() ?>>
        <?php if ( function_exists( 'wp_body_open' ) ) : ?>
            <?php wp_body_open() ?>
        <?php endif; ?>

        <?php get_template_part( 'lib/templates/structure/header' ) ?>

        <main>
