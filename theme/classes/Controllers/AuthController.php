<?php

namespace WPLite\Controllers;

use WPLite\Utils\Form;

defined('ABSPATH') || exit;

class AuthController
{
  /**
   * Constructor.
   */
  public function __construct()
  {
    add_action('wp_logout', [$this, 'on_logout']);
  }

  /**
   * Redirect to login page on logout.
   */
  public function on_logout()
  {
    $form   = new Form('login');

    $form->add_message('You have successfully logged out.', 'non_field');
    wplite_redirect('login');
  }
}
