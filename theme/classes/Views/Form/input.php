<?php
$name = $args['name'] ?? '';
$label = $args['label'] ?? '';
$type = $args['type'] ?? 'text';
$placeholder = $args['placeholder'] ?? '';
$disabled = $args['disabled'] ?? false;
$required = $args['required'] ?? false;
$readonly = $args['readonly'] ?? false;

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

<input
  name="<?= $name ?>"
  id="id_<?= $name ?>"
  type="<?= $type ?>"
  placeholder="<?= $placeholder ?>"
  value="<?= ('password' !== $type) ? $form_value : '' ?>"
  aria-describedby="id_<?= $name ?>_helper"
  <?= $disabled ? 'disabled' : '' ?>
  <?= $required ? 'required' : '' ?>
  <?= $readonly ? 'readonly' : '' ?>
  class="form-control">
