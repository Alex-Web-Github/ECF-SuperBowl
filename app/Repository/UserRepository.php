<?php

namespace App\Repository;

use App\Entity\User;
use App\Tools\SecurityTools;
use PHPMailer\PHPMailer\PHPMailer;


class UserRepository extends Repository
{

  public function persist(User $user): bool
  {
    if ($user->getUserId() !== null) {
      $query = $this->pdo->prepare(
        'UPDATE users SET user_first_name = :first_name, user_last_name = :last_name, user_email = :email, user_password = :password, user_is_checked = :is_checked WHERE user_id = :id'
      );
      $query->bindValue(':id', $user->getUserId(), $this->pdo::PARAM_INT);
      $query->bindValue(':password', $user->getUserPassword(), $this->pdo::PARAM_STR);
      $query->bindValue(':is_checked', $user->getUserIsChecked(), $this->pdo::PARAM_INT);
    } else {
      // Si pas d'Id, il s'agit d'un nouvel Utilisateur
      $query = $this->pdo->prepare(
        'INSERT INTO users (user_first_name, user_last_name, user_email, user_password, user_role, user_is_checked, user_token) VALUES (:first_name, :last_name, :email, :password, :role, :is_checked, :token)'
      );
      // Je définis le rôle 'user' par défaut à toute nouvelle inscription
      $query->bindValue(':role', $user->getUserRole(), $this->pdo::PARAM_STR);
      // Je définis un token unique pour chaque nouvel utilisateur
      $query->bindValue(':token', $user->getUserToken(), $this->pdo::PARAM_STR);
      // J'initialise user_is_checked à 0 par défaut
      $query->bindValue(':is_checked', 0, $this->pdo::PARAM_INT);
      // Je chiffre le mot de passe avant de l'enregistrer en BDD
      $query->bindValue(':password', SecurityTools::hashPassword($user->getUserPassword()), $this->pdo::PARAM_STR);
    }
    $query->bindValue(':first_name', $user->getUserFirstName(), $this->pdo::PARAM_STR);
    $query->bindValue(':last_name', $user->getUserLastName(), $this->pdo::PARAM_STR);
    $query->bindValue(':email', $user->getUserEmail(), $this->pdo::PARAM_STR);

    return $query->execute();
  }

  public function findOneByEmail(string $email): User|bool
  {
    $query = $this->pdo->prepare("SELECT * FROM users WHERE user_email = :email");
    $query->bindValue(':email', $email, $this->pdo::PARAM_STR);
    $query->execute();
    $user = $query->fetch($this->pdo::FETCH_ASSOC);
    if ($user) {
      return User::createAndHydrate($user);
    }
    return false;
  }

  public function findAll(): array
  {
    $query = $this->pdo->prepare("SELECT * FROM users WHERE user_role = :role");
    $query->bindValue(':role', 'user', $this->pdo::PARAM_STR);
    $query->execute();
    $users = $query->fetchAll($this->pdo::FETCH_ASSOC);
    $usersList = [];
    // On hydrate les objets User
    foreach ($users as $user) {
      // Je stocke chaque objet User dans un tableau
      $usersList[] = User::createAndHydrate($user);
    }
    return $usersList;
  }

  public function findOneById(int $id): User|bool
  {
    $query = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :id");
    $query->bindValue(':id', $id, $this->pdo::PARAM_INT);
    $query->execute();
    $user = $query->fetch($this->pdo::FETCH_ASSOC);
    if ($user) {
      return User::createAndHydrate($user);
    }
    return false;
  }

  public function sendNewPassword(User $user, string $newPassword): bool
  {
    // J'instancie un nouvel objet PHPMailer (true-> pour activer les exceptions)
    $mail = new PHPMailer(true);

    /** Import du fichier de configuration des paramètres de mail
     * A décommenter ci-dessous en PRODUCTION
     */
    // $mailConfig = require_once APP_ROOT . '/config/mail_config.php';

    // Server settings (valeurs par défaut : en LOCAL avec MailHog (http://localhost:8025/)
    $mail->isSMTP();
    $mail->Host = $mailConfig['host'] ?? 'localhost';
    $mail->SMTPAuth = $mailConfig['SMTPAuth'] ?? false;
    $mail->SMTPDebug = $mailConfig['SMTPDebug'] ?? 0;
    $mail->Username = $mailConfig['username'] ?? '';
    $mail->Password = $mailConfig['password'] ?? '';
    $mail->SMTPSecure = $mailConfig['encryption'] ?? '';
    $mail->Port = $mailConfig['port'] ?? 1025;

    // Recipients
    $mail->setFrom('from_admin@moneybowl.com', 'MoneyBowl Admin');
    $mail->addAddress($user->getUserEmail(), $user->getUserFirstName());

    // Content
    $mail->isHTML(true);  // Set email format to HTML
    $mail->Subject = 'Votre compte MoneyBowl : nouveau mot de passe';
    $mail->Body    = 'Bonjour ' . $user->getUserFirstName() . ',<br><br>Voici votre nouveau mot de passe : ' . $newPassword . '<br><br>Vous pouvez le modifier dans votre espace personnel.<br><br>Cordialement,<br><br>L\'équipe SuperBowl';
    $mail->AltBody = 'Bonjour,Voici votre nouveau mot de passe : ' . $newPassword . 'Vous pouvez le modifier dans votre espace personnel.Cordialement,L\'équipe SuperBowl';

    return $mail->send();
  }

  public function sendValidationEmail(User $user): bool
  {
    // J'instancie un nouvel objet PHPMailer (true-> pour activer les exceptions)
    $mail = new PHPMailer(true);

    /** Import du fichier de configuration des paramètres de mail
     * A décommenter ci-dessous en PRODUCTION
     */
    // $mailConfig = require_once APP_ROOT . '/config/mail_config.php';

    // Server settings (valeurs par défaut : en LOCAL avec MailHog (http://localhost:8025/)
    $mail->isSMTP();
    $mail->Host = $mailConfig['host'] ?? 'localhost';
    $mail->SMTPAuth = $mailConfig['SMTPAuth'] ?? false;
    $mail->SMTPDebug = $mailConfig['SMTPDebug'] ?? 0;
    $mail->Username = $mailConfig['username'] ?? '';
    $mail->Password = $mailConfig['password'] ?? '';
    $mail->SMTPSecure = $mailConfig['encryption'] ?? '';
    $mail->Port = $mailConfig['port'] ?? 1025;

    // Recipients
    $mail->setFrom('from_admin@moneybowl.com', 'MoneyBowl Admin');
    $mail->addAddress($user->getUserEmail(), $user->getUserFirstName());

    // Content
    $mail->isHTML(true);  // Set email format to HTML
    $mail->Subject = 'Votre inscription sur le site MoneyBowl';
    $mail->Body    = 'Bonjour ' . $user->getUserFirstName() . ',<br><br> Merci de vous être inscrit sur notre site MoneyBowl. <br> Pour valider votre inscription, veuillez cliquer sur le lien suivant : <a href="' . constant('URL_SUBFOLDER') . '/check?id=' . $user->getUserId() . '&token=' . $user->getUserToken() . '">Valider mon inscription</a>';

    $mail->AltBody = 'Bonjour, Merci de vous être inscrit sur notre site MoneyBowl. Pour valider votre inscription, veuillez cliquer sur le lien suivant reçu par email.';

    if ($mail->send()) {
      return true;
    } else {
      return false;
    }
  }
}
