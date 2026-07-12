<?php

add_filter('use_block_editor_for_post', '__return_false');
add_filter('use_widgets_block_editor', '__return_false');

/**
 * Disable Gutenberg styles.
 */
function wplite_disable_gutenberg_styles()
{
    wp_dequeue_style('global-styles');

    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style');

    wp_dequeue_style('storefront-gutenberg-blocks');
}
add_action('wp_print_styles', 'wplite_disable_gutenberg_styles', 100);

/**
 * Enqueue vendor styles.
 */
function wplite_vendor_styles()
{
    $styles = [
        // '{{vendor-name}}' => [
        //   'version' => '{{vendor-version}}',
        //   'minified' => true,
        //   'enqueue' => true,
        // ],
    ];

    if (! empty($styles)) {
        foreach ($styles as $name => $args) {
            $handle       = "wplite-{$name}";
            $version      = $args['version']      ?? '1.0.0';
            $dependencies = $args['dependencies'] ?? [];
            $media        = $args['media']        ?? 'all';
            $minified     = $args['minified']     ?? false;
            $enqueue      = $args['enqueue']      ?? false;

            $suffix = $minified ? '.min' : '';
            $src    = THEME_DIR_URI . "/assets/vendor/{$name}/css/{$name}{$suffix}.css";

            wp_register_style(
                $handle,
                $src,
                $dependencies,
                $version,
                $media
            );

            if ($enqueue) {
                wp_enqueue_style($handle);
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'wplite_vendor_styles', 10);

/**
* Enqueue vendor scripts.
*/
function wplite_vendor_scripts()
{
    $scripts = [
        'bootstrap' => [
            'version'  => '5.3.3',
            'minified' => true,
            'enqueue'  => true,
            'strategy' => 'defer',
        ],
    ];

    if (! empty($scripts)) {
        foreach ($scripts as $name => $args) {
            $handle       = "wplite-{$name}";
            $version      = $args['version']      ?? '1.0.0';
            $dependencies = $args['dependencies'] ?? [];
            $minified     = $args['minified']     ?? false;
            $enqueue      = $args['enqueue']      ?? false;

            $suffix = $minified ? '.min' : '';
            $src    = THEME_DIR_URI . "/assets/vendor/{$name}/js/{$name}{$suffix}.js";
            $args   = [
                'strategy'  => $args['strategy']  ?? '',
                'in_footer' => $args['in_footer'] ?? true,
            ];

            wp_register_script(
                $handle,
                $src,
                $dependencies,
                $version,
                $args
            );

            if ($enqueue) {
                wp_enqueue_script($handle);
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'wplite_vendor_scripts', 10);

/**
 * Enqueue template styles.
 */
function wplite_template_styles()
{
    global $post;

    $should_enqueue = apply_filters('wplite_auto_enqueue_template_styles', true, $post);

    if (!$should_enqueue) {
        return;
    }

    $slug = $post ? $post->post_name : '';

    if (is_front_page() || is_page() || is_404()) {
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

        $path = get_theme_file_path("templates/{$nested_path}/{$slug}.css");
        $uri  = get_theme_file_uri("templates/{$nested_path}/{$slug}.css");

        if (! file_exists($path)) {
            $path = get_theme_file_path("templates/{$slug}/{$slug}.css");
            $uri  = get_theme_file_uri("templates/{$slug}/{$slug}.css");
        }

        if (! file_exists($path)) {
            $path = get_theme_file_path("templates/page/page.css");
            $uri  = get_theme_file_uri("templates/page/page.css");
        }
    } elseif (is_category() || is_tag() || is_tax()) {
        $current_obj = get_queried_object();
        $slug = $current_obj->taxonomy;

        $path = get_theme_file_path("templates/taxonomy/{$slug}/taxonomy-{$slug}.css");
        $uri  = get_theme_file_uri("templates/taxonomy/{$slug}/taxonomy-{$slug}.css");
    } elseif (is_home() || is_archive()) {
        $current_obj = get_queried_object();
        $slug = is_home() ? 'post' : ($current_obj->name ?? '');

        $path = get_theme_file_path("templates/archive/{$slug}/archive-{$slug}.css");
        $uri  = get_theme_file_uri("templates/archive/{$slug}/archive-{$slug}.css");
    } elseif (is_single()) {
        $slug = $post->post_type;

        $path = get_theme_file_path("templates/single/{$slug}/single-{$slug}.css");
        $uri  = get_theme_file_uri("templates/single/{$slug}/single-{$slug}.css");
    } else {
        $path = get_theme_file_path("templates/{$slug}/{$slug}.css");
        $uri  = get_theme_file_uri("templates/{$slug}/{$slug}.css");
    }

    if (! file_exists($path)) {
        return;
    }

    wp_enqueue_style(
        "wplite-{$slug}",
        $uri,
        [],
        wp_get_theme()->__get('version'),
        'all'
    );
}
add_action('wp_enqueue_scripts', 'wplite_template_styles', 12);

/**
 * Enqueue template scripts.
 */
function wplite_template_scripts()
{
    global $post;

    $should_enqueue = apply_filters('wplite_auto_enqueue_template_scripts', true, $post);

    if (!$should_enqueue) {
        return;
    }

    $slug = $post ? $post->post_name : '';

    if (is_front_page() || is_page() || is_404()) {
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

        $path = get_theme_file_path("templates/{$nested_path}/{$slug}.js");
        $uri  = get_theme_file_uri("templates/{$nested_path}/{$slug}.js");

        if (! file_exists($path)) {
            $path = get_theme_file_path("templates/{$slug}/{$slug}.js");
            $uri  = get_theme_file_uri("templates/{$slug}/{$slug}.js");
        }

        if (! file_exists($path)) {
            $path = get_theme_file_path("templates/page/page.js");
            $uri  = get_theme_file_uri("templates/page/page.js");
        }
    } elseif (is_category() || is_tag() || is_tax()) {
        $slug = get_queried_object()->taxonomy ?? '';

        $path = get_theme_file_path("templates/taxonomy/{$slug}/taxonomy-{$slug}.js");
        $uri  = get_theme_file_uri("templates/taxonomy/{$slug}/taxonomy-{$slug}.js");
    } elseif (is_home() || is_archive()) {
        $slug = is_home() ? 'post' : (get_queried_object()->name ?? '');

        $path = get_theme_file_path("templates/archive/{$slug}/archive-{$slug}.js");
        $uri  = get_theme_file_uri("templates/archive/{$slug}/archive-{$slug}.js");
    } elseif (is_single()) {
        $slug = $post->post_type;

        $path = get_theme_file_path("templates/single/{$slug}/single-{$slug}.js");
        $uri  = get_theme_file_uri("templates/single/{$slug}/single-{$slug}.js");
    }

    if (! file_exists($path)) {
        return;
    }

    wp_enqueue_script(
        "wplite-{$slug}",
        $uri,
        [],
        wp_get_theme()->__get('version'),
        ['strategy' => 'defer', 'in_footer' => true,]
    );
}
add_action('wp_enqueue_scripts', 'wplite_template_scripts', 12);

/**
 * Enqueue page template styles.
 */
function wplite_page_template_styles()
{
    global $post;

    if (!$post) {
        return;
    }

    $page_template = $post->__get('page_template');

    if ($page_template == 'default') {
        return;
    }

    $css_path = get_theme_file_path(str_replace('.php', '.css', $page_template));

    if (! file_exists($css_path)) {
        return;
    }

    $css_uri    = get_theme_file_uri(str_replace('.php', '.css', $page_template));
    $css_handle = 'wplite-' . strtolower(str_replace(' ', '-', $page_template));

    wp_enqueue_style(
        $css_handle,
        $css_uri,
        [],
        wp_get_theme()->__get('version'),
        'all'
    );
}
add_action('wp_enqueue_scripts', 'wplite_page_template_styles', 12);

/**
 * Enqueue page template scripts.
 */
function wplite_page_template_scripts()
{
    global $post;

    if (!$post) {
        return;
    }

    $page_template = $post->__get('page_template');

    if ($page_template == 'default') {
        return;
    }

    $js_path = get_theme_file_path(str_replace('.php', '.JS', $page_template));

    if (! file_exists($js_path)) {
        return;
    }

    $js_uri    = get_theme_file_uri(str_replace('.php', '.js', $page_template));
    $js_handle = 'wplite-' . strtolower(str_replace(' ', '-', $page_template));

    wp_enqueue_script(
        $js_handle,
        $js_uri,
        [],
        wp_get_theme()->__get('version'),
        ['strategy' => 'defer', 'in_footer' => true,]
    );
}
add_action('wp_enqueue_scripts', 'wplite_page_template_scripts', 12);
