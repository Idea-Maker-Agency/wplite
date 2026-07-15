<?php
$post_id     = intval($args['post_id']);
$name        = $args['field']['name'];
$type        = $args['field']['type']                ?? 'text';
$required    = $args['field']['args']['required']    ?? false;
$placeholder = $args['field']['args']['placeholder'] ?? '';

if (! empty($args['parent_name'])) {
    $name = "{$args['parent_name']}_{$name}";
}

$post = get_post($post_id);
?>

<input
	id="id_field_<?php echo $name ?>"
	name="<?php echo $name ?>"
	type="<?php echo $type ?>"
	value="<?php echo htmlspecialchars($post->__get($name)) ?>"
	style="width: 100%;"
	<?php echo $placeholder ? 'placeholder="' . $placeholder . '"' : '' ?>
	<?php echo $required ? 'required' : '' ?>>