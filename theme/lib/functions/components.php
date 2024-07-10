<?php

/**
 * Register the components assets.
 *
 * @since 1.0.0
 *
 * @return void
 */
add_action( 'wp_enqueue_scripts', 'wplite_component_assets', 15 );
function wplite_component_assets(): void {
  $components = [
    'article-card',
  ];

  foreach( $components as $component ) :
    $handle = 'wplite-'. $component;
    $path = '/components/'. $component .'/'. $component;
    $version = '1.0.0';

    if ( file_exists( THEME_DIR_PATH . $path .'.css' ) ) :
      wp_enqueue_style(
        $handle,
        THEME_DIR_URI . $path .'.css',
        [],
        $version,
        false
      );
    endif;

    if ( file_exists( THEME_DIR_PATH . $path .'.js' ) ) :
      wp_enqueue_script(
        $handle,
        THEME_DIR_URI . $path .'.js',
        [],
        $version,
        true
      );
    endif;
  endforeach;
}

/**
 * Article card component.
 *
 * @param WP_Post   $post       The WP post object.
 *
 * @return void
 */
function wplite_article_card( WP_Post $post ): void {
  get_template_part(
    '/components/article-card/article',
    'card',
    [
      'post' => $post,
    ]
  );
}
