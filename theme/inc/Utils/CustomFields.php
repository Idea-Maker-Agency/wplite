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

    foreach ($this->fields as $field) {
      $id = strtolower('id_' . $field['group']);
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
    foreach ($fields as $field) {
      $type = $field['type'] ?? 'text';
      $name = $field['name'] ?? '';
      $label = $field['label'] ?? '';
      $help_text = $field['helpText'] ?? '';
      $width = $field['width'] ?? 100;

      if ($parent_name) {
        $name = "{$parent_name}_{$name}";
      }
    ?>
      <div style="width: calc(<?= $width ?>% - 0.4rem);">
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
          <?php $fields = $field['fields'] ?>

          <div class="postbox" style="margin-bottom: 0;">
            <div class="inside" style="margin-top: 0; display: flex; flex-wrap: wrap; gap: 0.8rem;">
              <?php $this->render_fields($post, $fields, $name) ?>
            </div>
          </div>
        <?php } elseif ('select' === $type) { ?>
          <?php get_template_part('inc/Views/CustomFields/select', null, [
            'post_id' => $post->ID,
            'field' => $field,
            'parent_name' => $parent_name,
          ]) ?>
        <?php } elseif ('wpeditor' === $type) { ?>
          <?php get_template_part('inc/Views/CustomFields/wpeditor', null, [
            'post_id' => $post->ID,
            'field' => $field,
            'parent_name' => $parent_name,
          ]) ?>
        <?php } elseif ('image' === $type) { ?>
          <?php get_template_part('inc/Views/CustomFields/image', null, [
            'post_id' => $post->ID,
            'field' => $field,
            'parent_name' => $parent_name,
          ]) ?>
        <?php } elseif ('checkbox' === $type) { ?>
          <?php get_template_part('inc/Views/CustomFields/checkbox', null, [
            'post_id' => $post->ID,
            'field' => $field,
            'parent_name' => $parent_name,
          ]) ?>
        <?php } elseif ('radio' === $type) { ?>
          <?php get_template_part('inc/Views/CustomFields/radio', null, [
            'post_id' => $post->ID,
            'field' => $field,
            'parent_name' => $parent_name,
          ]) ?>
        <?php } else { ?>
          <?php get_template_part('inc/Views/CustomFields/input', null, [
            'post_id' => $post->ID,
            'field' => $field,
            'parent_name' => $parent_name,
          ]) ?>
        <?php } ?>

        <?php if ($help_text) { ?>
          <p class="post-attributes-help-text">
            <?= $help_text ?>
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
    $title = $args['title'];

    $columns = array_column($this->fields, 'group');
    $index = array_search($title, $columns);

    $field = $this->fields[$index];
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

    return $wp_post->__get($name) ?: $fallback_value;
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
      foreach ($fields as $field) {
        $type = $field['type'] ?? 'text';
        $name = $field['name'] ?? '';

        if ($parent_name) {
          $name = "{$parent_name}_{$name}";
        }

        $value = $_POST[$name] ?? '';

        if ('group' === $type) {
          $sub_fields = $field['fields'];

          $this->save_fields($post_id, $sub_fields, $name);
        } else {
          update_post_meta(
            $post_id,
            $name,
            $value
          );
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

    foreach ($this->fields as $group) {
      $fields = $group['fields'] ?? [];

      $this->save_fields($post_id, $fields);
    }
  }
}
