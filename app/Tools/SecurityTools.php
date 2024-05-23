<?php

namespace App\Tools;

use App\Entity\User;

class SecurityTools
{
  public static function verifyPassword(string $password, User $user): bool
  {
    return password_verify($password, $user->getUserPassword());
  }


  public static function isLogged(): bool
  {
    return isset($_SESSION['user']);
  }

  public static function isUser(): bool
  {
    return isset($_SESSION['user']) && $_SESSION['user']->getUserRole() === 'user';
  }

  public static function isAdmin(): bool
  {
    return isset($_SESSION['user']) && $_SESSION['user']->getUserRole() === 'admin';
  }

  public static function getCurrentUserId(): int|bool
  {
    return (isset($_SESSION['user']) && (null !== $_SESSION['user']->getUserId())) ? $_SESSION['user']->getUserId() : false;
  }
}
