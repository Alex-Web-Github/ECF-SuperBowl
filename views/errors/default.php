<?php require_once APP_ROOT . '/views/header.php'; ?>

<?php if ($error) { ?>
  <div class="alert alert-danger">
    <?= $error; ?>
  </div>
<?php } ?>

<?php require_once APP_ROOT . '/views/footer.php'; ?>