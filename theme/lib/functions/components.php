<?php

/**
 * Enqueues component styles & scripts if they are registered and not yet enqueued.
 *
 * @param string $handle The style/script handle.
 */
function wplite_maybe_enqueue_component_scripts(string $handle)
{
  $handle = 'wplite-' . $handle;

  if (wp_style_is($handle, 'registered') && ! wp_style_is($handle)) {
    wp_enqueue_style($handle);
  }

  if (wp_script_is($handle, 'registered') && ! wp_script_is($handle)) {
    wp_enqueue_script($handle);
  }
}

/**
 * Register the components assets.
 *
 * @since 1.0.0
 */
add_action('wp_enqueue_scripts', 'wplite_component_assets', 15);
function wplite_component_assets()
{
  $components = [
    'article-card',
  ];

  foreach ($components as $component) {
    $handle = 'wplite-' . $component;
    $version = '1.0.0';

    $base_path = '/lib/components/' . $component . '/' . $component;

    $css_mod_path = THEME_DIR_PATH . $base_path . '.css';
    $css_mod_uri = THEME_DIR_URI . $base_path . '.css';

    if (file_exists($css_mod_path)) {
      wp_register_style($handle, $css_mod_uri, [], $version, false);
    }

    $js_mod_path = THEME_DIR_PATH . $base_path . '.js';
    $js_mod_uri = THEME_DIR_URI . $base_path . '.js';

    if (file_exists($js_mod_path)) {
      wp_register_script($handle, $js_mod_uri, [], $version, true);
    }
  }
}

/**
 * Article card component.
 *
 * @param WP_Post $post The WP post object.
 */
function wplite_article_card(WP_Post $post)
{
  wplite_maybe_enqueue_component_scripts('article-card');

  get_template_part(
    '/lib/components/article-card/article',
    'card',
    [
      'post' => $post,
    ]
  );
}
