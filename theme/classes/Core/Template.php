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
   * The array of template's components css dependencies.
   *
   * @var array
   */
  private array $components_css_deps = [];

  /**
   * The array of template's components js dependencies.
   *
   * @var array
   */
  private array $components_js_deps = [];

  /**
   * Constructor.
   */
  public function __construct()
  {
    add_action('wp_enqueue_scripts', [$this, 'enqueue_assets'], 10);
  }

  /**
   * Enqueue template assets.
   */
  public function enqueue_assets()
  {
    $this->register_components_assets();
    $this->enqueue_template_assets();
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

    $name = $this->get_name_from_path($path);
    get_template_part("components/{$path}/{$name}", null, $args);
  }

  /**
   * Get name from path.
   *
   * @param  string $path
   * @return string
   */
  private function get_name_from_path(string $path): string
  {
    $parts = explode('/', $path);
    $name  = array_pop($parts);

    return $name;
  }

  /**
   * Register components assets.
   */
  private function register_components_assets()
  {
    $exts = ['css', 'js'];

    if (empty($this->components)) {
      return;
    }

    foreach ($exts as $ext) {
      foreach ($this->components as $component_path) {
        $name = $this->get_name_from_path($component_path);
        $path = get_theme_file_path("components/{$component_path}/{$name}.{$ext}");

        if (!file_exists($path)) {
          continue;
        }

        $uri        = get_theme_file_uri("components/{$component_path}/{$name}.{$ext}");
        $handle_key = sanitize_key(str_replace('/', '-', $component_path));
        $handle     = "wplite-component-{$handle_key}";

        if ($ext == 'css') {
          $this->components_css_deps[] = $handle;
          wp_register_style($handle, $uri, [], THEME_VERSION, 'all');
        } else {
          $this->components_js_deps[] = $handle;
          wp_register_script($handle, $uri, [], THEME_VERSION, ['in_footer' => true]);
        }
      }
    }
  }

  /**
   * Get the template path.
   *
   * @return string
   */
  private function get_template_path(): string
  {
    global $post;

    $slug = $post->post_name;

    if (is_front_page() || is_page()) {
      if (is_front_page()) {
        $slug = 'front-page';
      } elseif (is_search()) {
        $slug = 'search';
      } elseif (is_404()) {
        $slug = '404';
      }

      $ancestors = get_post_ancestors($post);

      $nested_path = array_reduce(
        array_reverse($ancestors),
        function (string $path, int $ancestor_id) {
          $slug = get_post_field('post_name', $ancestor_id);

          $path = "{$slug}/{$path}";

          return $path;
        },
        $slug
      );

      $path = "templates/page/{$nested_path}";

      if (! file_exists($path)) {
        $path = "templates/page/{$slug}";
      }

      return $path;
    } elseif (is_category() || is_tag() || is_tax()) {
      $slug = get_queried_object()->taxonomy ?? '';

      return "templates/taxonomy/{$slug}";
    } elseif (is_home() || is_archive()) {
      $slug = is_home() ? 'post' : (get_queried_object()->name ?? '');

      return "templates/archive/{$slug}";
    } elseif (is_single()) {
      $slug = $post->post_type;

      return "templates/single/{$slug}";
    } else {
      return "templates/{$slug}";
    }

    if (! file_exists($path)) {
      return '';
    }

    return $path;
  }

  /**
   * Enqueue template assets.
   */
  private function enqueue_template_assets()
  {
    $exts = ['css', 'js'];

    foreach ($exts as $ext) {
      $template_path = $this->get_template_path();
      $template_name = $this->get_name_from_path($template_path);

      $path = get_theme_file_path("{$template_path}/{$template_name}.{$ext}");

      if (!file_exists($path)) {
        continue;
      }

      $uri    = get_theme_file_uri("{$template_path}/{$template_name}.{$ext}");
      $handle = "wplite-template-{$template_name}";

      if ($ext == 'css') {
        add_filter('wplite_auto_enqueue_template_styles', '__return_false');
        wp_enqueue_style($handle, $uri, $this->components_css_deps, THEME_VERSION, 'all');
      } else {
        add_filter('wplite_auto_enqueue_template_scripts', '__return_false');
        wp_enqueue_script($handle, $uri, $this->components_js_deps, THEME_VERSION, ['in_footer' => true]);
      }
    }
  }
}
