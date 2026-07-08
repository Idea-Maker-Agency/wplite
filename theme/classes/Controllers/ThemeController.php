<?php

namespace WPLite\Controllers;

defined('ABSPATH') || exit;

class ThemeController
{
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
   * Cache theme's page templates.
   */
  public function cache_page_templates()
  {
    delete_transient('wplite_page_templates_list');
    wplite_get_page_templates();
  }

  /**
   * Include the theme's page templates.
   *
   * @param  array $page_templates
   * @return array
   */
  public function include_page_templates(array $page_templates): array
  {
    $theme_page_templates = wplite_get_page_templates();
    if ($theme_page_templates) {
      unset($page_templates['inc/page-templates.php']);

      return array_merge($page_templates, $theme_page_templates);
    }

    return $page_templates;
  }
}
