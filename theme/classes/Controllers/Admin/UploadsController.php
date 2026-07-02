<?php

namespace WPLite\Controllers\Admin;

defined('ABSPATH') || exit;

class UploadsController
{
  /**
   * Constructor.
   */
  public function __construct()
  {
    add_filter('wp_check_filetype_and_ext', [$this, 'allow_svg_uploads'], 10, 4);
    add_filter('upload_mimes', [$this, 'upload_mimes'], 10, 1);
  }

  /**
   * Filters the “real” file type of the given file.
   *
   * @param array  $data
   * @param string $file
   * @param string $filename
   * @param mixed  $mimes
   */
  public function allow_svg_uploads(array $data, string $file, string $filename, mixed $mimes)
  {
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

  /**
   * Include 'image/svg+xml' to upload mimes.
   *
   * @param  array $mimes
   * @return array
   */
  public function upload_mimes(array $mimes): array
  {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }
}
