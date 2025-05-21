<?php

namespace WPLite\Controllers\Admin;

if (! defined('ABSPATH')) {
  die;
}

use WP_Customize_Manager;
use WP_Customize_Image_Control;
use Spyc;

class ThemeCustomizerController
{
  /**
   * Init.
   *
   * @return void
   */
  public static function init(): void
  {
    add_action('customize_register', [self::class, 'register']);
  }

  /**
   * Register customizer.
   *
   * @param WP_Customize_Manager $manager The WP Customizer Manager instance.
   *
   * @return void
   */
  public static function register(WP_Customize_Manager $manager): void
  {
    $panels = Spyc::YAMLLoad(get_theme_file_path('/config/customizer.yaml'));

    if (! empty($panels)) {
      foreach ($panels as $panel_key => $panel) {
        $panel_id = "wplite_{$panel_key}";

        $manager->add_panel($panel_id, [
          'title'       => __($panel['title'], THEME_TEXT_DOMAIN),
          'description' => __($panel['description'], THEME_TEXT_DOMAIN),
          'priority'    => $panel['priority'] ?? 10,
        ]);

        if (! empty($panel['sections'])) {
          foreach ($panel['sections'] as $section_key => $section) {
            $section_id = "wplite_{$section_key}";

            $manager->add_section($section_id, [
              'title' => __($section['title'], THEME_TEXT_DOMAIN),
              'panel' => $panel_id,
            ]);

            if (! empty($section['settings'])) {
              foreach ($section['settings'] as $setting_key => $setting) {
                $setting_id   = "{$section_id}_{$setting_key}";
                $setting_args = [
                  'label'       => __($setting['label'], THEME_TEXT_DOMAIN),
                  'description' => __($setting['description'] ?? '', THEME_TEXT_DOMAIN),
                  'section'     => $section_id,
                  'settings'    => $setting_id,
                  'type'        => $setting['type'],
                ];

                if (
                  'select' === $setting['type']
                  && isset($setting['choices'])
                ) {
                  $setting_args['choices'] = self::resolve_select_choices($setting['choices']);
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
   * @param string $source The select choices source.
   *
   * @return array
   */
  private static function resolve_select_choices(string $source): array
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
