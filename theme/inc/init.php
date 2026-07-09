<?php

use WPLite\Controllers\ContactForm7Controller;
use WPLite\Controllers\Admin\{
  ThemeCustomizerController,
  UploadsController
};
use WPLite\Controllers\Form\{
  LoginFormController,
  SignUpFormController
};

require_once THEME_DIR_PATH . '/inc/functions-templates.php';
require_once THEME_DIR_PATH . '/inc/functions-page-templates.php';

require_once THEME_DIR_PATH . '/inc/ajax/ajax-custom-fields-repeater.php';

require_once THEME_DIR_PATH . '/inc/hooks-setup.php';
require_once THEME_DIR_PATH . '/inc/hooks-formatting.php';
require_once THEME_DIR_PATH . '/inc/hooks-script-loader.php';
require_once THEME_DIR_PATH . '/inc/hooks-nav-menu.php';
require_once THEME_DIR_PATH . '/inc/hooks-auth.php';
require_once THEME_DIR_PATH . '/inc/hooks-general-template.php';
require_once THEME_DIR_PATH . '/inc/hooks-templates.php';
require_once THEME_DIR_PATH . '/inc/hooks-comment-template.php';
require_once THEME_DIR_PATH . '/inc/hooks-page-templates.php';

/**
 * Init.
 *
 * @since 1.0.0
 *
 * @return void
 */
add_action('after_setup_theme', 'wplite_init');
function wplite_init()
{
  if (class_exists('WPCF7')) {
    ContactForm7Controller::init();
  }

  new ThemeCustomizerController();
  new UploadsController();

  // Initialize front-end form controllers
  LoginFormController::init();
  SignUpFormController::init();
}
