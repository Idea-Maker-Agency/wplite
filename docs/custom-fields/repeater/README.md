# Repeater

Registers a repeater custom field.

## Register field

```yaml
my_page:
  group: "Section 1"
  fields:
    section_1_repeater:
      type: repeater
      label: "Repeater"
      fields:
        image:
          type: image
          label: "Featured Image"
          width: 100

        text:
          type: text
          label: "Text"
          width: 50

        url:
          type: url
          label: "URL"
          width: 50

        content:
          type: wpeditor
          label: "Content"
          width: 100
```

## Usage

```phtml
<?php
use WPLite\Utils\CustomFields;

$items = CustomFields::get_field('section_1_repeater'); // Returns array of key/value pairs (e.g. [ "image" => {{image_id}}, "text" => "", "url" => "", "content" => "" ] )

<?php if (! empty($items)) { ?>
  <?php foreach ($items as $item) { ?>
    // Your logic here...
  <?php } ?>
<?php }
```
