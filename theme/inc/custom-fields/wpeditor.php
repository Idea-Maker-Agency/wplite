<?php

$post_id = intval($args['post_id']);
$name    = $args['field']['name'];

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
    'textarea_rows' => $args['field']['args']['rows'] ?? 10,
    'teeny'         => true,
  ]
);
