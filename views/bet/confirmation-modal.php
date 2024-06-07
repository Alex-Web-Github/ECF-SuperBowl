<?php
/*
  * Modal de demande de confirmation pour la validation du pari multiple
  */

/** REMARQUE : 
 * Le bouton "visible" du formulaire déclenche l'ouverture de la modal. Au clic sur le bouton de confirmation, on déclenche le submit du formulaire qui est en réalité caché.
 * Je n'ai pas trouvé d'autre solution pour déclencher le submit du formulaire caché sans passer par du JavaScript.
 */
?>

<!-- Modal de confirmation de pari -->
<div class="modal fade" id="betConfModal" tabindex="-1" aria-labelledby="betConfModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-light">
      <form action="" method="post">
        <div class=" modal-header">
          <h1 class="modal-title fs-5" id="betConfModalLabel">Avertissement :</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body fs-bold fs-5">
          Vous êtes sur le point de valider votre sélection. Êtes-vous sûr de vouloir continuer ?
        </div>
        <div class="modal-footer">
          <button type="button" id="submitBetMultipleConfig" name="submitBetMultipleConfig" class="btn btn-primary">Valider ma sélection</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  let submitBetMultipleConfig = document.getElementById('submitBetMultipleConfig');
  submitBetMultipleConfig.addEventListener('click', function() {
    let submitButton = document.getElementById('betMultipleConfigFormSubmitButton');
    submitButton.click();
  });
</script>