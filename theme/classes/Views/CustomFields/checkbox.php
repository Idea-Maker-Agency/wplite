<?php
$post_id  = (int) $args['post_id']     ?? 0;
$name     = $args['name']              ?? '';
$multiple = $args['field']['multiple'] ?? false;
$required = $args['field']['required'] ?? false;

if (! empty($args['parent_name'])) {
  $name = "{$args['parent_name']}_{$name}";
}

$options  = $args['field']['options']  ?? [];
$options  = array_map(function ($option) {
  if (is_string($option)) {
    return [
      'label' => $option,
      'value' => $option,
    ];
  }

  return $option;
}, $options);

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
            type="checkbox"
            value="<?= $option['value'] ?>"
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
