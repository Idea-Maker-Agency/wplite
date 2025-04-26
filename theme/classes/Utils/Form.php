<?php

namespace WPLite\Utils;

if (! defined('ABSPATH')) die;

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
   * Initialize class.
   *
   * @param string    $name     The form name.
   */
  public function __construct(string $name) {
    $this->name = $name;
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
    $prev_values = $_SESSION["form_{$this->name}"]['values'];

    $this->values = array_merge($prev_values, $new_values);

    $_SESSION["form_{$this->name}"]['values'] = $this->values;
  }

  /**
   * Get form value.
   *
   * @param string    $field    The form field name.
   *
   * @return mixed
   */
  public function get_value(string $field): mixed
  {
    $value = $_SESSION["form_{$this->name}"]['values'][$field] ?? '';

    return $value;
  }

  /**
   * Get form values.
   *
   * @return array
   */
  public function get_values(): array
  {
    $values = $_SESSION["form_{$this->name}"]['values'] ?? [];

    return $values;
  }

  /**
   * Clear form values.
   *
   * @return void
   */
  public function clear_values(): void
  {
    $this->values = [];

    unset($_SESSION["form_{$this->name}"]['values']);
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
    if ($field) {
      $this->messages[$field] = __($message, THEME_TEXT_DOMAIN);
    } else {
      $this->messages[] = __($message, THEME_TEXT_DOMAIN);
    }

    $_SESSION["form_{$this->name}"]['messages'] = $this->messages;
  }

  /**
   * Check if form has messages.
   *
   * @return bool
   */
  public function has_messages(): bool
  {
    return ! empty($this->messages);
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
    $value = $_SESSION["form_{$this->name}"]['messages'][$field] ?? '';

    return $value;
  }

  /**
   * Get form messages.
   *
   * @return array
   */
  public function get_messages(): array
  {
    $messages = $_SESSION["form_{$this->name}"]['messages'] ?? [];

    return $messages;
  }

  /**
   * Clear form messages.
   *
   * @return void
   */
  public function clear_messages(): void
  {
    $this->messages = [];

    unset($_SESSION["form_{$this->name}"]['messages']);
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
    if ($field) {
      $this->errors[$field] = __($message, THEME_TEXT_DOMAIN);
    } else {
      $this->errors[] = __($message, THEME_TEXT_DOMAIN);
    }

    $_SESSION["form_{$this->name}"]['errors'] = $this->errors;
  }

  /**
   * Check if form has errors.
   *
   * @return bool
   */
  public function has_errors(): bool
  {
    return ! empty($this->errors);
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
    $value = $_SESSION["form_{$this->name}"]['errors'][$field] ?? '';

    return $value;
  }

  /**
   * Get form errors.
   *
   * @return array
   */
  public function get_errors(): array
  {
    $errors = $_SESSION["form_{$this->name}"]['errors'] ?? [];

    return $errors;
  }

  /**
   * Clear form errors.
   *
   * @return void
   */
  public function clear_errors(): void
  {
    $this->errors = [];

    unset($_SESSION["form_{$this->name}"]['errors']);
  }
}
