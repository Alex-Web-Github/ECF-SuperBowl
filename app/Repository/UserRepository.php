<?php

namespace App\Repository;

use App\Entity\User;

class UserRepository extends Repository
{

  public function persist(User $user): bool
  {

    if ($user->getUserId() !== null) {
      $query = $this->pdo->prepare(
        'UPDATE users SET user_first_name = :first_name, user_last_name = :last_name, user_email = :email, user_password = :password WHERE user_id = :id'
      );
      $query->bindValue(':id', $user->getUserId(), $this->pdo::PARAM_INT);
      $query->bindValue(':password', $user->getUserPassword(), $this->pdo::PARAM_STR);
    } else {
      // Si pas d'Id, il s'agit d'un nouvel Utilisateur
      $query = $this->pdo->prepare(
        'INSERT INTO users (user_first_name, user_last_name, user_email, user_password, user_role) VALUES (:first_name, :last_name, :email, :password, :role)'
      );
      // Je définis le rôle 'user' par défaut à toute nouvelle inscription
      $query->bindValue(':role', $user->getUserRole(), $this->pdo::PARAM_STR);
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
}
