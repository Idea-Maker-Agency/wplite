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

    add_action('wp_print_styles', [self::class, 'disable_gutenberg_styles'], 100);

    add_action('wp_enqueue_scripts', [self::class, 'enqueue_theme_styles'], 10);

    add_action('wp_enqueue_scripts', [self::class, 'enqueue_vendor_styles'], 10);
    add_action('wp_enqueue_scripts', [self::class, 'enqueue_vendor_scripts'], 10);

    add_action('get_template_part', [self::class, 'register_template_part_assets'], 10, 2);
    add_action('wp_footer', [self::class, 'enqueue_template_part_assets'], 1);

    add_action('wp_enqueue_scripts', [self::class, 'enqueue_page_template_styles'], 10);
    add_action('wp_enqueue_scripts', [self::class, 'enqueue_page_template_scripts'], 10);
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

  /**
   * Enqueue theme styles.
   *
   * @return void
   */
  public static function enqueue_theme_styles(): void
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
  public static function enqueue_vendor_styles(): void
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
  public static function enqueue_vendor_scripts(): void
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
   * Register template part assets.
   *
   * @param string    $slug   The slug name for the generic template.
   * @param string    $name   The name of the specialized template or null if there is none.
   *
   * @return void
   */
  public static function register_template_part_assets(string $slug, string $name): void
  {
    if (! empty($name)) {
      $slug .= "-{$name}";
    }

    if (! str_starts_with($slug, 'template-parts')) return;

    $template_part = substr($slug, strrpos($slug, '/') + 1);

    if (locate_template("{$slug}.css")) {
      add_filter("enqueue_{$template_part}_styles", "__return_true");
    }

    if (locate_template("{$slug}.js")) {
      add_filter("enqueue_{$template_part}_scripts", "__return_true");
    }
  }

  /**
   * Enqueue template part assets.
   *
   * @return void
   */
  public static function enqueue_template_part_assets(): void
  {
    $template_parts = scandir(get_theme_file_path('/template-parts'));

    $template_parts = array_filter($template_parts, function($template_part) {
      if (in_array($template_part, ['.', '..'])) return false;

      $template_part_dir = get_theme_file_path("/template-parts/{$template_part}");

      if (! is_dir($template_part_dir)) return false;

      return true;
    });

    foreach ($template_parts as $template_part) {
      $base_url = THEME_DIR_URI . "/template-parts/{$template_part}/{$template_part}";
      $base_path = THEME_DIR_PATH . "/template-parts/{$template_part}/{$template_part}";

      if (apply_filters("enqueue_{$template_part}_styles", false)) {
      ?>
        <link
          id="wplite-<?= $template_part ?>"
          href="<?= $base_url ?>.css?ver=<?= filemtime("{$base_path}.css") ?>"
          rel="stylesheet"
          media="all">
      <?php
      }

      if (apply_filters("enqueue_{$template_part}_scripts", false)) {
      ?>
        <script
          id="wplite-<?= $template_part ?>"
          src="<?= $base_url ?>.js?ver=<?= filemtime("{$base_path}.js") ?>"
          type="text/javascript"></script>
      <?php
      }
    }
  }

  /**
   * Enqueue page template styles.
   *
   * @since 1.0.0
   */
  public static function enqueue_page_template_styles(): void
  {
    $templates = wp_get_theme()->get_page_templates();

    $templates = array_filter($templates, function(string $title, string $base_path) {
      return is_page_template($base_path);
    }, ARRAY_FILTER_USE_BOTH);

    if (! empty($templates)) {
      foreach ($templates as $base_path => $title) {
        $path = get_theme_file_path(str_replace('.php', '.css', $base_path));
        $uri = get_theme_file_uri(str_replace('.php', '.css', $base_path));

        if (! file_exists($path)) {
          continue;
        }

        $handle = 'wplite-' . strtolower(str_replace(' ', '-', $title));
        $version = filemtime($path);

        wp_enqueue_style($handle, $uri, [], $version, 'all');
      }
    }
  }

  /**
   * Enqueue page template scripts.
   *
   * @since 1.0.0
   */
  public static function enqueue_page_template_scripts(): void
  {
    $templates = wp_get_theme()->get_page_templates();

    $templates = array_filter($templates, function(string $title, string $base_path) {
      return is_page_template($base_path);
    }, ARRAY_FILTER_USE_BOTH);

    if (! empty($templates)) {
      foreach ($templates as $base_path => $title) {
        $path = get_theme_file_path(str_replace('.php', '.js', $base_path));
        $uri = get_theme_file_uri(str_replace('.php', '.js', $base_path));

        if (! file_exists($path)) {
          continue;
        }

        $handle = 'wplite-' . strtolower(str_replace(' ', '-', $title));
        $version = filemtime($path);

        wp_enqueue_script($handle, $uri, [], $version, true);
      }
    }
  }
}
