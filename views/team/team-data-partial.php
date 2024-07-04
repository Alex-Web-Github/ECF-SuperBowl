<?php

/**
 *  Template partial appelé dans views/game/game-data.php
 * les paramètres sont : $teamTitle, $teamName, $odds, $teamPlayers
 */
?>

<div class="col w-50 p-3 mb-2 bg-light mt-4 rounded-3">
  <div class="fs-5 my-3 px-2"><?= $teamTitle ?>&nbsp;:
    <span class="fw-bold ps-1"><?= $teamName ?></span>
  </div>
  <div class="my-3 px-2">Cote : <span class="fw-bold ps-1"><?= $odds ?></span></div>
  <div class="table-responsive">
    <table class="table table-sm table-hover table-light table-striped table-rounded">
      <thead>
        <tr class="table-secondary">
          <th scope="col">Prénom</th>
          <th scope="col">Nom</th>
          <th scope="col">Numéro</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <?php foreach ($teamPlayers as $player) : ?>
          <tr>
            <td><?= htmlspecialchars($player->getPlayerFirstname(), ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($player->getPlayerLastname(), ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= $player->getPlayerNumber() ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>