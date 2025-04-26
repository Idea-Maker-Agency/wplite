<?php
$name = $args['name'] ?? '';
$label = $args['label'] ?? '';
$placeholder = $args['placeholder'] ?? '';
$disabled = $args['disabled'] ?? false;
$required = $args['required'] ?? false;
$readonly = $args['readonly'] ?? false;
$rows = $args['rows'] ?? 10;
$cols = $args['cols'] ?? 6;

$form_value = $args['form_value'] ?? $args['default_value'];
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

<textarea
  name="<?= $name ?>"
  id="id_<?= $name ?>"
  placeholder="<?= $placeholder ?>"
  rows="<?= $rows ?>"
  cols="<?= $cols ?>"
  aria-describedby="id_<?= $name ?>_helper"
  <?= $disabled ? 'disabled' : '' ?>
  <?= $required ? 'required' : '' ?>
  <?= $readonly ? 'readonly' : '' ?>
  class="form-control"><?= $form_value ?></textarea>
