<?php

use WPLite\Controllers\{
  SetupController,
  AuthController,
  TemplateController,
  ContactForm7Controller
};
use WPLite\Controllers\Admin\{
  ThemeCustomizerController,
  CustomFieldsRepeaterAJAXController,
  UploadsController
};
use WPLite\Controllers\Form\{
  LoginFormController,
  SignUpFormController
};

require_once THEME_DIR_PATH . '/inc/functions-templates.php';
require_once THEME_DIR_PATH . '/inc/functions-page-templates.php';

require_once THEME_DIR_PATH . '/inc/page-templates.php';
require_once THEME_DIR_PATH . '/inc/script-loader.php';
require_once THEME_DIR_PATH . '/inc/nav-menu.php';
require_once THEME_DIR_PATH . '/inc/comment-template.php';

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
  new SetupController();
  new AuthController();
  new TemplateController();

  if (class_exists('WPCF7')) {
    ContactForm7Controller::init();
  }

  new ThemeCustomizerController();
  new CustomFieldsRepeaterAJAXController();
  new UploadsController();

  // Initialize front-end form controllers
  LoginFormController::init();
  SignUpFormController::init();
}
