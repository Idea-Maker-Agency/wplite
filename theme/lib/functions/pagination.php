<?php

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
