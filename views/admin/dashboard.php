<?php require_once APP_ROOT . '/views/header.php'; ?>


<div class="container-md mt-4 px-2">

  <h1 class="display-5 fw-bolder text-white text-center mb-4">Bienvenue sur votre espace Admin</h1>

  <!-- Navigation des matchs -->
  <ul class="nav nav-underline mb-4" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane" role="tab" aria-controls="all-tab-pane" aria-selected="true" href="#">Créer des Équipes/Joueurs</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link " id="live-tab" data-bs-toggle="tab" data-bs-target="#live-tab-pane" role="tab" aria-controls="live-tab-pane" aria-selected="false" href="#">Configurer des matches</a>
    </li>

  </ul>

  <div class="tab-content">
    <div class="tab-pane active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
      Création des équipes
    </div>

    <div class="tab-pane " id="live-tab-pane" role="tabpanel">
      Configuration des matches
    </div>

  </div>
</div>

<?php require_once APP_ROOT . '/views/footer.php'; ?>