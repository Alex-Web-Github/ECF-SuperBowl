<?php

namespace App\Repository;


use App\Entity\User;

class UserRepository extends Repository
{

  public function persist(User $user): bool
  {

    if ($user->getId() !== null) {
      $query = $this->pdo->prepare(
        'UPDATE users SET user_first_name = :first_name, user_last_name = :last_name, user_email = :email, user_password = :password WHERE user_id = :id'
      );
      $query->bindValue(':id', $user->getId(), $this->pdo::PARAM_INT);
      $query->bindValue(':password', $user->getPassword(), $this->pdo::PARAM_STR);
    } else {
      // Si pas d'Id, il s'agit d'un nouvel Utilisateur
      $query = $this->pdo->prepare(
        'INSERT INTO users (user_first_name, user_last_name, user_email, user_password, user_role) VALUES (:first_name, :last_name, :email, :password, :role)'
      );
      // Je définis le rôle 'user' par défaut à toute nouvelle inscription
      $query->bindValue(':role', $user->getRole(), $this->pdo::PARAM_STR);
      $query->bindValue(':password', password_hash($user->getPassword(), PASSWORD_DEFAULT), $this->pdo::PARAM_STR);
    }

    $query->bindValue(':first_name', $user->getFirstName(), $this->pdo::PARAM_STR);
    $query->bindValue(':last_name', $user->getLastName(), $this->pdo::PARAM_STR);
    $query->bindValue(':email', $user->getEmail(), $this->pdo::PARAM_STR);

    return $query->execute();
  }
}
