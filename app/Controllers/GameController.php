<?php

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;
use App\Entity\Game;
use App\Entity\Bet;
use App\Repository\GameRepository;
use App\Repository\TeamRepository;
use App\Repository\PlayerRepository;
use App\Repository\BetRepository;
use DateInterval;


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

      // Récupération d'un tableau contenant les données des paris pour ce match
      $betRepository = new BetRepository();
      $betsArray = $betRepository->findBetsByGameId($gameId);

      // Récupération du nombre de paris popur l'équipe 1 et l'équipe 2
      $team1Bets = 0;
      $team2Bets = 0;
      foreach ($betsArray as $bet) {
        if ($bet->getBetAmount1() !== 0) {
          $team1Bets++;
        } elseif ($bet->getBetAmount2() !== 0) {
          $team2Bets++;
        }
      }

      // Afficher la Vue speaker-data-game.php
      $this->render('speaker/speaker-data-game', [
        'game' => $game,
        'errors' => $errors,
        'betsArray' => $betsArray,
        'team1Bets' => $team1Bets,
        'team2Bets' => $team2Bets
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

      // Si il y a soumission du formulaire de fermeture de match
      if (isset($_POST) && !empty($_POST)) {
        // Vérifier que le match est bien "En cours"
        if ($game->getGameStatus() !== 'En cours') {
          $errors['message'] = 'Il n\'est pas possible de fermer ce match car il n\'est pas en cours.';
        }

        // Vérifier que la clôture du match est bien postérieure à l'heure de début + 1h
        $date_now = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        // Récupération de l'heure de début du match et ajout de 1 heure
        $game_start = new \DateTime($game->getGameStart(), new \DateTimeZone('Europe/Paris'));
        $game_start_plus_one_hour = clone $game_start;
        $game_start_plus_one_hour->add(new \DateInterval('PT1H'));
        // die(var_dump($date_now, $game_start, $game_start_plus_one_hour));
        if ($date_now < $game_start_plus_one_hour) {
          throw new \Exception('Il n\'est pas possible de fermer ce match avant l\'heure de début + 1h.');
        }

        // Validation des scores des équipes depuis le formulaire
        if (empty($_POST['game_team1_score']) || empty($_POST['game_team2_score'])) {
          $errors['game_team1_score'] = 'Les scores des équipes ne doivent pas être vides.';
          $errors['game_team2_score'] = 'Les scores des équipes ne doivent pas être vides.';
        } elseif (!is_numeric($_POST['game_team1_score'])) {
          $errors['game_team1_score'] = 'Le score de l\'équipe doit être un nombre.';
        } elseif (!is_numeric($_POST['game_team2_score'])) {
          $errors['game_team2_score'] = 'Le score de l\'équipe doit être un nombre.';
        }

        // Je récupère les champs de mon formulaire dans 'speaker-data-game.php' afin d'hydrater mon objet Game
        $game->setGameId($gameId);
        $game->setGameStatus($_POST['game_status']);
        $game->setGameWeather($_POST['game_weather']);
        $gameScore = (int)$_POST['game_team1_score'] . '-' . (int)$_POST['game_team2_score'];
        $game->setGameScore($gameScore);
        $time_now = $date_now->format('H:i');
        $game->setGameEnd($time_now);

        $errors = $game->validateClose();
        // die(var_dump($game));

        if (empty($errors)) {
          // Remplissage du champs "game_winner" de l'Objet Game
          if ((int)$_POST['game_team1_score'] > (int)$_POST['game_team2_score']) {
            $game->setGameWinner(1);
          } elseif ((int)$_POST['game_team1_score'] < (int)$_POST['game_team2_score']) {
            $game->setGameWinner(2);
          } else {
            $game->setGameWinner(0);
          }

          // Enregistrement en BDD
          $gameRepository->persist($game);

          // TODO Ajouter la fonction de calcul des gains des parieurs
          $betRepository = new BetRepository();
          $betRepository->calculateGainByGameId($gameId);



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
      // Afficher la View error.php
      $this->render('errors/default', [
        'error' => $e->getMessage(),
        'redirection_text' => 'Retour à la page du match',
        'redirection_slug' => '/speaker/game/' . $gameId
      ]);
    }
  }
}
