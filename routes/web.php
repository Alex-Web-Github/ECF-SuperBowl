<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Création de la collection de routes
$routes = new RouteCollection();

// Redirection vers la page d'accueil (liste des matchs) si l'URL est vide
if (empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] === '/') {
  header('Location: ' . constant('URL_SUBFOLDER') . '/all-games');
  exit();
}

/**
 * Configuration des Routes :
 */

// Redirection vers page 404
$routes->add('404', new Route(constant('URL_SUBFOLDER') . '/404', array('controller' => 'PageController', 'method' => 'error404Action'), array()));

// Redirection vers la page d'accueil (liste des matchs)
$routes->add('all-games', new Route(constant('URL_SUBFOLDER') . '/all-games', array('controller' => 'PageController', 'method' => 'homeAction'), array()));

// Page Login 
$routes->add('login', new Route(constant('URL_SUBFOLDER') . '/login', array('controller' => 'AuthController', 'method' => 'loginAction'), array()));

// Page Logout
$routes->add('logout', new Route(constant('URL_SUBFOLDER') . '/logout', array('controller' => 'AuthController', 'method' => 'logoutAction'), array()));

// Page Check (a new subscription with token)
$routes->add('check', new Route(constant('URL_SUBFOLDER') . '/check', array('controller' => 'UserController', 'method' => 'checkAction'), array()));

// Page Register
$routes->add('register', new Route(constant('URL_SUBFOLDER') . '/register', array('controller' => 'UserController', 'method' => 'registerFormAction'), array()));

// Page Dashboard User
$routes->add('userDashboard', new Route(constant('URL_SUBFOLDER') . '/dashboard', array('controller' => 'UserController', 'method' => 'dashboardAction'), array()));

// Page Dashboard Admin
$routes->add('adminDashboard', new Route(constant('URL_SUBFOLDER') . '/admin/dashboard', array('controller' => 'AdminController', 'method' => 'dashboardAction'), array()));

// Page Data Game selon l'Id
$routes->add('game', new Route(constant('URL_SUBFOLDER') . '/all-games/{id}', array('controller' => 'GameController', 'method' => 'singleGameAction'), array('id' => '\d+')));
// ici '\d+' signifie que l'on attend un nombre entier. Cela permet de sécuriser la route et d'éviter les injections SQL.

// Page pour Miser sur un match donné
$routes->add('bet', new Route(constant('URL_SUBFOLDER') . '/bet/{id}', array('controller' => 'BetController', 'method' => 'betAction'), array('id' => '\d+')));

// Page pour parier sur une sélection de matchs
$routes->add('betMultiple', new Route(constant('URL_SUBFOLDER') . '/bet/multiple', array('controller' => 'BetController', 'method' => 'betMultipleAction'), array()));

// Page pour configurer les paris multiples sur une sélection de matchs
$routes->add('betMultipleConfig', new Route(constant('URL_SUBFOLDER') . '/bet/multiple/config', array('controller' => 'BetController', 'method' => 'betMultipleConfigAction'), array()));
