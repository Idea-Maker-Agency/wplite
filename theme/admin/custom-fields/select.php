<?php
global $post;

$name = $args['field']['name'] ?? '';
$required = $args['field']['required'] ?? false;
$options = $args['field']['options'] ?? [];

if (! empty($args['parent_name'])) {
  $name = "{$args['parent_name']}_{$name}";
}
?>

<select
  id="id_field_<?= $name ?>"
  name="<?= $name ?>"
  class="postbox"
  <?= $required ? 'required' : ''?>>
  <option disabled>Select option</option>

  <?php if (! empty($options)) { ?>
    <?php foreach ($options as $option) { ?>
      <option
        value="<?= $option['value'] ?>"
        <?php selected($post->__get($name), $option['value'], true) ?>>
        <?= $option['label'] ?>
      </option>
    <?php } ?>
  <?php } ?>
</select>
