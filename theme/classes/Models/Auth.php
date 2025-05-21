<?php

namespace WPLite\Models;

if (! defined('ABSPATH')) {
  die;
}

class Auth
{
  /**
   * Get the ID.
   *
   * @return int
   */
  public static function id(): int
  {
    return get_current_user_id();
  }

  /**
   * Check if authenticated.
   *
   * @return bool
   */
  public static function check(): bool
  {
    return is_user_logged_in();
  }

  /**
   * Check if user matches the role provided.
   *
   * @param string $role The role to check.
   *
   * @return bool
   */
  public static function has_role(string $role): bool
  {
    if (! self::check()) {
      return false;
    }

    $user = wp_get_current_user();

    return in_array($role, $user->roles);
  }

  /**
   * Get user meta data by key.
   *
   * @param string $key The meta key.
   *
   * @return mixed
   */
  public static function get_meta(string $key): mixed
  {
    if (! self::check()) {
      return null;
    }

    return get_user_meta(self::id(), $key, true);
  }
}
