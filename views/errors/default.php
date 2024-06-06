<?php

/**
 * Vue par défaut pour les erreurs
 */

?>

<?php require_once APP_ROOT . '/views/header.php'; ?>

<?php if ($error) { ?>
  <div class="container alert alert-danger mt-4 p-4 bg-light rounded-3">
    <span><?= $error; ?>

      <?php if (isset($redirection)) { ?>
        <a class="ps-2 text-decoration-none fw-bold" href=" <?= constant('URL_SUBFOLDER') . '/' . $redirection ?>" title="Retour vers la page <?= $redirection ?>"> Retour vers la page <?= $redirection ?> -></a>
      <?php } ?>

    </span>
  </div>
<?php } ?>

<?php require_once APP_ROOT . '/views/footer.php'; ?>