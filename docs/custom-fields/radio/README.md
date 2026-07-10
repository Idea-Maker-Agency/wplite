# Radio

Registers a radio buttons custom field.

## Register field

```yaml
my_page:
    group: "Section 1"
    fields:
        section_1_theme:
            type: radio
            label: "Theme"
            options:
                - label: "Light"
                  value: "light"

                - label: "Dark"
                  value: "dark"
            required: true
            width: 100
```

## Usage

```phtml
<?php
$theme = wplite_cf_value(
  'section_1_theme',
  'light'
);

if ('dark' === $theme) {
?>
  // Your logic here...
<?php
}
```
