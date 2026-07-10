# Input

Registers an input custom field.

## Register field

```yaml
my_page:
    group: "Section 1"
    fields:
        section_1_title:
            type: text
            label: "Title"
            helper_text: "Lorem ipsum dolor sit amet"
            required: true
            width: 100
```

## Usage

```phtml
<?php
$title = wplite_cf_value(
  'section_1_title',
  'Fallback title'
);

if ($title) {
?>
  <h1><?= $title ?></h1>
<?php
}
```
