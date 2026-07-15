<?php

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
        $page_templates_dir = $theme_dir . '/page-templates';

        if (!is_dir($page_templates_dir)) {
            continue;
        }

        $dirs = scandir($page_templates_dir);
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
