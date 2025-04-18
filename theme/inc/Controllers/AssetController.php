<?php

namespace WPLite\Controllers;

if (! defined('ABSPATH')) die;

class AssetController
{
  /**
   * Init.
   *
   * @return void
   */
  public static function init(): void
  {
    add_filter('use_block_editor_for_post', '__return_false');
    add_filter('use_widgets_block_editor', '__return_false');
    add_action('wp_enqueue_scripts', [self::class, 'theme_styles'], 10);
    add_action('wp_enqueue_scripts', [self::class, 'vendor_styles'], 10);
    add_action('wp_enqueue_scripts', [self::class, 'vendor_scripts'], 10);
    add_action('wp_print_styles', [self::class, 'disable_gutenberg_styles'], 100);
  }

  /**
   * Enqueue theme styles.
   *
   * @return void
   */
  public static function theme_styles(): void
  {
    wp_enqueue_style(
      'wplite-main',
      THEME_DIR_URI . '/assets/lib/css/main.min.css',
      [],
      THEME_VERSION,
      'all'
    );
  }

  /**
   * Enqueue vendor styles.
   *
   * @return void
   */
  public static function vendor_styles(): void
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
        $src = THEME_DIR_URI . "/assets/vendor/{$handle}/css/{$handle}{$suffix}.css";

        wp_register_style(
          $handle,
          $src,
          $dependencies,
          $version,
          $media
        );

        if ($enqueue) {
          wp_enqueue_style($handle);
        }
      }
    }
  }

  /**
   * Enqueue vendor scripts.
   *
   * @return void
   */
  public static function vendor_scripts(): void
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
        $handle = "wplite-{$name}";
        $version = $args['version'] ?? '1.0.0';
        $dependencies = $args['dependencies'] ?? [];
        $minified = $args['minified'] ?? false;
        $enqueue = $args['enqueue'] ?? false;

        $suffix = $minified ? '.min' : '';
        $src = THEME_DIR_URI . "/assets/vendor/{$name}/js/{$name}{$suffix}.js";
        $args = [
          'strategy' => $args['strategy'] ?? '',
          'in_footer' => $args['in_footer'] ?? true,
        ];

        wp_register_script(
          $handle,
          $src,
          $dependencies,
          $version,
          $args
        );

        if ($enqueue) {
          wp_enqueue_script($handle);
        }
      }
    }
  }

  /**
   * Disable gutenberg styles.
   *
   * @return void
   */
  public static function disable_gutenberg_styles(): void
  {
    wp_dequeue_style('global-styles');

    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style');

    wp_dequeue_style('storefront-gutenberg-blocks');
  }
}
