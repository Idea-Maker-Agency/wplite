<?php

namespace WPLite\Utils;

if (! defined('ABSPATH')) die;

class Helpers
{
  /**
   * Get webp asset image url.
   *
   * @param string    $name       The webp image file name.
   * @param array     $size       {
   *  @param int        $width      The webp image file width.
   *  @param int        $height     The webp image file height.
   * }
   *
   * @return string
   */
  public static function get_webp_asset_url(string $name, array $size = []): string
  {
    if (! empty($size)) {
      [$width, $height] = $size;

      $filename = "{$name}-{$width}x{$height}.webp";
    } else {
      $filename = "{$name}.webp";
    }

    return THEME_DIR_URI . "/assets/lib/img/{$filename}";
  }
}
