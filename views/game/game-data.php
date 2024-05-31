<?php

/**
 * Template de la vue game/game-data.php
 * Utilise le Template Partial views/team/team-data-partial.php
 */

use App\Tools\SecurityTools;

?>

<?php require_once APP_ROOT . '/views/header.php'; ?>

<div class="container-md my-4 px-2">
  <h2 class="display-6 fw-bolder text-white text-center mb-4">Les détails du match</h2>

  <div class="row mx-0">
    <!-- Bloc Infos 1 -->
    <div class="col-lg-7 table-responsive-lg mb-2 px-0">
      <table class="table table-hover table-striped table-rounded h-100">
        <thead>
          <tr>
            <th scope="col">Équipe 1</th>
            <th scope="col">Date</th>
            <th scope="col">Début</th>
            <th scope="col">Fin</th>
            <th scope="col">Équipe 2</th>
          </tr>
        </thead>

        <tbody class="table-group-divider">
          <tr>
            <td><?= $game->getTeam1Name() ?></td>
            <td><?= $game->getGameDate() ?></td>
            <td><?= $game->getGameStart() ?></td>
            <td><?= $game->getGameEnd() ?></td>
            <td><?= $game->getTeam2Name() ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Bloc Infos 2 -->
    <div class="col-lg-4 offset-lg-1 table-responsive-lg mb-2 px-0">
      <table class="table table-hover table-striped table-rounded h-100">
        <thead>
          <tr>
            <th scope="col">Météo</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>

        <tbody class="table-group-divider">
          <tr>

            <td>
              <div class="ps-3"><?= $game->getGameWeather() ?></div>
            </td>
            <?php if ($game->getGameStatus() == 'En cours') : ?>
              <td><span id="statusBadge" class="badge text-bg-danger"><?= $game->getGameStatus() ?></span></td>
            <?php elseif ($game->getGameStatus() == 'Terminé') : ?>
              <td><span id="statusBadge" class="badge text-bg-success"><?= $game->getGameStatus() ?></span></td>
            <?php else : ?>
              <td><span id="statusBadge" class="badge text-bg-warning"><?= $game->getGameStatus() ?></span></td>
            <?php endif; ?>
            <?php if ($game->getGameStatus() === 'Terminé' || $game->getGameStatus() === 'En cours') : ?>
            <?php else : ?>

            <?php endif; ?>
            <td>
              <?php
              if ($game->getGameStatus() !== 'Terminé') : ?>

                <?php if (SecurityTools::isLogged()) : ?>
                  <a href="<?= constant('URL_SUBFOLDER') . '/miser' ?>" title="miser sur ce match">
                    <button class="btn btn-danger btn-sm " type="button">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                        <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                        <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567" />
                      </svg>
                      Miser
                    </button>
                  </a>
                <?php
                // Le bouton déclenche une Modal pour se connecter
                else : ?>
                  <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                      <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                      <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
                      <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567" />
                    </svg>
                    Miser
                  </button>
                <?php endif; ?>

              <?php else : ?>
                <div class="ps-3">-</div>
              <?php endif; ?>
            </td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>

  <div class="d-flex flex-column flex-md-row justify-content-between flex-wrap">
    <!-- Infos Équipe 1 -->
    <?php
    $teamTitle = 'Équipe 1';
    $teamName = $game->getTeam1Name();
    $odds = $game->getTeam1Odds();
    $teamPlayers = $team1Players;

    require APP_ROOT . '/views/team/team-data-partial.php';
    ?>
    <div class="px-md-2 px-lg-4"></div>

    <!-- Infos Équipe 2 -->
    <?php
    $teamTitle = 'Équipe 2';
    $teamName = $game->getTeam2Name();
    $odds = $game->getTeam2Odds();
    $teamPlayers = $team2Players;

    require APP_ROOT . '/views/team/team-data-partial.php';
    ?>
  </div>

  <!-- Bloc Score & Commentaires  -->
  <!-- <div class="row mx-0">
    <div class="col table-responsive-lg mb-2">
      <table class="table table-hover table-striped table-rounded h-100">
        <thead>
          <tr>
            <th scope="col">Score</th>
            <th scope="col">Commentaires</th>
          </tr>
        </thead>

        <tbody class="table-group-divider">
          <tr>
            <td>Le score ICI</td>
            <td>Les commentaires ICI</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div> -->

</div>

<!-- Modal si l'utilisateur !isLogged -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Avertissement :</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body fs-bold fs-5">
        Pour miser il faut être connecté...
      </div>
      <div class="modal-footer">
        <a href="<?= constant('URL_SUBFOLDER') . '/register' ?>" title="Créer un compte">
          <button type="button" class="btn btn-secondary">S'inscrire</button>
        </a>

        <a href="<?= constant('URL_SUBFOLDER') . '/login' ?>" title="Connexion">
          <button type="button" class="btn btn-primary">Se connecter</button>
        </a>
      </div>
    </div>
  </div>
</div>


<?php require_once APP_ROOT . '/views/footer.php'; ?>