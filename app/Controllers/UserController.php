<?php

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Tools\SecurityTools;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
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
          $mail = new PHPMailer(true);

          try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
            $mail->isSMTP(); //Send using SMTP
            $mail->Host       = 'smtp.example.com'; //Set the SMTP server to send through
            $mail->SMTPAuth   = true; //Enable SMTP authentication
            $mail->Username   = 'user@example.com'; //SMTP username
            $mail->Password   = 'secret'; //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            //Enable implicit TLS encryption
            $mail->Port       = 465;
            //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress('alexandre-foulc@orange.fr', 'Joe User'); //Add a recipient
            // $mail->addAddress('ellen@example.com'); //Name is optional
            $mail->addReplyTo('alexandre-foulc@orange.fr', '');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz'); //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); //Optional name

            //Content
            $mail->isHTML(true); //Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
          } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
