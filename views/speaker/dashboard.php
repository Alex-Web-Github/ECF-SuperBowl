<?php

/** 
 * PAGE Dashboard du Commentateur
 */
?>

<?php require_once APP_ROOT . '/views/speaker/speaker-header.php'; ?>

<div class="container my-4 p-2">
  <h2 class="fs-2 fw-bolder text-white text-center mb-5">Les matchs du jour</h2>

  <?php
  $gamesList = $dailyGames;

  require_once APP_ROOT . '/views/speaker/speaker-live-games.php';
  ?>

</div>


<?php require_once APP_ROOT . '/views/footer.php'; ?>