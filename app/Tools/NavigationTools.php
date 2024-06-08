<?php

namespace App\Tools;

class NavigationTools
{

  public static function addActiveClass(string $pageName): string
  {
    if (isset($pageName) && !empty($pageName)) {
      // Je récupère l'URL actuelle
      $currentPage = $_SERVER['REQUEST_URI'];
      // Je vérifie si l'URL actuelle est exactement égale au nom de la page
      if ($currentPage == $pageName) {
        // Si c'est le cas, renvoie la chaîne 'active'
        return 'active';
      } else {
        // Sinon, renvoie une chaîne vide
        return '';
      }
    } else {
      return '';
    }
  }
}
