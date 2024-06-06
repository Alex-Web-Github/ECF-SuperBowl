<?php

/**
 * Vue par défaut pour les erreurs
 */

?>

<?php require_once APP_ROOT . '/views/header.php'; ?>

<?php if ($error) { ?>
  <div class="d-flex justify-content-center px-2">
    <div class="d-inline-flex flex-column flex-row-md mt-4 p-4 bg-light rounded-3">
      <p><?= $error; ?></p>
      <?php if (isset($redirection_slug) && isset($redirection_text)) { ?>
        <a class="ps-2 text-decoration-none fw-bold text-secondary" href=" <?= constant('URL_SUBFOLDER') . $redirection_slug ?>" title="<?= $redirection_text ?>"><?= $redirection_text ?> -></a>
      <?php } ?>

    </div>
  </div>
<?php } ?>

<?php require_once APP_ROOT . '/views/footer.php'; ?>