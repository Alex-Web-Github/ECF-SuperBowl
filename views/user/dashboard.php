<?php

/** 
 * Vue du Dashboard de l'espace Utilisateur
 * 
 */
?>
<?php
// Modal de demande de confirmation pour la suppression du pari
require_once APP_ROOT . '/views/bet/deleteBet-modal.php';

require_once APP_ROOT . '/views/header.php';
?>

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

      <?php if (isset($betsArray) && !empty($betsArray)) : ?>

        <div style="background-color: whitesmoke; padding: 1.5rem;">
          <canvas id="userDashboardChart"></canvas>
        </div>

        <?php foreach ($betsArray as $bet) {
          // Je récupère les données des paris pour cet utilisateur
          $data[] = [
            'date' => $bet['bet_date'],
            'gain' => floatval($bet['bet_result'])
          ];
        }
        // die(var_dump($data));
        // Conversion en JSON pour l'utilisation dans ChartJS
        $jsonData = json_encode($data);
        ?>

      <?php else :
        // Message d'erreur si aucun pari n'a été trouvé
        $redirection_slug = '/';
        $redirection_text = 'Page Accueil';
        $error = 'Vous n\'avez aucun pari enregistré pour le moment.';
      ?>
        <div class="d-flex justify-content-center px-2">
          <div class="d-inline-flex flex-column flex-row-md mt-4 p-4 bg-light rounded-3">
            <p><?= $error; ?></p>
            <?php if (isset($redirection_slug) && isset($redirection_text)) { ?>
              <a class="ps-2 text-decoration-none fw-bold text-secondary cursor-pointer" href="<?= constant('URL_SUBFOLDER') . $redirection_slug ?>" title="<?= $redirection_text ?>">Revenir à la <?= $redirection_text ?></a>
            <?php } ?>
          </div>
        </div>

      <?php endif; ?>


      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script>
        // Récupération des données JSON pour le graphique
        const dataFromPHP = <?php echo $jsonData; ?>;

        // Transformer les données en deux tableaux séparés pour les labels et les données du graphique
        const labels = dataFromPHP.map(item => item.date);
        const data = dataFromPHP.map(item => item.gain);

        const ctx = document.getElementById('userDashboardChart');

        new Chart(ctx, {
          type: 'line',
          data: {
            labels: labels, // Utiliser les dates comme labels
            datasets: [{
              label: 'Gains / Pertes en €',
              data: data, // Utiliser les gains comme données
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: false,
                //position: 'top',
              },
            },
            scales: {
              x: {
                title: {
                  display: true,
                  text: 'Date de la mise'
                }
              },
              y: {
                title: {
                  display: true,
                  text: 'Gains/Pertes en €'
                }
              }
            }
          },
        });
      </script>

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
                  <td><?= htmlspecialchars($user->getUserLastName(), ENT_QUOTES, 'UTF-8') ?></td>
                  <td><?= htmlspecialchars($user->getUserFirstName(), ENT_QUOTES, 'UTF-8') ?></td>
                  <td><?= $user->getUserEmail() ?></td>
                  <td>
                    <!-- TODO A faire -->
                    <div class="d-flex gap-3">
                      <a href="#" class="text-secondary">
                        <svg xmlns=" http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                          <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
                          <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"></path>
                        </svg>
                      </a>
                    </div>

                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- bloc Historique des mises -->
    <div class="tab-pane" id="myBets" role="tabpanel" aria-labelledby="myBets-tab" tabindex="0">

      <div class="table-responsive-lg">
        <table class="table table-hover table-light table-striped table-rounded">
          <thead>
            <tr>
              <th scope="col">Équipe 1</th>
              <th scope="col">Équipe 2</th>
              <th scope="col">Date</th>
              <th scope="col">Heure début</th>
              <th scope="col">Heure fin</th>
              <th scope="col">Mise</th>
              <th scope="col">Résultat</th>
              <th scope="col">Action</th>
            </tr>
          </thead>

          <tbody class="table-group-divider">
            <?php if (isset($betsArray) && !empty($betsArray)) : ?>
              <?php foreach ($betsArray as $bet) : ?>
                <tr>
                  <td><?= htmlspecialchars($bet['team1_name'], ENT_QUOTES, 'UTF-8') ?></td>
                  <td><?= htmlspecialchars($bet['team2_name'], ENT_QUOTES, 'UTF-8') ?></td>
                  <td><?= date('d/m/y', strtotime($bet['game_date'])) ?>
                  <td><?= $bet['game_start'] ?></td>
                  <td><?= $bet['game_end'] ?></td>
                  <td>
                    <span class="m-0"><?= ($bet['bet_amount1'] > 0) ? $bet['bet_amount1'] : $bet['bet_amount2'] ?> €</span>
                    <span class="small m-0">le <?= date('d/m/y', strtotime($bet['bet_date'])) ?></span>
                  </td>
                  <td>
                    <?php if ($bet['game_status'] !== 'Terminé') : ?>
                      <span class="badge 
                      <?php
                      switch ($bet['game_status']) {
                        case 'En cours':
                          echo 'text-bg-danger';
                          break;
                        case 'A venir':
                          echo 'text-bg-info';
                          break;
                        default:
                          echo 'text-bg-warning';
                      }
                      ?>">
                        <?= $bet['game_status'] ?>
                      </span>
                    <?php else : // Cas du match Terminé 
                    ?>
                      <?= isset($bet['bet_result']) ? $bet['bet_result'] . ' €' : 'à calculer...' ?>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if ($bet['game_status'] !== 'Terminé') : ?>
                      <div class="d-flex gap-3">
                        <a href="<?= constant('URL_SUBFOLDER') . '/bet/' . $bet['game_id'] ?>" class="text-secondary">
                          <svg xmlns=" http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"></path>
                          </svg>
                        </a>
                        <!-- ouverture de modal de confirmation de suppression -->
                        <a role="button" data-bs-toggle="modal" data-bs-target="#deleteBetModal" class="text-secondary">
                          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"></path>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"></path>
                          </svg>
                        </a>
                        <form action="<?= constant('URL_SUBFOLDER') . '/delete-bet/' . $bet['bet_id'] ?>" method="POST">
                          <input type="hidden" name="bet_id" value="<?= $bet['bet_id'] ?>">
                          <button type="submit" id="deleteBet" name="deleteBet" class="btn btn-primary d-none">Supprimer</button>
                        </form>
                      </div>
                    <?php else : // cas du match Terminé : aucune Action possible 
                    ?>
                      <span>-</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="8">Aucun pari n'a été trouvé</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>

      </div>

    </div>

  </div>

</div>


<?php require_once APP_ROOT . '/views/footer.php'; ?>