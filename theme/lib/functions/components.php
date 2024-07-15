<?php

/**
 * Enqueues component styles & scripts if they are registered and not yet enqueued.
 *
 * @param string    $handle       The style/script handle.
 *
 * @return void
 */
function wplite_maybe_enqueue_component_scripts( string $handle ): void {
  $handle = 'wplite-'. $handle;

  if ( wp_style_is( $handle, 'registered' ) && !wp_style_is( $handle ) ) :
    wp_enqueue_style( $handle );
  endif;

  if ( wp_script_is( $handle, 'registered' ) && ! wp_script_is( $handle ) ) :
    wp_enqueue_script( $handle );
  endif;
}

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
    $path = '/lib/components/'. $component .'/'. $component;
    $version = '1.0.0';

    if ( file_exists( THEME_DIR_PATH . $path .'.css' ) ) :
      wp_register_style(
        $handle,
        THEME_DIR_URI . $path .'.css',
        [],
        $version,
        false
      );
    endif;

    if ( file_exists( THEME_DIR_PATH . $path .'.js' ) ) :
      wp_regsiter_script(
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
  wplite_maybe_enqueue_component_scripts( 'article-card' );

  get_template_part(
    '/lib/components/article-card/article',
    'card',
    [
      'post' => $post,
    ]
  );
}
