<?php

/**
 * Filters the “real” file type of the given file.
 *
 * @param array  $data
 * @param string $file
 * @param string $filename
 * @param mixed  $mimes
 */
function wplite_allow_svg_uploads(array $data, string $file, string $filename, mixed $mimes) {
    global $wp_version;
    if ($wp_version !== '4.7.1') {
      return $data;
    }

    $filetype = wp_check_filetype($filename, $mimes);

    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
}
add_filter('wp_check_filetype_and_ext', 'wplite_allow_svg_uploads', 10, 4);

/**
 * Filter data for the current svg file to upload.
 *
 * @param  array $file
 * @return array
 */
function wplite_sanitize_uploaded_svg(array $file): array {
	if ($file['type'] === 'image/svg+xml') {
		$sanitizer = new enshrined\svgSanitize\Sanitizer();

		$dirty_svg = file_get_contents($file['tmp_name']);
		$clean_svg = $sanitizer->sanitize($dirty_svg);

		file_put_contents($file['tmp_name'], $clean_svg);
	}

	return $file;
}
add_filter('wp_handle_upload_prefilter', 'wplite_sanitize_uploaded_svg');

/**
 * Include 'image/svg+xml' to upload mimes.
 *
 * @param  array $mimes
 * @return array
 */
function wplite_upload_mimes(array $mimes): array {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'wplite_upload_mimes', 10, 1);