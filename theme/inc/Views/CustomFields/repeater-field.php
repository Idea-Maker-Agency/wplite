<?php
use WPLite\Utils\CustomFields;

$index = intval($args['index'] ?? 0);
$post_id = intval($args['post_id'] ?? null);
$name = $args['name'] ?? '';
$key = $args['key'] ?? '';
$fields = $args['fields'] ?? [];

$post = get_post($post_id);

$custom_fields = new CustomFields();
?>

<div
  x-data
  id="repeater-field-<?= $key ?>"
  class="stuffbox"
  style="margin-top: 14px; clear: both;"
  x-merge="replace">
  <div style="clear: both;">
    <div style="padding: 0 12px 12px; display: flex; flex-wrap: wrap; gap: 0.8rem;">
      <input
        name="<?= $key ?>_index"
        type="hidden"
        value="<?= $index ?>">
      <?php $custom_fields->render_fields($post, $fields, $key) ?>
    </div>
  </div>

  <button
    class="button button-link-delete"
    type="button"
    style="margin: 8px 0 12px; border-color: #d63638; float: right;"
    @click='$ajax("<?= esc_url(admin_url('admin-ajax.php')) ?>", {
      method: "post",
      body: {
        action: "custom_fields__repeater_remove",
        post_id: <?= $post->ID ?>,
        name: "<?= $name ?>",
        key: "<?= $key ?>",
      },
      target: "repeater-field-<?= $key ?>"
    })'
    @ajax:sent="$dispatch('<?= $name ?>:remove-key', '<?= $key ?>')">
    <?= __('Remove', THEME_TEXT_DOMAIN) ?>
  </button>
</div>
