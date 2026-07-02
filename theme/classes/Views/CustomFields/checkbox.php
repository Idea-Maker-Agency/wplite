<?php
$post_id  = intval($args['post_id']);
$name     = $args['field']['name'];
$multiple = $args['field']['args']['multiple'] ?? false;
$required = $args['field']['args']['required'] ?? false;

$options = $args['field']['options'] ?? [];
$options = array_map(function ($option) {
  if (is_string($option)) {
    return [
      'label' => $option,
      'value' => $option,
    ];
  }

  return $option;
}, $options);

if (! empty($args['parent_name'])) {
  $name = "{$args['parent_name']}_{$name}";
}

$post = get_post($post_id);

if ($multiple) {
  ?>
  <ul>
    <?php foreach ($options as $option) { ?>
      <li>
        <label>
          <input
            id="id_field_<?= $name ?>"
            name="<?= $name ?>[]"
            value="<?= $option['value'] ?>"
            type="checkbox"
            <?php checked(in_array($option['value'], $post->__get($name) ?: [])) ?>
            <?= $required ? 'required' : '' ?>>

          <?= $option['label'] ?>
        </label>
      </li>
    <?php } ?>
  </ul>
<?php } else { ?>
  <input
    id="id_field_<?= $name ?>"
    name="<?= $name ?>"
    type="checkbox"
    value="on"
    <?php checked($post->__get($name), 'on', true) ?>
    <?= $required ? 'required' : '' ?>>
<?php
}
