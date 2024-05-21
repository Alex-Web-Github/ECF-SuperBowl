<?php require_once APP_ROOT . '/views/header.php';
/** 
 * @var \App\Entity\User $user 
 */
?>

<div class="container d-flex mt-4 px-4">

  <div class="mt-5 col-12 col-sm-10 col-xl-8 m-auto">
    <h1 class="display-5 fw-bolder text-white text-center mb-4">Créer un compte</h1>

    <form class="row g-3 text-left mt-4" method="post">

      <div class="col-md-6">
        <label for="last_name" class="form-label text-white">Nom</label>
        <input type="text" class="form-control <?= (isset($errors['last_name']) ? 'is-invalid' : '') ?>" id="last_name" name="last_name" value="<?= isset($_POST['last_name']) ? $_POST['last_name'] : '' ?>">
        <?php if (isset($errors['last_name'])) { ?>
          <div class="invalid-feedback"><?= $errors['last_name'] ?></div>
        <?php } ?>
      </div>

      <div class="col-md-6">
        <label for="first_name" class="form-label text-white">Prénom</label>
        <input type="text" class="form-control <?= (isset($errors['first_name']) ? 'is-invalid' : '') ?>" id="first_name" name="first_name" value="<?= isset($_POST['first_name']) ? $_POST['first_name'] : '' ?>">
        <?php if (isset($errors['first_name'])) { ?>
          <div class="invalid-feedback"><?= $errors['first_name'] ?></div>
        <?php } ?>
      </div>

      <div class="col-md-6">
        <label for="email" class="form-label text-white">E-mail</label>
        <input type="email" class="form-control <?= (isset($errors['email']) ? 'is-invalid' : '') ?>" id="email" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>">
        <?php if (isset($errors['email'])) { ?>
          <div class="invalid-feedback"><?= $errors['email'] ?></div>
        <?php } ?>
      </div>

      <div class="col-md-6">
        <label for="password" class="form-label text-white">Mot de passe</label>
        <input type="text" class="form-control <?= (isset($errors['password']) ? 'is-invalid' : '') ?>" id="password" name="password" value="<?= isset($_POST['password']) ? $_POST['password'] : '' ?>">
        <?php if (isset($errors['password'])) { ?>
          <div class="invalid-feedback"><?= $errors['password'] ?></div>
        <?php } ?>
      </div>

      <div class="col-12 text-center">
        <button type="submit" name="saveUser" class="btn btn-primary mt-4">Je commence à jouer</button>
      </div>
    </form>
  </div>

</div>

<?php require_once APP_ROOT . '/views/footer.php'; ?>