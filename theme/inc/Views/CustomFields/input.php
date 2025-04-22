<?php
global $post;

$name = $args['field']['name'] ?? '';
$type = $args['field']['type'] ?? 'text';
$placeholder = $args['field']['placeholder'] ?? '';
$required = $args['field']['required'] ?? false;

if (! empty($args['parent_name'])) {
  $name = "{$args['parent_name']}_{$name}";
}
?>

<input
  id="id_field_<?= $name ?>"
  name="<?= $name ?>"
  type="<?= $type ?>"
  placeholder="<?= $placeholder ?>"
  value="<?= $post->__get($name) ?>"
  style="width: 100%;"
  <?= $required ? 'required' : '' ?>>
