<?php

/**
 * Vue Formulaire de création de match dans l'espace administrateur
 */
?>

<form class="row justify-content-center g-3 text-left mt-4 mx-0" action="/admin/dashboard" method="post">

  <!-- Bouton Submit -->
  <div class="col-12 text-center mb-5">
    <button type="submit" name="createGame" class="btn btn-primary">Créer ce match</button>
  </div>


  <!-- Date du match -->
  <div class="col-md-3 mb-2">
    <label for="gameDate" class="form-label text-white">Date du match</label>
    <input type="date" class="form-control <?= (isset($error['game_date']) ? 'is-invalid' : '') ?>" id="gameDate" name="gameDate" value="<?= isset($_POST['gameDate']) ? $_POST['gameDate'] : '' ?>">
    <?php if (isset($error['game_date'])) { ?>
      <div class="invalid-tooltip"><?= $error['game_date'] ?></div>
    <?php } ?>
  </div>
  <!-- Heure de début du match -->
  <div class="col-md-3 mb-2">
    <label for="gameStart" class="form-label text-white">Heure de début</label>
    <input type="time" class="form-control <?= (isset($error['game_start']) ? 'is-invalid' : '') ?>" id="gameStart" name="gameStart" value="<?= isset($_POST['gameStart']) ? $_POST['gameStart'] : '' ?>">
    <?php if (isset($error['game_start'])) { ?>
      <div class="invalid-tooltip"><?= $error['game_start'] ?></div>
    <?php } ?>
  </div>
  <!-- Heure de fin du match -->
  <div class="col-md-3 mb-2">
    <label for="gameEnd" class="form-label text-white">Heure de fin</label>
    <input type="time" class="form-control <?= (isset($error['game_end']) ? 'is-invalid' : '') ?>" id="gameEnd" name="gameEnd" value="<?= isset($_POST['gameEnd']) ? $_POST['gameEnd'] : '' ?>">
    <?php if (isset($error['game_end'])) { ?>
      <div class="invalid-tooltip"><?= $error['game_end'] ?></div>
    <?php } ?>
  </div>

  <!-- Équipe 1 -->
  <div class="col-md-6 mb-2">
    <label for="team1_id" class="form-label text-white">Équipe 1</label>
    <select class="form-select <?= (isset($error['team1_id']) ? 'is-invalid' : '') ?>" id="team1_id" name="team1_id">
      <option selected>Choisir une équipe</option>
      <?php foreach ($teams as $team) { ?>
        <option value="<?= $team->getTeamId() ?>"><?= htmlspecialchars($team->getTeamName(), ENT_QUOTES, 'UTF-8') ?></option>
      <?php } ?>
    </select>
    <?php if (isset($error['team1_id'])) { ?>
      <div class="invalid-tooltip"><?= $error['team1_id'] ?></div>
    <?php } ?>
  </div>
  <!-- Cote Équipe 1 -->
  <div class="col-md-3 mb-2">
    <label for="team1Odds" class="form-label text-white">Cote</label>
    <input type="number" class="form-control <?= (isset($error['team1_Odds']) ? 'is-invalid' : '') ?>" id="team1Odds" name="team1Odds" value="1" min="0.1" max="10" step="0.1">
    <?php if (isset($error['team1_Odds'])) { ?>
      <div class="invalid-tooltip"><?= $error['team1_Odds'] ?></div>
    <?php } ?>
  </div>

  <!-- Équipe 2 -->
  <div class="col-md-6 mb-2">
    <label for="team2_id" class="form-label text-white">Équipe 2</label>
    <select class="form-select <?= (isset($error['team2_id']) ? 'is-invalid' : '') ?>" id="team2_id" name="team2_id">
      <option selected>Choisir une équipe</option>
      <?php foreach ($teams as $team) { ?>
        <option value="<?= $team->getTeamId() ?>"><?= htmlspecialchars($team->getTeamName(), ENT_QUOTES, 'UTF-8') ?></option>
      <?php } ?>
    </select>
    <?php if (isset($error['team2_id'])) { ?>
      <div class="invalid-tooltip"><?= $error['team2_id'] ?></div>
    <?php } ?>
  </div>
  <!-- Cote Équipe 2 -->
  <div class="col-md-3 mb-2">
    <label for="team2Odds" class="form-label text-white">Cote</label>
    <input type="number" class="form-control <?= (isset($error['team2_Odds']) ? 'is-invalid' : '') ?>" id="team2Odds" name="team2Odds" value="1" min="0.1" max="10" step="0.1">
    <?php if (isset($error['team2_Odds'])) { ?>
      <div class="invalid-tooltip"><?= $error['team2_Odds'] ?></div>
    <?php } ?>
  </div>

</form>