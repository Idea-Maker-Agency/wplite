# Image

Registers a single image picker custom field.

## Register field

```yaml
my_page:
    group: "Section 1"
    fields:
        section_1_bg:
            type: image
            label: "Background image"
            helper_text: "Lorem ipsum dolor sit amet"
            width: 100
```

## Usage

```phtml
<?php
$bg_image_id = wplite_cf_value('section_1_bg');

<?php if ($bg_image_id) { ?>
  <img
    src="<?= wp_get_attachment_image_url($bg_image_id, [1920, 1080]) ?>"
    srcset="
      <?= wp_get_attachment_image_url($bg_image_id, [1920, 1080]) ?> 1920w,
      <?= wp_get_attachment_image_url($bg_image_id, [1024, 768]) ?> 1024w,
      <?= wp_get_attachment_image_url($bg_image_id, [320, 500]) ?> 320w"
    sizes="(min-width: 1920px) 1920px, (min-width: 1024px) 1024px, 100vw"
    width="1920"
    height="1080"
    alt="Section 1 image"
    decoding="async" />
<?php }
```
