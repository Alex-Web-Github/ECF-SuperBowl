<?php

use App\Tools\NavigationTools;
use App\Tools\SecurityTools;

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="Enfin une application de gestion intuitive pour suivre vos cryptos et gérer facilement vos gains" />
  <title>Money Bowl</title>
  <!-- Favicon-->
  <link rel="icon" type="image/x-icon" href="favicon.png" />
  <link rel="stylesheet" href="/css/styles.css">
</head>

<body class="d-flex flex-column">

  <header id="customHeader" class="header-fixed">
    <div class="container-md px-2">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="/">
          <img src="" alt="Logo" width="50" height="50" class="d-inline-block me-1">Money BOWL</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link <?= NavigationTools::addActiveClass('/game') ?>" href=" <?= constant('URL_SUBFOLDER') . '/game' ?>">Tous les matchs</a>
            </li>
            <li class="nav-item"><a class="nav-link <?= NavigationTools::addActiveClass('/bet/') ?>" href="<?= constant('URL_SUBFOLDER') . '/bet/multiple' ?>">Parier</a>
            </li>
            <?php if (SecurityTools::islogged() === false) { ?>
              <li class="nav-item">
                <a class="nav-link <?= NavigationTools::addActiveClass('/register') ?>" href="<?= constant('URL_SUBFOLDER') . '/register' ?>">Créer un compte</a>
              </li>
            <?php } ?>

            <?php
            // Condition isAdmin
            if (SecurityTools::isAdmin()) { ?>
              <li class=" nav-item"><a class="nav-link <?= NavigationTools::addActiveClass('/admin/dashboard') ?>" href="<?= constant('URL_SUBFOLDER') . '/admin/dashboard' ?>">Mon espace</a></li>
            <?php }
            if (SecurityTools::isUser()) { ?>
              <li class="nav-item">
                <a class="nav-link <?= NavigationTools::addActiveClass('/dashboard') ?>" href="<?= constant('URL_SUBFOLDER') . '/dashboard' ?>" title="mon espace utilisateur">Mon espace</a>
              </li>
            <?php } ?>
            <?php if (SecurityTools::isLogged()) { ?>
              <li class="nav-item">
                <a class="nav-link" href="<?= constant('URL_SUBFOLDER') . '/logout' ?>" title="Déconnexion">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">Se déconnecter
                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                  </svg>
                </a>
              </li>
            <?php } else { ?>
              <li class="nav-item"><a class="nav-link <?= NavigationTools::addActiveClass('/login') ?>" href=" <?= constant('URL_SUBFOLDER') . '/login' ?>" title="Connexion">Se connecter
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z" />
                    <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                  </svg>
                </a>
              </li>
            <?php } ?>

          </ul>
        </div>
        <!-- Menu -->
      </nav>
      <!-- Navbar-->
    </div>

  </header>

  <main class="flex-shrink-0 pb-5">
    <!-- Banner -->
    <div class="banner text-center">
      <h1 class="display-5 fw-bold text-white">Money Bowl<span class="ps-md-2 fs-5 fw-light d-block d-md-inline">paris sportifs en ligne</span></h1>
      <p class="fs-5 fw-normal fst-italic lead text-white pt-0 pt-md-2">Misez tout sur le Football Américain !</p>
    </div>
    <!-- Banner -->