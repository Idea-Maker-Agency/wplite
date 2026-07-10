# Select

Registers an select dropdown custom field.

## Register field

```yaml
my_page:
    group: "Section 1"
    fields:
        section_1_status:
            type: select
            label: "Status"
            options:
                - label: "Active"
                  value: "active"

                - label: "Inactive"
                  value: "inactive"
            helper_text: "Lorem ipsum dolor sit amet"
            required: true
            width: 50
```

## Usage

```phtml
<?php
$status = wplite_cf_value(
  'section_1_status',
  'active'
);

if ($active) {
?>
  // Your logic here...
<?php
}
```
