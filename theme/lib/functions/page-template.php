<?php

use WPLite\CustomFields;

/**
 * Admin init.
 *
 * @return void
 */
add_action('admin_init', 'wplite_init_page_templates_custom_fields');
function wplite_init_page_templates_custom_fields()
{
  $post_id = $_GET['post'] ?? null;
  $action = $_POST['action'] ?? null;

  if (empty($post_id) && 'editpost' === $action) {
    $post_id = $_POST['post_ID'] ?? null;
  }

  if (empty($post_id)) return;

  $page_template = get_post_meta($post_id, '_wp_page_template', true);

  if (! empty($page_template)) {
    $page_template_path = THEME_DIR_PATH . '/' . $page_template;
    $custom_fields_path = str_replace('.php', '.fields.yaml', $page_template_path);

    if (! file_exists($custom_fields_path)) return;

    $loaded_custom_fields = Spyc::YAMLLoad($custom_fields_path);

    if (empty($loaded_custom_fields)) return;

    $custom_fields = new CustomFields();

    $custom_fields->setFields($loaded_custom_fields);
    $custom_fields->init();
  }
}

/**
 * Filters list of page templates.
 *
 * @param array     $page_templates       Array of page templates. Keys are filenames, values are translated names.
 *
 * @return array
 */
add_filter( 'theme_page_templates', 'wplite_theme_page_templates', 10, 3 );
function wplite_theme_page_templates( array $page_templates, WP_Theme $theme, WP_Post | null $post ): array {
  $templates_path = THEME_DIR_PATH . '/templates';
  $templates_dir = scandir( $templates_path );

  if ( $templates_dir ) :
    $templates_subdir = array_filter( $templates_dir, function ( string $dir ) use ( $templates_path ) {
      if ( in_array( $dir, [ '.', '..' ] ) ) return false;

      return is_dir( $templates_path . '/'. $dir );
    } );

    $templates_subdir_keys = array_map( function ( string $value ) {
      return 'templates/'. $value .'/'. $value .'.php';
    }, $templates_subdir );

    $templates_subdir_names = array_map( function ( string $value, string $key ) {
      $file_contents = file_get_contents( get_theme_file_path( $key ) );

      if ( preg_match( '|Template Name:(.*)$|mi', $file_contents, $type ) ) :
        return _cleanup_header_comment( $type[1] );
      endif;

      return $value;
    }, $templates_subdir, $templates_subdir_keys );

    $templates_subdir_items = array_combine( $templates_subdir_keys, $templates_subdir_names );

    if ( 0 < count( $templates_subdir_items ) ) :
      $page_templates = array_merge( $page_templates, $templates_subdir_items );
    endif;
  endif;

  return $page_templates;
}

/**
 * Enqueue page template resources.
 *
 * @since 1.0.0
 *
 * @return void
 */
add_action( 'wp_enqueue_scripts', 'wplite_theme_page_templates_resources', 10 );
function wplite_theme_page_templates_resources(): void {
  $page_templates = wp_get_theme()->get_page_templates();

  $page_templates = array_filter( $page_templates, function ( string $value, string $key ) {
    return is_page_template( $key );
  }, ARRAY_FILTER_USE_BOTH );

  if ( 0 < count( $page_templates ) ) :
    foreach ( $page_templates as $key => $value ) :
      $page_template_handle = strtolower( str_replace( ' ', '-', $value ) );

      $page_template_css = str_replace( '.php', '.css', $key );
      $page_template_js = str_replace( '.php', '.js', $key );

      if ( file_exists( get_theme_file_path( $page_template_css ) ) ) :
        wp_enqueue_style(
          'wplite-'. $page_template_handle,
          get_theme_file_uri( $page_template_css ),
          [],
          THEME_VERSION,
          'all'
        );
      endif;

      if ( file_exists( get_theme_file_path( $page_template_js ) ) ) :
        wp_enqueue_script(
          'wplite-'. $page_template_handle,
          get_theme_file_uri( $page_template_js ),
          [],
          THEME_VERSION,
          true
        );
      endif;
    endforeach;
  endif;
}
