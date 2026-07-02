<?php

namespace WPLite\Controllers\Admin;

use WP_Customize_Manager;
use WP_Customize_Image_Control;

defined('ABSPATH') || exit;

class ThemeCustomizerController
{
  /**
   * Constructor.
   */
  public function __construct()
  {
    add_action('customize_register', [$this, 'register']);
  }

  /**
   * Register customizer.
   *
   * @param WP_Customize_Manager $manager
   */
  public function register(WP_Customize_Manager $manager)
  {
    $file     = get_theme_file_path('/config/customizer.json');
    $contents = file_get_contents($file);
    $panels   = json_decode($contents, true);

    if (! empty($panels)) {
      foreach ($panels as $panel) {
        $panel_id = "wplite_{$panel['panel']}";

        $manager->add_panel($panel_id, [
          'title'       => __($panel['title'], THEME_TEXT_DOMAIN),
          'description' => __($panel['description'], THEME_TEXT_DOMAIN),
          'priority'    => $panel['priority'] ?? 10,
        ]);

        if (! empty($panel['sections'])) {
          foreach ($panel['sections'] as $section) {
            $section_id = "wplite_{$section['name']}";

            $manager->add_section($section_id, [
              'title' => __($section['title'], THEME_TEXT_DOMAIN),
              'panel' => $panel_id,
            ]);

            if (! empty($section['settings'])) {
              foreach ($section['settings'] as $setting) {
                $setting_id   = "{$section_id}_{$setting['name']}";
                $setting_args = [
                  'label'       => __($setting['label'], THEME_TEXT_DOMAIN),
                  'description' => __($setting['description'] ?? '', THEME_TEXT_DOMAIN),
                  'section'     => $section_id,
                  'settings'    => $setting_id,
                  'type'        => $setting['type'],
                ];

                if (
                  'select' === $setting['type']
                  && isset($setting['source'])
                ) {
                  $setting_args['choices'] = $this->resolve_select_choices($setting['source']);
                }

                $manager->add_setting($setting_id, [
                  'sanitize_callback' => 'wp_kses_post',
                ]);

                if ('image' === $setting['type']) {
                  $manager->add_control(new WP_Customize_Image_Control(
                    $manager,
                    $setting_id,
                    $setting_args
                  ));
                } else {
                  $manager->add_control($setting_id, $setting_args);
                }
              }
            }
          }
        }
      }
    }
  }

  /**
   * Resolve select choices.
   *
   * @param  string $source
   * @return array
   */
  private function resolve_select_choices(string $source): array
  {
    $choices = [
      null => __('Select option', THEME_TEXT_DOMAIN),
    ];

    if ($source === 'wp-nav-menus') {
      $menus = wp_get_nav_menus();

      foreach ($menus as $menu) {
        $choices[$menu->term_id] = $menu->name;
      }
    }

    return $choices;
  }
}
