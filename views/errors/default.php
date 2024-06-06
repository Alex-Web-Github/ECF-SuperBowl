<?php

/**
 * Vue par défaut pour les erreurs
 */

use Symfony\Component\Routing\RouteCollection;
?>

<?php require_once APP_ROOT . '/views/header.php'; ?>

<?php if ($error) { ?>
  <div class="alert alert-danger">
    <p><?= $error; ?>
      <a class="" href=" <?= constant('URL_SUBFOLDER') . '/' . $redirection ?>" title="Retour vers la page <?= $redirection ?>"> Retour vers la page <?= $redirection ?> -></a>
    </p>
  </div>
<?php } ?>

<?php require_once APP_ROOT . '/views/footer.php'; ?>