<?php
$post_id  = (int) $args['post_id']     ?? 0;
$name     = $args['name']              ?? '';
$multiple = $args['field']['multiple'] ?? false;
$required = $args['field']['required'] ?? false;
$options  = $args['field']['options']  ?? [];
$source   = $args['field']['post_type_source'];

if (! empty($args['parent_name'])) {
  $name = "{$args['parent_name']}_{$name}";
}

// Use post type/users as source of options
if (! empty($source)) {
  if (post_type_exists($source)) {
    $posts = get_posts([
      'post_type' => $source,
      'posts_per_page' => -1,
    ]);

    $options = array_map(function ($post) {
      return [
        'label' => $post->post_title,
        'value' => $post->ID,
      ];
    }, $posts);
  } else if ('users' === $source) {
    $users = get_users();

    $options = array_map(function ($user) {
      return [
        'label' => $post->display_name,
        'value' => $user->ID,
      ];
    }, $users);
  }
}

$post = get_post($post_id);
?>

<select
  id="id_field_<?= $name ?>"
  name="<?= $name ?><?= $multiple ? '[]' : '' ?>"
  class="postbox"
  <?= $multiple ? 'multiple' : '' ?>
  <?= $required ? 'required' : '' ?>>
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
