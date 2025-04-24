<?php

/**
 * Init.
 *
 * @since 1.0.0
 *
 * @return void
 */
function wplite_init(): void {
  require_once THEME_DIR_PATH . '/lib/functions/helpers.php';

  WPLite\Controllers\SetupController::init();
  WPLite\Controllers\AuthController::init();
  WPLite\Controllers\AssetController::init();
  WPLite\Controllers\NavMenuController::init();
  WPLite\Controllers\TemplateController::init();
  WPLite\Controllers\CommentController::init();

  if (class_exists('WPCF7')) {
    WPLite\Controllers\ContactForm7Controller::init();
  }

  WPLite\Controllers\Admin\ThemeCustomizerController::init();
  WPLite\Controllers\Admin\CustomFieldsRepeaterAJAXController::init();

  // Initialize front-end form controllers
  WPLite\Controllers\Form\LoginFormController::init();
  WPLite\Controllers\Form\SignUpFormController::init();

  // Register custom components
  WPLite\Utils\Components::register('logo');
  WPLite\Utils\Components::register('article-card');
  WPLite\Utils\Components::register('related-posts');
}

wplite_init();
