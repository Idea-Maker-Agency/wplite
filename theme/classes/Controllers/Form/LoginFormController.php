<?php

namespace WPLite\Controllers\Form;

if (! defined('ABSPATH')) die;

use WPLite\Utils\{
  FormBuilder,
  Router
};

class LoginFormController extends BaseFormController
{
  /**
   * Init.
   *
   * @return void
   */
  public static function init(): void
  {
    parent::init();

    add_action('form_login_after', [self::class, 'reset_form_state']);
  }

  /**
   * The form action name.
   *
   * @return string
   */
  public static function form_action(): string
  {
    return 'login';
  }

  /**
   * Validate form submission.
   *
   * @return void
   */
  protected function validate(): void
  {
    $values = $this->get_values();

    if (empty($values['username'])) {
      $this->add_error('Username is required.', 'username');
    }

    if (empty($values['password'])) {
      $this->add_error('Password is required.', 'password');
    }
  }

  /**
   * Process form submission.
   *
   * @return void
   */
  protected function process(): void
  {
    $values = $this->get_values();

    $user = wp_signon([
      'user_login' => $values['username'],
      'user_password' => $values['password'],
      'remember' => $values['remember-me'],
    ]);

    if (is_wp_error($user)) {
      $this->add_error('Login failed.', 'non_field');

      Router::redirect('login');
    }

    wp_set_current_user($user);

    $this->cleanup();

    Router::redirect($values['redirect'] ?? 'home');
  }

  /**
   * Reset form state.
   *
   * @return void
   */
  public static function reset_form_state(FormBuilder $form_builder): void
  {
    $form_builder->clear_values();
    $form_builder->clear_messages();
    $form_builder->clear_errors();
  }
}
