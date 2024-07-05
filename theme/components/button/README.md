# Button

### Parameters

### Props

| Property   | Type        | Default       | Description                                                                                                              |
| ---------- | ----------- | ------------- | ------------------------------------------------------------------------------------------------------------------------ |
| `variant`  | `BSVariant` | `"secondary"` | The style variant of the button. Accepts `primary`, `secondary`, `success`, `danger`, `warning`, `info`, `light`, `dark` |
| `size`     | `BSSize`    | —             | The size variant of the button. Accepts `sm`, `lg`                                                                       |
| `outlined` | `Boolean`   | —             | If `true`, the button will have an outlined style.                                                                       |
| `block`    | `Boolean`   | —             | If `true`, the button will expand to the full width of its parent.                                                       |
| `loading`  | `Boolean`   | —             | If `true`, the button will display a loading spinner.                                                                    |
| `type`     | `Boolean`   | `"button"`    | Specifies the type of button. Accepts `button`, `submit`, `reset`                                                        |
| `tag`      | `String`    | `"button"`    | The HTML tag to render, allowing for custom components or elements. Accepts `a`, `button`, `input`                       |

### Usage

```php
<?php

Component::render(
  'button',
  '{{ Lorem ipsum }}',
  [
    'id' => '{{ id }}',
    'class' => [ '{{ class-1 }}', '{{ class-2 }}'],
    'variant' => 'primary',
    'size' => 'sm',
    'outlined' => false,
    'block' => false,
    'type' => 'button',
    'title' => '{{ title }}',
  ]
);
```
