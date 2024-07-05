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
