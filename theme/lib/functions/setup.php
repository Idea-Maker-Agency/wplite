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

  add_image_size( 'card-image', 420, 320, [ 'center', 'center' ] );
}
