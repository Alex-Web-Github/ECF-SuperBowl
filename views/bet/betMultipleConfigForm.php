<?php

/**
 * Template de la vue 'Formulaire de configuration de pari multiple' dans /views/bet/betMultipleConfigForm.php
 */

use App\Tools\SecurityTools;
?>

<?php
// Modal de demande de confirmation pour la validation du pari multiple
require_once APP_ROOT . '/views/bet/confirmation-modal.php';
// Modal si l'utilisateur n'est pas connecté
require_once APP_ROOT . '/views/auth/login-modal.php';
?>

<?php require_once APP_ROOT . '/views/header.php'; ?>

<div class="container-lg my-4 px-2">

  <?php if (isset($error['bet']['message'])) { ?>
    <div class="alert alert-danger">
      <?= $error['bet']['message']; ?>
      <a href="<?= constant('URL_SUBFOLDER') . $error['bet']['redirection_slug'] ?>" class="btn-primary"><?= $error['bet']['redirection_text'] ?></a>
    </div>
  <?php } ?>

  <form id="betMultipleConfigForm" class="p-0" method="post" action="">

    <?php
    // Affichage du template PARTIAL du pari pour chaque match sélectionné
    foreach ($gamesSelectedData as $game) : ?>
      <div class="p-3 border rounded-3 mb-4">

        <p class="text-white">Date du match : <span class="fs-6 text-white"><?= $game->getGameDate() ?></span></p>

        <!-- Ajout des champs de formulaire pour bet_amount1 et bet_amount2 -->
        <input type="hidden" name="game_id[]" value="<?= $game->getGameId() ?>">

        <div class="row mt-4 mx-0">
          <!-- Bloc Infos 1 -->
          <div class="col-lg mx-lg-2 p-3 mb-2 bg-light rounded-3">
            <table class="table table-hover table-light table-striped table-rounded h-100">
              <thead>
                <tr>
                  <th scope="col">Équipe 1</th>
                  <th scope="col">Cote</th>
                  <th scope="col">Votre mise (Euros)</th>
                </tr>
              </thead>

              <tbody class="table-group-divider">
                <tr>
                  <td><?= $game->getTeam1Name() ?></td>
                  <td><?= $game->getTeam1Odds() ?></td>
                  <td>
                    <input type="number" name="bet_amount1[]" id="bet_amount1_<?= $game->getGameId() ?>" class="form-control <?= (isset($error['bet_amount1']) ? 'is-invalid' : '') ?>" placeholder="votre mise" step="0.01" value="<?php echo isset($error['bet']['betAmount1Old']) ? $error['bet']['betAmount1Old'] : '' ?>">
                    <?php if (isset($error['bet_amount1'])) { ?>
                      <div class="invalid-tooltip"><?= $error['bet_amount1'] ?></div>
                    <?php } ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Bloc Infos 2 -->
          <div class="col-lg mx-lg-2 p-3 mb-2 bg-light rounded-3">
            <table class="table table-hover table-light table-striped table-rounded h-100">
              <thead>
                <tr>
                  <th scope="col">Équipe 2</th>
                  <th scope="col">Cote</th>
                  <th scope="col">Votre mise (Euros)</th>
                </tr>
              </thead>

              <tbody class="table-group-divider">
                <tr>
                  <td><?= $game->getTeam2Name() ?></td>
                  <td><?= $game->getTeam2Odds() ?></td>
                  <td>
                    <input type="number" id="bet_amount2_<?= $game->getGameId() ?>" name="bet_amount2[]" class="form-control <?= (isset($error['bet_amount2']) ? 'is-invalid' : '') ?>" placeholder="votre mise" step="0.01" value="<?php echo isset($error['bet']['betAmount2Old']) ? $error['bet']['betAmount2Old'] : '' ?>">
                    <?php if (isset($error['bet_amount2'])) { ?>
                      <div class="invalid-tooltip"><?= $error['bet_amount2'] ?></div>
                    <?php } ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    <?php endforeach; ?>

    <!-- Submit Button -->
    <div class="form-group">
      <?php if (SecurityTools::isLogged()) : ?>
        <button type="submit" name="submitBetMultipleConfig" class="d-none" id="betMultipleConfigFormSubmitButton"></button>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#betConfModal">Valider ma sélection</button>
      <?php else : ?>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#betAuthModal">Valider ma sélection</button>
      <?php endif; ?>
    </div>
  </form>

</div>

<?php require_once APP_ROOT . '/views/footer.php'; ?>