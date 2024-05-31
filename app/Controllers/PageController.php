<?php

namespace App\Controllers;

use App\Repository\GameRepository;
use Symfony\Component\Routing\RouteCollection;


class PageController extends Controller
{

  public function homeAction(RouteCollection $routes)
  {
    try {
      $errors = [];
      $gamesList = [];

      $gameRepositiory = new GameRepository;

      // 1. Récupérer le DateTime actuel
      $dateTime = new \DateTime();
      $dateTime->setTimezone(new \DateTimeZone('Europe/Paris'));
      $nowTime = $dateTime->format('H:i:s');
      $nowDate = $dateTime->format('Y-m-d');

      // 2. Actualiser le Status en fonction du dateTime actuel
      $gameRepositiory->updateStatus($nowTime, $nowDate);

      // 2. Récupérer tous les Games sous la forme d'un tableau d'objets Game
      $gamesList[] = $gameRepositiory->findAll();

      // 3. Récupérer la liste des Games suivant le Status
      foreach ($gamesList[0] as $game) {
        if ($game->getGameStatus() === 'A venir') {
          $gamesList['upcoming'][] = $game;
        } else if ($game->getGameStatus() === 'En cours') {
          $gamesList['live'][] = $game;
        } else {
          $gamesList['past'][] = $game;
        }
      }

      // Afficher la View home.php
      $this->render('home', [
        'gamesList' => $gamesList[0],
        'upcomingGames' => $gamesList['upcoming'],
        'liveGames' => $gamesList['live'],
        'pastGames' => $gamesList['past'],
        'errors' => $errors
      ]);
    } catch (\Exception $e) {
      $errors[] = $e->getMessage();
    }
  }
}
