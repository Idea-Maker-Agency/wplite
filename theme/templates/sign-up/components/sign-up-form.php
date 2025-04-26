<?php $form = new WPLite\Utils\FormBuilder('sign-up') ?>

<?php if (is_user_logged_in()) { ?>
  <div
    class="alert alert-warning my-0"
    role="alert">
    <?= __('You are currently logged in.', THEME_TEXT_DOMAIN) ?>
  </div>
<?php } else { ?>
  <?php
    $form
      ->add_field(
        'email',
        'Email address',
        'email',
        [
          'required' => true,
        ]
      )
      ->add_field(
        'password',
        'Password',
        'password',
        [
          'required' => true,
        ]
      )
      ->add_field(
        'confirm_password',
        'Confirm password',
        'password',
        [
          'required' => true,
        ]
      )
      ->render()
  ?>

  <a
    href="<?= WPLite\Utils\Router::url('login') ?>"
    class="mt-3 d-inline-block">
    <?= __('Already have an account?') ?>
  </a>
<?php }
