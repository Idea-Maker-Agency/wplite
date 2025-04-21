<?php

namespace WPLite\Controllers\Form;

if (! defined('ABSPATH')) die;

use WPLite\Utils\Router;

class LoginFormController extends BaseFormController
{
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

    if (empty($values['user_login'])) {
      $this->add_error('Username is required.', 'user_login');
    }

    if (empty($values['user_password'])) {
      $this->add_error('Password is required.', 'user_password');
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
      'user_login' => $values['user_login'],
      'user_password' => $values['user_password'],
      'remember' => $values['remember'],
    ]);

    if (is_wp_error($user)) {
      $this->add_error('Login failed.', 'non_field');

      Router::redirect('login');
    }

    wp_set_current_user($user);

    $this->cleanup();

    Router::redirect('home');
  }
}
