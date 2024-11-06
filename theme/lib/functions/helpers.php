<?php

/**
 * Get webp asset image url.
 *
 * @param string    $name       The webp image file name.
 * @param string    $path       If the webp image file is placed on different directory.
 * @param array     $size       {
 *  @param int        $width      The webp image file width.
 *  @param int        $height     The webp image file height.
 * }
 *
 * @return string
 */
function wplite_get_webp_url(
  string $name,
  string $path = '',
  array $size = []
): string {
  if (! empty($size)) {
    [$width, $height] = $size;

    $filename = $name . '-' . $width . 'x' . $height . '.webp';
  } else {
    $filename = $name . '.webp';
  }

  return THEME_DIR_URI . '/assets/lib/img' . $path . '/' . $filename;
}
