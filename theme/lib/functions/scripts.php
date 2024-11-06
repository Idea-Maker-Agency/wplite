<?php

/**
 * Register vendor scripts.
 *
 * @since 1.0.0
 */
add_action('wp_enqueue_scripts', 'wplite_vendor_scripts', 10);
function wplite_vendor_scripts()
{
  $scripts = [
    'bootstrap' => [
      'version' => '5.3.3',
      'minified' => true,
      'enqueue' => true,
      'strategy' => 'defer',
    ],
  ];

  if (! empty($scripts)) {
    foreach ($scripts as $name => $args) {
      $handle = 'wplite-' . $name;
      $version = $args['version'] ?? '1.0.0';
      $dependencies = $args['dependencies'] ?? [];
      $minified = $args['minified'] ?? false;
      $enqueue = $args['enqueue'] ?? false;

      $suffix = $minified ? '.min' : '';
      $src = THEME_DIR_URI . '/assets/vendor/' . $name . '/js/' . $name . $suffix .'.js';
      $args = [
        'strategy' => $args['strategy'] ?? '',
        'in_footer' => $args['in_footer'] ?? true,
      ];

      wp_register_script($handle, $src, $dependencies, $version, $args);

      if ($enqueue) {
        wp_enqueue_script($handle);
      }
    }
  }
}
