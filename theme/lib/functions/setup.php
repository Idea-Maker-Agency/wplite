<?php

use IdeaMaker\WPLite\Component;

Component::register( 'button' );
Component::register( 'link' );

/**
 * Fires after the theme is loaded.
 *
 * @since 1.0.0
 *
 * @return void
 */
add_action( 'after_setup_theme', 'wp_after_setup_theme' );
function wp_after_setup_theme(): void {
	add_theme_support( 'post-thumbnails' );
  add_theme_support( 'widgets' );

  add_image_size( 'card-image', 420, 320, [ 'center', 'center' ] );
  add_image_size( 'featured-image', 640, 320, [ 'center', 'center' ] );
}
