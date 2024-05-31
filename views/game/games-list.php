<?php

/**
 * Vue de la liste des matchs sur la page d'accueil dans /views/home.php 
 */
?>
<div class="table-responsive-lg">
  <table class="table table-hover table-striped table-rounded">
    <thead>
      <tr>
        <th scope="col">Équipe 1</th>
        <th scope="col">Équipe 2</th>
        <th scope="col">Date</th>
        <th scope="col">Heure début</th>
        <th scope="col">Heure fin</th>
        <th scope="col">Status</th>
        <th scope="col">Score</th>
        <th scope="col">Détails</th>
      </tr>
    </thead>

    <tbody class="table-group-divider">
      <?php if ($gamesList !== null) : ?>
        <?php foreach ($gamesList as $game) : ?>
          <tr>
            <td><?= $game->getTeam1Name() ?></td>
            <td><?= $game->getTeam2Name() ?></td>
            <td><?= $game->getGameDate() ?></td>
            <td><?= $game->getGameStart() ?></td>
            <td><?= $game->getGameEnd() ?></td>
            <?php if ($game->getGameStatus() == 'En cours') : ?>
              <td><span class="badge text-bg-danger"><?= $game->getGameStatus() ?></span></td>
            <?php elseif ($game->getGameStatus() == 'Terminé') : ?>
              <td><span class="badge text-bg-success"><?= $game->getGameStatus() ?></span></td>
            <?php else : ?>
              <td><span class="badge text-bg-warning"><?= $game->getGameStatus() ?></span></td>
            <?php endif; ?>
            <?php if ($game->getGameStatus() === 'Terminé' || $game->getGameStatus() === 'En cours') : ?>
              <td><?= $game->getGameScore() ?></td>
            <?php else : ?>
              <td>-</td>
            <?php endif; ?>
            <td>
              <a href="<?= constant('URL_SUBFOLDER') . '/game/' . $game->getGameId(); ?>" title="les détails du match">
                <button type="button" class="btn btn-primary btn-sm">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"></path>
                  </svg>
                  infos
                </button>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr>
          <td colspan="8">Aucun match n'a été trouvé</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

</div>