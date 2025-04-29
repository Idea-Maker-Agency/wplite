<?php $form = new WPLite\Utils\FormBuilder('login') ?>

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
        'Username',
        [
          'required' => true,
        ]
      )
      ->add_field(
        'Password',
        [
          'type' => 'password',
          'required' => true,
        ]
      )
      ->add_field(
        'Remember me',
        [
          'type' => 'checkbox',
        ]
      )
      ->render()
  ?>

  <a
    href="<?= WPLite\Utils\Router::url('sign-up') ?>"
    class="mt-3 d-inline-block">
    <?= __('Dont\'t have an account?') ?>
  </a>
<?php }
