<?php

$field_groups = [];

/**
 * Init custom fields.
 */
function wplite_cf_init_template_custom_fields()
{
    $id     = (int) $_GET['post'] ?? 0;
    $action = $_POST['action']    ?? null;

    $front_page_id = get_option('page_on_front');

    if (! $id && 'editpost' === $action) {
        $id = (int) $_POST['post_ID'] ?? 0;
    }

    if (! $id) {
        return;
    }

    $page_template = get_post_meta($id, '_wp_page_template', true);

    if ($front_page_id == $id) {
        $json_file = locate_template("templates/front-page/front-page.json")
            ?: locate_template("templates/front-page.json");

        remove_post_type_support('page', 'editor');
    } else {
        $post_type = get_post_field('post_type', $id);
        $post_name = get_post_field('post_name', $id);

        if (empty($page_template) || 'default' === $page_template) {
            if ('page' === $post_type) {
                $ancestors = get_post_ancestors($id);

                $nested_path = array_reduce(
                    array_reverse($ancestors),
                    function (string $path, int $ancestor_id) {
                        $slug = get_post_field('post_name', $ancestor_id);

                        return "{$slug}/{$path}";
                    },
                    $post_name
                );

                $page_template = locate_template("templates/{$nested_path}/{$post_name}.php");

                if (! $page_template) {
                    $page_template = locate_template("templates/{$post_name}/{$post_name}.php");
                }

                if (! $page_template) {
                    $page_template = locate_template("templates/{$post_name}.php");
                }
            } else {
                $page_template = locate_template("templates/single/{$post_type}/single-{$post_type}.php")
                    ?: locate_template("templates/single/single-{$post_type}.php");
            }

            $json_file = str_replace('.php', '.json', $page_template);
        } else {
            $json_file = locate_template(str_replace('.php', '.json', $page_template));
        }

        if ('page' === $post_type) {
            remove_post_type_support('page', 'editor');
        }
    }

    if (! $json_file) {
        return;
    }

    $json_contents = file_get_contents($json_file);
    $json_groups   = json_decode($json_contents, true);

    if (empty($json_groups)) {
        return;
    }

    global $field_groups;
    $field_groups = $json_groups;
}
add_action('admin_init', 'wplite_cf_init_template_custom_fields');

/**
 * Add the meta boxes.
 *
 * @since 1.0.0
 */
function wplite_cf_add_meta_boxes()
{
    global $post, $field_groups;

    if (empty($field_groups)) {
        return;
    }

    foreach ($field_groups as $group) {
        add_meta_box(
            $group['name'],
            $group['title'],
            '_wplite_cf_render_meta_boxes',
            $post->post_type
        );
    }
}
add_action('add_meta_boxes', 'wplite_cf_add_meta_boxes');

/**
 * Render the meta box fields.
 *
 * @param  WP_Post $post
 * @param  array   $args
 */
function _wplite_cf_render_meta_boxes(WP_Post $post, array $args)
{
    global $field_groups;

    $column = array_column($field_groups, 'name');
    $index  = array_search($args['id'], $column);

    if (! isset($field_groups[$index])) {
        return;
    }

    $name    = $field_groups[$index]['name'];
    $fields  = $field_groups[$index]['fields']  ?? [];
    $extends = $field_groups[$index]['extends'] ?? null;

    if ($extends) {
        $fields = wplite_cf_extend($fields, $extends);
    }

    if (empty($fields)) {
        return;
    }

    _wplite_cf_render_fields($post, $fields, $name);
}

/**
 * Render custom fields.
 *
 * @param  WP_Post $post
 * @param  array   $fields
 * @param  string  $parent_name
 */
function _wplite_cf_render_fields(WP_Post $post, array $fields = [], string $parent_name = ''): void
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

        if (! empty($field['args']['helper_text'])) {
            ?>
			<p class="post-attributes-help-text">
				<?= esc_html($field['args']['helper_text']) ?>
			</p>
		<?php } ?>
	</div>
	<?php
    }
}

