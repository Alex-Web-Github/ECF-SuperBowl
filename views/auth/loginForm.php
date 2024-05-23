<?php require_once APP_ROOT . '/views/header.php';
/** 
 * @var \App\Entity\User $user 
 */
?>

<?php foreach ($errors as $error) { ?>
  <div class="alert alert-danger" role="alert">
    <?= $error; ?>
  </div>
<?php } ?>

<div class="container d-flex mt-4 px-4">

  <div class="mt-5 row m-auto">
    <h1 class="display-5 fw-bolder text-white text-center mb-4">Connexion</h1>

    <form class="d-flex flex-column align-items-center text-left mt-4" method="post">
      <div class="col mb-2">
        <label for="email" class="form-label text-white">E-mail</label>
        <input type="email" class="form-control <?= (isset($errors['email']) ? 'is-invalid' : '') ?>" id="email" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>">
        <?php if (isset($errors['email'])) { ?>
          <div class="invalid-feedback"><?= $errors['email'] ?></div>
        <?php } ?>
      </div>
      <div class="col">
        <label for="password" class="form-label text-white">Mot de passe</label>
        <input type="text" class="form-control <?= (isset($errors['password']) ? 'is-invalid' : '') ?>" id="password" name="password" value="<?= isset($_POST['password']) ? $_POST['password'] : '' ?>">
        <?php if (isset($errors['password'])) { ?>
          <div class="invalid-feedback"><?= $errors['password'] ?></div>
        <?php } ?>
      </div>
      <div class="col text-center mt-4">
        <button type="submit" name="loginUser" class="btn btn-primary mt-4">Je me connecte</button>
      </div>
    </form>
  </div>

</div>

<?php require_once APP_ROOT . '/views/footer.php'; ?>