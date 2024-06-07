<?php

/**
 * Template de la vue 'Formulaire de configuration de pari multiple' dans /views/bet/betMultipleConfigForm.php
 */

use App\Tools\SecurityTools;
?>

<?php
// Modal de demande de confirmation pour la validation du pari multiple
require_once APP_ROOT . '/views/bet/confirmation-modal.php';
// Modal si l'utilisateur !isLogged
require_once APP_ROOT . '/views/auth/login-modal.php';
?>

<?php require_once APP_ROOT . '/views/header.php'; ?>

<div class="container-lg my-4 px-2">

  <form class="p-0" method="post" action="<?= constant('URL_SUBFOLDER') . '/bet/multiple/config' ?>">

    <?php
    // Affichage du template PARTIAL du formulaire de pari
    foreach ($gamesSelectedData as $game) : ?>
      <div class="p-3 border rounded-3 mb-4">
        <p class="text-white">Date du match : <span class="fs-6 text-white"><?= $game->getGameDate() ?></span></p>
        <?php require APP_ROOT . '/views/bet/bet-partial.php'; ?>
      </div>
    <?php endforeach; ?>

    <!-- Submit Button -->
    <div class="form-group">
      <?php if (SecurityTools::isLogged()) : ?>
        <button type="button" name="submitBetMultipleConfig" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#betConfModal">Valider ma sélection</button>
      <?php else : ?>
        <button type="button" name="submitBetMultipleConfig" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#betAuthModal">Valider ma sélection</button>
      <?php endif; ?>
    </div>
  </form>

</div>

<?php require_once APP_ROOT . '/views/footer.php'; ?>