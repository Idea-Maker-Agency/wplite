<?php

namespace WPLite\Utils;

if (! defined('ABSPATH')) {
  die;
}

class Helpers
{
  /**
   * Get current template part.
   *
   * @param string $name   The template file name.
   * @param array  $args   Additional arguments passed to the template.
   *
   * @return void
   */
  public static function get_template_part(string $name, array $args = []): void
  {
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
    $caller = $backtrace[0]['file'] ?? null;

    $path = str_replace(get_theme_file_path() . '/', '', dirname($caller));

    get_template_part("{$path}/template-parts/{$name}", null, $args);
  }

  /**
   * Get webp asset image url.
   *
   * @param string $name   The webp image file name.
   * @param array  $size   {
   * @param int    $width  The webp image file width.
   * @param int    $height The webp image file height.
   *                       }
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

    return get_theme_file_uri("/assets/lib/img/{$filename}");
  }
}
