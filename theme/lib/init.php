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
  CustomFieldsRepeaterAJAXController
};
use WPLite\Controllers\Form\{
  LoginFormController,
  SignUpFormController
};
use WPLite\Utils\Components;

/**
 * Init.
 *
 * @since 1.0.0
 *
 * @return void
 */
add_action('after_setup_theme', 'wplite_init');
function wplite_init(): void {
  SetupController::init();
  AuthController::init();
  AssetController::init();
  NavMenuController::init();
  TemplateController::init();
  CommentController::init();

  if (class_exists('WPCF7')) {
    ContactForm7Controller::init();
  }

  ThemeCustomizerController::init();
  CustomFieldsRepeaterAJAXController::init();

  // Initialize front-end form controllers
  LoginFormController::init();
  SignUpFormController::init();

  // Register custom components
  Components::register('logo');
  Components::register('social-links');
  Components::register('article-card');
  Components::register('related-posts');
}
