<?php

use WPLite\Controllers\{
  SetupController,
  AuthController,
  AssetController,
  NavMenuController,
  TemplateController,
  CommentController,
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
use WPLite\Utils\{
  Component,
  View
};

/**
 * Init.
 *
 * @since 1.0.0
 *
 * @return void
 */
function wplite_init(): void
{
  new SetupController();
  new AuthController();
  new AssetController();
  new NavMenuController();
  TemplateController::init();
  new CommentController();

  if (class_exists('WPCF7')) {
    ContactForm7Controller::init();
  }

  new ThemeCustomizerController();
  new CustomFieldsRepeaterAJAXController();
  new UploadsController();

  // Initialize front-end form controllers
  LoginFormController::init();
  SignUpFormController::init();

  // Register components
  Component::register([
    'logo',
    'social-links',
    'related-posts',
  ], 'Misc');

  Component::register([
    'login-form',
    'sign-up-form',
  ], 'Auth');

  Component::register([
    'article-card',
  ], 'Blog');
}

wplite_init();
