<?php

/**
 * On save post.
 *
 * @param int $post_id
 */
function wplite_on_save_post(int $post_id)
{
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
function wplite_page_template(string $template, string $type, array $templates): string
{
    global $post;

    if (is_front_page()) {
        $custom_template = locate_template("templates/front-page/front-page.php") ?: locate_template("templates/front-page.php");
    } elseif (is_home()) {
        $custom_template = locate_template("templates/archive/post/archive-post.php") ?: locate_template("templates/archive/archive-post.php");
    } elseif (is_search()) {
        $custom_template = locate_template("templates/search/search.php") ?: locate_template("templates/search.php");
    } elseif (is_404()) {
        $custom_template = locate_template("templates/404/404.php") ?: locate_template("templates/404.php");
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

            // E.g. `templates/<slug>/<slug>.php` or, if it has no CSS/JS, flat as `templates/<slug>.php`
            $custom_template = locate_template("templates/{$nested_path}/{$post->post_name}.php")
              ?: locate_template("templates/{$post->post_name}/{$post->post_name}.php")
              ?: locate_template("templates/{$post->post_name}.php");

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
function wplite_single_template(string $template): string
{
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
function wplite_archive_template(string $template): string
{
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
function wplite_category_template(string $template): string
{
    $current_obj = get_queried_object();
    $slug = $current_obj->taxonomy;

    $custom_template = locate_template("templates/taxonomy/{$slug}/taxonomy-{$slug}.php")
      ?: locate_template("templates/taxonomy/taxonomy-{$slug}.php");

    return $custom_template ?: $template;
}
add_filter('category_template', 'wplite_category_template', 10, 3);
add_filter('taxonomy_template', 'wplite_category_template', 10, 3);

/**
 * Loads custom tag templates file.
 *
 * @param  string $template
 * @return string
 */
function wplite_tag_template(string $template): string
{
    $current_obj = get_queried_object();
    $slug = $current_obj->taxonomy;

    $custom_template = locate_template("templates/taxonomy/{$slug}/taxonomy-{$slug}.php")
      ?: locate_template("templates/taxonomy/taxonomy-{$slug}.php");

    return $custom_template ?: $template;
}
add_filter('tag_template', 'wplite_tag_template', 10, 3);
