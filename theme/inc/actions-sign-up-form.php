<?php

use WPLite\Utils\Form;
use WPLite\Utils\FormBuilder;

if (! defined('ABSPATH')) {
  die;
}

add_action('after_setup_theme', 'wplite_sign_up_form_init');
/**
 * Init.
 *
 * @return void
 */
function wplite_sign_up_form_init(): void
{
  add_action('admin_post_nopriv_sign-up', 'wplite_sign_up_form_dispatch');
  add_action('admin_post_sign-up', 'wplite_sign_up_form_dispatch');

  add_action('form_sign-up_after', 'wplite_sign_up_form_reset_state');
}

/**
 * Dispatch form submission.
 *
 * @return void
 */
function wplite_sign_up_form_dispatch(): void
{
  $form = new Form('sign-up');

  $form->set_values($_POST);

  $nonce    = $_POST['_wpnonce']         ?? '';
  $referrer = $_POST['_wp_http_referer'] ?? '';

  if (! wp_verify_nonce($nonce, 'wplite')) {
    $form->add_error('Security check failed.', 'non_field');

    wplite_redirect($referrer);
  }

  wplite_sign_up_form_validate($form);

  if ($form->has_errors()) {
    wplite_redirect($referrer);
  }

  wplite_sign_up_form_process($form);
}

/**
 * Validate form submission.
 *
 * @param Form $form The form instance.
 *
 * @return void
 */
function wplite_sign_up_form_validate(Form $form): void
{
  $email_address    = $form->get_value('email_address');
  $password         = $form->get_value('password');
  $confirm_password = $form->get_value('confirm_password');

  if (empty($email_address)) {
    $form->add_error('Email address is required.', 'email_address');
  }

  if (empty($password)) {
    $form->add_error('Password is required.', 'password');
  }

  if (empty($confirm_password)) {
    $form->add_error('Password confirmation is required.', 'confirm_password');
  } elseif ($password !== $confirm_password) {
    $form->add_error('Passwords does not match.', 'confirm_password');
  }
}

/**
 * Process form submission.
 *
 * @param Form $form The form instance.
 *
 * @return void
 */
function wplite_sign_up_form_process(Form $form): void
{
  $email_address = $form->get_value('email_address');
  $password      = $form->get_value('password');

  $redirect = $form->get_value('redirect');

  if (email_exists($email_address)) {
    $form->add_error('Email address is already taken.', 'non_field');

    wplite_redirect('sign-up');
  }

  $user_id = wp_create_user($email_address, $password, $email_address);

  if (is_wp_error($user_id)) {
    $form->add_error('Sign up failed.', 'non_field');

    wplite_redirect('sign-up');
  }

  $user = wp_signon([
    'user_login'    => $email_address,
    'user_password' => $password,
  ]);

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
function wplite_sign_up_form_reset_state(FormBuilder $form_builder): void
{
  $form_builder->clear_values();
  $form_builder->clear_messages();
  $form_builder->clear_errors();
}