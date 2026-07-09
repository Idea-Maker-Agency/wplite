<?php

namespace WPLite\Utils;

use WP_Post;

defined('ABSPATH') || exit;

class CustomFields
{
  /**
   * Groups array.
   *
   * @access private
   *
   * @since 1.0.1
   */
  private $groups = [];

  /**
   * Init.
   *
   * @since 1.0.0
   */
  public function init()
  {
    add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
    add_action('save_post', [$this, 'handle_save'], 10, 2);
    add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
  }

  /**
   * Enqueue assets.
   *
   * @since 1.0.0
   */
  public function enqueue_assets()
  {
    wp_enqueue_script(
      'alpine-ajax',
      THEME_DIR_URI . '/assets/vendor/alpine-ajax/js/alpine-ajax.min.js',
      [],
      '0.12.1',
      [
        'strategy'  => 'defer',
        'in_footer' => false,
      ]
    );
    wp_enqueue_script(
      'alpinejs-sort',
      THEME_DIR_URI . '/assets/vendor/alpinejs/js/alpinejs-sort.min.js',
      [],
      '3.14.9',
      [
        'strategy'  => 'defer',
        'in_footer' => false,
      ]
    );
    wp_enqueue_script(
      'alpinejs',
      THEME_DIR_URI . '/assets/vendor/alpinejs/js/alpinejs.min.js',
      [],
      '3.14.3',
      [
        'strategy'  => 'defer',
        'in_footer' => false,
      ]
    );
  }

  /**
   * Set the custom field groups.
   *
   * @param array $groups The array of custom field groups.
   *
   * @since 1.0.0
   */
  public function set_groups(array $groups)
  {
    $this->groups = $groups;
  }

  /**
   * Add the meta boxes.
   *
   * @since 1.0.0
   */
  public function add_meta_boxes()
  {
    global $post;

    if (empty($this->groups)) {
      return;
    }

    foreach ($this->groups as $group) {
      add_meta_box(
        $group['name'],
        $group['title'],
        [&$this, 'render_meta_boxes'],
        $post->post_type
      );
    }
  }

  /**
   * Render fields.
   *
   * @param WP_Post $post        The WP post object.
   * @param array   $fields      The array of fields.
   * @param string  $parent_name The parent field name.
   *
   * @return void
   */
  public function render_fields(
    WP_Post $post,
    array $fields = [],
    string $parent_name = ''
  ): void {
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
              class="post-attributes-label">
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
   * Extend fields.
   *
   * @param array $fields  The array of fields.
   * @param mixed $extends Whether a string or array of strings of custom field groups.
   *
   * @return array
   */
  public static function extend_fields(array $fields, mixed $extends): array
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

  /**
   * Render the meta box fields.
   *
   * @param WP_Post $post The post object.
   * @param array   $args The array of meta box arguments.
   *
   * @since 1.0.0
   */
  public function render_meta_boxes(WP_Post $post, array $args)
  {
    $column = array_column($this->groups, 'name');
    $index  = array_search($args['id'], $column);

    if (! isset($this->groups[$index])) {
      return;
    }

    $name    = $this->groups[$index]['name'];
    $fields  = $this->groups[$index]['fields']  ?? [];
    $extends = $this->groups[$index]['extends'] ?? null;

    if ($extends) {
      $fields = self::extend_fields($fields, $extends);
    }

    if (empty($fields)) {
      return;
    }

    $this->render_fields($post, $fields, $name);
  }

  /**
   * Get field value.
   *
   * @param string  $name           The field name.
   * @param string  $fallback_value The fallback value.
   * @param WP_Post $wp_post        The post object.
   *
   * @return mixed
   */
  public static function get_field(
    string $name,
    mixed $fallback_value = null,
    WP_Post $wp_post = null
  ): mixed {
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
   * Save field values.
   *
   * @param int   $post_id The post ID.
   * @param array $fields  The array of fields.
   *
   * @return void
   */
  public function save_fields(
    int $post_id,
    array $fields = [],
    string $parent_name = ''
  ): void {
    if (! empty($fields)) {
      foreach ($fields as $field) {
        $name = $field['name'];
        $type = $field['type'] ?? 'text';

        if ($parent_name) {
          $name = "{$parent_name}_{$name}";
        }

        $value = $_POST[$name] ?? '';

        if ('group' === $type) {
          $this->save_fields($post_id, $field['fields'] ?? [], $name);
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
              $this->save_fields($post_id, $field['fields'] ?? [], $key);
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
   * Handle meta box fields saving.
   *
   * @param int     $post_id The post ID.
   * @param WP_Post $post    The post object.
   *
   * @since 1.0.0
   */
  public function handle_save(int $post_id, WP_Post $post)
  {
    if (! current_user_can('edit_post', $post_id)) {
      return;
    }

    if (wp_is_post_autosave($post_id)) {
      return;
    }

    if (wp_is_post_revision($post_id)) {
      return;
    }

    if (empty($this->groups)) {
      return;
    }

    foreach ($this->groups as $group) {
      $name   = $group['name']   ?? '';
      $fields = $group['fields'] ?? [];

      $extends = $group['extends'] ?? null;

      if ($extends) {
        $fields = self::extend_fields($fields, $extends);
      }

      $this->save_fields($post_id, $fields, $name);
    }
  }
}
