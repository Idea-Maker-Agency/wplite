<?php

namespace WPLite\Controllers;

use WPLite\Utils\{
  Form,
  Router
};

if (! defined('ABSPATH')) {
  die;
}

class AuthController
{
  /**
   * Init.
   *
   * @return void
   */
  public static function init(): void
  {
    add_action('wp_logout', [self::class, 'on_logout']);
  }

  /**
   * Redirect to login page on logout.
   *
   * @return void
   */
  public static function on_logout(): void
  {
    $form = new Form('login');

    $form->add_message('You have successfully logged out.', 'non_field');

    Router::redirect('login');
  }
}
