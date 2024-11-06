<?php

namespace WPLite;

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
    add_action('add_meta_boxes', [$this, 'addMetaBoxes']);
    add_action('save_post', [$this, 'handleSave'], 10, 2);
    add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
  }

  /**
   * Enqueue assets.
   *
   * @since 1.0.0
   */
  public function enqueueAssets()
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
   * @param array $fields Array of custom fields.
   *
   * @since 1.0.0
   */
  public function setFields(array $fields)
  {
    $this->fields = $fields;
  }

  /**
   * Add the meta boxes.
   *
   * @since 1.0.0
   */
  public function addMetaBoxes()
  {
    if (empty($this->fields)) return;

    foreach ($this->fields as $field) {
      $id = strtolower('id_' . $field['group']);
      $title = $field['group'];

      add_meta_box($id, $title, [&$this, 'renderMetaBoxFields'], 'page');
    }
  }

  /**
   * Render the meta box fields.
   *
   * @param WP_Post $post The post object.
   * @param array $args The array of meta box arguments.
   *
   * @since 1.0.0
   */
  public function renderMetaBoxFields(\WP_Post $post, array $args)
  {
    $title = $args['title'];

    $columns = array_column($this->fields, 'group');
    $index = array_search($title, $columns);

    $field = $this->fields[$index];

    if (empty($field['fields'])) return;

    foreach ($field['fields'] as $field) {
      $value = $post->__get($field['name']);

      $id = 'id_field_' . $field['name'];
      $name = $field['name'];
      $type = $field['type'];
  ?>
      <?php if (isset($field['label'])) { ?>
        <p class="post-attributes-label-wrapper page-template-label-wrapper">
          <label
            for="<?php echo $id ?>"
            class="post-attributes-label">
            <?php echo $field['label'] ?>
          </label>
        </p>
      <?php } ?>

      <?php if ('select' === $type) { ?>
        <select
          id="<?php echo $id ?>"
          name="<?php echo $name ?>"
          class="postbox"
          <?php echo ! empty($field['required']) ? 'required' : ''?>>
          <option disabled>Select option</option>

          <?php if (! empty($field['options'])) { ?>
            <?php foreach ($field['options'] as $option) { ?>
              <option
                value="<?php echo $option['value'] ?>"
                <?php selected($value, $option['value'], true) ?>>
                <?php echo $option['label'] ?>
              </option>
            <?php } ?>
          <?php } ?>
        </select>
      <?php } elseif ('wpeditor' === $type) { ?>
        <?php
          wp_editor(
            html_entity_decode($value),
            $id,
            [
              'media_buttons' => false,
              'textarea_name' => $name,
              'textarea_rows' => 10,
              'teeny' => true,
            ]
          )
        ?>
      <?php } elseif ('image' === $type) { ?>
        <?php
          $attachment_data = null;

          if ($value) {
            [$url, $width, $height] = wp_get_attachment_image_src((int) $value, 'thumbnail');

            if ($url) {
              $attachment_data = [
                'id' => $value,
                'alt' => '',
                'sizes' => [
                  'thumbnail' => [
                    'url' => $url,
                    'width' => $width,
                    'height' => $height,
                  ]
                ]
              ];
            }
          }
        ?>

        <div
          x-data='{
            frame: null,
            attachmentData: <?php echo $attachment_data ? json_encode($attachment_data) : 'null' ?>,

            get hasAttachment() {
              return !!this.attachmentData;
            },

            handleUpload() {
              if (this.frame) {
                this.frame.open();
              } else {
                this.frame = wp.media({
                  title: "Select or Upload Media Of Your Chosen Persuasion",
                  button: {
                    text: "Use this image"
                  },
                  multiple:false
                });

                this.frame.on("select", () => {
                  this.attachmentData = this.frame.state().get("selection").first().toJSON();
                });

                this.frame.open();
              }
            },
            handleRemove() {
              this.attachmentData = null;
            }
          }'
          x-init>
          <template x-if="hasAttachment">
            <div>
              <img
                :src="attachmentData.sizes.thumbnail.url"
                :alt="attachmentData.alt"
                :width="attachmentData.sizes.thumbnail.width"
                :height="attachmentData.sizes.thumbnail.height" />
            </div>
          </template>

          <p class="hide-if-no-js">
            <template x-if="!hasAttachment">
              <a
                :class="{
                  hidden: hasAttachment,
                }"
                href="<?php echo esc_url(get_upload_iframe_src('image', $post->ID)) ?>"
                role="button"
                @click.prevent="handleUpload">
                <?php _e('Select image') ?>
              </a>
            </template>

            <template x-if="hasAttachment">
              <a
                id="remove-post-thumbnail"
                :class="{
                  hidden: !hasAttachment,
                }"
                role="button"
                href
                @click.prevent="handleRemove">
                <?php _e('Remove image') ?>
              </a>
            </template>
          </p>

          <input
            :value="hasAttachment && attachmentData.id"
            name="<?php echo $name ?>"
            type="hidden" />
        </div>
      <?php } elseif ('checkbox' === $type) { ?>
        <input
          id="<?php echo $id ?>"
          name="<?php echo $name ?>"
          type="checkbox"
          value="on"
          <?php checked($value, 'on', true) ?>>
      <?php } else { ?>
        <input
          id="<?php echo $id ?>"
          name="<?php echo $name ?>"
          type="<?php echo $type ?: 'text' ?>"
          placeholder="<?php echo $field['placeholder'] ?? '' ?>"
          value="<?php echo $value ?? '' ?>"
          <?php echo ! empty($field['required']) ? 'required' : '' ?>>
      <?php } ?>

      <?php if (! empty($field['helpText'])) { ?>
        <p class="post-attributes-help-text">
          <?php echo $field['helpText'] ?>
        </p>
      <?php } ?>
    <?php
    }
  }

  /**
   * Handle meta box fields saving.
   *
   * @param int $post_id The post ID.
   * @param WP_Post $post The post object.
   *
   * @since 1.0.0
   */
  public function handleSave(int $post_id, \WP_Post $post)
  {
    if (! current_user_can('edit_post', $post_id)) return;

    if (wp_is_post_autosave($post_id)) return;

    if (wp_is_post_revision($post_id)) return;

    if (empty($this->fields)) return;

    foreach ($this->fields as $group) {
      if (! empty($group['fields'])) {
        foreach ($group['fields'] as $field) {
          $name = $field['name'];

          if (isset($_POST[$name])) {
            update_post_meta($post_id, $name, $_POST[$name]);
          }
        }
      }
    }
  }
}
