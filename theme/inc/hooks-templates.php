<?php

use WPLite\Utils\CustomFields;

/**
 * On save post.
 *
 * @param int $post_id
 */
function wplite_on_save_post(int $post_id) {
	delete_post_meta($post_id, '_wplite_resolved_template');
}
add_action('save_post', 'wplite_on_save_post');

/**
 * Loads custom page templates file.
 *
 * @param  string $template
 * @param  string $type
 * @param  array  $templates
 * @return string
 */
function wplite_page_template(string $template, string $type, array $templates): string {
    global $post;

    if (is_front_page()) {
      $custom_template = locate_template("pages/front-page/front-page.php") ?: locate_template("pages/front-page.php");
    } elseif (is_home()) {
      $custom_template = locate_template("templates/archive/post/archive-post.php") ?: locate_template("templates/archive/archive-post.php");
    } elseif (is_search()) {
      $custom_template = locate_template("pages/search/search.php") ?: locate_template("pages/search.php");
    } elseif (is_404()) {
      $custom_template = locate_template("pages/404/404.php") ?: locate_template("pages/404.php");
    } else {
      $custom_template = get_post_meta($post->ID, '_wplite_resolved_template', true);

      if (! $custom_template) {
        $ancestors   = get_post_ancestors($post);
        $nested_path = array_reduce(
          array_reverse($ancestors),
          function (string $path, int $ancestor_id) {
            $slug = get_post_field('post_name', $ancestor_id);
            return "{$slug}/{$path}";
          },
          $post->post_name
        );

        // E.g. `pages/<slug>/<slug>.php` or, if it has no CSS/JS, flat as `pages/<slug>.php`
        $custom_template = locate_template("pages/{$nested_path}/{$post->post_name}.php")
          ?: locate_template("pages/{$post->post_name}/{$post->post_name}.php")
          ?: locate_template("pages/{$post->post_name}.php");

        update_post_meta($post->ID, '_wplite_resolved_template', $custom_template ?: '__none__');
      }

      if ('__none__' === $custom_template) {
        $custom_template = '';
      }
    }

    return $custom_template ?: $template;
}
add_filter('frontpage_template', 'wplite_page_template', 10, 3);
add_filter('home_template', 'wplite_page_template', 10, 3);
add_filter('page_template', 'wplite_page_template', 10, 3);
add_filter('privacypolicy_template', 'wplite_page_template', 10, 3);
add_filter('search_template', 'wplite_page_template', 10, 3);
add_filter('404_template', 'wplite_page_template', 10, 3);

/**
 * Loads custom single templates file.
 *
 * @param  string $template
 * @return string
 */
function wplite_load_single_template(string $template): string {
	global $post;

	// E.g. `templates/single/<post_type>/single-<post_type>.php`, or flat as `templates/single/single-<post_type>.php`
	$custom_template = locate_template("templates/single/{$post->post_type}/single-{$post->post_type}.php")
		?: locate_template("templates/single/single-{$post->post_type}.php");

	return $custom_template ?: $template;
}
add_filter('single_template', 'wplite_single_template', 10, 3);
add_filter('singular_template', 'wplite_single_template', 10, 1);

/**
 * Loads custom archive templates file.
 *
 * @param  string $template
 * @return string
 */
function wplite_archive_template(string $template): string {
	$post_type = get_queried_object()->name ?? '';

	// E.g. `templates/archive/<post_type>/archive-<post_type>.php`, or flat as `templates/archive/archive-<post_type>.php`
	$custom_template = locate_template("templates/archive/{$post_type}/archive-{$post_type}.php")
		?: locate_template("templates/archive/archive-{$post_type}.php");

	return $custom_template ?: $template;
}
add_filter('archive_template', 'wplite_archive_template', 10, 1);

/**
 * Loads custom category templates file.
 *
 * @param  string $template
 * @return string
 */
function wplite_category_template(string $template): string {
    $slug = get_queried_object()->slug ?? '';

    $custom_template = locate_template("templates/taxonomy/category/taxonomy-category.php")
      ?: locate_template("templates/taxonomy/taxonomy-category.php");

    return $custom_template ?: $template;
}
add_filter('category_template', 'wplite_category_template', 10, 3);

/**
 * Loads custom tag templates file.
 *
 * @param  string $template
 * @return string
 */
function wplite_tag_template(string $template): string {
    $slug = get_queried_object()->slug ?? '';

    $custom_template = locate_template("templates/taxonomy/post_tag/taxonomy-post_tag.php")
      ?: locate_template("templates/taxonomy/taxonomy-post_tag.php");

    return $custom_template ?: $template;
}
add_filter('tag_template', 'wplite_tag_template', 10, 3);

/**
 * Init custom fields.
 */
function wplite_init_template_custom_fields() {
    $id     = (int) $_GET['post'] ?? 0;
    $action = $_POST['action']    ?? null;

    $front_page_id = get_option('page_on_front');

    if (! $id && 'editpost' === $action) {
      	$id = (int) $_POST['post_ID'] ?? 0;
    }

    if (! $id) {
      	return;
    }

    $page_template = get_post_meta($id, '_wp_page_template', true);

    if ($front_page_id == $id) {
		$json_file = locate_template("pages/front-page/front-page.json")
			?: locate_template("pages/front-page.json");

		remove_post_type_support('page', 'editor');
    } else {
		$post_type = get_post_field('post_type', $id);
		$post_name = get_post_field('post_name', $id);

		if (empty($page_template) || 'default' === $page_template) {
			if ('page' === $post_type) {
				$ancestors = get_post_ancestors($id);

				$nested_path = array_reduce(
					array_reverse($ancestors),
					function (string $path, int $ancestor_id) {
						$slug = get_post_field('post_name', $ancestor_id);

						return "{$slug}/{$path}";
					},
					$post_name
				);

				$page_template = locate_template("pages/{$nested_path}/{$post_name}.php");

				if (! $page_template) {
					$page_template = locate_template("pages/{$post_name}/{$post_name}.php");
				}

				if (! $page_template) {
					$page_template = locate_template("pages/{$post_name}.php");
				}
			} else {
				$page_template = locate_template("templates/single/{$post_type}/single-{$post_type}.php")
					?: locate_template("templates/single/single-{$post_type}.php");
			}

			$json_file = str_replace('.php', '.json', $page_template);
		} else {
			$json_file = locate_template(str_replace('.php', '.json', $page_template));
		}

		if ('page' === $post_type) {
			remove_post_type_support('page', 'editor');
		}
    }

    if (! $json_file) {
      	return;
    }

    $json_contents = file_get_contents($json_file);
    $json_groups   = json_decode($json_contents, true);

    if (empty($json_groups)) {
      	return;
    }

    $custom_fields = new CustomFields();

    $custom_fields->set_groups($json_groups);
    $custom_fields->init();
}
add_action('admin_init', 'wplite_init_template_custom_fields');