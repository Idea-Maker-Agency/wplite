<?php

/**
 * Init.
 *
 * @since 1.0.0
 *
 * @return void
 */
function wplite_init(): void {
  require_once THEME_DIR_PATH . '/lib/classes/Component.php';

  require_once THEME_DIR_PATH . '/lib/classes/Components/Component.php';
  require_once THEME_DIR_PATH . '/lib/classes/Components/ArticleCard.php';

  require_once THEME_DIR_PATH . '/lib/functions/setup.php';
  require_once THEME_DIR_PATH . '/lib/functions/general-template.php';
  require_once THEME_DIR_PATH . '/lib/functions/components.php';
  require_once THEME_DIR_PATH . '/lib/functions/styles.php';
  require_once THEME_DIR_PATH . '/lib/functions/scripts.php';
  require_once THEME_DIR_PATH . '/lib/functions/formatting.php';
  require_once THEME_DIR_PATH . '/lib/functions/pagination.php';
  require_once THEME_DIR_PATH . '/lib/functions/menus.php';
  require_once THEME_DIR_PATH . '/lib/functions/search.php';
  require_once THEME_DIR_PATH . '/lib/functions/widgets.php';

  if ( class_exists( 'WPCF7' ) ) :
    require_once THEME_DIR_PATH . '/lib/functions/cf7.php';
  endif;
}

wplite_init();
