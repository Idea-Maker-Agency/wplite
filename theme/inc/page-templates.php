<?php

/**
 * Cache theme's page templates.
 */
function wplite_cache_page_templates() {
    delete_transient('wplite_page_templates_list');
    wplite_get_page_templates();
}
add_action('switch_theme', 'wplite_cache_page_templates');
add_action('upgrader_process_complete', 'wplite_cache_page_templates');

/**
 * Include the theme's page templates.
 *
 * @param  array $page_templates
 * @return array
 */
function wplite_page_templates_list(array $page_templates): array
{
	$theme_page_templates = wplite_get_page_templates();
	if ($theme_page_templates) {
		unset($page_templates['inc/page-templates.php']);

		return array_merge($page_templates, $theme_page_templates);
	}

	return $page_templates;
}
add_filter('theme_page_templates', 'wplite_page_templates_list', 10, 3);

/**
 * Get page templates.
 *
 * @return array
 */
function wplite_get_page_templates(): array
{
  $cached = get_transient('wplite_page_templates_list');
  if ($cached !== false) {
    return $cached;
  }

  $scan_dirs = array_unique([get_stylesheet_directory(), THEME_DIR_PATH]);

  $names = [];
  foreach ($scan_dirs as $theme_dir) {
    $dirs = scandir($theme_dir . '/page-templates');
    if ($dirs === false) {
      continue;
    }

    foreach ($dirs as $name) {
      if (! in_array($name, ['.', '..'], true)) {
        $names[$name] = true;
      }
    }
  }

  $page_templates = [];
  foreach (array_keys($names) as $name) {
    if (!is_dir(get_theme_file_path("page-templates/{$name}"))) {
      continue;
    }

    $path      = sprintf('page-templates/%1$s/%1$s.php', $name);
    $full_path = get_theme_file_path($path);

    if (! preg_match('|Template Name:(.*)$|mi', file_get_contents($full_path), $header)) {
      continue;
    }

    $page_templates[$path] = _cleanup_header_comment($header[1]);
  }

  set_transient('wplite_page_templates_list', $page_templates, 24 * 60 * 60);
  return $page_templates;
}
