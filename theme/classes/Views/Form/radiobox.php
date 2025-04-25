<?php
$name = $args['name'] ?? '';
$value = $args['value'] ?? '';
$label = $args['label'] ?? '';
$disabled = $args['disabled'] ?? false;
$required = $args['required'] ?? false;

$form_value = $args['form_value'] ?? '';
?>

<div class="form-check">
  <input
    name="<?= $name ?>"
    id="id_<?= $name ?>"
    class="form-check-input"
    type="radio"
    value="<?= $value ?>"
    <?= $disabled ? 'disabled' : '' ?>
    <?= $required ? 'required' : '' ?>
    <?= checked($form_value, $value) ?>>

  <?php if ($label) { ?>
    <label
      for="id_<?= $name ?>"
      class="form-check-label">
      <?= $label ?>
    </label>
  <?php } ?>
</div>
