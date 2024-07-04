<?php

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
