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
  (new FormBuilder('login'))
    ->add_field(
      'Redirect',
      [
        'type'  => 'hidden',
        'value' => $_GET['redirect'] ?? '',
      ]
    )
    ->add_field(
      'Username',
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
      'Remember me',
      [
        'type' => 'checkbox',
      ]
    )
    ->render();
  ?>
  <a
    href="<?= $router->url('sign-up') ?>"
    class="mt-3 d-inline-block">
    <?= __('Dont\'t have an account?', THEME_TEXT_DOMAIN) ?>
  </a>
<?php
}