/**
   * Handle meta box fields saving.
   *
   * @param int     $post_id The post ID.
   * @param WP_Post $post    The post object.
   *
   * @since 1.0.0
   */
function wplite_cf_on_save(int $post_id, WP_Post $post)
{
    global $field_groups;

    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    if (wp_is_post_autosave($post_id)) {
        return;
    }

    if (wp_is_post_revision($post_id)) {
        return;
    }

    if (empty($field_groups)) {
        return;
    }

    foreach ($field_groups as $group) {
        $name   = $group['name']   ?? '';
        $fields = $group['fields'] ?? [];

        $extends = $group['extends'] ?? null;

        if ($extends) {
            $fields = wplite_cf_extend($fields, $extends);
        }

        _wplite_cf_save_fields($post_id, $fields, $name);
    }
}
add_action('save_post', 'wplite_cf_on_save', 10, 2);

/**
 * Save field values.
 *
 * @param  int    $post_id
 * @param  array  $fields
 * @param  string $parent_name
 */
function _wplite_cf_save_fields(int $post_id, array $fields = [], string $parent_name = '')
{
    if (! empty($fields)) {
        foreach ($fields as $field) {
            $name = $field['name'];
            $type = $field['type'] ?? 'text';

            if ($parent_name) {
                $name = "{$parent_name}_{$name}";
            }

            $value = $_POST[$name] ?? '';

            if ('group' === $type) {
                _wplite_cf_save_fields($post_id, $field['fields'] ?? [], $name);
            } elseif ('repeater' === $type) {
                $sub_fields = array_column($field['fields'] ?? [], 'name');

                // Filter keys with non-empty fields
                $keys = json_decode(stripslashes($_POST["{$name}_keys"] ?? ''), true) ?: [];

                $keys = array_filter($keys, function ($key) use ($sub_fields) {
                    $valid_fields = array_filter($sub_fields, function ($sub_field) use ($key) {
                        $value = $_POST["{$key}_{$sub_field}"];

                        return ! empty($value) && "false" !== $value;
                    });

                    return ! empty($valid_fields);
                });

                if (! empty($keys)) {
                    foreach ($keys as $key) {
                        _wplite_cf_save_fields($post_id, $field['fields'] ?? [], $key);
                    }

                    update_post_meta($post_id, "{$name}_keys", $keys);
                    update_post_meta($post_id, "{$name}_fields", $sub_fields);
                } else {
                    delete_post_meta($post_id, "{$name}_keys"); // IMPORTANT: Prevent saving empty keys to optimize DB
                    delete_post_meta($post_id, "{$name}_fields"); // IMPORTANT: Prevent saving empty keys to optimize DB
                }
            } else {
                if (! empty($value) && 'false' !== $value) {
                    update_post_meta($post_id, $name, $value);
                } else {
                    delete_post_meta($post_id, $name); // IMPORTANT: Prevent saving falsy value to optimize DB
                }
            }
        }
    }
}

/**
 * Enqueue custom fields assets.
 *
 * @since 1.0.0
 */
function wplite_cf_assets()
{
    wp_enqueue_script(
        'alpine-ajax',
        THEME_DIR_URI . '/assets/vendor/alpine-ajax/js/alpine-ajax.min.js',
        [],
        '0.12.1',
        ['strategy'  => 'defer','in_footer' => false,]
    );
    wp_enqueue_script(
        'alpinejs-sort',
        THEME_DIR_URI . '/assets/vendor/alpinejs/js/alpinejs-sort.min.js',
        [],
        '3.14.9',
        ['strategy'  => 'defer','in_footer' => false,]
    );
    wp_enqueue_script(
        'alpinejs',
        THEME_DIR_URI . '/assets/vendor/alpinejs/js/alpinejs.min.js',
        [],
        '3.14.3',
        ['strategy'  => 'defer','in_footer' => false,]
    );
}
add_action('admin_enqueue_scripts', 'wplite_cf_assets');
?>