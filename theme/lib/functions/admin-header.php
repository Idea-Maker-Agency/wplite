<?php

/**
 * Admin notices.
 *
 * @since 1.0.0
 *
 * @return void
 */
add_action( 'admin_notices', 'ctvb_admin_notices' );
function ctvb_admin_notices(): void {
  if( !class_exists( 'WPCF7' ) ) :
    echo '<div class="notice notice-warning">'.
            '<p>'.
              '<strong>Warning:</strong> '. __( 'The theme requires Contact Form 7 plugin.', THEME_TEXT_DOMAIN ).
            '</p>'.
          '</div>';
  endif;
}
