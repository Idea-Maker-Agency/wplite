<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
		    <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
          <?php wp_title( ' | ', true, 'right' ); ?> <?php echo bloginfo( 'name' ); ?>
        </title>

        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

        <?php if ( is_singular() && get_option( 'thread_comments' ) ) : ?>
            <?php wp_enqueue_script( 'comment-reply' ); ?>
        <?php endif; ?>

        <link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>">

        <?php wp_head(); ?>
    </head>

    <body>
        <?php if ( function_exists( 'wp_body_open' ) ) : ?>
            <?php wp_body_open(); ?>
        <?php endif; ?>

        <?php get_template_part( 'lib/structure/header' ); ?>
