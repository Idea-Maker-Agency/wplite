<?php

/**
 * Functional article card component renderer.
 *
 * @since 1.0.0
 *
 * @param \WP_Post    $post       The WP post object.
 *
 * @return void
 */
function wplite_article_card( \WP_Post $post ): void {
  $article_card = new IdeaMaker\WPLite\Components\ArticleCard();

  $article_card->output( $post );
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
    'button',
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
 * Button component.
 *
 * @param string    $text       The button text.
 * @param string    $variant    The style variant of the button. Accepts `primary`, `secondary`, `success`, `danger`, `warning`, `info`, `light`, `dark`
 * @param string    $size       The size variant of the button. Accepts `sm`, `lg`
 * @param bool      $outlined   If `true`, the button will have an outlined style.
 * @param bool      $block      If `true`, the button will expand to the full width of its parent.
 * @param array     $attrs {
 *    @param string   $id       If set, the button will have an id HTML attribute.
 *    @param array    $class    If set, the button will have class HTML attribute.
 *    @param string   $type     If set, the button will have a type HTML attribute. Defaults to `button`
 *    @param string   $title    If set, the button will have a title HTML attribute.
 * }
 *
 * @return void
 */
function wplite_button( string $text, string $variant = 'primary', string $size = null, bool $outlined = false, bool $block = false, array $attrs = [] ): void {
  $args = wp_parse_args( [
    'text' => $text,
    'variant' => $variant,
    'size' => $size,
    'outlined' => $outlined,
    'block' => $block,
  ], $attrs );

  get_template_part(
    '/components/button/button',
    null,
    $args
  );
}
