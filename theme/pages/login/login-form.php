<?php
use WPLite\Utils\FormBuilder;

if (is_user_logged_in()) {
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

  <?php if ($signup_url = wplite_get_url('sign-up')) { ?>
	<a
		href="<?php echo $signup_url ?>"
		class="mt-3 d-inline-block">
		<?= __('Dont\'t have an account?', THEME_TEXT_DOMAIN) ?>
	</a>
<?php
  }
}
