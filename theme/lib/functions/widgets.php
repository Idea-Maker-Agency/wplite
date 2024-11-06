<?php

/**
 * Fires after all default WordPress widgets have been registered.
 *
 * @since 1.0.0
 */
add_action('widgets_init', 'wplite_register_sidebars');
function wplite_register_sidebars()
{
	register_sidebar([
		'id' => 'primary-sidebar',
    'name' => __('Primary Sidebar', THEME_TEXT_DOMAIN),
		'description' => __('Widgets in this area will be shown on posts sidebar.', THEME_TEXT_DOMAIN),
		'before_widget' => '<div id="%1$s" class="card mb-3 mb-lg-4 %2$s"><div class="card-body">',
		'after_widget' => '</div></div>',
		'before_title' => '<h2 class="card-title mb-3 fs-4">',
		'after_title' => '</h2>',
  ]);
}
