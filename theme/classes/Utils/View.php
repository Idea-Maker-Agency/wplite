<?php

namespace WPLite\Utils;

if (! defined('ABSPATH')) die;

class View
{
  /**
   * The array of registered views.
   *
   * @access protected
   */
  protected static array $views = [];

  /**
   * Register a new view.
   *
   * @param string    $name       The view name.
   * @param string    $namespace  The view namespace.
   */
  public static function register(string $name, string $namespace = ''): void
  {
    if (! isset(self::$views[$namespace])) {
      self::$views[$namespace] = [$name];
    } else {
      self::$views[$namespace][] = $name;
    }

    add_action('wp_enqueue_scripts', function () use ($name, $namespace) {
      $exts = ['css', 'js'];

      foreach ($exts as $ext) {
        $folder = '';

        if ($namespace) {
          $folder = "{$namespace}/";
        }

        $path = get_theme_file_path("/classes/Views/{$folder}{$name}/{$name}.{$ext}");
        $uri = get_theme_file_uri("/classes/Views/{$folder}{$name}/{$name}.{$ext}");

        if (! file_exists($path)) {
          continue;
        }

        $handle = "wplite-view-{$name}";
        $version = filemtime($path);

        if ('css' === $ext) {
          wp_register_style($handle, $uri, [], $version);
        } else {
          wp_register_script($handle, $uri, [], $version, true);
        }
      }
    });
  }

  /**
   * Load view assets.
   *
   * @param string    $name       The view name.
   * @param string    $namespace  The view namespace.
   *
   * @return void
   */
  private static function load_assets(string $name, string $namespace = ''): void
  {
    if (
      ! isset(self::$views[$namespace])
      || ! in_array($name, self::$views[$namespace])
    ) {
      return;
    }

    $handle = "wplite-view-{$name}";

    if (wp_style_is($handle, 'registered')) {
      wp_enqueue_style($handle);
    }

    if (wp_script_is($handle, 'registered')) {
      wp_enqueue_script($handle);
    }
  }

  /**
   * Render the view.
   *
   * @param string    $name       The view name.
   * @param string    $namespace  The view namespace.
   * @param array     $args       The view args. (Optional)
   *
   * @return void
   */
  public static function render(string $name, string $namespace = '', array $args = []): void
  {
    if (
      ! isset(self::$views[$namespace])
      || ! in_array($name, self::$views[$namespace])
    ) {
      echo "<!-- View '{$name}' not found -->";

      return;
    }

    self::load_assets($name, $namespace);

    $folder = '';

    if ($namespace) {
      $folder = "{$namespace}/";
    }

    get_template_part("classes/Views/{$folder}{$name}/{$name}", null, $args);
  }
}
