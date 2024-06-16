<?php

/**
 * Vue Formulaire d'ajout d'une équipe dans l'espace administrateur
 */
?>

<form class="row g-3 text-left mt-4 mx-0" action="/admin/dashboard" method="post">

  <!-- Bouton de validation -->
  <div class="col-12 text-center mb-5">
    <button type="submit" name="createTeam" class="btn btn-secondary">Créer cette équipe</button>
  </div>


  <!-- Nom de l'équipe -->
  <div class="col-md-4 mb-2">
    <label for="teamName" class="form-label text-white">Nom de l'équipe</label>
    <input type="text" class="form-control <?= (isset($errors['team_name']) ? 'is-invalid' : '') ?>" id="teamName" name="teamName" value="<?= isset($_POST['teamName']) ? $_POST['teamName'] : '' ?>">
    <?php if (isset($errors['team_name'])) { ?>
      <div class="invalid-tooltip"><?= $errors['team_name'] ?></div>
    <?php } ?>
  </div>
  <!-- Nom du Pays -->
  <div class="col-md-4 offset-md-2 mb-2">
    <label for="teamCountry" class="form-label text-white">Pays</label>
    <input type="text" class="form-control <?= (isset($errors['team_country']) ? 'is-invalid' : '') ?>" id="teamCountry" name="teamCountry" value="<?= isset($_POST['teamCountry']) ? $_POST['teamCountry'] : '' ?>">
    <?php if (isset($errors['team_country'])) { ?>
      <div class="invalid-tooltip"><?= $errors['team_country'] ?></div>
    <?php } ?>
  </div>

  <!-- choix des 11 joueurs -->
  <div class="col-md-6 mb-2">
    <label for="teamPlayers" class="form-label text-white">Choisir 11 joueurs</label>
    <select class="form-select <?= (isset($errors['team_players']) ? 'is-invalid' : '') ?>" id="teamPlayers" name="teamPlayers[]" multiple>
      <?php foreach ($players as $player) { ?>
        <option value="<?= $player->getPlayerId() ?>"><?= $player->getPlayerFirstname() . ' ' . $player->getPlayerLastname() . ' - ' . $player->getPlayerNumber() ?></option>
      <?php } ?>
    </select>
    <?php if (isset($errors['team_players'])) { ?>
      <div class="invalid-tooltip"><?= $errors['team_players'] ?></div>
    <?php } ?>
    <button type="button" id="addPlayers" class="btn btn-primary mt-2">Ajouter ce(s) joueur(s) à votre équipe</button>
  </div>

  <!-- Affichage des joueurs ajoutés -->
  <div class="col-md-6 mb-2" id="playersList">
    <label class="form-label text-white">Liste des 11 joueurs</label>

    <table class="table table-sm table-light table-responsive table-striped table-rounded">
      <thead>
        <tr>
          <th scope="col">Prénom</th>
          <th scope="col">Nom</th>
          <th scope="col">Numéro</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- Insertion en JS des joueurs sélectionnés -->
      </tbody>
    </table>

    <!-- Script pour ajouter un joueur à la liste et désactiver l'option sélectionnée -->
    <script>
      document.addEventListener('DOMContentLoaded', (event) => {
        // Récupération des éléments du DOM
        const addPlayers = document.getElementById('addPlayers');
        const teamPlayers = document.getElementById('teamPlayers');
        const playersList = document.getElementById('playersList').querySelector('tbody');

        // Ajout d'un joueur à la liste
        addPlayers.addEventListener('click', () => {
          // Récupération des options sélectionnées
          const selectedPlayers = Array.from(teamPlayers.selectedOptions);

          selectedPlayers.forEach(selectedPlayer => {
            // Vérification du nombre de joueurs
            if (playersList.getElementsByTagName('tr').length >= 11) {
              alert('Vous ne pouvez pas ajouter plus de 11 joueurs.');
              return;
            }

            // Création d'une nouvelle ligne
            const newRow = document.createElement('tr');
            // Création des cellules
            const firstnameCell = document.createElement('td');
            const lastnameCell = document.createElement('td');
            const numberCell = document.createElement('td');
            const deleteCell = document.createElement('td');
            // Création du bouton de suppression
            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Supprimer';
            deleteButton.classList.add('btn', 'btn-danger', 'btn-sm');
            deleteButton.addEventListener('click', () => {
              newRow.remove();
              selectedPlayer.disabled = false; // Réactive l'option lorsque le joueur est supprimé de la liste
            });
            // Insertion des données dans les cellules
            const playerData = selectedPlayer.textContent.split(' ');
            firstnameCell.textContent = playerData[0];
            lastnameCell.textContent = playerData[1];
            numberCell.textContent = playerData[3];
            // Ajout de l'attribut data-id à la ligne
            newRow.dataset.id = selectedPlayer.value;
            // Création du champ d'entrée caché
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'selectedPlayers[]';
            hiddenInput.value = selectedPlayer.value;
            // Insertion des cellules dans la ligne
            newRow.appendChild(firstnameCell);
            newRow.appendChild(lastnameCell);
            newRow.appendChild(numberCell);
            newRow.appendChild(deleteCell);
            deleteCell.appendChild(deleteButton);
            // Insertion du champ d'entrée caché dans la ligne
            newRow.appendChild(hiddenInput);
            // Insertion de la ligne dans le tableau
            playersList.appendChild(newRow);

            // Désactive l'option sélectionnée
            selectedPlayer.disabled = true;
          });
        })
      });
    </script>
  </div>

</form>