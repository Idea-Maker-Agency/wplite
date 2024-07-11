<?php

/**
 * Disable Gutenberg on the back end.
 *
 * @since 1.0.0
 */
add_filter( 'use_block_editor_for_post', '__return_false' );

/**
 * Disable Gutenberg for widgets.
 *
 * @since 1.0.0
 */
add_filter( 'use_widgets_block_editor', '__return_false' );

/**
 * Dequeue WP blocks styles.
 *
 * @since 1.0.0
 *
 * @return void
 */
add_action( 'wp_print_styles', 'wplite_print_styles', 100 );
function wplite_print_styles(): void {
  wp_dequeue_style( 'global-styles' );

  wp_dequeue_style( 'wp-block-library' );
  wp_dequeue_style( 'wp-block-library-theme' );
  wp_dequeue_style( 'wc-block-style' );

  wp_dequeue_style( 'storefront-gutenberg-blocks' );
}

/**
 * Register vendor stylesheets.
 *
 * @since 1.0.0
 *
 * @return void
 */
add_action( 'wp_enqueue_scripts', 'wplite_vendor_styles', 10 );
function wplite_vendor_styles(): void {
  $styles = [
    // '{{vendor-name}}' => [
    //   'version' => '{{vendor-version}}',
    //   'minified' => true,
    //   'enqueue' => true,
    // ],
  ];

  foreach ( $styles as $handle => $args ) :
    $version = isset( $args['version'] ) && $args['version'] ? $args['version'] : '1.0.0';
    $dependencies = isset( $args['dependencies'] ) && $args['dependencies'] ? $args['dependencies'] : [];
    $media = isset( $args['media'] ) && $args['media'] ? $args['media'] : 'all';
    $minified = isset( $args['minified'] ) && $args['minified'] ? $args['minified'] : false;
    $enqueue = isset( $args['enqueue'] ) && $args['enqueue'] ? $args['enqueue'] : false;

    $suffix = $minified ? '.min' : '';
    $src = THEME_DIR_URI . "/assets/vendor/{$handle}/css/{$handle}{$suffix}.css";

    wp_register_style(
      $handle,
      $src,
      $dependencies,
      $version,
      $media
    );

    if ( $enqueue ) :
      wp_enqueue_style( $handle );
    endif;
  endforeach;
}

/**
 * Register stylesheets.
 *
 * @since 1.0.0
 *
 * @return void
 */
add_action( 'wp_enqueue_scripts', 'wplite_styles', 10 );
function wplite_styles(): void {
  wp_enqueue_style(
    'wplite-main',
    THEME_DIR_URI . "/assets/lib/css/main.css",
    [],
    THEME_VERSION,
    'all'
  );
}
