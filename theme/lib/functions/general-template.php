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
