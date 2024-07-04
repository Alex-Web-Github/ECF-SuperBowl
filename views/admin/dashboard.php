<?php

/** 
 * Vue du Dashboard de l'espace administrateur
 * Utilise le Template Partial views/admin/add-game.php et views/admin/add-team.php
 */
?>

<?php require_once APP_ROOT . '/views/header.php'; ?>

<div class="container my-4 p-2">
  <h2 class="display-6 fw-bolder text-white text-center mb-5">Espace Administrateur</h2>

  <?php if (isset($error['gameCreate']['message'])) { ?>
    <div class="alert alert-success">
      <?= $error['gameCreate']['message']; ?>
    </div>
  <?php } elseif (isset($error['teamCreate']['message'])) { ?>
    <div class="alert alert-success">
      <?= $error['teamCreate']['message']; ?>
    </div>
  <?php }
  ?>

  <!-- Navigation des matchs -->
  <ul class="nav nav-underline mb-4" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button type="button" class="nav-link <?php echo $activeTab !== 'team' ? 'active' : '' ?>" id="match-tab" data-bs-toggle="tab" data-bs-target="#match" role="tab" aria-controls="match" aria-selected="<?php echo $activeTab !== 'team' ? 'true' : 'false' ?>">Les matches</button>
    </li>
    <li class="nav-item" role="presentation">
      <button type="button" class="nav-link <?php echo $activeTab == 'team' ? 'active' : '' ?>" id="team-tab" data-bs-toggle="tab" data-bs-target="#team" role="tab" aria-controls="team" aria-selected="<?php echo $activeTab == 'team' ? 'true' : 'false' ?>" tabindex="-1">Les équipes & joueurs</button>
    </li>
  </ul>

  <div class="tab-content">
    <!-- Bloc Matches -->
    <div class="tab-pane <?php echo $activeTab !== 'team' ? 'active' : '' ?>" id="match" role="tabpanel" aria-labelledby="match-tab" tabindex="0">
      <h3 class="fs-2 fw-bolder text-white text-center mb-4">Créer un match</h3>

      <?php require_once APP_ROOT . '/views/admin/add-game.php'; ?>

    </div>

    <!-- bloc Équipes/Joueurs -->
    <div class="tab-pane <?php echo $activeTab == 'team' ? 'active' : '' ?>" id="team" role="tabpanel" aria-labelledby="team-tab" tabindex="0">
      <h3 class="fs-2 fw-bolder text-white text-center mb-4">Créer une équipe</h3>

      <?php require_once APP_ROOT . '/views/admin/add-team.php'; ?>

    </div>

  </div>

</div>


<?php require_once APP_ROOT . '/views/footer.php'; ?>