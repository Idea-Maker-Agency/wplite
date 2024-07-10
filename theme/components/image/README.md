# Image

```php
wplite_image( string $src, int $width, int $height, array $sizes = [], array $attrs = [] ): void
```

### Description

Renders the image component.

### Parameters

| Property  | Type     | Default | Description                                                             |
| --------- | -------- | ------- | ----------------------------------------------------------------------- |
| `$src`    | `string` | —       | The img src. _( Required )_                                             |
| `$width`  | `int`    | —       | The img width. _( Required )_                                           |
| `$height` | `int`    | —       | The img height. _( Required )_                                          |
| `$sizes`  | `array`  | []      | An array of srcset by viewport. Accepts `xl`, `lg`, `md`, `sm`, `xs`    |
| `$attrs`  | `array`  | []      | An array of img attributes. Accepts `id`, `class` and `alt` attributes. |

### Return

`void` on success, `false` if the template does not exist

### Example Usage

```php
wplite_image( THEME_DIR_URI .'/assets/lib/img/sample-image-full.jpg', 400, 400, [
  'xl' => THEME_DIR_URI .'/assets/lib/img/sample-image-xl.png',
  'lg' => THEME_DIR_URI .'/assets/lib/img/sample-image-lg.png',
  'md' => THEME_DIR_URI .'/assets/lib/img/sample-image-md.png',
  'sm' => THEME_DIR_URI .'/assets/lib/img/sample-image-sm.png',
  'xs' => THEME_DIR_URI .'/assets/lib/img/sample-image-xs.png',
], [
  'id' => 'image-id',
  'class' => 'rounded',
  'alt' => 'Sample image alt',
] )
```
