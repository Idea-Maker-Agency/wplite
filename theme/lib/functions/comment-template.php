<?php

// TODO: Add php doc
add_filter('comment_form_default_fields', 'wplite_comment_form_default_fields', 10, 1);
function wplite_comment_form_default_fields(array $fields): array
{
  $fields = array_map(function($name, $field) {
    if ('cookies' === $name) {
      $field = str_replace(
        '<label',
        sprintf('<label class="%s"', 'form-check-label'),
        $field
      );
      $field = str_replace(
        '<input',
        sprintf('<input class="%s"', 'form-check-input me-1'),
        $field
      );
    } else {
      $field = str_replace(
        '<label',
        sprintf('<label class="%s"', 'form-label'),
        $field
      );
      $field = str_replace(
        '<input',
        sprintf('<input class="%s"', 'form-control'),
        $field
      );
    }

    return $field;
  }, array_keys($fields), array_values($fields));

  return $fields;
}
