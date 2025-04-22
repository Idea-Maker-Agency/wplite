<?php
global $post;

$name = $args['field']['name'] ?? '';
$required = $args['field']['required'] ?? false;

if (! empty($args['parent_name'])) {
  $name = "{$args['parent_name']}_{$name}";
}
?>

<input
  id="id_field_<?= $name ?>"
  name="<?= $name ?>"
  type="checkbox"
  value="on"
  <?php checked($post->__get($name), 'on', true) ?>
  <?= $required ? 'required' : '' ?>>
