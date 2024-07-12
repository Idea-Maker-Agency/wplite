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
  require_once THEME_DIR_PATH . '/lib/functions/settings.php';
  require_once THEME_DIR_PATH . '/lib/functions/admin-header.php';
  require_once THEME_DIR_PATH . '/lib/functions/general-template.php';
  require_once THEME_DIR_PATH . '/lib/functions/comment-template.php';
  require_once THEME_DIR_PATH . '/lib/functions/components.php';
  require_once THEME_DIR_PATH . '/lib/functions/styles.php';
  require_once THEME_DIR_PATH . '/lib/functions/scripts.php';
  require_once THEME_DIR_PATH . '/lib/functions/formatting.php';
  require_once THEME_DIR_PATH . '/lib/functions/nav-menu.php';
  require_once THEME_DIR_PATH . '/lib/functions/widgets.php';

  if ( class_exists( 'WPCF7' ) ) :
    require_once THEME_DIR_PATH . '/lib/functions/contact-form-7.php';
  endif;
}

wplite_init();
