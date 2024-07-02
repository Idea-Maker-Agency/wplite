<?php

/**
 * Init.
 *
 * @since 1.0.0
 *
 * @return void
 */
function wplite_init(): void {
  require_once THEME_DIR_PATH . '/lib/classes/Components/Component.php';

  require_once THEME_DIR_PATH . '/lib/functions/setup.php';
  require_once THEME_DIR_PATH . '/lib/functions/styles.php';
  require_once THEME_DIR_PATH . '/lib/functions/scripts.php';
  require_once THEME_DIR_PATH . '/lib/functions/formatting.php';
  require_once THEME_DIR_PATH . '/lib/functions/pagination.php';
  require_once THEME_DIR_PATH . '/lib/functions/menus.php';
}

wplite_init();
