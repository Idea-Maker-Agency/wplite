<?php if (! $args['hide_label']) { ?>
  <label
    for="<?= $args['id'] ?>"
    class="form-label">
    <?= $args['label'] ?>

    <?php if ($args['required']) { ?>
      <span class="text-danger">*</span>
    <?php } ?>
  </label>
<?php } ?>

<input
  <?= implode(' ', $args['attrs']) ?>
  value="<?= $args['request_value'] ?? $args['value'] ?>">
