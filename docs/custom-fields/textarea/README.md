# Textarea

Registers a textarea custom field.

## Register field

```yaml
- group: "Section 1"
  fields:
    - name: "section_1_description"
      type: "textarea"
      label: "Description"
      helpText: "Lorem ipsum dolor sit amet"
      required: true
      width: 100
```

## Usage

```phtml
<?php
use WPLite\Utils\CustomFields;

$description = CustomFields::get_field(
  'section_1_description',
  'Fallback description'
);

if ($description) {
?>
  <?= $description ?>
<?php
}
```
