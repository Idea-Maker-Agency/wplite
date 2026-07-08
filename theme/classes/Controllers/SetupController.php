<?php

namespace WPLite\Controllers;

defined('ABSPATH') || exit;

class SetupController
{
  /**
   * Constructor.
   */
  public function __construct()
  {
    add_action('after_setup_theme', [$this, 'setup']);
    add_action('after_switch_theme', [$this, 'generate_initial_pages']);

    add_action('widgets_init', [$this, 'register_sidebars']);

    add_filter('excerpt_length', [$this, 'excerpt_length'], 999);
    add_filter('excerpt_more', [$this, 'excerpt_more'], 999);
  }

  /**
   * Setup.
   */
  public function setup()
  {
    add_theme_support('post-thumbnails');
    add_theme_support('widgets');

    $this->remove_head_bloat();

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
   * Remove default `wp_head` output that adds requests/bytes but isn't used by the theme.
   */
  private function remove_head_bloat()
  {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');

    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');

    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
  }

  /**
   * Generate initial pages.
   */
  public function generate_initial_pages()
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
      [
        'title' => 'Login',
        'slug'  => 'login'
      ],
      [
        'title' => 'Sign Up',
        'slug'  => 'sign-up'
      ],
    ];

    foreach ($pages as $page) {
      $page_object = get_page_by_path($page['slug']);
      $page_id     = $page_object ? $page_object->ID : 0;

      $front_page_id = get_option('page_on_front');
      $posts_page_id = get_option('page_for_posts');

      $page_id = wp_insert_post([
        'ID'           => $page_id,
        'post_title'   => $page['title'],
        'post_name'    => $page['slug'],
        'post_content' => '',
        'post_status'  => 'publish',
        'post_type'    => 'page',
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
   * Register custom sidebars.
   */
  public function register_sidebars()
  {
    register_sidebar([
      'id'            => 'primary-sidebar',
      'name'          => __('Primary Sidebar', THEME_TEXT_DOMAIN),
      'description'   => __('Widgets in this area will be shown on posts sidebar.', THEME_TEXT_DOMAIN),
      'before_widget' => '<div id="%1$s" class="card mb-3 mb-lg-4 %2$s"><div class="card-body">',
      'after_widget'  => '</div></div>',
      'before_title'  => '<h2 class="card-title mb-3 fs-4">',
      'after_title'   => '</h2>',
    ]);
  }

  /**
   * Filters the maximum number of words in a post excerpt.
   *
   * @param  int $length
   * @return int
   */
  public function excerpt_length(int $length): int
  {
    return 14;
  }

  /**
   * Filters the string in the “more” link displayed after a trimmed excerpt.
   *
   * @param  string $more
   * @return string
   */
  public function excerpt_more(string $more): string
  {
    return '...';
  }
}
