<?php

namespace WPLite\Controllers;

defined('ABSPATH') || exit;

class ThemeController
{
  /**
   * Page templates cache lifetime.
   */
  private const PAGE_TEMPLATES_CACHE_LIFETIME = 24 * 60 * 60;

  /**
   * Constructor.
   */
  public function __construct()
  {
    add_action('switch_theme', [$this, 'cache_page_templates']);
    add_action('upgrader_process_complete', [$this, 'cache_page_templates']);
    add_filter('theme_page_templates', [$this, 'include_page_templates'], 10, 3);
  }

  /**
   * Get the theme's page templates.
   *
   * @return array
   */
  private function get_page_templates(): array
  {
    $dirs = scandir(get_theme_file_path('page-templates'));
    if ($dirs === false) {
      return [];
    }

    $page_templates = [];
    foreach ($dirs as $name) {
      if (in_array($name, ['.', '..'], true) || !is_dir(get_theme_file_path("page-templates/{$name}"))) {
        continue;
      }

      $path      = sprintf('page-templates/%1$s/%1$s.php', $name);
      $full_path = get_theme_file_path($path);

      if (! preg_match('|Template Name:(.*)$|mi', file_get_contents($full_path), $header)) {
        continue;
      }

      $page_templates[$path] = _cleanup_header_comment($header[1]);
    }

    return $page_templates;
  }

  /**
   * Cache theme's page templates.
   */
  public function cache_page_templates()
  {
    $page_templates = $this->get_page_templates();

    if (!$page_templates) {
      return;
    }

    set_transient('wplite_page_templates_list', $page_templates, self::PAGE_TEMPLATES_CACHE_LIFETIME);
  }

  /**
   * Include the theme's page templates.
   *
   * @param  array $page_templates
   * @return array
   */
  public function include_page_templates(array $page_templates): array
  {
    $cached_page_templates = get_transient('wplite_page_templates_list');
    if ($cached_page_templates) {
      return array_merge($page_templates, $cached_page_templates);
    }

    $theme_page_templates = $this->get_page_templates();
    if ($theme_page_templates) {
      set_transient('wplite_page_templates_list', $theme_page_templates, self::PAGE_TEMPLATES_CACHE_LIFETIME);
      return array_merge($page_templates, $theme_page_templates);
    }

    return $page_templates;
  }
}
