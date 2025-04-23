# Input

Registers an input custom field.

## Register field

```yaml
- group: "Section 1"
  fields:
    - name: "section_1_title"
      type: "text"
      label: "Title"
      helpText: "Lorem ipsum dolor sit amet"
      required: true
      width: 100
```

## Usage

```phtml
<?php
use WPLite\Utils\CustomFields;

$title = CustomFields::get_field(
  'section_1_title',
  'Fallback title'
);

if ($title) {
?>
  <h1><?= $title ?></h1>
<?php
}
```
