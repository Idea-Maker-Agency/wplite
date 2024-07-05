<?php

/**
 * Unauto-p CF7 form elements.
 *
 * @since 1.0.0
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * Filters CF7 form tags.
 *
 * @since 1.0.0
 *
 * @param array   $form_tag     Form tags array.
 * @param string  $replace      Form tags replacement string.
 *
 * @return array
 */
add_filter( 'wpcf7_form_tag', 'wplite_cf7_form_tag', 10, 2 );
function wplite_cf7_form_tag( array $form_tag, string $replace ): array {
  if ( in_array( $form_tag['basetype'], [ 'text', 'email', 'textarea' ] ) ) :
    $form_tag['options'][] = 'class:form-control';
    $form_tag['options'][] = 'class:mt-2';
  elseif ( 'submit' === $form_tag['basetype'] ) :
    $form_tag['options'][] = 'class:btn';
  endif;

  return $form_tag;
}
