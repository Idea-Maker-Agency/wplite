<?php
use WPLite\Utils\CustomFields;

$post_id = intval($args['post_id'] ?? null);
$name = $args['field']['name'] ?? '';
$fields = $args['field']['fields'] ?? [];

if (! empty($args['parent_name'])) {
  $name = "{$args['parent_name']}_{$name}";
}

$post = get_post($post_id);

$custom_fields = new CustomFields();
?>

<?php if (! empty($custom_fields)) { ?>
  <div
    class="postbox"
    style="margin-bottom: 0;">
    <div
      class="inside"
      style="margin: 0 -12px; display: flex; flex-wrap: wrap;">
      <?php $custom_fields->render_fields($post, $fields, $name) ?>
    </div>
  </div>
<?php }
