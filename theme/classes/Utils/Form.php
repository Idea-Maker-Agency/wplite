<?php

namespace WPLite\Utils;

if (! defined('ABSPATH')) die;

use WPLite\Models\Auth;

class Form
{
  /**
   * Form name.
   *
   * @access protected
   */
  protected string $name;

  /**
   * Form values array.
   *
   * @access protected
   */
  protected array $values = [];

  /**
   * Form messages array.
   *
   * @access protected
   */
  protected array $messages = [];

  /**
   * Form errors array.
   *
   * @access protected
   */
  protected array $errors = [];

  /**
   * Transient expiration.
   *
   * @access protected
   */
  protected int $transient_expiration = 60 * 10; // Expires after 10mins

  /**
   * Initialize class.
   *
   * @param string    $name     The form name.
   */
  public function __construct(string $name) {
    $this->name = $name;

    if (! isset($_COOKIE['user_id'])) {
      $user_id = wp_generate_uuid4();

      setcookie(
        'user_id',
        $user_id,
        time() + DAY_IN_SECONDS,
        COOKIEPATH,
        COOKIE_DOMAIN
      );

      $_COOKIE['user_id'] = $user_id;
    }
  }

  /**
   * Transient key.
   *
   * @return string
   */
  protected function transient_key(): string
  {
    if (Auth::check()) {
      $user_id = Auth::id();
    } else {
      $user_id = $_COOKIE['user_id'];
    }

    return "form_{$this->name}_{$user_id}";
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
    $key = $this->transient_key();

    $prev_values = get_transient("{$key}_values") ?: [];
    $prev_values[$key] = $new_value;

    $this->values = $prev_values;

    set_transient(
      "{$key}_values",
      $this->values,
      $this->transient_expiration
    );
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
    $key = $this->transient_key();

    $prev_values = get_transient("{$key}_values") ?: [];

    $this->values = array_merge($prev_values, $new_values);

    set_transient(
      "{$key}_values",
      $this->values,
      $this->transient_expiration
    );
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
    $key = $this->transient_key();

    $values = get_transient("{$key}_values") ?: [];

    return $values[$field] ?? $fallback;
  }

  /**
   * Get form values.
   *
   * @return array
   */
  public function get_values(): array
  {
    $key = $this->transient_key();

    $values = get_transient("{$key}_values") ?: [];

    return $values;
  }

  /**
   * Clear form values.
   *
   * @return void
   */
  public function clear_values(): void
  {
    $key = $this->transient_key();

    $this->values = [];

    delete_transient("{$key}_values");
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
    $key = $this->transient_key();

    if ($field) {
      $this->messages[$field] = __($message, THEME_TEXT_DOMAIN);
    } else {
      $this->messages[] = __($message, THEME_TEXT_DOMAIN);
    }

    set_transient(
      "{$key}_messages",
      $this->messages,
      $this->transient_expiration
    );
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
    $key = $this->transient_key();

    $messages = get_transient("{$key}_messages") ?: [];

    return $messages[$field] ?? '';
  }

  /**
   * Get form messages.
   *
   * @return array
   */
  public function get_messages(): array
  {
    $key = $this->transient_key();

    $messages = get_transient("{$key}_messages") ?: [];

    return $messages;
  }

  /**
   * Clear form messages.
   *
   * @return void
   */
  public function clear_messages(): void
  {
    $key = $this->transient_key();

    $this->messages = [];

    delete_transient("{$key}_messages");
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
    $key = $this->transient_key();

    if ($field) {
      $this->errors[$field] = __($message, THEME_TEXT_DOMAIN);
    } else {
      $this->errors[] = __($message, THEME_TEXT_DOMAIN);
    }

    set_transient(
      "{$key}_errors",
      $this->errors,
      $this->transient_expiration
    );
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
    $key = $this->transient_key();

    $errors = get_transient("{$key}_errors") ?: [];

    return $errors[$field] ?? '';
  }

  /**
   * Get form errors.
   *
   * @return array
   */
  public function get_errors(): array
  {
    $key = $this->transient_key();

    $errors = get_transient("{$key}_errors") ?: [];

    return $errors;
  }

  /**
   * Clear form errors.
   *
   * @return void
   */
  public function clear_errors(): void
  {
    $key = $this->transient_key();

    $this->errors = [];

    delete_transient("{$key}_errors");
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
