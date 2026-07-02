<?php

namespace WPLite\Utils;

use WPLite\Utils\Transient;

defined('ABSPATH') || exit;

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
    public static function make_instance(
        string $key,
        int $expiration = 60 * 10
    ): static {
        return new static($key, $expiration);
    }
}
