# Link

```php
wplite_link( string $text, string $url, string $variant = 'primary', string $size = null, bool $outlined = false, bool $block = false, bool $as_button = false, array $attrs = [] ): void
```

### Description

Renders the link component.

### Parameters

| Property     | Type     | Default     | Description                                                                                                            |
| ------------ | -------- | ----------- | ---------------------------------------------------------------------------------------------------------------------- |
| `$text`      | `string` | —           | The link text. _( Required )_                                                                                          |
| `$variant`   | `string` | `"primary"` | The style variant of the link. Accepts `primary`, `secondary`, `success`, `danger`, `warning`, `info`, `light`, `dark` |
| `$size`      | `string` | —           | The size variant of the link. Accepts `sm`, `lg`                                                                       |
| `$outlined`  | `bool`   | —           | If `true`, the link will have an outlined style.                                                                       |
| `$block`     | `bool`   | —           | If `true`, the link will expand to the full width of its parent.                                                       |
| `$as_button` | `bool`   | —           | If `true`, the link will render as a link.                                                                             |
| `$attrs`     | `array`  | —           | An array of link attributes. Accepts `id`, `class`, `target`, `alt`, `icon` and `icon_pos` attributes.                 |

### Return

`void` on success, `false` if the template does not exist

### Example Usage

```php
wplite_link( 'Click here', 'https://your-website.com', 'primary', 'sm', true, false, true, [
  'id' => 'button-link',
  'class' => [ 'button-link--primary' ],
  'target' => '_blank',
  'alt' => 'Button link alt',
  'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-2"><path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/></svg>',
  'icon_pos' => 'end',
] )
```
