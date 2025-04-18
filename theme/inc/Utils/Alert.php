<?php

namespace WPLite\Utils;

if (! defined('ABSPATH')) die;

class Alert
{
  /**
   * Add new alert.
   *
   * @param string    $message  The alert message.
   * @param string    $type     The alert type.
   *
   * @return void
   */
  public static function add(string $message, string $type = 'success'): void
  {
    $alerts = $_SESSION['alerts'][$type] ?? [];

    $alerts[] = __($message, THEME_TEXT_DOMAIN);

    $_SESSION['alerts'][$type] = array_unique($alerts);
  }

  /**
   * Get alerts by type.
   *
   * @param string    $type     The alert type.
   *
   * @return array
   */
  public static function get(string $type = 'success'): array
  {
    $alerts = $_SESSION['alerts'][$type] ?? [];

    return $alerts;
  }

  /**
   * Render alerts by type.
   *
   * @param string    $type     The alert type.
   */
  public static function render(string $type = 'success')
  {
    get_template_part('src/Views/Widgets/alerts', null, [
      'type' => $type,
    ]);
  }

  /**
   * Clear the alerts.
   *
   * @return void
   */
  public static function clear(): void
  {
    unset($_SESSION['alerts']);
  }
}
