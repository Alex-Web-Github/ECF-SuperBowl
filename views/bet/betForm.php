<?php

/** 
 * Template du formulaire "Miser sur un match"
 */
?>

<?php require_once APP_ROOT . '/views/header.php'; ?>

<div class="container-md my-4 px-2">
  <h2 class="display-6 fw-bolder text-white text-center mb-4">Miser sur le match</h2>

  <?php if (isset($error['bet']['message'])) { ?>
    <div class="alert alert-danger">
      <?= $error['bet']['message']; ?>
    </div>
  <?php } ?>
  <form action="<?= constant('URL_SUBFOLDER') ?>/bet/<?= $game->getGameId() ?>" method="POST">
    <div class="row mt-4 mx-0">
      <!-- Bloc Infos 1 -->
      <div class="col-lg mx-lg-2 p-3 mb-2 bg-light rounded-3">
        <table class="table table-hover table-striped table-rounded h-100">
          <thead>
            <tr>
              <th scope="col">Équipe 1</th>
              <th scope="col">Cote</th>
              <th scope="col">Votre mise (Euros)</th>
            </tr>
          </thead>

          <tbody class="table-group-divider">
            <tr>
              <td><?= $game->getTeam1Name() ?></td>
              <td><?= $game->getTeam1Odds() ?></td>
              <td>
                <input type="number" name="bet_amount1" id="bet_amount1" class="form-control <?= (isset($error['bet_amount1']) ? 'is-invalid' : '') ?>" placeholder="votre mise" step="0.01" value="<?php echo isset($error['bet']['betAmount1Old']) ? $error['bet']['betAmount1Old'] : '' ?>">
                <?php if (isset($error['bet_amount1'])) { ?>
                  <div class="invalid-feedback"><?= $error['bet_amount1'] ?></div>
                <?php } ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- <div class="col px-0 px-md-2"></div> -->

      <!-- Bloc Infos 2 -->
      <div class="col-lg mx-lg-2 p-3 mb-2 bg-light rounded-3">
        <table class="table table-hover table-striped table-rounded h-100">
          <thead>
            <tr>
              <th scope="col">Équipe 2</th>
              <th scope="col">Cote</th>
              <th scope="col">Votre mise (Euros)</th>
            </tr>
          </thead>

          <tbody class="table-group-divider">
            <tr>
              <td><?= $game->getTeam2Name() ?></td>
              <td><?= $game->getTeam2Odds() ?></td>
              <td>
                <input type="number" name="bet_amount2" id="bet_amount2" class="form-control <?= (isset($error['bet_amount2']) ? 'is-invalid' : '') ?>" placeholder="votre mise" step="0.01" value="<?php echo isset($error['bet']['betAmount2Old']) ? $error['bet']['betAmount2Old'] : '' ?>">
                <?php if (isset($error['bet_amount2'])) { ?>
                  <div class="invalid-feedback"><?= $error['bet_amount2'] ?></div>
                <?php } ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
      <button type="submit" name="submitBet" class="btn btn-primary col-sm-6 col-xl-4"><?php echo isset($error['bet']['textButton']) ? $error['bet']['textButton'] : 'Valider'; ?></button>
    </div>
  </form>

</div>


<?php require_once APP_ROOT . '/views/footer.php'; ?>