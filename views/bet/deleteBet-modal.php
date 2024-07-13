<?php
/*
  * Modal de demande de confirmation pour supprimer un pari depuis le Dashboard User
  */

/** REMARQUE : // TODO : A supprimer ???
 * Le bouton "visible" du formulaire déclenche l'ouverture de la modal. Au clic sur le bouton de confirmation, on déclenche le submit du formulaire qui est en réalité caché.
 * Je n'ai pas trouvé d'autre solution pour déclencher le submit du formulaire caché sans passer par du JavaScript.
 */
?>

<!-- Modal de confirmation de suppression d'un pari -->
<div class="modal fade" id="deleteBetModal" tabindex="-1" aria-labelledby="deleteBetModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-light">
      <form action="" method="post">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="deleteBetModalLabel">Avertissement :</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body fs-bold fs-5">
          Vous êtes sur le point de supprimer votre pari.</br> Êtes-vous sûr de vouloir continuer ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Annuler</button>

          <button type="button" id="submitDeleteBet" name="submitDeleteBet" class="btn btn-primary">Supprimer mon pari</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  let submitDeleteBet = document.getElementById('submitDeleteBet');

  submitDeleteBet.addEventListener('click', function() {
    let submitButton = document.getElementById('deleteBet');
    submitButton.click();

  });
</script>