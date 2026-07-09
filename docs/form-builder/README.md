# Form Builder

A lightweight and extensible utility for building and handling front-end forms within the WPLite framework.

## Usage

### View Template

Use the FormBuilder utility to define and render fields in your view:

```phtml
<?php $form = new WPLite\Utils\FormBuilder('my-form') ?>

<div class="card">
  <div class="card-body">
  <?php
    $form
      ->add_field(
        'First name',
        [
          'type' => 'text',
          'required' => true,
        ],
        'first_name'
      )
      ->add_field(
        'Last name',
        [
          'type' => 'text',
          'required' => true,
        ],
        'last_name'
      )
      ->render()
  ?>
  </div>
</div>
```

### Controller

Create a dedicated controller to handle validation and processing of the form submission:

```php
<?php

namespace WPLite\Controllers\Form;

if (! defined('ABSPATH')) die;

class MyFormController extends BaseFormController
{
  /**
   * The form action name.
   *
   * @return string
   */
  public static function form_action(): string
  {
    return 'my-form';
  }

  /**
   * Validate form submission.
   *
   * @return void
   */
  protected function validate(): void
  {
    $values = $this->get_values();

    // Validation logic goes here...
  }

  /**
   * Process form submission.
   *
   * @return void
   */
  protected function process(): void
  {
    $values = $this->get_values();

    // Process form submission...

    $this->cleanup();
  }
}

```

### Initialization

Ensure your controller is registered by adding the following line in `lib/init.php` within the `wplite_init()` function:

```php
WPLite\Controllers\Form\MyFormController::init();
```
