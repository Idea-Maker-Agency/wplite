<?php

namespace WPLite\Traits;

if (! defined('ABSPATH')) {
  die;
}

trait MetaTrait
{
  /**
   * Meta data array.
   *
   * @var array
   */
  private array $meta = [];

  /**
   * Load meta data for the given object ID.
   *
   * @param int    $id      The object ID.
   * @param string $context The object context. Defaults to 'post'.
   *
   * @return void
   */
  protected function load_meta(int $id, string $context = 'post'): void
  {
    if ('user' === $context) {
      $meta = get_user_meta($id);
    } else {
      $meta = get_post_meta($id);
    }

    $this->meta = array_map(function ($value) {
      if (is_serialized($value[0])) {
        return [unserialize($value[0])];
      } else {
        return $value;
      }
    }, $meta);
  }

  /**
   * Dynamically get meta data.
   *
   * @param string $key The meta key.
   *
   * @return mixed
   */
  public function get_meta(string $key): mixed
  {
    $value = $this->meta[$key][0];

    if (is_array($value)) {
      $value = array_values($value);
    }

    return $value ?? null;
  }

  /**
   * Dynamically set meta data.
   *
   * @param string $key   The meta key.
   * @param mixed  $value The meta value.
   *
   * @return void
   */
  public function set_meta(string $key, mixed $value): void
  {
    if (is_array($value)) {
      $value = array_values($value);
    }

    $this->meta[$key] = [$value];
  }

  /**
   * Save meta datas.
   *
   * @param int    $id      The object ID.
   * @param string $context The object context.
   *
   * @return void
   */
  public function save_meta(int $id, string $context = 'post'): void
  {
    foreach ($this->meta as $key => $value) {
      if ('user' === $context) {
        update_user_meta($id, $key, $value[0]);
      } else {
        update_post_meta($id, $key, $value[0]);
      }
    }
  }
}
