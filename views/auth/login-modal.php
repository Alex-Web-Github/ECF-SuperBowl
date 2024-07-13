<?php
/*
  * Modal d'avertissement si l'utilisateur n'est pas connecté
  */
?>


<!-- Modal si l'utilisateur !isLogged -->
<div class="modal fade" id="betAuthModal" tabindex="-1" aria-labelledby="betAuthModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-light">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="betAuthModalLabel">Avertissement :</h1>
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