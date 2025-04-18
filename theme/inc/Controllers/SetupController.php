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
    add_action('after_switch_theme', [self::class, 'generate_initial_pages']);
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
}
