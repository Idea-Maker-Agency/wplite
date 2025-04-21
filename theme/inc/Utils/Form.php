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
   * @param array     $values     The form values.
   *
   * @return void
   */
  public function set_values(array $values): void
  {
    $this->values = $values;

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
   * Add form error.
   *
   * @param string    $message  The error message.
   * @param string    $field    The form field name. (Optional)
   *
   * @return void
   */
  protected function add_error(string $message, string $field = ''): void
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
  protected function clear_errors(): void
  {
    $this->errors = [];

    unset($_SESSION["form_{$this->name}"]['errors']);
  }
}
