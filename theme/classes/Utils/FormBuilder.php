<?php

namespace WPLite\Utils;

if (! defined('ABSPATH')) die;

class FormBuilder extends Form
{
  /**
   * The form action.
   *
   * @access public
   */
  public string $action;

  /**
   * Form fields array.
   *
   * @access public
   */
  public array $fields = [];

  /**
   * Initialize class.
   *
   * @param string    $name     The form name.
   */
  public function __construct(string $name) {
    parent::__construct($name);

    $this->action = admin_url('admin-post.php');
  }

  /**
   * Set form action.
   *
   * @param string    $action   The form action.
   *
   * @return $this
   */
  public function set_action(string $action) {
    $this->action = $action;

    return $this;
  }

  /**
   * Add form field.
   *
   * @param string    $name     The form field name.
   * @param string    $label    The form field label. Defaults to empty string.
   * @param string    $type     The form field type. Defaults to "input".
   * @param array     $args     The form field args. Defaults to empty array.
   *
   * @return $this
   */
  public function add_field(
    string $name,
    string $label = '',
    string $type = 'input',
    array $args = []
  ) {
    $this->fields[$name] = [
      'label' => __($label, THEME_TEXT_DOMAIN),
      'type' => $type,
      'args' => $args,
    ];

    return $this;
  }

  /**
   * Render form.
   *
   * @return void
   */
  public function render(): void
  {
  ?>
    <?php if ($non_field_message = $this->get_message('non_field')) { ?>
      <div
        class="alert alert-success"
        role="alert">
        <?= $non_field_message ?>
      </div>
    <?php } ?>

    <?php if ($non_field_error = $this->get_error('non_field')) { ?>
      <div
        class="alert alert-danger"
        role="alert">
        <?= $non_field_error ?>
      </div>
    <?php } ?>

    <form
      action="<?= $this->action ?>"
      name="<?= $this->name ?>"
      method="post">
      <?= wp_nonce_field('wplite') ?>

      <input
        name="action"
        type="hidden"
        value="<?= $this->name ?>">

      <?php if(! empty($this->fields)) { ?>
        <fieldset>
          <?php
          foreach ($this->fields as $name => $field) {
            $args = array_merge($field['args'] ?? [], [
              'name' => $name,
              'label' => $field['label'],
              'type' => $field['type'],
              'form_value' => $this->get_value($name),
            ]);
          ?>
            <div class="mb-3">
              <?php if ('select' === $field['type']) { ?>
                <?php get_template_part('inc/Views/Form/select', null, $args) ?>
              <?php } elseif ('checkbox' === $field['type']) { ?>
                <?php get_template_part('inc/Views/Form/checkbox', null, $args) ?>
              <?php } elseif ('radio' === $field['type']) { ?>
                <?php get_template_part('inc/Views/Form/radiobox', null, $args) ?>
              <?php } elseif ('textarea' === $field['type']) { ?>
                <?php get_template_part('inc/Views/Form/textarea', null, $args) ?>
              <?php } else { ?>
                <?php get_template_part('inc/Views/Form/input', null, $args) ?>
              <?php } ?>

              <?php if ($error = $this->get_error($name)) { ?>
                <div class="invalid-feedback d-block">
                  <?= $error ?>
                </div>
              <?php } ?>
            </div>
          <?php } ?>
        </fieldset>
      <?php } ?>

      <button
        type="submit"
        class="btn btn-primary">
        <?= __('Submit', THEME_TEXT_DOMAIN) ?>
      </button>
    </form>
  <?php

    $this->clear_values();
    $this->clear_messages();
    $this->clear_errors();
  }
}
