<?php

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

  add_image_size( 'thumbnail', get_option( 'thumbnail_size_w', 320 ), get_option( 'thumbnail_size_h', 240 ), true );
  add_image_size( 'medium', get_option( 'medium_size_w', 640 ), get_option( 'medium_size_h', 480 ), true );
  add_image_size( 'large', get_option( 'large_size_w', 1024 ), get_option( 'large_size_h', 768 ), true );

  add_image_size( 'card-image', 420, 320, [ 'center', 'center' ] );
  add_image_size( 'featured-image', 640, 320, [ 'center', 'center' ] );
}
