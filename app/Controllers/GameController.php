<?php

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;
use App\Entity\Game;
use App\Repository\GameRepository;
use App\Repository\TeamRepository;
use App\Repository\PlayerRepository;


class GameController extends Controller
{
  // Afficher les données d'un match selon son Id
  public function singleGameAction(int $gameId): void
  {
    try {
      $errors = [];

      // Récupérer un Objet Game, correspondant à l'Id désiré
      $game = new Game();
      $gameRepository = new GameRepository();
      $game = $gameRepository->findOneById($gameId);

      // Récupérer les données de chaque équipe par leur Id
      // Le retour est un Objet Team
      $teamRepository = new TeamRepository();
      $team1 = $teamRepository->findOneById($game->getTeam1Id());
      $team2 = $teamRepository->findOneById($game->getTeam2Id());

      // Récupérer un tableau contenant les id de chaque joueur de chaque équipe
      $team1PlayersIdList = explode(",", $team1->getTeamPlayers());
      $team2PlayersIdList = explode(",", $team2->getTeamPlayers());

      // Récupérer un tableau contenant les objets Player de chaque joueur de chaque équipe
      $playerRepository = new PlayerRepository();
      foreach ($team1PlayersIdList as $playerId) {
        $team1Players[] = $playerRepository->findOneById($playerId);
      }
      foreach ($team2PlayersIdList as $playerId) {
        $team2Players[] = $playerRepository->findOneById($playerId);
      }

      // Afficher la View game-data.php
      $this->render('game/game-data', [
        'game' => $game,
        'team1Players' => $team1Players,
        'team2Players' => $team2Players,
        'errors' => $errors
      ]);
    } catch (\Exception $e) {
      $errors[] = $e->getMessage();

      // Afficher la View error.php
      $this->render('error', [
        'errors' => $errors
      ]);
    }
  }

  // Afficher les données d'un match selon son Id pour le Speaker
  public function singleGameSpeakerAction(int $gameId): void
  {
    try {
      $errors = [];

      // Récupérer un Objet Game, correspondant à l'Id désiré
      $game = new Game();
      $gameRepository = new GameRepository();
      $game = $gameRepository->findOneById($gameId);
      // die(var_dump($game));

      // Afficher la Vue speaker-data-game.php
      $this->render('speaker/speaker-data-game', [
        'game' => $game,
        'errors' => $errors
      ]);
    } catch (\Exception $e) {
      $errors[] = $e->getMessage();

      // Afficher la View error.php
      $this->render('error', [
        'errors' => $errors
      ]);
    }
  }

  // Fermer un match selon son Id pour le speaker
  public function closeGameAction(int $gameId, RouteCollection $routes): void
  {
    try {
      $errors = [];

      // Récupérer un Objet Game, correspondant à l'Id désiré
      $game = new Game();
      $gameRepository = new GameRepository();
      $game = $gameRepository->findOneById($gameId);

      // Vérifier si le match est déjà commencé et que l'heure actuelle est supérieure ou égale à l'heure de début + 1h
      if ($game->getGameStatus() !== 'En cours') {
        // throw new \Exception('Il n\'est pas possible de fermer ce match car il n\'est pas en cours.');
        $errors['message'] = 'Il n\'est pas possible de fermer ce match car il n\'est pas en cours.';
      } elseif (strtotime($game->getGameStart()) + 3600 >= time()) {
        $errors['message'] = 'Il n\'est pas possible de fermer ce match car il n\'est pas commencé depuis au moins 1 heure.';
        // throw new \Exception('Il n\'est pas possible de fermer ce match car il n\'est pas commencé depuis au moins 1 heure.');
      }

      if (empty($errors)) {
        die('TODO  : Fermeture du match' . var_dump($_POST));


        // Rediriger vers la page d'accueil du Speaker
        header('Location: ' . $routes->get('speakerDashboard')->getPath());
        exit();
      } else {
        // Je reste sur la page actuelle
        $this->render('speaker/speaker-data-game', [
          'game' => $game,
          'error' => $errors
        ]);
      }
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage()
      ]);
    }
  }
}
