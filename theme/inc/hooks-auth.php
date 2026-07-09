<?php

use WPLite\Utils\Form;

/**
 * Redirect to login page on logout.
 */
function wplite_on_logout() {
	$form   = new Form('login');
	$form->add_message('You have successfully logged out.', 'non_field');

	wplite_redirect('login');
}
add_action('wp_logout', 'wplite_on_logout');