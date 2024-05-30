<?php require_once APP_ROOT . '/views/header.php'; ?>


<div class="container-md mt-4 px-2">

  <!-- Navigation des matchs -->
  <ul class="nav nav-underline mb-4" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane" role="tab" aria-controls="all-tab-pane" aria-selected="true" href="#">Tous les matchs</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link " id="live-tab" data-bs-toggle="tab" data-bs-target="#live-tab-pane" role="tab" aria-controls="live-tab-pane" aria-selected="false" href="#">En cours</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link " id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming-tab-pane" role="tab" aria-controls="upcoming-tab-pane" aria-selected="false" href="#">A venir</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link " id="past-tab" data-bs-toggle="tab" data-bs-target="#past-tab-pane" role="tab" aria-controls="past-tab-pane" aria-selected="false" href="#">Passés</a>
    </li>
  </ul>

  <div class="tab-content">
    <div class="tab-pane active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
      <!-- Tableau de tous les matchs -->
      <table class="table table-hover table-striped table-rounded">
        <thead>
          <tr>
            <th scope="col">Équipe 1</th>
            <th scope="col">Équipe 2</th>
            <th scope="col">Date</th>
            <th scope="col">Heure début</th>
            <th scope="col">Heure fin</th>
            <th scope="col">Status</th>
            <th scope="col">Score</th>
            <th scope="col">Détails</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><span class="badge text-bg-warning">terminé</span></td>
            <td>SCORE</td>
            <td><a href="#lien vers les détails du match">
                <button type="button" class="btn btn-primary btn-sm">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"></path>
                  </svg>
                  infos
                </button>
              </a></td>
          </tr>

      </table>

    </div>

    <div class="tab-pane " id="live-tab-pane" role="tabpanel">
      <table class="table table-hover table-striped table-rounded">
        <thead>
          <tr>
            <th scope="col">Équipe 1</th>
            <th scope="col">Équipe 2</th>
            <th scope="col">Date</th>
            <th scope="col">Heure début</th>
            <th scope="col">Heure fin</th>
            <th scope="col">Status</th>
            <th scope="col">Score</th>
            <th scope="col">Détails</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">

      </table>

    </div>

    <div class="tab-pane " id="upcoming-tab-pane" role="tabpanel">
      <table class="table table-hover table-striped table-rounded">
        <thead>
          <tr>
            <th scope="col">Équipe 1</th>
            <th scope="col">Équipe 2</th>
            <th scope="col">Date</th>
            <th scope="col">Heure début</th>
            <th scope="col">Heure fin</th>
            <th scope="col">Status</th>
            <th scope="col">Score</th>
            <th scope="col">Détails</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">

      </table>
    </div>

    <div class="tab-pane " id="past-tab-pane" role="tabpanel">
      <table class="table table-hover table-striped table-rounded">
        <thead>
          <tr>
            <th scope="col">Équipe 1</th>
            <th scope="col">Équipe 2</th>
            <th scope="col">Date</th>
            <th scope="col">Heure début</th>
            <th scope="col">Heure fin</th>
            <th scope="col">Status</th>
            <th scope="col">Score</th>
            <th scope="col">Détails</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">

      </table>
    </div>

  </div>

  <!-- All matchs -->

  <?php require_once APP_ROOT . '/views/footer.php'; ?>