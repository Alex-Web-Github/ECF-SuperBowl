<?php
/*
  * Modal de formulaire LastName/Email en cas de perte de mot de passe
  */
?>

<div class="modal fade" id="lostPwModal" tabindex="-1" aria-labelledby="lostPwModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content bg-light">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="lostPwModalLabel">Réinitialisation de votre mot de passe</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body fs-bold fs-5">
        Remplir ce formulaire puis vous recevrez un nouveau mot de passe par e-mail.</br>Vous devrez le changer lors de prochaine connexion.
        <!-- Formulaire de renseignement -->
        <form class="col mx-auto px-4 py-4" method="post" action="<?= constant('URL_SUBFOLDER') . '/login' ?>">
          <div class="mb-2">
            <label for="lastName" class="form-label ">Nom</label>
            <input type="text" class="form-control <?= (isset($error['lastName']) ? 'is-invalid' : '') ?>" id="lastName" name="lastName" value="<?= isset($_POST['lastName']) ? $_POST['lastName'] : '' ?>">
            <?php if (isset($error['lastName'])) { ?>
              <div class="invalid-tooltip"><?= $error['lastName'] ?></div>
            <?php } ?>
          </div>
          <div class="mb-2">
            <label for="email" class="form-label ">E-mail</label>
            <input type="email" class="form-control <?= (isset($error['email']) ? 'is-invalid' : '') ?>" id="email" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>">
            <?php if (isset($error['email'])) { ?>
              <div class="invalid-tooltip"><?= $error['email'] ?></div>
            <?php } ?>
          </div>

          <div class="d-flex flex-column flex-lg-row align-items-center gap-4 flex-wrap mt-4">
            <button type="submit" name="lostPwModal" class="btn btn-primary">Envoyer ma demande</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
        </a>
      </div>
    </div>
  </div>
</div>