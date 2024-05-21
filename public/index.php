<?php
// Affichage des erreurs
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

// Chargement de l'autoloader de Composer
require_once '../vendor/autoload.php';

// Chargement des fichiers de configuration
require_once '../config/config.php';

//Sécurise le cookie de session avec httponly
session_set_cookie_params([
  'lifetime' => 3600,
  'path' => '/',
  'domain' => $_SERVER['SERVER_NAME'],
  //'secure' => true, // pas activé car pas de HTTPS sur le serveur de développement
  'httponly' => true
]);

// Démarrage de la session
session_start();

// Chargement des routes
require_once '../routes/web.php';
require_once '../app/Router.php';

// TODO
// setcookie('name', 'value', time() + 3600, '/', '', false, true);
