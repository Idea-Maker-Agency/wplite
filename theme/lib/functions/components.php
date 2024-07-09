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

/**
 * Link component.
 *
 * @param string    $text       The link text.
 * @param string    $variant    The style variant of the link. Accepts `primary`, `secondary`, `success`, `danger`, `warning`, `info`, `light`, `dark`
 * @param string    $size       The size variant of the link. Accepts `sm`, `lg`
 * @param bool      $outlined   If `true`, the link will have an outlined style.
 * @param bool      $block      If `true`, the link will expand to the full width of its parent.
 * @param bool      $as_button  If `true`, the link will render as a link.
 * @param array     $attrs {
 *    @param string   $id       If set, the link will have an id HTML attribute.
 *    @param array    $class    If set, the link will have class HTML attribute.
 *    @param string   $target   If set, the link will have a target HTML attribute.
 *    @param string   $alt      If set, the link will have a alt HTML attribute. Defaults to the link text.
 * }
 *
 * @return void
 */
function wplite_link( string $text, string $url, string $variant = 'primary', string $size = null, bool $outlined = false, bool $block = false, bool $as_button = false, array $attrs = [] ): void {
  $args = wp_parse_args( [
    'text' => $text,
    'url' => $url,
    'variant' => $variant,
    'size' => $size,
    'outlined' => $outlined,
    'block' => $block,
    'as_button' => $as_button,
  ], $attrs );

  get_template_part(
    '/components/link/link',
    null,
    $args
  );
}

/**
 * Article card component.
 *
 * @param WP_Post   $post       The WP post object.
 * @param array     $attrs {
 *    @param string   $id       If set, the link will have an id HTML attribute.
 *    @param array    $class    If set, the link will have class HTML attribute.
 *    @param string   $target   If set, the link will have a target HTML attribute.
 *    @param string   $alt      If set, the link will have a alt HTML attribute. Defaults to the link text.
 * }
 *
 * @return void
 */
function wplite_article_card( WP_Post $post, array $attrs = [] ): void {
  $args = wp_parse_args( [
    'post' => $post,
  ], $attrs );

  get_template_part(
    '/components/article-card/article-card',
    null,
    $args
  );
}
