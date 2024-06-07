<?php

/**
 * Template PARTIAL du formulaire de pari (/views/bet/betForm.php)
 */
?>

<div class="row mt-4 mx-0">
  <!-- Bloc Infos 1 -->
  <div class="col-lg mx-lg-2 p-3 mb-2 bg-light rounded-3">
    <table class="table table-hover table-light table-striped table-rounded h-100">
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
    <table class="table table-hover table-light table-striped table-rounded h-100">
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