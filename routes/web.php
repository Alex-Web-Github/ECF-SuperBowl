<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Création de la collection de routes
$routes = new RouteCollection();

// Ajout des routes :
// Redirection vers la page d'accueil
$routes->add('homepage', new Route(constant('URL_SUBFOLDER') . '/', array('controller' => 'PageController', 'method' => 'homeAction'), array()));

// Page Login //TODO

$routes->add('login', new Route(constant('URL_SUBFOLDER') . '/login', array('controller' => 'AuthController', 'method' => 'loginAction'), array()));

// Page Logout //TODO
$routes->add('logout', new Route(constant('URL_SUBFOLDER') . '/logout', array('controller' => 'AuthController', 'method' => 'logoutAction'), array()));

// Page Register
$routes->add('register', new Route(constant('URL_SUBFOLDER') . '/register', array('controller' => 'UserController', 'method' => 'registerFormAction'), array()));
