<?php

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;


class PageController extends Controller
{

  public function homeAction(RouteCollection $routes)
  {
    // charger la page home.php
    $this->render('home');
  }
}
