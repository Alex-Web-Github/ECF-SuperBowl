<?php require_once APP_ROOT . '/views/header.php';
/** 
 * @var \App\Entity\User $user 
 */
?>

<div class="container d-flex mt-0 mt-md-4 px-md-4">

  <div class="col-12 col-sm-10 col-xl-8 m-auto">
    <div class="row m-auto mt-4 px-md-5">

      <?php if (isset($error['mail']['message'])) { ?>
        <div class="alert alert-danger">
          <?= $error['mail']['message']; ?>
          <a href="<?= constant('URL_SUBFOLDER') . $error['mail']['redirection_slug'] ?>" class="btn-primary"><?= $error['mail']['redirection_text'] ?></a>
        </div>
      <?php } ?>

      <form class="row g-3 text-left mx-0 mt-4 p-4" method="post">

        <h1 class="display-6 fw-bolder text-white text-center mb-4">Créer un compte</h1>

        <div class="col-lg-6">
          <label for="user_first_name" class="form-label text-white">Prénom</label>
          <input type="text" class="form-control <?= (isset($errors['user_first_name']) ? 'is-invalid' : '') ?>" id="user_first_name" name="user_first_name" value="<?= isset($_POST['user_first_name']) ? $_POST['user_first_name'] : '' ?>">
          <?php if (isset($errors['user_first_name'])) { ?>
            <div class="invalid-feedback"><?= $errors['user_first_name'] ?></div>
          <?php } ?>
        </div>

        <div class="col-lg-6">
          <label for="user_last_name" class="form-label text-white">Nom</label>
          <input type="text" class="form-control <?= (isset($errors['user_last_name']) ? 'is-invalid' : '') ?>" id="user_last_name" name="user_last_name" value="<?= isset($_POST['user_last_name']) ? $_POST['user_last_name'] : '' ?>">
          <?php if (isset($errors['user_last_name'])) { ?>
            <div class="invalid-feedback"><?= $errors['user_last_name'] ?></div>
          <?php } ?>
        </div>

        <div class="col-lg-6">
          <label for="user_email" class="form-label text-white">E-mail</label>
          <input type="user_email" class="form-control <?= (isset($errors['user_email']) ? 'is-invalid' : '') ?>" id="user_email" name="user_email" value="<?= isset($_POST['user_email']) ? $_POST['user_email'] : '' ?>">
          <?php if (isset($errors['user_email'])) { ?>
            <div class="invalid-feedback"><?= $errors['user_email'] ?></div>
          <?php } ?>
        </div>

        <div class="col-lg-6">
          <label for="user_password" class="form-label text-white">Mot de passe</label>
          <input type="text" class="form-control <?= (isset($errors['user_password']) ? 'is-invalid' : '') ?>" id="user_password" name="user_password" value="<?= isset($_POST['user_password']) ? $_POST['user_password'] : '' ?>">
          <?php if (isset($errors['user_password'])) { ?>
            <div class="invalid-feedback"><?= $errors['user_password'] ?></div>
          <?php } ?>
        </div>

        <div class="col-12 text-center">
          <button type="submit" name="saveUser" class="btn btn-primary mt-4">Je commence à jouer</button>
        </div>
      </form>
    </div>

  </div>

  <?php require_once APP_ROOT . '/views/footer.php'; ?>