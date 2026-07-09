<?php
$post_id  = intval($args['post_id']);
$name     = $args['field']['name'];
$options  = $args['field']['options']          ?? [];
$multiple = $args['field']['args']['multiple'] ?? false;
$required = $args['field']['args']['required'] ?? false;
$source   = $args['field']['args']['source']   ?? null;

if (! empty($args['parent_name'])) {
  $name = "{$args['parent_name']}_{$name}";
}

// Use post type/users as source of options
if ($source) {
  if (post_type_exists($source)) {
    $posts = get_posts([
      'post_type'      => $source,
      'posts_per_page' => -1,
    ]);

    $options = array_map(function ($post) {
      return [
        'label' => $post->post_title,
        'value' => $post->ID,
      ];
    }, $posts);
  } elseif ('users' === $source) {
    $users = get_users();

    $options = array_map(function ($user) {
      return [
        'label' => $user->display_name,
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
  style="width: 100%;"
  <?= $multiple ? 'multiple' : '' ?>
  <?= $required ? 'required' : '' ?>>
  <option disabled>
    <?= __('Select option', THEME_TEXT_DOMAIN) ?>
  </option>

  <?php
  if (! empty($options)) {
    foreach ($options as $option) {
      ?>
      <option
        value="<?= $option['value'] ?>"
        <?php
            selected(
              $multiple ? in_array($option['value'], $post->__get($name) ?: []) : $post->__get($name),
              $multiple ? true : $option['value'],
              true
            );
      ?>>
        <?= $option['label'] ?>
      </option>
  <?php
    }
  }
?>
</select>
