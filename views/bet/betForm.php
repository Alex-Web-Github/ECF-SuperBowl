<?php

/** 
 * Template du formulaire "Miser sur un match"
 */
?>

<?php require_once APP_ROOT . '/views/header.php'; ?>

<div class="container-md my-4 p-2">
  <h2 class="display-6 fw-bolder text-white text-center mb-5">Miser sur le match</h2>

  <?php if (isset($error['bet']['message'])) { ?>
    <div class="alert alert-danger">
      <?= $error['bet']['message']; ?>
    </div>
  <?php } ?>

  <form action="<?= constant('URL_SUBFOLDER') ?>/bet/<?= $game->getGameId() ?>" method="POST">

    <?php require APP_ROOT . '/views/bet/bet-partial.php'; ?>

    <!-- Submit Button -->
    <div class="d-flex justify-content-center mt-4">
      <button type="submit" name="submitBet" class="btn btn-primary col-sm-6 col-xl-4"><?php echo isset($error['bet']['textButton']) ? $error['bet']['textButton'] : 'Valider'; ?></button>
    </div>
  </form>

</div>


<?php require_once APP_ROOT . '/views/footer.php'; ?>