<?php

/**
 * Disable Gutenberg on the back end.
 *
 * @since 1.0.0
 */
add_filter('use_block_editor_for_post', '__return_false');

/**
 * Disable Gutenberg for widgets.
 *
 * @since 1.0.0
 */
add_filter('use_widgets_block_editor', '__return_false');

/**
 * Dequeue WP blocks styles.
 *
 * @since 1.0.0
 */
add_action('wp_print_styles', 'wplite_print_styles', 100);
function wplite_print_styles()
{
  wp_dequeue_style('global-styles');

  wp_dequeue_style('wp-block-library');
  wp_dequeue_style('wp-block-library-theme');
  wp_dequeue_style('wc-block-style');

  wp_dequeue_style('storefront-gutenberg-blocks');
}

/**
 * Register vendor stylesheets.
 *
 * @since 1.0.0
 */
add_action('wp_enqueue_scripts', 'wplite_vendor_styles', 10);
function wplite_vendor_styles()
{
  $styles = [
    // '{{vendor-name}}' => [
    //   'version' => '{{vendor-version}}',
    //   'minified' => true,
    //   'enqueue' => true,
    // ],
  ];

  if (! empty($styles)) {
    foreach ($styles as $handle => $args) {
      $version = $args['version'] ?? '1.0.0';
      $dependencies = $args['dependencies'] ?? [];
      $media = $args['media'] ?? 'all';
      $minified = $args['minified'] ?? false;
      $enqueue = $args['enqueue'] ?? false;

      $suffix = $minified ? '.min' : '';
      $src = THEME_DIR_URI . '/assets/vendor/' . $handle . '/css/' . $handle . $suffix . '.css';

      wp_register_style($handle, $src, $dependencies, $version, $media);

      if ($enqueue) {
        wp_enqueue_style($handle);
      }
    }
  }
}

/**
 * Register stylesheets.
 *
 * @since 1.0.0
 */
add_action('wp_enqueue_scripts', 'wplite_styles', 10);
function wplite_styles()
{
  wp_enqueue_style(
    'wplite-main',
    THEME_DIR_URI . '/assets/lib/css/main.min.css',
    [],
    THEME_VERSION,
    'all'
  );
}
