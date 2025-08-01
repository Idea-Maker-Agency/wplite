<?php
use WPLite\Utils\CustomFields;

$post_id = intval($args['post_id']);
$name    = $args['field']['name'];
$fields  = $args['field']['fields'] ?? [];
$extends = $args['field']['extends'] ?? null;

if ($extends) {
  $extends_file = locate_template("lib/custom-field-groups/{$extends}.json");

  if ($extends_file) {
    $extends_contents = file_get_contents($extends_file);
    $extends_fields = json_decode($extends_contents, true) ?: [];

    $fields = array_merge($extends_fields, $fields);
  }
}

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
