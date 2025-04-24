# Components

A lightweight system for registering custom theme components and auto-loading their CSS/JS if present.

## Usage

### View Template

Place the component’s folder inside the `inc/Views/Components/` directory, and include the PHP, CSS, and JS files within it. Here's an example of the structure:

```
my-component
├── my-component.php
├── my-component.css
└── my-component.js
```

### Initialization

Ensure your component is registered by adding the following line in `lib/init.php` within the `wplite_init()` function:

```php
WPLite\Utils\Components::register('my-component');
```

To display the component in your templates, include the following snippet:

```php
WPLite\Utils\Components::render('my-component', [
  'arg_1' => 'Lorem ipsum',
]);
```
