<?php

/**
 * Vue par défaut pour les erreurs
 */

?>

<?php require_once APP_ROOT . '/views/header.php'; ?>

<?php if ($error) { ?>
  <div class="alert alert-danger">
    <p><?= $error; ?>

      <?php if (isset($redirection)) { ?>
        <a class="ps-2 text-decoration-none" href=" <?= constant('URL_SUBFOLDER') . '/' . $redirection ?>" title="Retour vers la page <?= $redirection ?>"> Retour vers la page <?= $redirection ?> -></a>
      <?php } ?>

    </p>
  </div>
<?php } ?>

<?php require_once APP_ROOT . '/views/footer.php'; ?>