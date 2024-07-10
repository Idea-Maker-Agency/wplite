<?php

/**
 * Register vendor scripts.
 *
 * @since 1.0.0
 *
 * @return void
 */
add_action( 'wp_enqueue_scripts', 'wplite_vendor_scripts', 10 );
function wplite_vendor_scripts(): void {
  $scripts = [
    'alpine' => [
      'version' => '3.14.1',
      'minified' => true,
      'enqueue' => false,
      'strategy' => 'defer',
    ],
    'bootstrap' => [
      'version' => '5.3.3',
      'minified' => true,
      'enqueue' => true,
      'strategy' => 'defer',
    ],
  ];

  foreach ( $scripts as $name => $args ) :
    $handle = 'wplite-'. $name;
    $version = isset( $args['version'] ) && $args['version'] ? $args['version'] : '1.0.0';
    $dependencies = isset( $args['dependencies'] ) && $args['dependencies'] ? $args['dependencies'] : [];
    $media = isset( $args['media'] ) && $args['media'] ? $args['media'] : 'all';
    $minified = isset( $args['minified'] ) && $args['minified'] ? $args['minified'] : false;
    $strategy = isset( $args['strategy'] ) && $args['strategy'] ? $args['strategy'] : '';
    $in_footer = isset( $args['in_footer'] ) && $args['in_footer'] ? $args['in_footer'] : true;
    $enqueue = isset( $args['enqueue'] ) && $args['enqueue'] ? $args['enqueue'] : false;

    $suffix = $minified ? '.min' : '';
    $src = THEME_DIR_URI . "/assets/vendor/{$name}/js/{$name}{$suffix}.js";

    wp_register_script(
      $handle,
      $src,
      $dependencies,
      $version,
      [
        'strategy' => $strategy,
        'in_footer' => $in_footer,
      ]
    );

    if ( $enqueue ) :
      wp_enqueue_script( $handle );
    endif;
  endforeach;
}
