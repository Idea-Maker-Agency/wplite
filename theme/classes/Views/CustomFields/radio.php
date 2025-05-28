<?php
$post_id  = (int) $args['post_id']     ?? 0;
$name     = $args['name']              ?? '';
$value    = $args['field']['value']    ?? '';
$options  = $args['field']['options']  ?? [];
$required = $args['field']['required'] ?? false;

if (! empty($args['parent_name'])) {
  $name = "{$args['parent_name']}_{$name}";
}

$post = get_post($post_id);
?>

<?php if (! empty($options)) { ?>
  <?php foreach ($options as $key => $option) { ?>
    <label
      for="id_field_<?= $name ?>-<?= $key ?>"
      style="margin-right: 0.75rem;">
      <input
        id="id_field_<?= $name ?>-<?= $key ?>"
        name="<?= $name ?>"
        type="radio"
        value="<?= $option['value'] ?>"
        <?php checked($post->__get($name), $option['value'], true) ?>
        <?= $required ? 'required' : '' ?>>

      <span>
        <?= $option['label'] ?>
      </span>
    </label>
  <?php } ?>
<?php }
