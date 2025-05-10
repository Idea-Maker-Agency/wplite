<?php

namespace WPLite\Traits;

if (! defined('ABSPATH')) die;

trait MetaTrait
{
  /**
   * Meta data array.
   *
   * @var array
   */
  private array $meta = [];

  /**
   * Load meta data for the given post ID.
   *
   * @param int     $id  The post ID.
   *
   * @return void
   */
  protected function load_meta(int $id): void
  {
    $meta = get_post_meta($id);

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
   * @param string    $key    The meta key.
   *
   * @return mixed
   */
  public function get_meta(string $key): mixed
  {
    return $this->meta[$key][0] ?? null;
  }

  /**
   * Dynamically set meta data.
   *
   * @param string    $key    The meta key.
   * @param mixed     $value  The meta value.
   *
   * @return void
   */
  public function set_meta(string $key, mixed $value): void
  {
    $this->meta[$key] = [$value];
  }

  /**
   * Save meta datas.
   *
   * @param int     $id       The post ID.
   *
   * @return void
   */
  public function save_meta(int $id): void
  {
    foreach ($this->meta as $key => $value) {
      update_post_meta($id, $key, $value[0]);
    }
  }
}
