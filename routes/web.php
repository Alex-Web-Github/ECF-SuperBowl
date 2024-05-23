<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Création de la collection de routes
$routes = new RouteCollection();

// Ajout des routes :
// Redirection vers la page d'accueil
$routes->add('homepage', new Route(constant('URL_SUBFOLDER') . '/', array('controller' => 'PageController', 'method' => 'homeAction'), array()));

// Page Login 
$routes->add('login', new Route(constant('URL_SUBFOLDER') . '/login', array('controller' => 'AuthController', 'method' => 'loginAction'), array()));

// Page Logout
$routes->add('logout', new Route(constant('URL_SUBFOLDER') . '/logout', array('controller' => 'AuthController', 'method' => 'logoutAction'), array()));

// Page Register
$routes->add('register', new Route(constant('URL_SUBFOLDER') . '/register', array('controller' => 'UserController', 'method' => 'registerFormAction'), array()));

// Page Dashboard User
$routes->add('userDashboard', new Route(constant('URL_SUBFOLDER') . '/dashboard', array('controller' => 'UserController', 'method' => 'dashboardAction'), array()));

// Page Dashboard Admin
$routes->add('adminDashboard', new Route(constant('URL_SUBFOLDER') . '/admin/dashboard', array('controller' => 'AdminController', 'method' => 'dashboardAction'), array()));
