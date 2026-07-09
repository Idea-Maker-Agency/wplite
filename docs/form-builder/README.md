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

### Actions

Create a dedicated `inc/actions-my-form.php` file to handle validation and processing of the form submission:

```php
<?php

use WPLite\Utils\Form;

if (! defined('ABSPATH')) {
  die;
}

add_action('after_setup_theme', 'wplite_my_form_init');
/**
 * Init.
 *
 * @return void
 */
function wplite_my_form_init(): void
{
  add_action('admin_post_nopriv_my-form', 'wplite_my_form_dispatch');
  add_action('admin_post_my-form', 'wplite_my_form_dispatch');
}

/**
 * Dispatch form submission.
 *
 * @return void
 */
function wplite_my_form_dispatch(): void
{
  $form = new Form('my-form');

  $form->set_values($_POST);

  $nonce    = $_POST['_wpnonce']         ?? '';
  $referrer = $_POST['_wp_http_referer'] ?? '';

  if (! wp_verify_nonce($nonce, 'wplite')) {
    $form->add_error('Security check failed.', 'non_field');

    wplite_redirect($referrer);
  }

  wplite_my_form_validate($form);

  if ($form->has_errors()) {
    wplite_redirect($referrer);
  }

  wplite_my_form_process($form);
}

/**
 * Validate form submission.
 *
 * @param Form $form The form instance.
 *
 * @return void
 */
function wplite_my_form_validate(Form $form): void
{
  $values = $form->get_values();

  // Validation logic goes here...
}

/**
 * Process form submission.
 *
 * @param Form $form The form instance.
 *
 * @return void
 */
function wplite_my_form_process(Form $form): void
{
  $values = $form->get_values();

  // Process form submission...

  $form->clear_values();
  $form->clear_errors();
}
```

### Initialization

Ensure your actions file is loaded by adding the following line in `inc/init.php`:

```php
require_once THEME_DIR_PATH . '/inc/actions-my-form.php';
```
