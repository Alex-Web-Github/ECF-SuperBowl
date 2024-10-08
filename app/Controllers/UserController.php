<?php

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Tools\SecurityTools;
use PHPMailer\PHPMailer\PHPMailer;
use App\Repository\BetRepository;


class UserController extends Controller
{

  public function registerFormAction(): void
  {
    try {
      $errors = [];
      $user = new User();

      if (isset($_POST['saveUser'])) {

        // je filtre les données reçues du formulaire contre les failles XSS directement dans la méthode "hydrate()"
        $user->hydrate($_POST);

        // Puis on attribue, par défaut, le rôle "user" à l'utilisateur
        $user->setUserRole('user');

        // Puis je génère un token unique pour l'utilisateur (true -> plus de caractères, plus de sécurité)
        $user->setUserToken(
          uniqid($prefix = 'D', $more_entropy = true)
        );

        // Méthode validate() : permet de vérifier si les données sont valides
        $errors = $user->validate();

        if (empty($errors)) {
          // Si il n'y a pas d'erreurs, alors on enregistre l'utilisateur en BDD
          $userRepository = new UserRepository();

          // La méthode persist() permet de créer (ou modifier un utilisateur si cet Utilisateur est déjà enregistré) un nouvel Utilisateur en BDD
          $userRepository->persist($user);

          /**
           *  Envoi d'un email de confirmation avec PHPMailer
           */
          $user = $userRepository->findOneByEmail($_POST['user_email']);
          $userRepository->sendValidationEmail($user);

          // Je paramètre un message d'envoi de mail de confirmation réussi'
          $errors['mail'] = [
            'message' => 'Votre inscription a bien été enregistrée. Un email de confirmation vous a été envoyé. Veuillez cliquer sur le lien de validation pour activer votre compte. Si aucun message reçu, vérifiez dans vos Spams.',
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
        'error' => $e->getMessage()
      ]);
    }
  }

  public function checkAction(): void
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
        'error' => $e->getMessage()
      ]);
    }
  }

  public function dashboardAction(RouteCollection $routes)
  {
    try {
      // Si le visiteur n'est pas connecté, on le redirige vers la page de login
      if (SecurityTools::isLogged() === false) {
        header('Location: ' . $routes->get('login')->getPath());
        exit();
      }

      $errors = [];

      // Je récupère les infos de l'utilisateur connecté
      $userRepository = new UserRepository();
      $user = $userRepository->findOneById($_SESSION['user']->getUserId());

      // Je récupère tous les paris+infos du Game de l'utilisateur connecté
      $betRepository = new BetRepository();
      $betsArray = $betRepository->findAllBetsWithGameByUser($user->getUserId());
      // die(var_dump($betsArray));

      // charger la page dashboard.php
      $this->render('user/dashboard', [
        'user' => $user,
        'betsArray' => $betsArray,
        'error' => $errors ?? []
      ]);
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage()
      ]);
    }
  }
}
