# Article card

```php
wplite_article_card( WP_Post $post ): void
```

### Description

Renders the article card component.

### Parameters

| Property | Type      | Default | Description                        |
| -------- | --------- | ------- | ---------------------------------- |
| `$post`  | `WP_Post` | —       | The WP Post object. _( Required )_ |

### Return

`void` on success, `false` if the template does not exist

### Example Usage

```php
wplite_article_card( $post )
```
