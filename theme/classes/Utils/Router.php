<?php

namespace WPLite\Utils;

defined('ABSPATH') || exit;

class Router
{
    /**
     * Get page url by path.
     *
     * @param string $path The page path.
     *
     * @return string|bool
     */
    public static function url(string $path, array $params = []): string | bool
    {
        if ('home' === $path) {
            return get_home_url();
        } elseif ('forgot-password' === $path) {
            return wp_lostpassword_url();
        } else {
            $page = get_page_by_path($path);

            $qs = http_build_query($params);
            $qs = ! empty($qs) ? '?' . $qs : '';

            return get_the_permalink($page) . $qs;
        }
    }

    /**
     * Redirect to page by path.
     *
     * @param string $path   The page path.
     * @param array  $params An array of query params.
     *
     * @return void
     */
    public static function redirect(string $path = '', array $params = []): void
    {
        if ($path) {
            $page = get_page_by_path($path);

            if ($page) {
                $permalink = 'home' === $path ? get_home_url() : get_permalink($page);
            } else {
                $permalink = $path;
            }
        } else {
            $permalink = $_SERVER['HTTP_REFERER'];
        }

        $qs = http_build_query($params);
        $qs = ! empty($qs) ? '?' . $qs : '';

        if (wp_safe_redirect($permalink . $qs)) {
            exit();
        }
    }
}
