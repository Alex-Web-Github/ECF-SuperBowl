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

        // Je valide les champs envoyés par le formulaire
        if (empty($_POST['email']) || empty($_POST['password'])) {
          $errors['email'] = $errors['password'] = 'Les champs mot de passe et/ou e-mail ne doivent pas être vides';
        } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
          $errors['email'] = 'L\'email n\'est pas valide';
        }

        if (empty($errors)) {
          // Si il n'y a pas d'erreurs de validation, alors on vérifie si l'utilisateur existe en BDD
          $userRepository = new UserRepository();
          $user = $userRepository->findOneByEmail($_POST['email']);

          // Je vérifie si le mot de passe qui correspond à l'email est correct ET que son compte est bien vérifié
          if ($user && SecurityTools::verifyPassword($_POST['password'], $user)) {

            // Je vérifie que le compte de l'utilisateur est bien vérifié
            if ($user->getUserIsChecked() !== 1) {
              throw new \Exception('Votre compte n\'a pas encore été vérifié. Veuillez vérifier vos emails.');
            }
            // Je stocke en Session tous les attributs de l'objet User
            // Attention : $_SESSION['user'] devient un objet User
            $_SESSION['user'] = $user;

            // Redirige l'utilisateur en fonction de son rôle
            if ($user->getUserRole() === 'admin') {
              header('Location: ' . $routes->get('adminDashboard')->getPath());
              exit();
            } else {
              header('Location: ' . $routes->get('userDashboard')->getPath());
              exit();
            }
          } else {
            // Je lance une exception si l'email et/ou le mot de passe sont incorrects
            throw new \Exception('Email et/ou mot de passe incorrect(s).');
          }
        }
      }
      // charger la page loginForm.php
      $this->render('auth/loginForm', [
        // On passe les erreurs à la View pour pouvoir les afficher dans le formulaire le cas échéant
        'error' => $errors
      ]);
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage(),
        'redirection_slug' => '/login',
        'redirection_text' => 'Retour vers la page Connexion'
      ]);
    }
  }


  public function logoutAction(RouteCollection $routes)
  {

    // Supprime toutes les données de session
    unset($_SESSION['user']);
    // Redirige vers la page Accueil
    header('Location: ' . $routes->get('all-games')->getPath());
    exit();
  }
}
