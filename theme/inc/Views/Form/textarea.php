<?php
$name = $args['name'] ?? '';
$label = $args['label'] ?? '';
$placeholder = $args['placeholder'] ?? '';
$disabled = $args['disabled'] ?? false;
$required = $args['required'] ?? false;
$rows = $args['rows'] ?? 10;
$cols = $args['cols'] ?? 6;

$form_value = $args['form_value'] ?? '';
?>

<?php if ($label) { ?>
  <label
    for="id_<?= $name ?>"
    class="form-label">
    <?= $label ?>
  </label>
<?php } ?>

<textarea
  name="<?= $name ?>"
  id="id_<?= $name ?>"
  placeholder="<?= $placeholder ?>"
  rows="<?= $rows ?>"
  cols="<?= $cols ?>"
  <?= $disabled ? 'disabled' : '' ?>
  <?= $required ? 'required' : '' ?>
  class="form-control"><?= $form_value ?></textarea>
