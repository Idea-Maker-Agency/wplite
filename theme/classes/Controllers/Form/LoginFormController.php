<?php

namespace WPLite\Controllers\Form;

if (! defined('ABSPATH')) {
  die;
}

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
    $username = $this->get_value('username');
    $password = $this->get_value('password');

    if (empty($username)) {
      $this->add_error('Username is required.', 'username');
    }

    if (empty($password)) {
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
    $router = new Router();

    $username   = $this->get_value('username');
    $password   = $this->get_value('password');
    $rememberme = $this->get_value('remember_me');

    $redirect = $this->get_value('redirect');

    $user = wp_signon([
      'user_login'    => $username,
      'user_password' => $password,
      'remember'      => $rememberme,
    ]);

    if (is_wp_error($user)) {
      $this->add_error('Login failed.', 'non_field');

      $router->redirect('login');
    }

    wp_set_current_user($user);

    $this->cleanup();

    $router->redirect($redirect ?: 'home');
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
