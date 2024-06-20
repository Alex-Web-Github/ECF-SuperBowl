<?php

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Tools\SecurityTools;


class UserController extends Controller
{

  public function registerFormAction(RouteCollection $routes)
  {
    try {
      $errors = [];
      $user = new User();

      if (isset($_POST['saveUser'])) {

        // je filtre les données reçues du formulaire contre les failles XSS directement dans la méthode "hydrate()" // TODO : à revoir
        $user->hydrate($_POST);

        // Puis on attribue, par défaut, le rôle "user" à l'utilisateur
        $user->setUserRole('user');

        // Méthode validate() : permet de vérifier si les données sont valides
        $errors = $user->validate();

        if (empty($errors)) {
          // Si il n'y a pas d'erreurs, alors on enregistre l'utilisateur en BDD
          $userRepository = new UserRepository();

          // Puis on attribue un token unique à l'utilisateur
          $user->setUserToken(SecurityTools::generateToken());

          // J'enregistre l'utilisateur en BDD, en attente de validation de son compte
          $userRepository->persist($user);

          // Pour la validation d'email, je récupère l'Id de l'utilisateur nouvellement enregistré en BDD
          $newUser = $userRepository->findOneByEmail($user->getUserEmail());

          // Si l'envoi de l'email de confirmation échoue, je lève une exception
          if (!$userRepository->sendValidationEmail($newUser)) {
            throw new \Exception('Une erreur est survenue lors de l\'envoi de l\'email de confirmation.</br> Veuillez réessayer.');
          }

          // Sinon, pas de problème d'envoi de mail, je paramètre un message de confirmation 'envoi de mail réussi'
          $errors['mail'] = [
            'message' => 'Votre inscription a bien été enregistrée. Un email de confirmation vous a été envoyé. Veuillez cliquer sur le lien de validation pour activer votre compte. ',
            'redirection_text' => 'Retour à l\'accueil',
            'redirection_slug' => '/'
          ];
        }
      }

      // charger la page registerForm.php
      $this->render('user/registerForm', [
        'error' => $errors ?? [],
      ]);
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage(),
        'redirection_slug' => '/',
        'redirection_text' => 'Retour vers la page Accueil'
      ]);
    }
  }

  public function checkAction(RouteCollection $routes)
  {
    try {
      // Je vérifie si l'Id et le Token sont nuls ou absents dans l'URL
      if (isset($_GET['id']) && isset($_GET['token']) && !empty($_GET['id']) && !empty($_GET['token'])) {
        // Je vérifie si l'Id est un nombre entier
        if (ctype_digit($_GET['id'])) {
          // Je vérifie si l'Id et le Token correspondent à un utilisateur enregistré en BDD
          $userRepository = new UserRepository();
          $user = $userRepository->findOneById($_GET['id']);
          if ($user && $user->getUserToken() === $_GET['token']) {
            // Si l'Id et le Token correspondent à un utilisateur enregistré en BDD, je mets à jour le champ user_is_checked à 1
            $user->setUserIsChecked(1);
            $userRepository->persist($user);

            // J'affiche un message de confirmation sur la page Login
            $errors['mail'] = [
              'message' => 'Votre inscription a bien été validée. Vous pouvez désormais vous connecter.',
              'redirection_text' => '',
              'redirection_slug' => ''
            ];
          } else {
            // Si l'Id et le Token ne correspondent pas à un utilisateur enregistré en BDD, je lève une exception
            throw new \Exception('L\'utilisateur n\'existe pas ou le token est incorrect');
          }
        } else {
          // Si l'Id n'est pas un nombre entier, je lève une exception
          throw new \Exception('L\'Id doit être un nombre entier');
        }
      } else {
        // Si l'Id et/ou le Token sont absents dans l'URL, je lève une exception
        throw new \Exception('L\'Id et/ou le Token sont absents dans l\'URL');
      }

      // charger la page check.php
      $this->render('/auth/loginForm', [
        'error' => $errors ?? []
      ]);
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage(),
        'redirection_slug' => '/',
        'redirection_text' => 'Retour vers la page Accueil'
      ]);
    }
  }


  public function dashboardAction(RouteCollection $routes)
  {
    try {
      // Si l'utilisateur n'est pas connecté ou connecté en Admin, on le redirige vers la page de login
      if (SecurityTools::isLogged() === false || SecurityTools::isAdmin()) {
        header('Location: ' . $routes->get('login')->getPath());
        exit();
      }

      // charger la page dashboard.php
      $this->render('user/dashboard', [
        'user' => $_SESSION['user']
      ]);
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage()
      ]);
    }
  }
}
