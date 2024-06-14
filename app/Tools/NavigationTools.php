<?php

namespace App\Tools;

class NavigationTools
{

  public static function addActiveClass(string $pageName): string
  {
    if (isset($pageName) && !empty($pageName)) {
      $currentUrl = $_SERVER['REQUEST_URI'] ?? '/';
      $path = constant('URL_SUBFOLDER') . $pageName;
      // Si l'URL actuelle est exactement égale au nom de la page
      if (strpos($currentUrl, $path) === 0) {
        return 'active';
      } else {
        return '';
      }
    } else {
      return '';
    }
  }
}
