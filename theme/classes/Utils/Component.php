<?php

namespace WPLite\Utils;

if (! defined('ABSPATH')) {
  die;
}

class Component
{
  /**
   * The array of registered components.
   *
   * @access protected
   */
  protected static array $components = [];

  /**
   * Register a new component.
   *
   * @param string|string[] $names     The component name.
   * @param string          $namespace The component namespace.
   */
  public static function register(mixed $names, string $namespace = ''): void
  {
    $names = is_array($names) ? $names : [$names];

    if (! isset(self::$components[$namespace])) {
      self::$components[$namespace] = $names;
    } else {
      self::$components[$namespace] = array_merge(self::$components[$namespace], $names);
    }
  }

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
    if (
      ! isset(self::$components[$namespace])
      || ! in_array($name, self::$components[$namespace])
    ) {
      echo "<!-- Component '{$name}' not found -->";

      return;
    }

    $folder = '';

    if ($namespace) {
      $folder = "{$namespace}/";
    }

    get_template_part("components/{$folder}{$name}/{$name}", null, $args);
  }
}
