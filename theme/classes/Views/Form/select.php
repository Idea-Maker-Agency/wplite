<?php
$name = $args['name'] ?? '';
$label = $args['label'] ?? '';
$disabled = $args['disabled'] ?? false;
$required = $args['required'] ?? false;
$options = $args['options'] ?? [];

$form_value = $args['form_value'] ?? '';
?>

<?php if ($label) { ?>
  <label
    for="id_<?= $name ?>"
    class="form-label">
    <?= $label ?>

    <?php if ($required) { ?>
      <span class="text-danger">*</span>
    <?php } ?>
  </label>
<?php } ?>

<select
  name="<?= $name ?>"
  id="id_<?= $name ?>"
  aria-describedby="id_<?= $name ?>_helper"
  <?= $disabled ? 'disabled' : '' ?>
  <?= $required ? 'required' : '' ?>
  class="form-control">
  <option
    value=""
    <?= checked($form_value, '') ?>>
    <?= __('Select option', THEME_TEXT_DOMAIN) ?>
  </option>

  <?php foreach ($options as $option) { ?>
    <option
      value="<?= $option['value'] ?>"
      <?= checked($form_value, $option['value']) ?>>
      <?= __($option['text'], THEME_TEXT_DOMAIN) ?>
    </option>
  <?php } ?>
</select>
