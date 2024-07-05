<?php

/**
 * Vue des détails d'un match pour le Commentateur
 */

use App\Tools\SecurityTools;
?>

<?php require_once APP_ROOT . '/views/speaker/speaker-header.php'; ?>

<div class="container my-4 p-2">
  <h2 class="fs-2 fw-bolder text-white text-center mb-5">Les détails du match</h2>

  <?php // Affichage des erreurs éventuelles //TODO: à garder ???
  if (isset($error['message'])) { ?>
    <div class="alert alert-danger">
      <?= $error['message']; ?>
    </div>
  <?php } ?>

  <form action="<?= constant('URL_SUBFOLDER') . '/speaker/close-game/' . $game->getGameId() ?>" method="post">
    <input type="hidden" name="game_id" value="<?= $game->getGameId() ?>">
    <input type="hidden" name="game_status" value="Terminé">
    <input type="hidden" name="game_end" value="<?= date('Y-m-d H:i:s') ?>">

    <button type="submit" class="btn btn-danger mx-auto">Fermer ce match</button>

    <div class="row gap-4 mx-0 mt-4">
      <!-- Bloc Infos 1 -->
      <div class="col-12 col-lg table-responsive-lg mb-2 px-0">
        <div class="table-responsive-lg">
          <table class="table table-hover table-light table-striped table-rounded">
            <thead>
              <tr>
                <th scope="col">Heure début</th>
                <th scope="col">Heure fin</th>
                <th scope="col">Status</th>
                <th scope="col">Nb de parieurs</th>
            </thead>

            <tbody class="table-group-divider">
              <?php if ($game !== null) : ?>
                <tr>
                  <td><?= $game->getGameStart() ?></td>
                  <td><?= $game->getGameEnd() ?></td>
                  <td>
                    <span class="badge 
                  <?php
                  switch ($game->getGameStatus()) {
                    case 'En cours':
                      echo 'text-bg-danger';
                      break;
                    case 'Terminé':
                      echo 'text-bg-success';
                      break;
                    case 'A venir':
                      echo 'text-bg-info';
                      break;
                    default:
                      echo 'text-bg-warning';
                  }
                  ?>">
                      <?= $game->getGameStatus() ?>
                    </span>
                  </td>
                  <td>xxx</td>
                </tr>
              <?php else : ?>
                <tr>
                  <td colspan="8">Aucun match n'a été trouvé</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>

        </div>
      </div>
      <!-- Bloc Infos 2 -->
      <div class="col-12 col-lg table-responsive-lg mb-2 px-0">
        <div class="table-responsive-lg">
          <table class="table table-hover table-light table-striped table-rounded">
            <thead>
              <tr>
                <th scope="col">Météo</th>
                <th scope="col">Score</th>
              </tr>
            </thead>

            <tbody class="table-group-divider">
              <?php if ($game !== null) : ?>
                <tr>
                  <td>
                    <select class="form-select form-select-sm" aria-label="météo du match" id="game_weather" name="game_weather">
                      <option selected>Choisir la météo</option>
                      <option value="Soleil">Soleil</option>
                      <option value="Pluie">Pluie</option>
                      <option value="Neige">Neige</option>
                      <option value="Brouillard">Brouillard</option>
                      <option value="Orage">Orage</option>
                    </select>
                  </td>
                  <td class="d-flex gap-1">
                    <input type='number' class='form-control form-control-sm' id='game_team1_score' name='game_team1_score' placeholder='Equipe 1' min='0' max='20' required>
                    <input type='number' class='form-control form-control-sm' id='game_team2_score' name='game_team2_score' placeholder='Equipe 2' min='0' max='20' required>
                  </td>
                </tr>
              <?php else : ?>
                <tr>
                  <td colspan="8">Aucun match n'a été trouvé</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </form>

  <div class="row gap-4 mx-0">
    <!-- Infos Équipe 1 -->
    <?php
    $teamTitle = 'Équipe 1';
    $teamName = htmlspecialchars($game->getTeam1Name(), ENT_QUOTES, 'UTF-8');
    $odds = htmlspecialchars($game->getTeam1Odds(), ENT_QUOTES, 'UTF-8');
    ?>
    <div class="col-12 col-lg p-3 mb-2 bg-light mt-4 rounded-3">
      <div class="fs-5 my-3 px-2"><?= $teamTitle ?>&nbsp;:
        <span class="fw-bold ps-1"><?= $teamName ?></span>
      </div>
      <div class="my-3 px-2">Cote : <span class="fw-bold ps-1"><?= $odds ?></span></div>
      <div class="my-3 px-2">Parieurs en faveur de cette équipe : <span class="fw-bold ps-1">xxx</span></div>
    </div>

    <!-- Infos Équipe 2 -->
    <?php
    $teamTitle = 'Équipe 2';
    $teamName = htmlspecialchars($game->getTeam2Name(), ENT_QUOTES, 'UTF-8');
    $odds = htmlspecialchars($game->getTeam2Odds(), ENT_QUOTES, 'UTF-8');
    ?>

    <div class="col-12 col-lg p-3 mb-2 bg-light mt-4 rounded-3">
      <div class="fs-5 my-3 px-2"><?= $teamTitle ?>&nbsp;:
        <span class="fw-bold ps-1"><?= $teamName ?></span>
      </div>
      <div class="my-3 px-2">Cote : <span class="fw-bold ps-1"><?= $odds ?></span></div>
      <div class="my-3 px-2">Parieurs en faveur de cette équipe : <span class="fw-bold ps-1">xxx</span></div>
    </div>
  </div>

</div>


<?php require_once APP_ROOT . '/views/footer.php'; ?>