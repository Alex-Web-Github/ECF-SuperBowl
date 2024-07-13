<?php

namespace App\Tools;

use App\Entity\User;

class SecurityTools
{

  // Fonction de hachage du mot de passe utilisée dans la méthode persist() de UserRepository
  public static function hashPassword(string $password): string
  {
    return password_hash($password, PASSWORD_DEFAULT);
  }

  // Fonction de génération de mot de passe aléatoire
  public static function generatePassword(): string
  {
    return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()'), 0, 10);
    // Renvoie un String des 10 premiers caractères de la grand chaîne 'abc...()' mélangée aléatoirement
  }

  // Fonction de vérification du mot de passe
  public static function verifyPassword(string $password, User $user): bool
  {
    return password_verify($password, $user->getUserPassword());
  }

  // Fonction de génération de token unique
  // Ou plus simple : un token unique basé sur l'heure actuelle (en microsec.) --> uniqid($prefix='D', $more_entropy=true)
  public static function generateToken(): string
  {
    // Convertit des données binaires (de 16 octets aléatoires) en représentation hexadécimale (chaque octet est converti en 2 caractères hexadécimaux -> chaîne de 32 caractères à prévoir en BDD. Adapté pour générer des tokens sécurisés
    return bin2hex(random_bytes(16));
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

  public static function isSpeaker(): bool
  {
    return isset($_SESSION['user']) && $_SESSION['user']->getUserRole() === 'speaker';
  }

  public static function getCurrentUserId(): int|bool
  {
    return (isset($_SESSION['user']) && (null !== $_SESSION['user']->getUserId())) ? $_SESSION['user']->getUserId() : false;
  }
}
