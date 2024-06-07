<?php
/*
  * Modal de demande de confirmation pour la validation du pari multiple
  */
?>

<!-- Modal de confirmation de pari -->
<div class="modal fade" id="betConfModal" tabindex="-1" aria-labelledby="betConfModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-light">
      <form action="<?= constant('URL_SUBFOLDER') . '/bet/multiple/config' ?>" method="post">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="betConfModalLabel">Avertissement :</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body fs-bold fs-5">
          Vous êtes sur le point de valider votre sélection. Êtes-vous sûr de vouloir continuer ?
        </div>
        <div class="modal-footer">
          <button type="submit" name="submitBetMultipleConfig" class="btn btn-primary">Valider ma sélection</button>
        </div>
      </form>
    </div>
  </div>
</div>