<?php

namespace WPLite\Controllers;

if (! defined('ABSPATH')) die;

use WP_Theme, WP_Post;
use Spyc;
use WPLite\Utils\CustomFields;

class SetupController
{
  /**
   * Init.
   *
   * @return void
   */
  public static function init(): void
  {
    add_action('after_setup_theme', [self::class, 'setup']);
    add_action('after_switch_theme', [self::class, 'generate_initial_pages']);

    add_filter('excerpt_length', [self::class, 'excerpt_length'], 999);
    add_filter('excerpt_more', [self::class, 'excerpt_more'], 999);
  }

  /**
   * Setup.
   *
   * @return void
   */
  public static function setup(): void
  {
    add_theme_support('post-thumbnails');
    add_theme_support('widgets');

    add_image_size(
      'thumbnail',
      get_option('thumbnail_size_w', 320),
      get_option('thumbnail_size_h', 240),
      true
    );
    add_image_size(
      'medium',
      get_option('medium_size_w', 640),
      get_option('medium_size_h', 480),
      true
    );
    add_image_size(
      'large',
      get_option('large_size_w', 1024),
      get_option('large_size_h', 768),
      true
    );

    add_image_size(
      'card-image',
      420,
      320,
      ['center', 'center']
    );
    add_image_size(
      'featured-image',
      640,
      320,
      ['center', 'center']
    );
  }

  /**
   * Generate initial pages.
   *
   * @return void
   */
  public static function generate_initial_pages(): void
  {
    $pages = [
      [
        'title' => 'Home',
        'slug'  => 'home'
      ],
      [
        'title' => 'Blog',
        'slug'  => 'blog'
      ],
    ];

    foreach ($pages as $page) {
      $page_object = get_page_by_path($page['slug']);
      $page_id = $page_object ? $page_object->ID : 0;

      $front_page_id = get_option('page_on_front');
      $posts_page_id = get_option('page_for_posts');

      $page_id = wp_insert_post([
        'ID' => $page_id,
        'post_title' => $page['title'],
        'post_name' => $page['slug'],
        'post_content' => '',
        'post_status' => 'publish',
        'post_type' => 'page',
      ]);

      if (
        ! $front_page_id
        && ('home' === $page['slug'])
      ) {
        update_option('page_on_front', $page_id);
      } elseif (
        ! $posts_page_id
        && ('blog' === $page['slug'])
      ) {
        update_option('page_for_posts', $page_id);
      }
    }

    update_option('show_on_front', 'page');
  }

  /**
   * Filters the maximum number of words in a post excerpt.
   *
   * @param int     $length   The maximum number of words.
   *
   * @return int
   */
  public static function excerpt_length(int $length): int
  {
    return 14;
  }

  /**
   * Filters the string in the “more” link displayed after a trimmed excerpt.
   *
   * @param string    $more   The string shown within the more link.
   *
   * @return string
   */
  function excerpt_more(string $more): string
  {
    return '...';
  }
}
