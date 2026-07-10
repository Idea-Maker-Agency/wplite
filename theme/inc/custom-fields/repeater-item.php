<?php
$index   = (int) $args['index']      ?? 0;
$post_id = (int) $args['post_id']    ?? 0;
$name    = $args['name']             ?? '';
$key     = $args['key']              ?? '';
$fields  = $args['fields']           ?? [];
$extends = $args['field']['extends'] ?? null;

if ($extends) {
    $fields = wplite_cf_extend($fields, $extends);
}

$post = get_post($post_id);
?>

<div
	x-data
	id="repeater-field-<?php echo $key ?>"
	class="stuffbox"
	style="padding-left: 24px; margin-top: 14px; clear: both; position: relative;"
	x-merge="replace"
	x-sort:item="'<?php echo $key ?>'">
	<div
		x-sort:handle
		style="width: 24px; height: 100%; background-color: #c3c4c7; display: inline-flex; align-items: center; justify-content: center; position: absolute; top: 0; left: 0; cursor: move;">
		<?php echo $index ?>
	</div>

	<div style="clear: both;">
		<div style="padding: 0 12px 12px; margin: 0 -12px; display: flex; flex-wrap: wrap;">
			<?php wplite_cf_render($post, $fields, $key) ?>
		</div>
	</div>

	<button
		class="button button-link-delete"
		type="button"
		style="margin: 8px 0 12px; border-color: #d63638; float: right;"
		@click='$ajax("<?php echo esc_url(admin_url('admin-ajax.php')) ?>", {
		method: "post",
		body: {
			action: "custom_fields__repeater_remove",
			post_id: <?php echo $post->ID ?>,
			name: "<?php echo $name ?>",
			key: "<?php echo $key ?>",
		},
		target: "repeater-field-<?php echo $key ?>"
		})'
		@ajax:sent="$dispatch('<?php echo $name ?>:remove-key', '<?php echo $key ?>')">
		<?php echo __('Remove', THEME_TEXT_DOMAIN) ?>
	</button>
</div>