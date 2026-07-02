<?php
$post_id     = intval($args['post_id']);
$name        = $args['field']['name'];
$type        = $args['field']['type']                ?? 'text';
$required    = $args['field']['args']['required']    ?? false;
$placeholder = $args['field']['args']['placeholder'] ?? '';

if (! empty($args['parent_name'])) {
  $name = "{$args['parent_name']}_{$name}";
}

$post = get_post($post_id);
?>

<input
  id="id_field_<?= $name ?>"
  name="<?= $name ?>"
  type="<?= $type ?>"
  value="<?= htmlspecialchars($post->__get($name)) ?>"
  style="width: 100%;"
  <?= $placeholder ? 'placeholder="' . $placeholder . '"' : '' ?>
  <?= $required ? 'required' : '' ?>>
