<?php

namespace WPLite\Controllers;

defined('ABSPATH') || exit;

class AssetController
{
    /**
     * Init.
     *
     * @return void
     */
    public static function init(): void
    {
        add_filter('use_block_editor_for_post', '__return_false');
        add_filter('use_widgets_block_editor', '__return_false');

        add_action('wp_print_styles', [self::class, 'disable_gutenberg_styles'], 100);

        add_action('wp_enqueue_scripts', [self::class, 'enqueue_theme_styles'], 10);

        add_action('wp_enqueue_scripts', [self::class, 'enqueue_vendor_styles'], 10);
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_vendor_scripts'], 10);

        add_action('wp_enqueue_scripts', [self::class, 'enqueue_template_styles'], 10);
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_template_scripts'], 10);

        add_action('wp_enqueue_scripts', [self::class, 'enqueue_page_template_styles'], 10);
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_page_template_scripts'], 10);
    }

    /**
     * Disable gutenberg styles.
     *
     * @return void
     */
    public static function disable_gutenberg_styles(): void
    {
        wp_dequeue_style('global-styles');

        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-block-style');

        wp_dequeue_style('storefront-gutenberg-blocks');
    }

    /**
     * Enqueue theme styles.
     *
     * @return void
     */
    public static function enqueue_theme_styles(): void
    {
        wp_enqueue_style(
            'wplite-main',
            THEME_DIR_URI . '/assets/css/main.min.css',
            [],
            THEME_VERSION,
            'all'
        );
    }

    /**
     * Enqueue vendor styles.
     *
     * @return void
     */
    public static function enqueue_vendor_styles(): void
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

    /**
     * Enqueue vendor scripts.
     *
     * @return void
     */
    public static function enqueue_vendor_scripts(): void
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

    /**
     * Enqueue template styles.
     *
     * @since 1.0.0
     */
    public static function enqueue_template_styles(): void
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

            $path = get_theme_file_path("templates/page/{$nested_path}/{$slug}.css");
            $uri  = get_theme_file_uri("templates/page/{$nested_path}/{$slug}.css");

            if (! file_exists($path)) {
                $path = get_theme_file_path("templates/page/{$slug}/{$slug}.css");
                $uri  = get_theme_file_uri("templates/page/{$slug}/{$slug}.css");
            }
        } elseif (is_category() || is_tag() || is_tax()) {
            $slug = get_queried_object()->taxonomy ?? '';

            $path = get_theme_file_path("templates/taxonomy/{$slug}/taxonomy-{$slug}.css");
            $uri  = get_theme_file_uri("templates/taxonomy/{$slug}/taxonomy-{$slug}.css");
        } elseif (is_home() || is_archive()) {
            $slug = is_home() ? 'post' : (get_queried_object()->name ?? '');

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

        $handle  = "wplite-{$slug}";
        $version = filemtime($path);

        wp_enqueue_style($handle, $uri, [], $version, 'all');
    }

    /**
     * Enqueue template scripts.
     *
     * @since 1.0.0
     */
    public static function enqueue_template_scripts(): void
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

            $path = get_theme_file_path("templates/page/{$nested_path}/{$slug}.js");
            $uri  = get_theme_file_uri("templates/page/{$nested_path}/{$slug}.js");

            if (! file_exists($path)) {
                $path = get_theme_file_path("templates/page/{$slug}/{$slug}.js");
                $uri  = get_theme_file_uri("templates/page/{$slug}/{$slug}.js");
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

        $handle  = "wplite-{$slug}";
        $version = filemtime($path);

        wp_enqueue_script($handle, $uri, [], $version, true);
    }

    /**
     * Enqueue page template styles.
     *
     * @since 1.0.0
     */
    public static function enqueue_page_template_styles(): void
    {
        $templates = wp_get_theme()->get_page_templates();

        $templates = array_filter($templates, function (string $title, string $base_path) {
            return is_page_template($base_path);
        }, ARRAY_FILTER_USE_BOTH);

        if (! empty($templates)) {
            foreach ($templates as $base_path => $title) {
                $path = get_theme_file_path(str_replace('.php', '.css', $base_path));
                $uri  = get_theme_file_uri(str_replace('.php', '.css', $base_path));

                if (! file_exists($path)) {
                    continue;
                }

                $handle  = 'wplite-' . strtolower(str_replace(' ', '-', $title));
                $version = filemtime($path);

                wp_enqueue_style($handle, $uri, [], $version, 'all');
            }
        }
    }

    /**
     * Enqueue page template scripts.
     *
     * @since 1.0.0
     */
    public static function enqueue_page_template_scripts(): void
    {
        $templates = wp_get_theme()->get_page_templates();

        $templates = array_filter($templates, function (string $title, string $base_path) {
            return is_page_template($base_path);
        }, ARRAY_FILTER_USE_BOTH);

        if (! empty($templates)) {
            foreach ($templates as $base_path => $title) {
                $path = get_theme_file_path(str_replace('.php', '.js', $base_path));
                $uri  = get_theme_file_uri(str_replace('.php', '.js', $base_path));

                if (! file_exists($path)) {
                    continue;
                }

                $handle  = 'wplite-' . strtolower(str_replace(' ', '-', $title));
                $version = filemtime($path);

                wp_enqueue_script($handle, $uri, [], $version, true);
            }
        }
    }
}
