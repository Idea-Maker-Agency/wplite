<?php
use WPLite\Utils\CustomFields;

$post_id = intval($args['post_id']);
$name    = $args['field']['name'];
$fields  = $args['field']['fields'] ?? [];
$extends = $args['field']['extends'] ?? null;

if ($extends) {
	$extends = is_array($extends) ? $extends : [$extends];

	$fields = array_reduce(
		array_reverse($extends),
		function (array $carry, string $extend) {
			$extend_file = locate_template("lib/custom-field-groups/{$extend}.json");

			if ($extend_file) {
				$extend_contents = file_get_contents($extend_file ?: '');
				$extend_fields = json_decode($extend_contents, true) ?: [];

				$carry = array_merge($extend_fields, $carry);
			}

			return $carry;
		},
		$fields
	);
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
