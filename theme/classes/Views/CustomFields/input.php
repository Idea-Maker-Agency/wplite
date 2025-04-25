<?php
$post_id = intval($args['post_id'] ?? null);
$name = $args['name'] ?? '';
$type = $args['field']['type'] ?? 'text';
$placeholder = $args['field']['placeholder'] ?? '';
$required = $args['field']['required'] ?? false;

if (! empty($args['parent_name'])) {
  $name = "{$args['parent_name']}_{$name}";
}

$post = get_post($post_id);
?>

<input
  id="id_field_<?= $name ?>"
  name="<?= $name ?>"
  type="<?= $type ?>"
  placeholder="<?= $placeholder ?>"
  value="<?= htmlspecialchars($post->__get($name)) ?>"
  style="width: 100%;"
  <?= $required ? 'required' : '' ?>>
