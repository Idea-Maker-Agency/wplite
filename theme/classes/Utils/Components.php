<?php

namespace WPLite\Utils;

if (! defined('ABSPATH')) die;

class Components
{
  /**
   * The array of registered components.
   *
   * @access protected
   */
  protected static array $components = [];

  /**
   * Register a new component.
   *
   * @param string    $name   The component name.
   */
  public static function register(string $name): void
  {
    self::$components[] = $name;

    add_action('wp_enqueue_scripts', function () use ($name) {
      $exts = ['css', 'js'];

      foreach ($exts as $ext) {
        $path = get_theme_file_path("/classes/Views/Components/{$name}/{$name}.{$ext}");
        $uri = get_theme_file_uri("/classes/Views/Components/{$name}/{$name}.{$ext}");

        if (! file_exists($path)) {
          continue;
        }

        $handle = "wplite-component-{$name}";
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
   * Load component assets.
   *
   * @param string    $name   The component name.
   *
   * @return void
   */
  private static function load_assets(string $name): void
  {
    if (! in_array($name, self::$components)) {
      return;
    }

    $handle = "wplite-component-{$name}";

    if (wp_style_is($handle, 'registered')) {
      wp_enqueue_style($handle);
    }

    if (wp_script_is($handle, 'registered')) {
      wp_enqueue_script($handle);
    }
  }

  /**
   * Render the component.
   *
   * @param string    $name   The component name.
   * @param array     $args   The component args. (Optional)
   *
   * @return void
   */
  public static function render(string $name, array $args = []): void
  {
    if (! in_array($name, self::$components)) {
      echo "<!-- Component '{$name}' not found -->";

      return;
    }

    self::load_assets($name);

    get_template_part("classes/Views/Components/{$name}/{$name}", null, $args);
  }
}
