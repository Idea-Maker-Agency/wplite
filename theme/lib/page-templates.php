<?php

namespace WPLite;

/**
 * Get page templates.
 *
 * @return array
 */
function get_page_templates(): array
{
  $cached = get_transient('wplite_page_templates_list');
  if ($cached !== false) {
    return $cached;
  }

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

  set_transient('wplite_page_templates_list', $page_templates, 24 * 60 * 60);
  return $page_templates;
}
