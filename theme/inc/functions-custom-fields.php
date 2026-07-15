<?php

/**
 * Render custom fields.
 *
 * @param  WP_Post $post
 * @param  array   $fields
 * @param  string  $parent_name
 */
function wplite_cf_render(WP_Post $post, array $fields = [], string $parent_name = '')
{
    foreach ($fields as $field) {
        $name = $field['name'];
        $type = $field['type'] ?? 'text';

        if (! $name) {
            echo '<code>name</code> arg is required for this field.';

            continue;
        }

        ?>
		<div
			style="width: calc(<?= $field['args']['width'] ?? 100 ?>% - 24px); padding: 0 12px;"
			<?= ('hidden' === $type) ? 'hidden' : '' ?>>
			<?php if (! empty($field['label'])) { ?>
				<p class="post-attributes-label-wrapper page-template-label-wrapper">
					<label
						for="id_field_<?= $parent_name ?>_<?= $name ?>"
						class="post-attributes-label"
					>
						<?= $field['label'] ?>
					</label>
				</p>
			<?php } ?>

			<?php
            if ('group' === $type) {
                get_template_part('inc/custom-fields/group', null, [
                    'post_id'     => $post->ID,
                    'field'       => $field,
                    'parent_name' => $parent_name,
                ]);
            } elseif ('repeater' === $type) {
                get_template_part('inc/custom-fields/repeater', null, [
                    'post_id'     => $post->ID,
                    'field'       => $field,
                    'parent_name' => $parent_name,
                ]);
            } elseif ('select' === $type) {
                get_template_part('inc/custom-fields/select', null, [
                    'post_id'     => $post->ID,
                    'field'       => $field,
                    'parent_name' => $parent_name,
                ]);
            } elseif ('wpeditor' === $type) {
                get_template_part('inc/custom-fields/wpeditor', null, [
                    'post_id'     => $post->ID,
                    'field'       => $field,
                    'parent_name' => $parent_name,
                ]);
            } elseif ('image' === $type) {
                get_template_part('inc/custom-fields/image', null, [
                    'post_id'     => $post->ID,
                    'field'       => $field,
                    'parent_name' => $parent_name,
                ]);
            } elseif ('checkbox' === $type) {
                get_template_part('inc/custom-fields/checkbox', null, [
                    'post_id'     => $post->ID,
                    'field'       => $field,
                    'parent_name' => $parent_name,
                ]);
            } elseif ('radio' === $type) {
                get_template_part('inc/custom-fields/radio', null, [
                    'post_id'     => $post->ID,
                    'field'       => $field,
                    'parent_name' => $parent_name,
                ]);
            } elseif ('textarea' === $type) {
                get_template_part('inc/custom-fields/textarea', null, [
                    'post_id'     => $post->ID,
                    'field'       => $field,
                    'parent_name' => $parent_name,
                ]);
            } else {
                get_template_part('inc/custom-fields/input', null, [
                    'post_id'     => $post->ID,
                    'field'       => $field,
                    'parent_name' => $parent_name,
                ]);
            }
        ?>

        	<?php if (! empty($field['args']['helper_text'])) { ?>
			<p class="post-attributes-help-text">
				<?= esc_html($field['args']['helper_text']) ?>
			</p>
		<?php } ?>
	</div>
<?php
    }
}

/**
 * Get custom field value.
 *
 * @param  string       $name
 * @param  mixed        $fallback_value
 * @param  WP_Post|null $wp_post
 * @return mixed
 */
function wplite_cf_value(string $name, mixed $fallback_value = null, WP_Post $wp_post = null): mixed
{
    global $post;

    if (! $wp_post) {
        $wp_post = $post;
    }

    // Check if the field is a repeater
    if ($keys = $wp_post->__get("{$name}_keys")) {
        $fields = $wp_post->__get("{$name}_fields");

        $values = array_map(function ($key) use ($wp_post, $fields) {
            $values = array_map(function ($field) use ($wp_post, $key) {
                return [
                  $field => $wp_post->__get("{$key}_{$field}"),
                ];
            }, $fields);

            return array_reduce($values, function ($carry, $item) {
                return array_merge($item, $carry);
            }, []);
        }, $keys);

        return $values;
    } else {
        return $wp_post->__get($name) ?: $fallback_value;
    }
}

/**
 * Extend custom fields.
 *
 * @param array $fields  The array of fields.
 * @param mixed $extends Whether a string or array of strings of custom field groups.
 *
 * @return array
 */
function wplite_cf_extend(array $fields, mixed $extends): array
{
    $extends = is_array($extends) ? $extends : [$extends];

    $fields = array_reduce(
        array_reverse($extends),
        function (array $carry, string $extend) {
            $extend_file = locate_template("inc/custom-field-groups/{$extend}.json");

            if ($extend_file) {
                $extend_contents = file_get_contents($extend_file ?: '');
                $extend_fields   = json_decode($extend_contents, true) ?: [];

                $carry = array_merge($extend_fields, $carry);
            }

            return $carry;
        },
        $fields
    );

    return $fields;
}
?>