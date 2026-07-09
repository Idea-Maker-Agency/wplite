<?php

/**
 * Get page url by path.
 *
 * @param  string $path
 * @param  array  $params
 * @return string
 */
function wplite_get_url(string $path, array $params = []): string {
	if ('home' === $path) {
		return get_home_url();
	} elseif ('forgot-password' === $path) {
		return wp_lostpassword_url();
	}

	$page = get_page_by_path($path);
	$qs = http_build_query($params);
	$qs = ! empty($qs) ? '?' . $qs : '';

	return get_the_permalink($page) . $qs;
}

/**
 * Redirect to page by path.
 *
 * @param string $path
 * @param array  $params
 */
function wplite_redirect(string $path = '', array $params = []) {
	if ($path) {
		if ($page = get_page_by_path($path)) {
			$permalink = 'home' === $path ? get_home_url() : get_the_permalink($page);
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