<?php

$post_id = (int) $args['post_id'] ?? 0;
$name    = $args['name']          ?? '';

if (! empty($args['parent_name'])) {
  $name = "{$args['parent_name']}_{$name}";
}

$post = get_post($post_id);

wp_editor(
  html_entity_decode($post->__get($name)),
  "id_field_{$name}",
  [
    'media_buttons' => false,
    'textarea_name' => $name,
    'textarea_rows' => 10,
    'teeny'         => true,
  ]
);
