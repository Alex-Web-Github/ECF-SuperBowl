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

      if (isset($_POST) && !empty($_POST)) {
        // Vérifier que le match est bien "En cours"
        if ($game->getGameStatus() !== 'En cours') {
          $errors['message'] = 'Il n\'est pas possible de fermer ce match car il n\'est pas en cours.';
        }
        // Validation des scores des équipes depuis le formulaire
        if (empty($_POST['game_team1_score']) || empty($_POST['game_team2_score'])) {
          $errors['message'] = 'Les scores des équipes ne doivent pas être vides.';
        } elseif (!is_numeric($_POST['game_team1_score']) || !is_numeric($_POST['game_team2_score'])) {
          $errors['message'] = 'Les scores des équipes doivent être des nombres.';
        }

        // Je récupère les champs de mon formulaire dans 'speaker-data-game.php' afin d'hydrater mon objet Game
        $game->setGameId($gameId);
        $game->setGameStatus($_POST['game_status']);
        $game->setGameWeather($_POST['game_weather']);
        $gameScore = (int)$_POST['game_team1_score'] . '-' . (int)$_POST['game_team2_score'];
        $game->setGameScore($gameScore);
        $game->setGameEnd($_POST['game_end']);

        $errors = $game->validateClose();
        // die(var_dump($errors));

        if (empty($errors)) {
          // Enregistrement en BDD
          $gameRepository->persist($game);
          // Rediriger vers la page d'accueil du Speaker
          header('Location: ' . $routes->get('speakerDashboard')->getPath());
          exit();
        }
      }

      // Je reste sur la page actuelle
      $this->render('speaker/speaker-data-game', [
        'errors' => $errors,
        'game' => $game
      ]);
    } catch (\Exception $e) {
      $errors[] = $e->getMessage();
      // Afficher la View error.php
      $this->render('error', [
        'errors' => $errors
      ]);
    }
  }
}
