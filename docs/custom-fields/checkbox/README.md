# Checkbox

Registers a checkbox custom field.

## Register field

```yaml
my_page:
  group: "Section 1"
  fields:
    section_1_is_visible:
      type: checkbox
      label: "Is visible?"
      width: 100
```

## Usage

```phtml
<?php
use WPLite\Utils\CustomFields;

$is_visible = CustomFields::get_field(
  'section_1_is_visible',
  'on'
);

if ('on' === $is_visible) {
?>
  // Your logic here...
<?php
}
```
