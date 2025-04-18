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
  require_once THEME_DIR_PATH . '/lib/functions/general-template.php';
  require_once THEME_DIR_PATH . '/lib/functions/components.php';
  require_once THEME_DIR_PATH . '/lib/functions/widgets.php';

  if (class_exists('WPCF7')) {
    require_once THEME_DIR_PATH . '/lib/functions/contact-form-7.php';
  }

  WPLite\Controllers\SetupController::init();
  WPLite\Controllers\AssetController::init();
  WPLite\Controllers\NavMenuController::init();
  WPLite\Controllers\TemplateController::init();
  WPLite\Controllers\CommentController::init();
}

wplite_init();
