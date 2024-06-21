<?php

/** 
 * Vue du Dashboard de l'espace Utilisateur
 * 
 */
?>

<?php require_once APP_ROOT . '/views/header.php'; ?>

<div class="container my-4 p-2">
  <h2 class="display-6 fw-bolder text-white text-center mb-5">Espace Utilisateur</h2>

  <!-- Onglets de navigation -->
  <ul class="nav nav-underline mb-4" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button type="button" class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard" role="tab" aria-controls="dashboard" aria-selected="true">Dashboard</button>
    </li>
    <li class="nav-item" role="presentation">
      <button type="button" class="nav-link" id="myAccount-tab" data-bs-toggle="tab" data-bs-target="#myAccount" role="tab" aria-controls="myAccount" aria-selected="false" tabindex="-1">Mes informations</button>
    </li>
    <li class="nav-item" role="presentation">
      <button type="button" class="nav-link" id="myBets-tab" data-bs-toggle="tab" data-bs-target="#myBets" role="tab" aria-controls="myBets" aria-selected="false" tabindex="-1">Historique des mises</button>
    </li>
  </ul>

  <div class="tab-content">
    <!-- Bloc Dashboard -->
    <div class="tab-pane active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab" tabindex="0">


    </div>

    <!-- bloc Mes informations -->
    <div class="tab-pane" id="myAccount" role="tabpanel" aria-labelledby="myAccount-tab" tabindex="0">
      <div class="container-md my-4 p-2">
        <div class="row mx-0 mt-4">
          <div class="col-lg-8 table-responsive mb-2 px-0">
            <table class="table table-hover table-light table-striped table-rounded">
              <thead>
                <tr>
                  <th scope="col">Nom</th>
                  <th scope="col">Prénom</th>
                  <th scope="col">Email</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody class="table-group-divider">
                <tr>
                  <td><?= $user->getUserLastName() ?></td>
                  <td><?= $user->getUserFirstName() ?></td>
                  <td><?= $user->getUserEmail() ?></td>
                  <td>
                    <a href="#" class="btn btn-primary disabled">Modifier</a>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- bloc Historique des mises -->
    <div class="tab-pane" id="myBets" role="tabpanel" aria-labelledby="myBets-tab" tabindex="0">


    </div>

  </div>

</div>


<?php require_once APP_ROOT . '/views/footer.php'; ?>