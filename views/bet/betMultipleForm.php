<?php

/**
 * Template de la vue 'Formulaire de pari multiple' dans /views/bet/betMultipleForm.php
 */

use App\Tools\SecurityTools;
?>

<?php
// Modal si l'utilisateur !isLogged
require_once APP_ROOT . '/views/auth/login-modal.php';
?>

<?php require_once APP_ROOT . '/views/header.php'; ?>

<div class="container-lg my-4 px-2">

  <form class="p-0" method="post" action="<?= constant('URL_SUBFOLDER') . '/bet/multiple' ?>">
    <?php
    // Affichage de tous les Games 'À venir'
    require APP_ROOT . '/views/game/games-list.php';
    ?>

    <!-- Submit Button -->
    <div class="form-group">
      <?php if (SecurityTools::isLogged()) : ?>
        <button type="submit" name="submitBetSelection" class="btn btn-primary">Miser sur la sélection</button>
      <?php else : ?>
        <button type="button" name="submitBetSelection" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#betAuthModal">Miser sur la sélection</button>
      <?php endif; ?>
    </div>
  </form>

</div>

<?php require_once APP_ROOT . '/views/footer.php'; ?>