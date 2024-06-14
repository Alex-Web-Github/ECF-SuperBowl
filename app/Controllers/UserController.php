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

          // La méthode persist() permet à la fois de créer ou modifier un utilisateur suivant si un Id est renseigné (ie: Utilisateur déjà enregistré) ou non en BDD
          $userRepository->persist($user);

          /**
           *  Envoi d'un email de confirmation avec PHPMailer
           */

          // J'instancie un nouvel objet PHPMailer (true-> pour activer les exceptions)
          $mail = new PHPMailer(true);

          // Server settings
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
          $mail->Body    = 'Bonjour ' . $user->getUserFirstName() . ',<br><br> Merci de vous être inscrit sur notre site MoneyBowl. <br> Pour valider votre inscription, veuillez cliquer sur le lien suivant : <a href="http://localhost:8000/validate/' . $user->getUserToken() . '">Valider mon inscription</a>';

          $mail->AltBody = 'Bonjour ,Merci de vous être inscrit sur notre site MoneyBowl. Pour valider votre inscription, veuillez cliquer sur le lien suivant : http://localhost:8000/validate/' . $user->getUserToken() . '';

          if (!$mail->send()) {
            // Si l'envoi a réussi, j'affiche un message de confirmation
            $error['mail'] = [
              'message' => 'Votre inscription a bien été enregistrée. Un email de confirmation vous a été envoyé à l\'adresse suivante : ' . $user->getUserEmail(),
              'redirection_text' => 'Retour à la page de connexion',
              'redirection_slug' => $routes->get('login')->getPath()
            ];
          } else {
            // Si l'email n'a pas pu être envoyé, je lève une exception
            throw new \Exception('Votre inscription a bien été enregistrée. Cependant, une erreur est survenue lors de l\'envoi de l\'email de confirmation. Veuillez réessayer ultérieurement.');
          }

          // Puis on redirige vers la page Login
          header('Location: ' . $routes->get('login')->getPath());
        }
      }

      // charger la page registerForm.php
      $this->render('user/registerForm', [
        'errors' => $errors
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
      // Si l'utilisateur n'est pas connecté ou connecté en Admin, on le redirige vers la page de login
      if (SecurityTools::isLogged() === false || SecurityTools::isAdmin()) {
        header('Location: ' . $routes->get('login')->getPath());
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
