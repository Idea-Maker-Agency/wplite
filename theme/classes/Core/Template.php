<?php

namespace WPLite\Core;

defined('ABSPATH') || exit;

class Template
{
  /**
   * The array of template's components.
   *
   * @var array
   */
  private array $components = [];

  /**
   * Constructor.
   */
  public function __construct()
  {
    add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
  }

  /**
   * Enqueue template assets.
   */
  public function enqueue_assets()
  {
    $this->enqueue_components_assets();
  }

  /**
   * Register component into the array of template's component.
   * NOTE: Must call above get_header()
   *
   * @param string $path
   */
  public function use_component(string $path)
  {
    if (in_array($path, $this->components)) {
      return;
    }

    $this->components[] = $path;
  }

  /**
   * Render the component.
   *
   * @param string $path
   * @param array  $args
   */
  public function get_component(string $path, array $args = [])
  {
    if (!in_array($path, $this->components)) {
      return;
    }

    $name = $this->get_component_name_from_path($path);
    get_template_part("components/{$path}/{$name}", null, $args);
  }

  /**
   * Enqueue components assets.
   */
  private function enqueue_components_assets()
  {
    $exts = ['css', 'js'];

    if (empty($this->components)) {
      return;
    }

    foreach ($exts as $ext) {
      foreach ($this->components as $component_path) {
        $name = $this->get_component_name_from_path($component_path);
        $path = get_theme_file_path("components/{$component_path}/{$name}.{$ext}");

        if (!file_exists($path)) {
          continue;
        }

        $uri        = get_theme_file_uri("components/{$component_path}/{$name}.{$ext}");
        $handle_key = sanitize_key(str_replace('/', '-', $component_path));
        $handle     = "wplite-component-{$handle_key}";

        if ($ext == 'css') {
          wp_enqueue_style($handle, $uri, [], THEME_VERSION, 'all');
        } else {
          wp_enqueue_script($handle, $uri, [], THEME_VERSION, ['in_footer' => true]);
        }
      }
    }
  }

  /**
   * Get component name from path.
   *
   * @param  string $path
   * @return string
   */
  private function get_component_name_from_path(string $path): string
  {
    $parts = explode('/', $path);
    $name  = array_pop($parts);

    return $name;
  }
}
