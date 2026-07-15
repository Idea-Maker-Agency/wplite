# Textarea

Registers a textarea custom field.

## Register field

```yaml
my_page:
    group: "Section 1"
    fields:
        section_1_description:
            type: textarea
            label: "Description"
            helper_text: "Lorem ipsum dolor sit amet"
            required: true
            width: 100
```

## Usage

```phtml
<?php
$description = wplite_cf_value(
  'section_1_description',
  'Fallback description'
);

if ($description) {
?>
  <?= $description ?>
<?php
}
```
