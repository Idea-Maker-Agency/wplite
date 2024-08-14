<?php

/**
 * Filters the archive title.
 *
 * @since 1.0.0
 *
 * @param string $title          Archive title to be displayed.
 * @param string $original_title Archive title without prefix.
 * @param string $prefix         Archive title prefix.
 *
 * @return string
 */
add_filter( 'get_the_archive_title', 'wplite_archive_title', 10, 3 );
function wplite_archive_title( string $title, string $original_title, string $prefix ): string {
  if ( $prefix ) :
    return sprintf(
			_x( '%1$s %2$s', 'archive title' ),
			'<span class="mb-2 fs-6 fw-normal text-uppercase d-block">'. preg_replace( '/:$/', '', $prefix ) .'</span>',
			$original_title
		);
  endif;

  return $original_title;
}

/**
 * Filters the HTML output of the search form.
 *
 * @param string    $form       The search form HTML output.
 * @param array     $args       The array of arguments for building the search form.
 *
 * @return string
 */
add_filter( 'get_search_form', 'wplite_search_form', 10, 2 );
function wplite_search_form( string $form, array $args ): string {
  $form = str_replace( 'type="text"', 'type="text" class="form-control"', $form );
  $form = str_replace( 'type="submit"', 'type="submit" class="btn btn-secondary mt-2"', $form );

  return $form;
}


/**
 * Filters the HTML output of paginated links for archives.
 *
 * @since 1.0.0
 *
 * @param string    $output       HTML output.
 * @param array     $args         An array of arguments. See `paginate_links()` for information on accepted arguments.
 *
 * @return string
 */
add_filter( 'paginate_links_output', 'wplite_paginate_links_output', 10, 2 );
function wplite_paginate_links_output( string $output, array $args ): string {
  if ( 'list' === $args['type'] ) :
    $output = str_replace( "<ul class='page-numbers'", "<ul class='pagination mb-0 justify-content-center'", $output );
    $output = str_replace( "<li", "<li class='page-item'", $output );
    $output = str_replace( "page-numbers", "page-link", $output );
    $output = str_replace( "current", "active", $output );
  endif;

  return $output;
}

/**
 * Register template parts resources.
 *
 * @since 1.0.0
 *
 * @return void
 */
add_action( 'wp_enqueue_scripts', 'wplite_register_template_parts_resources', 10 );
function wplite_register_template_parts_resources(): void {
  $template_parts = scandir( get_theme_file_path( '/template-parts' ) );

  if ( $template_parts ) :
    $template_parts = array_filter( $template_parts, function ( string $template_part ) use ( $template_parts_path ) {
      if ( in_array( $template_part, [ '.', '..' ] ) ) return false;

      $template_part_path = get_theme_file_path( '/template-parts/'. $template_part );

      if ( !is_dir( $template_part_path ) ) return false;

      $template_part_css_path = get_theme_file_path( '/template-parts/'. $template_part .'/'. $template_part .'.css' );

      if ( !file_exists( $template_part_css_path ) ) return false;

      return true;
    } );

    if ( 0 < count( $template_parts ) ) :
      foreach ( $template_parts as $template_part ) :
        wp_register_style(
          'wplite-'. $template_part,
          get_theme_file_uri( '/template-parts/'. $template_part .'/'. $template_part .'.css' ),
          [],
          '1.0.0',
          'all'
        );
      endforeach;
    endif;
  endif;
}

/**
 * Fires before an attempt is made to locate and load a template part.
 *
 * @since 1.0.0
 *
 * @param string    $slug         The slug name for the generic template.
 * @param string    $name         The name of the specialized template or an empty string if there is none.
 * @param string[]  $templates    Array of template files to search for, in order.
 * @param array     $args         Additional arguments passed to the template.
 */
add_action( 'get_template_part', 'wplite_get_template_part', 10, 4 );
function wplite_get_template_part( string $slug, string $name, array $templates, array $args ): void {
  if ( 0 < count( $templates ) ) :
    foreach( $templates as $template ) :
      $handle = substr( $template, strrpos( $template, '/' ) + 1 );
      $handle = str_replace( '.php', '', $handle );
      $handle = 'wplite-'. $handle;

      if ( wp_style_is( $handle, 'registered' ) && !wp_style_is( $handle, 'enqueued' ) ) :
        wp_enqueue_style( $handle );
      endif;
    endforeach;
  endif;
}
