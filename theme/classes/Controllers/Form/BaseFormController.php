<?php

namespace WPLite\Controllers\Form;

use WPLite\Utils\{
  Form,
  Router
};

if (! defined('ABSPATH')) die;

abstract class BaseFormController extends Form
{
  /**
   * The form action name.
   *
   * @return string
   */
  abstract public static function form_action(): string;

  /**
   * Validate form submission.
   *
   * @return void
   */
  abstract protected function validate(): void;

  /**
   * Process form submission.
   *
   * @return void
   */
  abstract protected function process(): void;

  /**
   * Initialize class.
   *
   * @param string    $name     The form name.
   */
  public function __construct(string $form) {
    parent::__construct($form);
  }

  /**
   * Init.
   *
   * @return void
   */
  public static function init(): void
  {
    add_action('admin_post_nopriv_' . static::form_action(), [static::class, 'dispatch']);
    add_action('admin_post_' . static::form_action(), [static::class, 'dispatch']);
  }

  /**
   * Dispatch.
   *
   * @return void
   */
  public static function dispatch(): void
  {
    $controller = new static(static::form_action());
    $controller->handle_submit();
  }

  /**
   * Handle form submission.
   *
   * @return void
   */
  public function handle_submit(): void
  {
    $this->set_values($_POST);

    $nonce = $_POST['_wpnonce'] ?? '';

    if (! wp_verify_nonce($nonce, 'wplite')) {
      $this->add_error('Security check failed.', 'non_field');

      Router::redirect();
    }

    $this->validate();

    if ($this->has_errors()) {
      Router::redirect();
    }

    $this->process();
  }

  /**
   * Clean up form.
   *
   * @return void
   */
  public function cleanup(): void
  {
    $this->clear_values();
    $this->clear_messages();
    $this->clear_errors();
  }
}
