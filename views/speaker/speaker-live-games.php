<?php

/**
 * TEMPLATE de la liste des matchs sur la page d'accueil dans /views/home.php 
 */

use App\Tools\SecurityTools;
?>
<div class="table-responsive-lg">
  <table class="table table-hover table-light table-striped table-rounded">
    <thead>
      <tr>
        <th scope="col">Équipe 1</th>
        <th scope="col">Équipe 2</th>
        <th scope="col">Heure début</th>
        <th scope="col">Heure fin</th>
        <th scope="col">Status</th>
        <th scope="col">Actions</th>
    </thead>

    <tbody class="table-group-divider">
      <?php if ($dailyGames) : ?>
        <?php foreach ($dailyGames as $game) : ?>
          <tr>
            <td><?= htmlspecialchars($game->getTeam1Name(), ENT_QUOTES, 'UTF-8') // Protection contre les failles XSS 
                ?></td>
            <td><?= htmlspecialchars($game->getTeam2Name(), ENT_QUOTES, 'UTF-8')
                ?></td>
            <td><?= htmlspecialchars($game->getGameStart(), ENT_QUOTES, 'UTF-8')
                ?></td>
            <td><?= htmlspecialchars($game->getGameEnd(), ENT_QUOTES, 'UTF-8')
                ?></td>
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
            <td>
              <?php
              if ($game->getGameStatus() === 'En cours') { ?>
                <a href="<?= constant('URL_SUBFOLDER') . '/speaker/game/' . $game->getGameId(); ?>" title="commenter un match">
                  <button type="button" class="btn btn-outline-primary btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-megaphone-fill" viewBox="0 0 16 16">
                      <path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0zm-1 .724c-2.067.95-4.539 1.481-7 1.656v6.237a25 25 0 0 1 1.088.085c2.053.204 4.038.668 5.912 1.56zm-8 7.841V4.934c-.68.027-1.399.043-2.008.053A2.02 2.02 0 0 0 0 7v2c0 1.106.896 1.996 1.994 2.009l.496.008a64 64 0 0 1 1.51.048m1.39 1.081q.428.032.85.078l.253 1.69a1 1 0 0 1-.983 1.187h-.548a1 1 0 0 1-.916-.599l-1.314-2.48a66 66 0 0 1 1.692.064q.491.026.966.06" />
                    </svg>
                    commenter
                  </button>
                </a>
              <?php } elseif ($game->getGameStatus() === 'Terminé') { ?>
                <a href="<?= constant('URL_SUBFOLDER') . '/game/' . $game->getGameId(); ?>" title="détails du match" target="_blank">
                  <button type="button" class="btn btn-outline-primary btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"></path>
                    </svg>
                    infos
                  </button>
                </a>
              <?php } elseif ($game->getGameStatus() === 'A venir') { ?>
                A venir
              <?php } ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr>
          <td colspan="8">Aucun match prévu ce jour</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

</div>