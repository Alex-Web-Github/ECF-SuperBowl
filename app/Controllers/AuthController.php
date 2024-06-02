<?php

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Tools\SecurityTools;

class AuthController extends Controller
{

  public function loginAction(RouteCollection $routes)
  {
    try {
      $errors = [];
      $user = new User();

      if (isset($_POST['loginUser'])) {

        // TODO : filtrer les données reçues du formulaire contre les failles XSS directement dans la méthode Hydrate() ou ici ...

        // Je valide les champs envoyés par le formulaire
        if (empty($_POST['email']) || empty($_POST['password'])) {
          $errors['email'] = 'Le champ email ne doit pas être vide';
          $errors['password'] = 'Le champ mot de passe ne doit pas être vide';
        } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
          $errors['email'] = 'L\'email n\'est pas valide';
        }

        if (empty($errors)) {
          // Si il n'y a pas d'erreurs, alors on vérifie si l'utilisateur existe en BDD
          $userRepository = new UserRepository();
          $user = $userRepository->findOneByEmail($_POST['email']);

          // Je vérifie si le mot de passe qui correspond à l'email est correct
          if ($user && SecurityTools::verifyPassword($_POST['password'], $user)) {
            // Je regénère l'id de Session pour éviter la "fixation de session"
            session_regenerate_id(true);

            // On stocke en Session tous les attributs de l'objet User
            // Attention : $_SESSION['user'] devient un objet User
            $_SESSION['user'] = $user;

            // Redirige l'utilisateur en fonction de son rôle
            if ($user->getUserRole() === 'admin') {
              header('Location: ' . $routes->get('adminDashboard')->getPath());
            } else {
              header('Location: ' . $routes->get('userDashboard')->getPath());
            }
          } else {
            // Je lance une exception si l'email et/ou le mot de passe sont incorrects
            throw new \Exception('Email et/ou mot de passe incorrect(s)');
          }
        }
      }
      // charger la page loginForm.php
      $this->render('auth/loginForm', [
        // On passe les erreurs à la View pour pouvoir les afficher dans le formulaire le cas échéant
        'error' => $errors,
      ]);
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage(),
        'redirection' => 'login'
      ]);
    }
  }


  public function logoutAction(RouteCollection $routes)
  {
    // Supprime les données de session du serveur
    session_destroy();
    // Supprime les données du tableau $_SESSION
    unset($_SESSION);
    // Redirige vers la page d'accueil
    header('Location: ' . $routes->get('homepage')->getPath());
  }
}
