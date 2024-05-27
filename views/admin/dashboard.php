<?php require_once APP_ROOT . '/views/header.php'; ?>

<div class="container my-4 px-2">
  <h2 class="display-5 fw-bolder text-white text-center mb-4">Espace Administrateur</h2>

  <!-- Navigation des matchs -->
  <ul class="nav nav-underline mb-4" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <a href="#" class="nav-link" id="match-tab" data-bs-toggle="tab" data-bs-target="#match-tab-pane" role="tab" aria-controls="match-tab-pane" aria-selected="true">Les matches</a>
    </li>

    <li class="nav-item" role="presentation">
      <a href="#" class="nav-link" id="team-tab" data-bs-toggle="tab" data-bs-target="#team-tab-pane" role="tab" aria-controls="team-tab-pane" aria-selected="false">Les équipes & joueurs</a>
    </li>
  </ul>

  <div class="tab-content">
    <!-- Bloc Matches -->
    <div class="tab-pane active" id="match-tab-pane" role="tabpanel" aria-labelledby="match-tab" tabindex="0">
      <h3 class="display-5 fw-bolder text-white text-center mb-4">Créer un match</h3>

      <?php require_once APP_ROOT . '/views/admin/add-game.php'; ?>

    </div>

    <!-- bloc Équipes/Joueurs -->
    <div class="tab-pane active" id="team-tab-pane" role="tabpanel" aria-labelledby="team-tab" tabindex="0">
      <h3 class="display-5 fw-bolder text-white text-center mb-4">Créer une équipe</h3>

      <?php require_once APP_ROOT . '/views/admin/add-team.php'; ?>

    </div>

  </div>

</div>


<?php require_once APP_ROOT . '/views/footer.php'; ?>