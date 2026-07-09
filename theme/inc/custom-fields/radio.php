<?php
$post_id  = intval($args['post_id']);
$name     = $args['field']['name'];
$value    = $args['field']['value']            ?? '';
$options  = $args['field']['options']          ?? [];
$required = $args['field']['args']['required'] ?? false;

if (! empty($args['parent_name'])) {
  $name = "{$args['parent_name']}_{$name}";
}

$post = get_post($post_id);

if (! empty($options)) {
  foreach ($options as $key => $option) {
    ?>
    <label
      for="id_field_<?= $name ?>-<?= $key ?>"
      style="margin-right: 0.75rem;">
      <input
        id="id_field_<?= $name ?>-<?= $key ?>"
        name="<?= $name ?>"
        value="<?= $option['value'] ?>"
        type="radio"
        <?php checked($post->__get($name), $option['value'], true) ?>
        <?= $required ? 'required' : '' ?>>

      <span>
        <?= $option['label'] ?>
      </span>
    </label>
<?php
  }
}
