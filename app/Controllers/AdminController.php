<?php

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;
use App\Tools\SecurityTools;

class AdminController extends Controller
{

  public function dashboardAction(RouteCollection $routes)
  {
    try {
      // Si l'utilisateur n'est pas connecté ou n'est pas un Admin, on le redirige vers la page de login
      if (SecurityTools::isLogged() === false || SecurityTools::isAdmin() === false) {
        header('Location: ' . $routes->get('login')->getPath());
      }

      $this->render('admin/dashboard');
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage()
      ]);
    }
  }
}
