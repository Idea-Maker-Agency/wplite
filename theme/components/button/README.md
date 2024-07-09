# Button

```php
wplite_button( string $text, string $variant = 'primary', string $size = null, bool $outlined = false, bool $block = false, array $attrs = [] ): void
```

### Description

Renders the button component.

### Parameters

| Property    | Type     | Default     | Description                                                                                                              |
| ----------- | -------- | ----------- | ------------------------------------------------------------------------------------------------------------------------ |
| `$text`     | `string` | —           | The button text. _( Required )_                                                                                          |
| `$variant`  | `string` | `"primary"` | The style variant of the button. Accepts `primary`, `secondary`, `success`, `danger`, `warning`, `info`, `light`, `dark` |
| `$size`     | `string` | —           | The size variant of the button. Accepts `sm`, `lg`                                                                       |
| `$outlined` | `bool`   | —           | If `true`, the button will have an outlined style.                                                                       |
| `$block`    | `bool`   | —           | If `true`, the button will expand to the full width of its parent.                                                       |
| `$attrs`    | `array`  | —           | An array of button attributes. Accepts `id`, `class`, `type` and `title` attributes.                                     |

### Return

`void` on success, `false` if the template does not exist

### Example Usage

```php
wplite_button( 'Click me', 'primary', 'sm', true, false, [
  'id' => 'click-me-btn',
  'class' => [ 'click-me-btn--primary' ],
  'type' => 'button',
  'title' => 'Click me title',
] )
```
