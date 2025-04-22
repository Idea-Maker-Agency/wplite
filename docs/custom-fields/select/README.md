# Select

Registers an select dropdown custom field.

## Register field

```yaml
- group: "Section 1"
  fields:
    - name: "section_1_status"
      type: "select"
      label: "Status"
      options:
        - label: "Active"
          value: "active"

        - label: "Inactive"
          value: "inactive"
      helpText: "Lorem ipsum dolor sit amet"
      required: true
      width: 50
```

## Usage

```phtml
<?php
use WPLite\Utils\CustomFields;

$status = CustomFields::get_field(
  'section_1_status',
  'active'
);

if ($active) {
?>
  // Your logic here...
<?php
}
```
