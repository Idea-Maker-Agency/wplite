<?php
$post_id = intval($args['post_id'] ?? null);
$name = $args['name'] ?? '';
$fields = $args['field']['fields'] ?? [];

if (! empty($args['parent_name'])) {
  $name = "{$args['parent_name']}_{$name}";
}

$keys = get_post_meta($post_id, "{$name}_keys", true) ?: ["{$name}_0"];
?>

<div
  x-data='{
    keys: <?= json_encode($keys) ?>,

    get nextIndex() {
      const sortedKeys = this.keys.map((key) => {
        return parseInt(key.replace("<?= $name ?>_", ""))
      }).sort()

      return sortedKeys[sortedKeys.length - 1] + 1
    },

    onSort: (key, position) => {
      const index = $data.keys.indexOf(key)

      $data.keys.splice(index, 1)
      $data.keys.splice(position, 0, key)
    }
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
      x-merge="append"
      x-sort.ghost="onSort">
      <?php foreach ($keys as $index => $key) { ?>
        <?php get_template_part('classes/Views/CustomFields/repeater', 'item', [
          'index' => $index,
          'post_id' => $post_id,
          'name' => $name,
          'key' => $key,
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
          index: keys.length,
          fields: <?= json_encode($fields) ?>,
          keys,
        },
        target: "repeater-fields-<?= $name ?>"
      })'
      @ajax:before="keys.push(`<?= $name ?>_${nextIndex}`)">
      <?= __('Add New', THEME_TEXT_DOMAIN) ?>
    </button>
  </div>
</div>
