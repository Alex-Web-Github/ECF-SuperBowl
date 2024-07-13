<?php

/**
 * Template de la vue 'Formulaire de configuration de pari multiple' dans /views/bet/betMultipleConfigForm.php
 */

use App\Tools\SecurityTools;
?>

<?php
// Modal de demande de confirmation pour la validation du pari multiple
require_once APP_ROOT . '/views/bet/multipleBetValidation-modal.php';
// Modal si l'utilisateur n'est pas connecté
require_once APP_ROOT . '/views/auth/login-modal.php';
?>

<?php require_once APP_ROOT . '/views/header.php'; ?>

<div class="container-lg my-4 px-2">

  <form id="betMultipleConfigForm" class="p-0" method="post" action="">

    <?php
    // Affichage du template PARTIAL du pari pour chaque match sélectionné
    foreach ($gamesSelectedData as $game) :
      $gameId = $game->getGameId();
    ?>

      <div class="p-3 border rounded-3 mb-4">
        <p class="text-white">Date du match : <span class="fs-6 text-white"><?= date('d/m/y', strtotime($game->getGameDate())) ?></span></p>
        <?php
        // Alerte en cas d'erreur sur la mise du pari
        if (isset($errorBetSelection[$gameId]) && !empty($errorBetSelection[$gameId]['message'])) {
          echo '<div class="alert alert-danger">' . $errorBetSelection[$gameId]['message'] . '</div>';
        }
        // Alerte en cas d'existence d'un pari pour ce match
        if (isset($messageBetSelection[$gameId]) && !empty($messageBetSelection[$gameId]['message'])) {
          echo '<div class="alert alert-info">' . $messageBetSelection[$gameId]['message'] . '</div>';
        }
        ?>
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
                  <td><?= htmlspecialchars($game->getTeam1Name(), ENT_QUOTES, 'UTF-8') ?></td>
                  <td><?= htmlspecialchars($game->getTeam1Odds(), ENT_QUOTES, 'UTF-8') ?></td>
                  <td>
                    <input type="number" name="bet_amount1[]" id="bet_amount1_<?= $game->getGameId() ?>" class="form-control <?= (isset($error[$game->getGameId()]['bet_amount1']) ? 'is-invalid' : '') ?>" placeholder="votre mise" step="1" value="<?= isset($oldBet[$gameId]['betAmount1_Old']) ? $oldBet[$gameId]['betAmount1_Old'] : '0' ?>">
                    <?php if (isset($error[$game->getGameId()]['bet_amount1'])) { ?>
                      <div class="invalid-tooltip"><?= $error[$game->getGameId()]['bet_amount1'] ?></div>
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
                  <td><?= htmlspecialchars($game->getTeam2Name(), ENT_QUOTES, 'UTF-8') ?></td>
                  <td><?= htmlspecialchars($game->getTeam2Odds(), ENT_QUOTES, 'UTF-8') ?></td>
                  <td>
                    <input type="number" name="bet_amount2[]" id="bet_amount2_<?= $game->getGameId() ?>" class="form-control <?= (isset($error[$game->getGameId()]['bet_amount2']) ? 'is-invalid' : '') ?>" placeholder="votre mise" step="1" value="<?= isset($oldBet[$gameId]['betAmount2_Old']) ? $oldBet[$gameId]['betAmount2_Old'] : '0' ?>">
                    <?php if (isset($error[$game->getGameId()]['bet_amount2'])) { ?>
                      <div class="invalid-tooltip"><?= $error[$game->getGameId()]['bet_amount2'] ?></div>
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
      <?php if (SecurityTools::isLogged()) : // Display-none sur le 1er bouton pour permettre le fonctionnement de la Modal de confirmation 
      ?>
        <button type="submit" name="submitBetMultipleConfig" class="d-none" id="betMultipleConfigFormSubmitButton"></button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#betConfModal">Valider ma sélection</button>
      <?php else : // Je demande à l'utilisateur de se connecter
      ?>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#betAuthModal">Valider ma sélection</button>
      <?php endif; ?>
    </div>
  </form>

</div>

<?php require_once APP_ROOT . '/views/footer.php'; ?>