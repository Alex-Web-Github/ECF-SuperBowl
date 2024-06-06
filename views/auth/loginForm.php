<?php

/**
 * Vue de la page de connexion 'LOGIN'
 */
?>
<?php require_once APP_ROOT . '/views/header.php'; ?>

<div class="container d-flex mt-0 mt-md-4 px-md-4">
  <div class="row m-auto mt-4 px-md-5">

    <form class="d-flex flex-column align-items-center text-left mt-4 p-4" method="post">

      <h1 class="display-6 fw-bolder text-white text-center mb-4">Connexion</h1>

      <div class="col mb-2 px-4">
        <label for="email" class="form-label text-white">E-mail</label>
        <input type="email" class="form-control <?= (isset($error['email']) ? 'is-invalid' : '') ?>" id="email" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>">
        <?php if (isset($error['email'])) { ?>
          <div class="invalid-feedback"><?= $error['email'] ?></div>
        <?php } ?>
      </div>
      <div class="col px-4">
        <label for="password" class="form-label text-white">Mot de passe</label>
        <input type="text" class="form-control <?= (isset($error['password']) ? 'is-invalid' : '') ?>" id="password" name="password" value="<?= isset($_POST['password']) ? $_POST['password'] : '' ?>">
        <?php if (isset($error['password'])) { ?>
          <div class="invalid-feedback"><?= $error['password'] ?></div>
        <?php } ?>
      </div>
      <div class="col col-md-8 text-center pt-4 mb-2">
        <button type="submit" name="loginUser" class="btn btn-primary">Je me connecte</button>
      </div>
    </form>
  </div>

</div>

<?php require_once APP_ROOT . '/views/footer.php'; ?>