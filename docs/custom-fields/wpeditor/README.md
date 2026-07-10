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
$content = wplite_cf_value(
  'section_1_content',
  'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantiumo'
);
?>

<?= wpautop($content) ?>
```
