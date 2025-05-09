<?php

namespace WPLite\Utils;

if (! defined('ABSPATH')) die;

use WPLite\Models\Auth;
use WPLite\Utils\Transient;

class Form extends Transient
{
  /**
   * Form name.
   *
   * @access protected
   */
  protected string $name;

  /**
   * Initialize class.
   *
   * @param string    $name     The form name.
   */
  public function __construct(string $name) {
    parent::__construct("form_{$name}", 60 * 10);

    $this->name = $name;
  }

  /**
   * Set form field value.
   *
   * @param string    $key        The form field key.
   * @param mixed     $new_value  The form field value.
   *
   * @return void
   */
  public function set_value(string $key, mixed $new_value): void
  {
    $transient = $this->get_transient() ?? [];

    $transient['values'][$key] = $new_value;

    $this->set_transient($transient);
  }

  /**
   * Set form values.
   *
   * @param array     $new_values The form values.
   *
   * @return void
   */
  public function set_values(array $new_values): void
  {
    $transient = $this->get_transient() ?? [];

    $transient['values'] = $new_values;

    $this->set_transient($transient);
  }

  /**
   * Get form value.
   *
   * @param string    $field    The form field name.
   * @param mixed     $fallback The fallback value.
   *
   * @return mixed
   */
  public function get_value(string $field, mixed $fallback = null): mixed
  {
    $transient = $this->get_transient() ?? [];

    return $transient['values'][$field] ?? $fallback;
  }

  /**
   * Get form values.
   *
   * @return array
   */
  public function get_values(): array
  {
    $transient = $this->get_transient() ?? [];

    return $transient['values'] ?? [];
  }

  /**
   * Clear form values.
   *
   * @return void
   */
  public function clear_values(): void
  {
    $transient = $this->get_transient() ?? [];
    $transient['values'] = [];

    $this->set_transient($transient);
  }

  /**
   * Add form message.
   *
   * @param string    $message  The message message.
   * @param string    $field    The form field name. (Optional)
   *
   * @return void
   */
  public function add_message(string $message, string $field = ''): void
  {
    $transient = $this->get_transient() ?? [];

    if ($field) {
      $transient['messages'][$field] = __($message, THEME_TEXT_DOMAIN);
    } else {
      $transient['messages'][] = __($message, THEME_TEXT_DOMAIN);
    }

    $this->set_transient($transient);
  }

  /**
   * Check if form has messages.
   *
   * @return bool
   */
  public function has_messages(): bool
  {
    return ! empty($this->get_messages());
  }

  /**
   * Get form field message.
   *
   * @param string    $field    The form field name.
   *
   * @return mixed
   */
  public function get_message(string $field): mixed
  {
    $transient = $this->get_transient() ?? [];

    return $transient['messages'][$field] ?? null;
  }

  /**
   * Get form messages.
   *
   * @return array
   */
  public function get_messages(): array
  {
    $transient = $this->get_transient() ?? [];

    return $transient['messages'] ?? [];
  }

  /**
   * Clear form messages.
   *
   * @return void
   */
  public function clear_messages(): void
  {
    $transient = $this->get_transient() ?? [];
    $transient['messages'] = [];

    $this->set_transient($transient);
  }

  /**
   * Add form error.
   *
   * @param string    $message  The error message.
   * @param string    $field    The form field name. (Optional)
   *
   * @return void
   */
  public function add_error(string $message, string $field = ''): void
  {
    $transient = $this->get_transient() ?? [];

    if ($field) {
      $transient['errors'][$field] = __($message, THEME_TEXT_DOMAIN);
    } else {
      $transient['errors'][] = __($message, THEME_TEXT_DOMAIN);
    }

    $this->set_transient($transient);
  }

  /**
   * Check if form has errors.
   *
   * @return bool
   */
  public function has_errors(): bool
  {
    return ! empty($this->get_errors());
  }

  /**
   * Get form field error.
   *
   * @param string    $field    The form field name.
   *
   * @return mixed
   */
  public function get_error(string $field): mixed
  {
    $transient = $this->get_transient() ?? [];

    return $transient['errors'][$field] ?? null;
  }

  /**
   * Get form errors.
   *
   * @return array
   */
  public function get_errors(): array
  {
    $transient = $this->get_transient() ?? [];

    return $transient['errors'] ?? [];
  }

  /**
   * Clear form errors.
   *
   * @return void
   */
  public function clear_errors(): void
  {
    $transient = $this->get_transient() ?? [];
    $transient['errors'] = [];

    $this->set_transient($transient);
  }

  /**
   * Check if file is valid.
   *
   * @param string    $name         The file input name.
   * @param array     $allowed_ext  The allowed file extensions.
   *
   * @return bool
   */
  public static function is_file_valid(string $name, array $allowed_ext = []): bool
  {
    $ext = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);

    return in_array($ext, $allowed_ext);
  }
}
