<?php

/**
 * Vue de la page 404
 */

// ne pas faire indexer cette page par les moteurs de recherche
http_response_code(404);
?>

<?php require_once APP_ROOT . '/views/header.php'; ?>

<div class="container-md mt-4 px-2">
  <div class="row">
    <div class="col-12 col-md-6 text-center mx-auto">
      <p class="display-6 text-white">Oups! </br>la page recherchée n'est pas accessible ou n'existe pas...</p>
      <a href="/" class="btn btn-primary mt-4">Retour à l'accueil</a>
    </div>
  </div>
</div>

<?php require_once APP_ROOT . '/views/footer.php'; ?>