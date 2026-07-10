<?php
$post_id = intval($args['post_id']);
$name    = $args['field']['name'];
$fields  = $args['field']['fields']  ?? [];
$extends = $args['field']['extends'] ?? null;

if ($extends) {
    $fields = wplite_cf_extend($fields, $extends);
}

if (! empty($args['parent_name'])) {
    $name = "{$args['parent_name']}_{$name}";
}

$keys = get_post_meta($post_id, "{$name}_keys", true) ?: ["{$name}_0"];
?>

<div
	x-data='{
		keys: <?php echo json_encode($keys) ?>,

		get nextIndex() {
			const sortedKeys = this.keys.map((key) => {
				return parseInt(key.replace("<?php echo $name ?>_", ""))
			}).sort((a, b) => a - b)

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
	<?php echo $name ?>>
	<div
		class="inside"
		style="margin-top: 0;"
	>
		<input
			name="<?php echo $name ?>_keys"
			type="hidden"
			:value="JSON.stringify(keys)"
		>

		<div
			id="repeater-fields-<?php echo $name ?>"
			x-merge="append"
			x-sort.ghost="onSort"
		>
			<?php
      foreach ($keys as $index => $key) {
          get_template_part('inc/custom-fields/repeater', 'item', [
            'index'   => $index,
            'post_id' => $post_id,
            'name'    => $name,
            'key'     => $key,
            'fields'  => $fields,
          ]);
      }
?>
		</div>

		<div style="clear: both;"></div>

		<button
			id="repeater-add-new-<?php echo $name ?>"
			class="button button-primary"
			type="button"
			@click='$ajax("<?php echo esc_url(admin_url('admin-ajax.php')) ?>", {
				method: "post",
				body: {
					action: "custom_fields__repeater_add",
					post_id: <?php echo $post_id ?>,
					name: "<?php echo $name ?>",
					index: keys.length,
					fields: <?php echo json_encode($fields) ?>,
					keys,
				},
				target: "repeater-fields-<?php echo $name ?>"
      		})'
			@ajax:before="keys.push(`<?php echo $name ?>_${nextIndex}`)"
		>
			<?php echo __('Add New', THEME_TEXT_DOMAIN) ?>
		</button>
	</div>
</div>