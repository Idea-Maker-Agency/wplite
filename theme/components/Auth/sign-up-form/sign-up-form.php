<?php
use WPLite\Models\Auth;
use WPLite\Utils\{
  FormBuilder,
  Router
};

$router = new Router();

if (Auth::check()) {
  ?>
  <div
    class="alert alert-warning my-0"
    role="alert">
    <?= __('You are currently logged in.', THEME_TEXT_DOMAIN) ?>
  </div>
<?php
} else {
  (new FormBuilder('sign-up'))
    ->add_field(
      'Redirect',
      [
        'type'  => 'hidden',
        'value' => $_GET['redirect'] ?? '',
      ]
    )
    ->add_field(
      'Email address',
      [
        'required' => true,
      ]
    )
    ->add_field(
      'Password',
      [
        'type'     => 'password',
        'required' => true,
      ]
    )
    ->add_field(
      'Confirm password',
      [
        'type'     => 'password',
        'required' => true,
      ]
    )
    ->render();
  ?>
  <a
    href="<?= $router->url('login') ?>"
    class="mt-3 d-inline-block">
    <?= __('Already have an account?', THEME_TEXT_DOMAIN) ?>
  </a>
<?php
}
