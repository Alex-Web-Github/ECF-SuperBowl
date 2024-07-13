<?php

/**
 * Vue de la page d'accueil du site
 */
?>

<?php require_once APP_ROOT . '/views/header.php'; ?>

<div class="container-lg my-4 px-2">
  <!-- Navigation des matchs -->
  <ul class="nav nav-underline mb-4" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane" role="tab" aria-controls="all-tab-pane" aria-selected="true" href="#">Tous les matchs</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link " id="live-tab" data-bs-toggle="tab" data-bs-target="#live-tab-pane" role="tab" aria-controls="live-tab-pane" aria-selected="false" href="#">En cours</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link " id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming-tab-pane" role="tab" aria-controls="upcoming-tab-pane" aria-selected="false" href="#">A venir</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link " id="past-tab" data-bs-toggle="tab" data-bs-target="#past-tab-pane" role="tab" aria-controls="past-tab-pane" aria-selected="false" href="#">Terminés</a>
    </li>
  </ul>

  <div class="tab-content">
    <div class="tab-pane active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
      <?php
      require APP_ROOT . '/views/game/games-list.php'; ?>
    </div>

    <div class="tab-pane " id="live-tab-pane" role="tabpanel">
      <?php
      $gamesList = $liveGames;

      require APP_ROOT . '/views/game/games-list.php'; ?>
    </div>

    <div class="tab-pane " id="upcoming-tab-pane" role="tabpanel">
      <?php
      $gamesList = $upcomingGames;

      require APP_ROOT . '/views/game/games-list.php'; ?>
    </div>

    <div class="tab-pane " id="past-tab-pane" role="tabpanel">
      <?php
      $gamesList = $pastGames;

      require APP_ROOT . '/views/game/games-list.php'; ?>
    </div>

  </div>

  <?php require_once APP_ROOT . '/views/footer.php'; ?>