<?php
$post_id = intval($args['post_id'] ?? null);
$name = $args['field']['name'] ?? '';
$fields = $args['field']['fields'] ?? [];

if (! empty($args['parent_name'])) {
  $name = "{$args['parent_name']}_{$name}";
}

$keys = get_post_meta($post_id, "{$name}_keys", true) ?: ["{$name}_0"];

$items = array_map(function ($key) use ($post_id) {
  $index = get_post_meta($post_id, "{$key}_index", true);

  return [
    'index' => $index,
    'key' => $key,
  ];
}, array_values($keys));

usort($items, function ($a, $b) {
  return $a['index'] - $b['index'];
});
?>

<div
  x-data='{
    keys: <?= json_encode($keys) ?>,
  }'
  class="postbox"
  style="margin-bottom: 0;"
  @<?= $name ?>:remove-key="() => {
    const index = keys.indexOf($event.detail)

    keys.splice(index, 1)
  }">
  <div
    class="inside"
    style="margin-top: 0;">
    <input
      name="<?= $name ?>_keys"
      type="hidden"
      :value="JSON.stringify(keys)">

    <div
      id="repeater-fields-<?= $name ?>"
      x-merge="append">
      <?php foreach ($items as $item) { ?>
        <?php get_template_part('inc/Views/CustomFields/repeater', 'field', [
          'index' => $item['index'],
          'post_id' => $post_id,
          'name' => $name,
          'key' => $item['key'],
          'fields' => $fields,
        ]) ?>
      <?php } ?>
    </div>

    <div style="clear: both;"></div>

    <button
      id="repeater-add-new-<?= $name ?>"
      class="button button-primary"
      type="button"
      @click='$ajax("<?= esc_url(admin_url('admin-ajax.php')) ?>", {
        method: "post",
        body: {
          action: "custom_fields__repeater_add",
          post_id: <?= $post_id ?>,
          name: "<?= $name ?>",
          fields: <?= json_encode($fields) ?>,
          keys,
        },
        target: "repeater-fields-<?= $name ?>"
      })'
      @ajax:before="() => {
        const key = keys[keys.length - 1]
        const index = parseInt(key.slice(key.lastIndexOf('_') + 1))

        keys.push(`<?= $name ?>_${index + 1}`)
      }">
      <?= __('Add New', THEME_TEXT_DOMAIN) ?>
    </button>
  </div>
</div>
