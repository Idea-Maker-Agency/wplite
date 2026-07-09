<?php

use WPLite\Utils\Form;
use WPLite\Utils\FormBuilder;

if (! defined('ABSPATH')) {
  die;
}

add_action('after_setup_theme', 'wplite_login_form_init');
/**
 * Init.
 *
 * @return void
 */
function wplite_login_form_init(): void
{
  add_action('admin_post_nopriv_login', 'wplite_login_form_dispatch');
  add_action('admin_post_login', 'wplite_login_form_dispatch');

  add_action('form_login_after', 'wplite_login_form_reset_state');
}

/**
 * Dispatch form submission.
 *
 * @return void
 */
function wplite_login_form_dispatch(): void
{
  $form = new Form('login');

  $form->set_values($_POST);

  $nonce    = $_POST['_wpnonce']         ?? '';
  $referrer = $_POST['_wp_http_referer'] ?? '';

  if (! wp_verify_nonce($nonce, 'wplite')) {
    $form->add_error('Security check failed.', 'non_field');

    wplite_redirect($referrer);
  }

  wplite_login_form_validate($form);

  if ($form->has_errors()) {
    wplite_redirect($referrer);
  }

  wplite_login_form_process($form);
}

/**
 * Validate form submission.
 *
 * @param Form $form The form instance.
 *
 * @return void
 */
function wplite_login_form_validate(Form $form): void
{
  $username = $form->get_value('username');
  $password = $form->get_value('password');

  if (empty($username)) {
    $form->add_error('Username is required.', 'username');
  }

  if (empty($password)) {
    $form->add_error('Password is required.', 'password');
  }
}

/**
 * Process form submission.
 *
 * @param Form $form The form instance.
 *
 * @return void
 */
function wplite_login_form_process(Form $form): void
{
  $username   = $form->get_value('username');
  $password   = $form->get_value('password');
  $rememberme = $form->get_value('remember_me');

  $redirect = $form->get_value('redirect');

  $user = wp_signon([
    'user_login'    => $username,
    'user_password' => $password,
    'remember'      => $rememberme,
  ]);

  if (is_wp_error($user)) {
    $form->add_error('Login failed.', 'non_field');

    wplite_redirect('login');
  }

  wp_set_current_user($user);

  $form->clear_values();
  $form->clear_errors();

  wplite_redirect($redirect ?: 'home');
}

/**
 * Reset form state.
 *
 * @param FormBuilder $form_builder The form builder instance.
 *
 * @return void
 */
function wplite_login_form_reset_state(FormBuilder $form_builder): void
{
  $form_builder->clear_values();
  $form_builder->clear_messages();
  $form_builder->clear_errors();
}