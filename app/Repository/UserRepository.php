<?php

namespace App\Repository;

use App\Entity\User;

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
      $query->bindValue(':password', password_hash($user->getUserPassword(), PASSWORD_DEFAULT), $this->pdo::PARAM_STR);
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
}
