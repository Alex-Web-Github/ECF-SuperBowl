<?php require_once APP_ROOT . '/views/header.php'; ?>


<section class="mt-md-5 py-5">
  <div class="container px-5">
    <div class="row gx-5 align-items-center justify-content-center">
      <div class="col-lg-8 col-xl-7 col-xxl-6">
        <div class="my-5 text-center text-xl-start">
          <h1 class="display-5 fw-bolder text-white mb-2">Money Bowl !</h1>
          <p class="lead fw-normal text-white-50 mb-4">SuperBowl 2024 : jouer et gagner durant l'évènement mondial du football Américain</p>
          <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
            <a class="btn btn-primary btn-lg px-4 me-sm-3" href="/index.php?controller=user&action=register">S'inscrire</a>
            <a class="btn btn-outline-light btn-lg px-4" href="/index.php?controller=auth&action=login">Se connecter</a>
          </div>
        </div>
      </div>

    </div>
</section>


<?php require_once APP_ROOT . '/views/footer.php'; ?>