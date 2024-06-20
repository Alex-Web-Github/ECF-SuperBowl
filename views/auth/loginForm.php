<?php

/**
 * Vue de la page de connexion 'LOGIN'
 */
?>
<?php require_once APP_ROOT . '/views/header.php'; ?>

<div class="container mt-4 px-2">

  <div class="row mx-0">
    <h1 class="col-12 display-5 fw-bolder text-white text-center mb-4">Connexion</h1>

    <?php if (isset($error['mail']['message'])) { ?>
      <div class="alert alert-danger">
        <?= $error['mail']['message']; ?>
        <a href="<?= constant('URL_SUBFOLDER') . $error['mail']['redirection_slug'] ?>" class="btn-primary"><?= $error['mail']['redirection_text'] ?></a>
      </div>
    <?php } ?>

    <form class="col col-sm-8 col-md-6 col-lg-6 col-xl-5 text-left mx-auto px-4 py-4" method="post" action="<?= constant('URL_SUBFOLDER') . '/login' ?>">
      <div class="mb-2">
        <label for="email" class="form-label text-white">E-mail</label>
        <input type="email" class="form-control <?= (isset($error['email']) ? 'is-invalid' : '') ?>" id="email" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>">
        <?php if (isset($error['email'])) { ?>
          <div class="invalid-tooltip"><?= $error['email'] ?></div>
        <?php } ?>
      </div>
      <div class="mb-2">
        <label for="password" class="form-label text-white">Mot de passe</label>
        <input type="password" class="form-control <?= (isset($error['password']) ? 'is-invalid' : '') ?>" id="password" name="password" value="<?= isset($_POST['password']) ? $_POST['password'] : '' ?>">
        <?php if (isset($error['password'])) { ?>
          <div class="invalid-tooltip"><?= $error['password'] ?></div>
        <?php } ?>
      </div>

      <div class="d-flex flex-column flex-lg-row align-items-center gap-4 flex-wrap mt-4">
        <button type="submit" name="loginUser" class="btn btn-primary">Je me connecte</button>
        <a class="form-link" type="button" data-bs-toggle="modal" data-bs-target="#lostPwModal">
          Mot de passe oublié ?</a>
      </div>
    </form>

  </div>

</div>

<!-- Modal de réinitialisation de PW -->
<?php require_once APP_ROOT . '/views/auth/lostPW-modal.php'; ?>

<?php require_once APP_ROOT . '/views/footer.php'; ?>