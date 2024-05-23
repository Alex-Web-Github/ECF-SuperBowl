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

        $userRepository = new UserRepository();
        // Je récupère l'utilisateur qui correspond à l'email
        $user = $userRepository->findOneByEmail($_POST['email']);

        // Je vérifie si le mot de passe qui correspond à l'email est correct
        if ($user && SecurityTools::verifyPassword($_POST['password'], $user)) {

          // Regénère l'id de Session pour éviter la "fixation de session"
          session_regenerate_id(true);

          // On stocke en Session tous les attributs de l'objet User
          $_SESSION['user'] = $user;

          // $_SESSION['user'] = [
          //   'id' => $user->getUserId(),
          //   'first_name' => $user->getUserFirstName(),
          //   'last_name' => $user->getUserLastName(),
          //   'email' => $user->getUserEmail(),
          //   'role' => $user->getUserRole()
          // ];

          // die(var_dump($_SESSION['user']));

          if (SecurityTools::isUser()) {
            // Si l'utilisateur est un utilisateur, on le redirige vers son profil
            // header('Location: ' . $routes->get('userDashboard')->getPath());
            $errors[] = 'Vous êtes connecté en tant qu\'utilisateur';
          } else if (SecurityTools::isAdmin()) {
            // Si l'utilisateur est un admin, on le redirige vers le dashboard
            // header('Location: ' . $routes->get('adminDashboard')->getPath());
            $errors[] = 'Vous êtes connecté en tant qu\'admin';
          }
        } else {
          // message d'erreur si le mot de passe est incorrect
          $errors[] = 'Email ou nom d\'utilisateur incorrect';
        }
      }

      // charger la page loginForm.php
      $this->render('auth/loginForm', [
        // On passe les erreurs à la View pour pouvoir les afficher dans le formulaire le cas échéant
        'errors' => $errors
      ]);
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage()
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
