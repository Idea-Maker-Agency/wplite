<div class="form-check">
  <input
    <?= implode(' ', $args['attrs']) ?>
    <?= checked($args['request_value'], $args['value']) ?>
    value="<?= $args['value'] ?>">

  <?php if (! $args['hide_label']) { ?>
    <label
      for="<?= $args['id'] ?>"
      class="form-check-label">
      <?= $args['label'] ?>
    </label>
  <?php } ?>
</div>
