<?php

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;
use App\Tools\SecurityTools;
use App\Entity\Game;
use App\Repository\GameRepository;
use App\Repository\Repository;

class SpeakerController extends Controller
{

  public function dashboardAction(RouteCollection $routes)
  {
    try {

      // Si l'utilisateur n'est pas un Admin, on le redirige vers la page d'accueil
      if (SecurityTools::isSpeaker() === false) {
        header('Location: ' . $routes->get('all-games')->getPath());
        exit();
      }

      $errors = [];
      $dailyGames = new GameRepository();
      $dailyGames = $dailyGames->findDailyGames();

      // Je rends la vue avec les données nécessaires
      $this->render('speaker/dashboard', [
        'dailyGames' => $dailyGames ?? [],
        'error' => $errors,
      ]);
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage()
      ]);
    }
  }
}
