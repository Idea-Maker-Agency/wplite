<?php

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
    ]
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
