<?php

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Tools\SecurityTools;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


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
          // J'instancie un nouvel objet PHPMailer (true-> pour activer les exceptions)
          $mail = new PHPMailer(true);


          // Je récupère les données de l'utilisateur pour les afficher dans le mail (§notamment son Id pour le lien de validation)
          $user = $userRepository->findOneByEmail($_POST['user_email']);

          // Server settings
          // Settings for localhost with MailHog (http://localhost:8025/)
          // $mail->SMTPDebug = 2;  // Enable verbose debug output
          $mail->SMTPDebug = 0;
          $mail->isSMTP();  // Send using SMTP
          $mail->Host       = 'localhost';  // Set the SMTP server to send through
          $mail->SMTPAuth   = false;  // Enable SMTP authentication
          // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
          $mail->Port       = 1025;

          // Recipients
          $mail->setFrom('from@example.com', 'SuperBowl Admin');  // Set who the message is to be sent from
          // $mail->addAddress('$user->getUserEmail()', $user->getUserFirstName());
          $mail->addAddress('joe@example.net', $user->getUserFirstName() . ' ' . $user->getUserLastName());  // Add a recipient

          // Content
          $mail->isHTML(true);  // Set email format to HTML
          $mail->Subject = 'Votre inscription sur le site MoneyBowl';
          $mail->Body    = 'Bonjour ' . $user->getUserFirstName() . ',<br><br> Merci de vous être inscrit sur notre site MoneyBowl. <br> Pour valider votre inscription, veuillez cliquer sur le lien suivant : <a href="' . constant('URL_SUBFOLDER') . '/check?id=' . $user->getUserId() . '&token=' . $user->getUserToken() . '">Valider mon inscription</a>';

          $mail->AltBody = 'Bonjour ,Merci de vous être inscrit sur notre site MoneyBowl. Pour valider votre inscription, veuillez cliquer sur le lien suivant reçu par email.';

          if (!$mail->send()) {
            // Si l'email n'a pas pu être envoyé, je lève une exception
            throw new \Exception('Votre inscription a bien été enregistrée. Cependant, une erreur est survenue lors de l\'envoi de l\'email de confirmation. Veuillez contacter l\'administrateur du site.');
          }

          // Sinon je paramètre un message d'envoi de mail de confirmation réussi'
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
        'error' => $e->getMessage()
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

      // die(var_dump($user));

      // charger la page dashboard.php
      $this->render('user/dashboard', [
        'user' => $user,
        'error' => $errors ?? []
      ]);
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage()
      ]);
    }
  }
}
