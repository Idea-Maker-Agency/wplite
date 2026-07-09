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
