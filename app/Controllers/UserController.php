<?php

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;
use App\Repository\UserRepository;
use App\Entity\User;

class UserController extends Controller
{

  public function registerFormAction(RouteCollection $routes)
  {
    try {
      $errors = [];
      $user = new User();

      if (isset($_POST['saveUser'])) {

        // je filtre les données reçues du formulaire contre les failles XSS directement dans la méthode "hydrate()"
        $user->hydrate($_POST);

        // Puis on attribue, par défaut, le rôle "user" à l'utilisateur
        $user->setUserRole('user');

        // Méthode validate() : permet de vérifier si les données sont valides
        $errors = $user->validate();

        if (empty($errors)) {
          // Si il n'y a pas d'erreurs, alors on enregistre l'utilisateur en BDD
          $userRepository = new UserRepository();

          // La méthode persist() permet à la fois de créer ou modifier un utilisateur suivant si un Id est renseigné (ie: Utilisateur déjà enregistré) ou non en BDD
          $userRepository->persist($user);

          // Puis on redirige vers la page Login
          header('Location: ' . $routes->get('login')->getPath());
        }
      }

      // charger la page registerForm.php
      $this->render('user/registerForm', [
        // On passe les erreurs à la View pour pouvoir les afficher dans le formulaire le cas échéant
        'errors' => $errors
      ]);
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage()
      ]);
    }
  }
}
