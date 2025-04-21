<?php
$name = $args['name'] ?? '';
$label = $args['label'] ?? '';
$type = $args['type'] ?? 'text';
$placeholder = $args['placeholder'] ?? '';
$disabled = $args['disabled'] ?? false;
$required = $args['required'] ?? false;

$form_value = $args['form_value'] ?? '';
?>

<?php if ($label) { ?>
  <label
    for="id_<?= $name ?>"
    class="form-label">
    <?= $label ?>
  </label>
<?php } ?>

<input
  name="<?= $name ?>"
  id="id_<?= $name ?>"
  type="<?= $type ?>"
  placeholder="<?= $placeholder ?>"
  value="<?= ('password' !== $type) ? $form_value : '' ?>"
  <?= $disabled ? 'disabled' : '' ?>
  <?= $required ? 'required' : '' ?>
  class="form-control">
