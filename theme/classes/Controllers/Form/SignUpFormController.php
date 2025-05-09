<?php

namespace WPLite\Controllers\Form;

if (! defined('ABSPATH')) die;

use WPLite\Utils\{
  FormBuilder,
  Router
};

class SignUpFormController extends BaseFormController
{
  /**
   * Init.
   *
   * @return void
   */
  public static function init(): void
  {
    parent::init();

    add_action('form_sign-up_after', [self::class, 'reset_form_state']);
  }

  /**
   * The form action name.
   *
   * @return string
   */
  public static function form_action(): string
  {
    return 'sign-up';
  }

  /**
   * Validate form submission.
   *
   * @return void
   */
  protected function validate(): void
  {
    $email_address = $this->get_value('email_address');
    $password = $this->get_value('password');
    $confirm_password = $this->get_value('confirm_password');

    if (empty($email_address)) {
      $this->add_error('Email address is required.', 'email_address');
    }

    if (empty($password)) {
      $this->add_error('Password is required.', 'password');
    }

    if (empty($confirm_password)) {
      $this->add_error('Password confirmation is required.', 'confirm_password');
    } elseif ($password !== $confirm_password) {
      $this->add_error('Passwords does not match.', 'confirm_password');
    }
  }

  /**
   * Process form submission.
   *
   * @return void
   */
  protected function process(): void
  {
    $email_address = $this->get_value('email_address');
    $password = $this->get_value('password');

    $redirect = $this->get_value('redirect');

    if (email_exists($email_address)) {
      $this->add_error('Email address is already taken.', 'non_field');

      Router::redirect('sign-up');
    }

    $user_id = wp_create_user($email_address, $password, $email_address);

    if (is_wp_error($user_id)) {
      $this->add_error('Sign up failed.', 'non_field');

      Router::redirect('sign-up');
    }

    $user = wp_signon([
      'user_login' => $email_address,
      'user_password' => $password,
    ]);

    wp_set_current_user($user);

    $this->cleanup();

    Router::redirect($redirect ?: 'home');
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
