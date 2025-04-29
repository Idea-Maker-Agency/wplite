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
   * @return self
   */
  public function set_action(string $action): self {
    $this->action = $action;

    return $this;
  }

  /**
   * Add form field.
   *
   * @param string    $label    The form field label. Defaults to empty string.
   * @param array     $args     The form field args. Defaults to empty array.
   * @param string    $name     The form field name.
   *
   * @return self
   */
  public function add_field(
    string $label,
    mixed $args = null,
    string $name = ''
  ): self {
    if (empty($args)) {
			$args = [];
		}

		if (empty($name)) {
			$name = $this->namify($label);
		}

    if (! empty($args['helper_text'])) {
      $args['aria-describedby'] = "id_{$name}_helper";
    }

    $defaults = [
			'type' => 'text',
			'name' => $name,
			'id' => "id_{$name}",
			'label' => __($label, THEME_TEXT_DOMAIN),
			'value' => '',
			'placeholder' => '',
			'class' => [
        'form-control',
      ],
			'min' => '',
			'max' => '',
			'step' => '',
			'autofocus' => false,
			'checked' => false,
			'selected' => false,
			'required' => false,
      'hide_label' => false,
			'options' => [],
      'wrap_id' => '',
      'wrap_class' => [
        'mb-3',
      ],
      'helper_text' => '',
		];

    $this->fields[$name] = array_merge($defaults, $args);

    return $this;
  }

  /**
   * Create a name from a label.
   *
   * @param string    $string   The label string.
   *
   * @return string
   */
  private function namify(string $string): string
  {
    $name = '';

    $name = str_replace('"', '', $string);
		$name = str_replace("'", '', $name);
		$name = str_replace('-', '_', $name);
		$name = preg_replace('~[\W\s]~', '_', $name);

		return strtolower($name);
  }

  /**
   * Render form.
   *
   * @param array     $args   {
   *    The extra form args.
   *    @type string    $submit_text  Submit button text. Defaults to "Submit".
   * }
   *
   * @return void
   */
  public function render(array $args = []): void
  {
    $non_attrs = ['label', 'value', 'options', 'wrap_id', 'wrap_class', 'helper_text', 'hide_label'];
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

    <?php do_action("form_{$this->name}_before", $this) ?>

    <form
      action="<?= $this->action ?>"
      name="<?= $this->name ?>"
      method="post"
      class="clearfix"
      enctype="multipart/form-data">
      <?= wp_nonce_field('wplite') ?>

      <input
        name="action"
        type="hidden"
        value="<?= $this->name ?>">

      <?php do_action("form_{$this->name}_before_fields", $this) ?>

      <?php if(! empty($this->fields)) { ?>
        <fieldset class="row p-0 border-0">
          <?php
          foreach ($this->fields as $name => $args) {
            // Override field value
            $args['request_value'] = $this->get_value($name) ?: null;

            if ('password' === $args['type']) {
              $args['value'] = '';
              $args['request_value'] = '';
            } elseif (in_array($args['type'], ['checkbox', 'radio'])) {
              $class_index = array_search('form-control', $args['class']);

              $args['class'][$class_index] = 'form-check-input';

              if ('checkbox' === $args['type']) {
                $args['value'] = '1';
              }
            }

            // Set field attributes
            $args['attrs'] = array_filter($args, function ($value, $key) use ($non_attrs) {
              if (empty($value)) return false;

              if (in_array($key, $non_attrs)) return false;

              return true;
            }, ARRAY_FILTER_USE_BOTH);

            $args['attrs'] = array_map(function ($key, $value) {
              if (is_array($value)) $value = implode(' ', $value);

              return $key . '="' . $value . '"';
            }, array_keys($args['attrs']), $args['attrs']);
          ?>
            <div
              <?= ! empty($args['wrap_id']) ? 'id="' . $args['wrap_id'] . '"' : '' ?>
              <?= ! empty($args['wrap_class']) ? 'class="' . implode(' ', $args['wrap_class']) . '"' : '' ?>
              <?= ('hidden' === $args['type']) ? 'hidden' : '' ?>>
              <?php if ('select' === $args['type']) { ?>
                <?php get_template_part('classes/Views/Form/select', null, $args) ?>
              <?php } elseif ('checkbox' === $args['type']) { ?>
                <?php get_template_part('classes/Views/Form/checkbox', null, $args) ?>
              <?php } elseif ('radio' === $args['type']) { ?>
                <?php get_template_part('classes/Views/Form/radiobox', null, $args) ?>
              <?php } elseif ('textarea' === $args['type']) { ?>
                <?php get_template_part('classes/Views/Form/textarea', null, $args) ?>
              <?php } else { ?>
                <?php get_template_part('classes/Views/Form/input', null, $args) ?>
              <?php } ?>

              <?php if (! empty($args['helper_text'])) { ?>
                <div
                  id="<?= $args['aria-describedby'] ?>"
                  class="form-text">
                  <?= $args['helper_text'] ?>
                </div>
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

      <?php do_action("form_{$this->name}_after_fields", $this) ?>

      <button
        type="submit"
        class="btn btn-primary">
        <?= __($args['submit_text'] ?? 'Submit', THEME_TEXT_DOMAIN) ?>
      </button>
    </form>

    <?php do_action("form_{$this->name}_after", $this) ?>
  <?php
  }
}
