<?php
$type = $args['type'] ?? 'success';
$variant = 'error' === $type ? 'danger' : 'success';

$alerts = WPLite\Utils\Alert::get($type);
?>

<?php if (! empty($alerts)) { ?>
  <?php foreach ($alerts as $alert) {?>
    <div
      class="alert alert-<?= $variant ?> alert-dismissible fade show"
      role="alert">
      <?= $alert ?>

      <a
        class="position-absolute top-0 end-0 m-3"
        data-bs-dismiss="alert"
        aria-label="Close"
        role="button">
        <i class="bi bi-x"></i>
      </a>
    </div>
  <?php } ?>
<?php } ?>
