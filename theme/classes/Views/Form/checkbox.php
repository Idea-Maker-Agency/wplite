<?php
$name = $args['name'] ?? '';
$label = $args['label'] ?? '';
$disabled = $args['disabled'] ?? false;
$required = $args['required'] ?? false;

$form_value = $args['form_value'] ?? $args['default_value'];
?>

<div class="form-check">
  <input
    name="<?= $name ?>"
    id="id_<?= $name ?>"
    class="form-check-input"
    type="checkbox"
    value="1"
    <?= $disabled ? 'disabled' : '' ?>
    <?= $required ? 'required' : '' ?>
    <?= checked($form_value, '1') ?>>

  <?php if ($label) { ?>
    <label
      for="id_<?= $name ?>"
      class="form-check-label">
      <?= $label ?>
    </label>
  <?php } ?>
</div>
