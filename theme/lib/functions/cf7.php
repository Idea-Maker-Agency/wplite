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
    $form_tag['options'][] = 'class:btn-primary';
  endif;

  return $form_tag;
}

/**
 * Filters CF7 default templates.
 *
 * @since 1.0.0
 *
 * @param string $template      Form default template HTML markup.
 * @param string $prop          Form template type.
 *
 * @return string
 */
add_filter( 'wpcf7_default_template', 'wplite_cf7_default_template', 10, 2 );
function wplite_cf7_default_template( mixed $template, string $prop ): mixed {
  if ( 'form' === $prop ) :
    $template = sprintf(
			"<div class=\"%12\$s\">\n".
        "\t<label for=\"%3\$s\" class=\"%11\$s\">%2\$s</label>\n".
        "\t[text* your-name id:%3\$s autocomplete:name]\n".
      "</div>\n\n".

      "<div class=\"%12\$s\">\n".
        "\t<label for=\"%5\$s\" class=\"%11\$s\">%4\$s</label>\n".
        "\t[email* your-email id:%5\$s autocomplete:email]\n".
      "</div>\n\n".

      "<div class=\"%12\$s\">\n".
        "\t<label for=\"%7\$s\" class=\"%11\$s\">%6\$s</label>\n".
        "\t[text* your-subject id:%7\$s]\n".
      "</div>\n\n".

      "<div class=\"%12\$s\">\n".
        "\t<label for=\"%9\$s\" class=\"%11\$s\">%8\$s</label>\n".
        "\t[textarea your-message id:%9\$s]\n".
      "</div>\n\n".

      "<div class=\"position-relative d-inline-block\">\n".
      "\t[submit \"%10\$s\"]\n".
      "</div>",

      __( "(optional)", THEME_TEXT_DOMAIN ),

      __( "Your name", THEME_TEXT_DOMAIN ),
      __( "id_your-name", THEME_TEXT_DOMAIN ),

      __( "Your email", THEME_TEXT_DOMAIN ),
      __( "id_your-email", THEME_TEXT_DOMAIN ),

      __( "Subject", THEME_TEXT_DOMAIN ),
      __( "id_subject", THEME_TEXT_DOMAIN ),

      __( "Your message", THEME_TEXT_DOMAIN ),
      __( "id_message", THEME_TEXT_DOMAIN ),

      __( "Submit", THEME_TEXT_DOMAIN ),

      "form-label mb-0",
      "mb-3"
    );

		return trim( $template );
  endif;

  return $template;
}
