<?php

/**
 * Filters the archive title.
 *
 * @param  string $title
 * @param  string $orig_title
 * @param  string $prefix
 * @return string
 */
function wplite_archive_title_output(string $title, string $orig_title, string $prefix): string {
	if (! empty($prefix)) {
		return sprintf(
			_x('%1$s %2$s', 'archive title'),
			'<span class="mb-2 fs-6 fw-normal text-uppercase d-block">' . preg_replace('/:$/', '', $prefix) . '</span>',
			$orig_title
		);
	}

	return $orig_title;
}
add_filter('get_the_archive_title', 'wplite_archive_title_output', 10, 3);

/**
 * Filters the HTML output of the search form.
 *
 * @param  string $form
 * @param  array  $args
 * @return string
 */
function wplite_search_form_output(string $form, array $args): string {
	$form = str_replace('type="text"', 'type="text" class="form-control"', $form);
	$form = str_replace('type="submit"', 'type="submit" class="btn btn-secondary mt-2"', $form);

	return $form;
}
add_filter('get_search_form', 'wplite_search_form_output', 10, 2);

/**
 * Filters the HTML output of paginated links for archives.
 *
 * @param  string $output
 * @param  array  $args
 * @return string
 */
function wplite_paginate_links_output(string $output, array $args): string {
    if ('list' === $args['type']) {
		$output = str_replace("<ul class='page-numbers'", "<ul class='pagination mb-0 justify-content-center'", $output);
		$output = str_replace("<li", "<li class='page-item'", $output);
		$output = str_replace("page-numbers", "page-link", $output);
		$output = str_replace("current", "active", $output);
    }

    return $output;
}
add_filter('paginate_links_output', 'wplite_paginate_links_output', 10, 2);