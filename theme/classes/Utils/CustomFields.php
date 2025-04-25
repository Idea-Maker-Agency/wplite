<?php

namespace WPLite\Utils;

if (! defined('ABSPATH')) die;

use WP_Post;

class CustomFields
{
  /**
   * Fields array.
   *
   * @access private
   *
   * @since 1.0.0
   */
  private $fields = [];

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
        'strategy' => 'defer',
        'in_footer' => false,
      ]
    );
    wp_enqueue_script(
      'alpinejs-sort',
      THEME_DIR_URI . '/assets/vendor/alpinejs/js/alpinejs-sort.min.js',
      [],
      '3.14.9',
      [
        'strategy' => 'defer',
        'in_footer' => false,
      ]
    );
    wp_enqueue_script(
      'alpinejs',
      THEME_DIR_URI . '/assets/vendor/alpinejs/js/alpinejs.min.js',
      [],
      '3.14.3',
      [
        'strategy' => 'defer',
        'in_footer' => false,
      ]
    );
  }

  /**
   * Set the custom fields.
   *
   * @param array     $fields       The array of custom fields.
   *
   * @since 1.0.0
   */
  public function set_fields(array $fields)
  {
    $this->fields = $fields;
  }

  /**
   * Add the meta boxes.
   *
   * @since 1.0.0
   */
  public function add_meta_boxes()
  {
    if (empty($this->fields)) return;

    foreach ($this->fields as $id => $field) {
      $title = $field['group'];

      add_meta_box($id, $title, [&$this, 'render_meta_boxes'], 'page');
    }
  }

  /**
   * Render fields.
   *
   * @param WP_Post   $post         The WP post object.
   * @param array     $fields       The array of fields.
   * @param string    $parent_name  The parent field name.
   *
   * @return void
   */
  public function render_fields(
    WP_Post $post,
    array $fields = [],
    string $parent_name = ''
  ): void {
    foreach ($fields as $name => $field) {
      $type = $field['type'] ?? 'text';
      $label = $field['label'] ?? '';
      $helper_text = $field['helper_text'] ?? '';
      $width = $field['width'] ?? 100;
    ?>
      <div style="width: calc(<?= $width ?>% - 24px); padding: 0 12px;">
        <?php if ($label) { ?>
          <p class="post-attributes-label-wrapper page-template-label-wrapper">
            <label
              for="id_field_<?= $name ?>"
              class="post-attributes-label">
              <?= $label ?>
            </label>
          </p>
        <?php } ?>

        <?php if ('group' === $type) { ?>
          <?php get_template_part('classes/Views/CustomFields/group', null, [
            'post_id' => $post->ID,
            'field' => $field,
            'name' => $name,
            'parent_name' => $parent_name,
          ]) ?>
        <?php } elseif ('repeater' === $type) { ?>
          <?php get_template_part('classes/Views/CustomFields/repeater', null, [
            'post_id' => $post->ID,
            'field' => $field,
            'name' => $name,
            'parent_name' => $parent_name,
          ]) ?>
        <?php } elseif ('select' === $type) { ?>
          <?php get_template_part('classes/Views/CustomFields/select', null, [
            'post_id' => $post->ID,
            'field' => $field,
            'name' => $name,
            'parent_name' => $parent_name,
          ]) ?>
        <?php } elseif ('wpeditor' === $type) { ?>
          <?php get_template_part('classes/Views/CustomFields/wpeditor', null, [
            'post_id' => $post->ID,
            'field' => $field,
            'name' => $name,
            'parent_name' => $parent_name,
          ]) ?>
        <?php } elseif ('image' === $type) { ?>
          <?php get_template_part('classes/Views/CustomFields/image', null, [
            'post_id' => $post->ID,
            'field' => $field,
            'name' => $name,
            'parent_name' => $parent_name,
          ]) ?>
        <?php } elseif ('checkbox' === $type) { ?>
          <?php get_template_part('classes/Views/CustomFields/checkbox', null, [
            'post_id' => $post->ID,
            'field' => $field,
            'name' => $name,
            'parent_name' => $parent_name,
          ]) ?>
        <?php } elseif ('radio' === $type) { ?>
          <?php get_template_part('classes/Views/CustomFields/radio', null, [
            'post_id' => $post->ID,
            'field' => $field,
            'name' => $name,
            'parent_name' => $parent_name,
          ]) ?>
        <?php } elseif ('textarea' === $type) { ?>
          <?php get_template_part('classes/Views/CustomFields/textarea', null, [
            'post_id' => $post->ID,
            'field' => $field,
            'name' => $name,
            'parent_name' => $parent_name,
          ]) ?>
        <?php } else { ?>
          <?php get_template_part('classes/Views/CustomFields/input', null, [
            'post_id' => $post->ID,
            'field' => $field,
            'name' => $name,
            'parent_name' => $parent_name,
          ]) ?>
        <?php } ?>

        <?php if ($helper_text) { ?>
          <p class="post-attributes-help-text">
            <?= $helper_text ?>
          </p>
        <?php } ?>
      </div>
    <?php
    }
  }

  /**
   * Render the meta box fields.
   *
   * @param WP_Post   $post     The post object.
   * @param array     $args     The array of meta box arguments.
   *
   * @since 1.0.0
   */
  public function render_meta_boxes(WP_Post $post, array $args)
  {
    $field = $this->fields[$args['id']];
    $fields = $field['fields'] ?? [];

    if (empty($fields)) return;

    $this->render_fields($post, $fields);
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
   * @param int     $post_id        The post ID.
   * @param array   $fields         The array of fields.
   *
   * @return void
   */
  public function save_fields(
    int $post_id,
    array $fields = [],
    string $parent_name = ''
  ): void {
    if (! empty($fields)) {
      foreach ($fields as $name => $field) {
        $type = $field['type'] ?? 'text';

        if ($parent_name) {
          $name = "{$parent_name}_{$name}";
        }

        $value = $_POST[$name] ?? '';

        if ('group' === $type) {
          $this->save_fields($post_id, $field['fields'], $name);
        } elseif ('repeater' === $type) {
          $sub_fields = array_keys($field['fields']);

          // Filter keys with non-empty fields
          $keys = json_decode(stripslashes($_POST["{$name}_keys"] ?? ''), true);

          $keys = array_filter($keys, function ($key) use ($sub_fields) {
            $valid_fields = array_filter($sub_fields, function ($sub_field) use ($key) {
              $value = $_POST["{$key}_{$sub_field}"];

              return ! empty($value) && "false" !== $value;
            });

            return ! empty($valid_fields);
          });

          if (! empty($keys)) {
            foreach ($keys as $key) {
              $this->save_fields($post_id, $field['fields'], $key);
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
   * @param int     $post_id      The post ID.
   * @param WP_Post $post         The post object.
   *
   * @since 1.0.0
   */
  public function handle_save(int $post_id, WP_Post $post)
  {
    if (! current_user_can('edit_post', $post_id)) return;

    if (wp_is_post_autosave($post_id)) return;

    if (wp_is_post_revision($post_id)) return;

    if (empty($this->fields)) return;

    foreach ($this->fields as $field) {
      $fields = $field['fields'] ?? [];

      $this->save_fields($post_id, $fields);
    }
  }
}
