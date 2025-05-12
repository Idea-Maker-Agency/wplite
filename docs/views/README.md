# Views

A lightweight system for registering custom theme views and auto-loading their CSS/JS if present.

## Usage

### View Template

Place the view’s folder inside the `classes/Views/` or `classes/Views/{{Namespace}}` directory, and include the PHP, CSS, and JS files within it. Here's an example of the structure:

```
{{Namespace}}/my-view
├── my-view.php
├── my-view.css
└── my-view.js
```

### Initialization

Ensure your view is registered by adding the following line in `lib/init.php` within the `wplite_init()` function:

```php
View::register('my-view', '{{Namespace}}');
```

To display the view in your templates, include the following snippet:

```php
View::render('my-view', '{{Namespace}}', [
  'arg_1' => 'Lorem ipsum',
]);
```
