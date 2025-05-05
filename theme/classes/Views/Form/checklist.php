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

<?php foreach ($args['options'] as $option) { ?>
  <?php $id = strtolower(str_replace(' ', '-', $option['value'])) ?>

  <div class="form-check">
    <input
      id="id_<?= $id ?>"
      name="<?= $args['name'] ?>[]"
      <?= checked($args['request_value'], $option['value']) ?>
      value="<?= $option['value'] ?>"
      type="checkbox">

    <label
      for="id_<?= $id ?>"
      class="form-check-label">
      <?= $option['text'] ?>
    </label>
  </div>
<?php } ?>
