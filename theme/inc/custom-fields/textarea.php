<?php
$post_id     = (int) $args['post_id'];
$name        = $args['field']['name'];
$required    = $args['field']['args']['required']    ?? false;
$placeholder = $args['field']['args']['placeholder'] ?? '';

if (! empty($args['parent_name'])) {
    $name = "{$args['parent_name']}_{$name}";
}

$post = get_post($post_id);
?>

<textarea
	id="id_field_<?php echo $name ?>"
	name="<?php echo $name ?>"
	style="width: 100%;"
	<?php echo $placeholder ? 'placeholder="' . $placeholder . '"' : '' ?>
	<?php echo $required ? 'required' : '' ?>><?php echo htmlspecialchars($post->__get($name)) ?></textarea>
