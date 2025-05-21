<?php

namespace WPLite\Utils;

if (! defined('ABSPATH')) {
  die;
}

use WPLite\Utils\Transient;

class StaticTransient extends Transient
{
  /**
   * Creates an instance of a child class
   *
   * @param string $key        The transient key.
   * @param int    $expiration The transient expiration time.
   *
   * @return static
   */
  public static function create(
    string $key,
    int $expiration = 60 * 10
  ): static {
    return new static($key, $expiration);
  }
}
