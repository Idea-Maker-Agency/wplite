<?php

use WPLite\Controllers\{
  SetupController,
  AuthController,
  AssetController,
  NavMenuController,
  TemplateController,
  CommentController,
  ContactForm7Controller,
  ThemeController
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
  new AssetController();
  new NavMenuController();
  new TemplateController();
  new CommentController();
  new ThemeController();

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
