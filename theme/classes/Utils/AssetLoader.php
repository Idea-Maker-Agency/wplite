<?php

namespace WPLite\Utils;

defined('ABSPATH') || exit;

class AssetLoader
{
  private static $instance = null;

  /**
   * Style assets.
   *
   * @var array
   */
  private static $styles = [];

  /**
   * Script assets.
   *
   * @var array
   */
  private static $scripts = [];

  /**
   * Constructor.
   */
  private function __construct()
  {
    add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
  }

  /**
   * Get the singleton instance of AssetLoader.
   *
   * @return AssetLoader
   */
  public static function instantiate(): AssetLoader
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Register style asset.
   *
   * @param string $handle
   * @param string $src
   * @param array  $deps
   * @param mixed  $ver
   * @param string $media
   */
  public static function register_style(string $handle, string $src, array $deps = [], mixed $ver = false, string $media = 'all')
  {
    wp_register_style($handle, $src, $deps, $ver, $media);
  }

  /**
   * Register script asset.
   *
   * @param string $handle
   * @param string $src
   * @param array  $deps
   * @param mixed  $ver
   * @param array  $args
   */
  public static function register_script(string $handle, string $src, array $deps = [], mixed $ver = false, array $args = [])
  {
    wp_register_script($handle, $src, $deps, $ver, $args);
  }

  /**
   * Use registered style asset.
   *
   * @param string $handle
   */
  public static function use_style(string $handle)
  {
    if (wp_style_is($handle, 'registered')) {
      self::$styles[] = $handle;
    }
  }

  /**
   * Use registered script asset.
   *
   * @param string $handle
   */
  public static function use_script(string $handle)
  {
    if (wp_script_is($handle, 'registered')) {
      self::$scripts[] = $handle;
    }
  }

  /**
   * Enqueue registered style assets.
   */
  public static function enqueue_styles()
  {
    if (empty(self::$styles)) {
      return;
    }

    foreach (self::$styles as $handle) {
      wp_enqueue_style($handle);
    }
  }

  /**
   * Enqueue registered scripts.
   */
  public static function enqueue_scripts()
  {
    if (empty(self::$scripts)) {
      return;
    }

    foreach (self::$scripts as $handle) {
      wp_enqueue_script($handle);
    }
  }
}
