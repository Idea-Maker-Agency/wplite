<?php
$post_id = intval($args['post_id'] ?? null);
$name    = $args['name'] ?? '';

if (! empty($args['parent_name'])) {
  $name = "{$args['parent_name']}_{$name}";
}

$attachment_data = null;

if ($post->__get($name)) {
  [$url, $width, $height] = wp_get_attachment_image_src((int) $post->__get($name), 'thumbnail');

  if ($url) {
    $attachment_data = [
      'id'    => $post->__get($name),
      'alt'   => '',
      'sizes' => [
        'thumbnail' => [
          'url'    => $url,
          'width'  => $width,
          'height' => $height,
        ]
      ]
    ];
  }
}

$post = get_post($post_id);
?>

<div
x-data='{
  frame: null,
  attachmentData: <?= $attachment_data ? json_encode($attachment_data) : 'null' ?>,

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
      href="<?= esc_url(get_upload_iframe_src('image', $post->ID)) ?>"
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
  name="<?= $name ?>"
  type="hidden" />
</div>
