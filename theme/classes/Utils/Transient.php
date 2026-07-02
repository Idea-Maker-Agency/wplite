<?php

namespace WPLite\Utils;

use WPLite\Models\Auth;

defined('ABSPATH') || exit;

abstract class Transient
{
    /**
     * The transient key.
     *
     * @var string
     *
     * @access protected
     */
    protected string $key;

    /**
     * The transient expiration time.
     *
     * @var int
     *
     * @access protected
     */
    protected int $expiration = 60 * 10;

    /**
     * Initialize the class.
     *
     * @param string $key        The transient key.
     * @param int    $expiration The transient expiration time.
     */
    public function __construct(string $key, int $expiration = 60 * 10)
    {
        if (
            ! Auth::check()
            && ! isset($_COOKIE['user_id'])
        ) {
            $user_id = wp_generate_uuid4();

            setcookie(
                'user_id',
                $user_id,
                time() + DAY_IN_SECONDS,
                COOKIEPATH,
                COOKIE_DOMAIN
            );

            $_COOKIE['user_id'] = $user_id;
        }

        $this->key        = $key;
        $this->expiration = $expiration;
    }

    /**
     * Generate a unique transient key.
     *
     * @return string
     */
    private function get_key(): string
    {
        if (Auth::check()) {
            $user_id = Auth::id();
        } else {
            $user_id = $_COOKIE['user_id'];
        }

        return "{$this->key}_{$user_id}";
    }

    /**
     * Set a transient value.
     *
     * @param mixed $value The transient value.
     *
     * @return void
     */
    public function set_transient(mixed $value): void
    {
        set_transient($this->get_key(), $value, $this->expiration);
    }

    /**
     * Get transient value.
     *
     * @return mixed
     */
    public function get_transient(): mixed
    {
        $transient = get_transient($this->get_key());

        if (false === $transient) {
            return null;
        }

        return $transient;
    }

    /**
     * Delete transient.
     *
     * @return void
     */
    public function delete_transient(): void
    {
        delete_transient($this->get_key());
    }
}
