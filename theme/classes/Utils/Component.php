<?php

namespace WPLite\Utils;

defined('ABSPATH') || exit;

class Component
{
  /**
   * Render the component.
   *
   * @param string $name      The component name.
   * @param string $namespace The component namespace.
   * @param array  $args      The component args. (Optional)
   *
   * @return void
   */
  public static function render(string $name, string $namespace = '', array $args = []): void
  {
    $folder = '';

    if ($namespace) {
      $folder = "{$namespace}/";
    }

    get_template_part("components/{$folder}{$name}/{$name}", null, $args);
  }
}
