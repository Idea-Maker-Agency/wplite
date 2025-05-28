<?php
$post_id  = (int) $args['post_id']     ?? 0;
$name     = $args['name']              ?? '';
$required = $args['field']['required'] ?? false;

if (! empty($args['parent_name'])) {
  $name = "{$args['parent_name']}_{$name}";
}

$post = get_post($post_id);
?>

<input
  id="id_field_<?= $name ?>"
  name="<?= $name ?>"
  type="checkbox"
  value="on"
  <?php checked($post->__get($name), 'on', true) ?>
  <?= $required ? 'required' : '' ?>>
