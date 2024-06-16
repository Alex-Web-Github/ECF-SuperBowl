<?php
// Affichage des erreurs
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

// Chargement de l'autoloader de Composer
require_once '../vendor/autoload.php';

// Chargement des fichiers de configuration
require_once '../config/config.php';

/** 
 * Sécurise le cookie de session pour prévenir certaines attaques (comme le vol de cookies via des scripts côté client (XSS) ou via des connexions non sécurisées).
 * Je commente car je ne vois pas l'intérêt de le mettre en place pour le moment.
 * Le cookie de Session dans lequel je place les infos de mon User connecté est déjà sécurisé par défaut car il est stocké sur le serveur et non sur le navigateur.
 */
// session_set_cookie_params([
//   'lifetime' => 3600, // (exe: durée de vie du cookie de session 1h)
//   'path' => '/',
//   'domain' => $_SERVER['SERVER_NAME'],
//   //'secure' => true, // pas activé car pas de HTTPS sur le serveur de développement
//   'httponly' => true,
//   'samesite' => 'Strict', // empêchera le cookie d'être envoyé avec des requêtes provenant de sites tiers
// ]);


// Démarrage de la session
session_start();

// Chargement des routes
require_once '../routes/web.php';
require_once '../app/Router.php';
