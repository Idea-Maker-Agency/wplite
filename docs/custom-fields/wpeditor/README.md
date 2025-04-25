# WPEditor

Registers a wysiwyg custom field.

## Register field

```yaml
my_page:
  group: "Section 1"
  fields:
    section_1_content:
      type: wpeditor
      label: "Content"
      helpText: "Lorem ipsum dolor sit amet"
      width: 100
```

## Usage

```phtml
<?php
use WPLite\Utils\CustomFields;

$content = CustomFields::get_field(
  'section_1_content',
  'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantiumo'
);
?>

<?= wpautop($content) ?>
```
