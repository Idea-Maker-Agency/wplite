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
    'bootstrap' => [
      'version' => '5.3.3',
      'minified' => true,
      'enqueue' => true,
    ],
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
  $styles = [
    'typography' => [
      'version' => '1.0.0',
      'category' => 'utils',
      'enqueue' => true,
    ],
    'variables' => [
      'version' => '1.0.0',
      'category' => 'utils',
      'enqueue' => true,
    ],
    'pagination' => [
      'version' => '1.0.0',
      'category' => 'components',
      'enqueue' => true,
    ],
    'post-navigation' => [
      'version' => '1.0.0',
      'category' => 'components',
      'enqueue' => true,
    ],
    'buttons' => [
      'version' => '1.0.0',
      'category' => 'components',
      'enqueue' => true,
    ],
    'card' => [
      'version' => '1.0.0',
      'category' => 'components',
      'enqueue' => true,
    ],
    'contact-form-7' => [
      'version' => '1.0.0',
      'category' => 'widgets',
      'enqueue' => true,
    ],
    'comments' => [
      'version' => '1.0.0',
      'category' => 'widgets',
      'enqueue' => true,
    ],
    'social-links' => [
      'version' => '1.0.0',
      'category' => 'widgets',
      'enqueue' => true,
    ],
  ];

  foreach ( $styles as $name => $args ) :
    $handle = 'wplite-'. $name;
    $version = isset( $args['version'] ) && $args['version'] ? $args['version'] : '1.0.0';
    $dependencies = isset( $args['dependencies'] ) && $args['dependencies'] ? $args['dependencies'] : [];
    $media = isset( $args['media'] ) && $args['media'] ? $args['media'] : 'all';
    $enqueue = isset( $args['enqueue'] ) && $args['enqueue'] ? $args['enqueue'] : false;

    $category = isset( $args['category'] ) && $args['category'] ? $args['category'] : '';

    $src = THEME_DIR_URI . "/assets/lib/css/{$category}/{$name}.css";

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
