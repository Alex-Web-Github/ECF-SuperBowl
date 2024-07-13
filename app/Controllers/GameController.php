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
      // Validation du $gameId
      if (!is_numeric($gameId) || $gameId <= 0) {
        throw new \Exception('L\'identifiant du match doit être un nombre entier positif.');
      }

      // Récupérer un Objet Game, correspondant à l'Id désiré
      $game = new Game();
      $gameRepository = new GameRepository();
      $game = $gameRepository->findOneById($gameId);
      // Si le match n'existe pas
      if (!$game) {
        throw new \Exception('Le match demandé n\'existe pas.');
      }
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
      // Afficher la Vue errors/default.php
      $this->render('errors/default', [
        'error' => $e->getMessage(),
        'redirection_text' => 'Retour à la page du match',
        'redirection_slug' => '/speaker/dashboard'
      ]);
    }
  }

  // Afficher les données d'un match selon son Id pour le Speaker
  public function singleGameSpeakerAction(int $gameId): void
  {
    try {
      $errors = [];

      // Validation de $gameId
      if (!is_numeric($gameId) || $gameId <= 0) {
        throw new \Exception('L\'identifiant du match doit être un nombre entier positif.');
      }

      // Récupérer un Objet Game, correspondant à l'Id désiré
      $game = new Game();
      $gameRepository = new GameRepository();
      $game = $gameRepository->findOneById($gameId);
      // Si le match n'existe pas
      if (!$game) {
        throw new \Exception('Le match demandé n\'existe pas.');
      }

      // Récupération d'un tableau contenant les données des paris pour ce match
      $betRepository = new BetRepository();
      $betsArray = $betRepository->findBetsByGameId($gameId);
      // Si il n'y a pas de paris pour ce match
      if (!$betsArray) {
        throw new \Exception('Il n\'y a pas de paris pour ce match.');
      }
      // Récupération du nombre de paris pour l'équipe 1 et l'équipe 2
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
      // Afficher la View error.php
      $this->render('errors/default', [
        'error' => $e->getMessage(),
        'redirection_text' => 'Retour au Dashboard',
        'redirection_slug' => '/speaker/dashboard'
      ]);
    }
  }

  // Fermer un match selon son Id pour le speaker
  public function closeGameAction(int $gameId, RouteCollection $routes): void
  {
    $errors = [];

    try {

      $gameRepository = new GameRepository();
      $betRepository = new BetRepository();

      // Démarrer la transaction
      $gameRepository->beginTransaction();

      // Récupérer un Objet Game, correspondant à l'Id désiré
      $game = $gameRepository->findOneById($gameId);
      // Si le match n'existe pas
      if (!$game) {
        throw new \Exception('Match non trouvé.');
      }
      // Récupération d'un tableau contenant les données des paris pour ce match (pour éviter les erreurs d'affichage en cas de rechargement de la page)
      $betsArray = $betRepository->findBetsByGameId($gameId);

      // Si il y a soumission du formulaire de fermeture de match
      if (isset($_POST) && !empty($_POST)) {

        // 1 - Vérifier que le match est bien "En cours"
        if ($game->getGameStatus() !== 'En cours') {
          $errors['message'] = 'Il n\'est pas possible de fermer ce match car il n\'est pas en cours.';
        }

        // 2 - Vérifier que la clôture du match est bien postérieure à l'heure de début + 1h
        $date_now = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $game_start = new \DateTime($game->getGameStart(), new \DateTimeZone('Europe/Paris'));
        $game_start_plus_one_hour = clone $game_start;
        $game_start_plus_one_hour->add(new \DateInterval('PT1H'));
        if ($date_now < $game_start_plus_one_hour) {
          throw new \Exception('Il n\'est pas possible de fermer ce match avant l\'heure de début + 1h.');
        }

        // 3 - Validation des scores des équipes depuis le formulaire
        if (empty($_POST['game_team1_score'])) {
          $errors['game_team1_score'] = 'Le score de l\'équipe 1 ne doit pas être vide.';
        } elseif (empty($_POST['game_team2_score'])) {
          $errors['game_team2_score'] = 'Le score de l\'équipe 2 ne doit pas être vide.';
        } elseif (!is_numeric($_POST['game_team1_score'])) {
          $errors['game_team1_score'] = 'Le score de l\'équipe doit être un nombre.';
        } elseif (!is_numeric($_POST['game_team2_score'])) {
          $errors['game_team2_score'] = 'Le score de l\'équipe doit être un nombre.';
        }
        // Validation du champs météo
        if (empty($_POST['game_weather']) || $_POST['game_weather'] === 'Choisir la météo') {
          $errors['game_weather'] = 'La météo ne doit pas être vide.';
        }

        // ===> Si aucune erreur de validation
        if (empty($errors)) {
          // 4 - Je récupère les champs de mon formulaire dans 'speaker-data-game.php' afin d'hydrater mon objet Game
          $game->setGameId($gameId);
          // Actualisation de l"heure de fin du match
          $game->setGameEnd($date_now->format('H:i'));
          // Mettre à jour l'état du match
          $game->setGameStatus('Terminé');
          $gameScore = (int)$_POST['game_team1_score'] . '-' . (int)$_POST['game_team2_score'];
          $game->setGameScore($gameScore);
          $game->setGameWeather($_POST['game_weather']);
          // Remplissage du champs "game_winner" de l'Objet Game
          if ((int)$_POST['game_team1_score'] > (int)$_POST['game_team2_score']) {
            $game->setGameWinner(1);
          } elseif ((int)$_POST['game_team1_score'] < (int)$_POST['game_team2_score']) {
            $game->setGameWinner(2);
          } else {
            $game->setGameWinner(0);
          }

          // 5 - Fermeture du match
          if ($gameRepository->inTransaction()) {
            // Enregistrement en BDD
            $gameRepository->persist($game);
            // Valider la transaction
            $gameRepository->commit();
            // Récupération d'un tableau contenant les paris pour ce match
            // et Calcul des gains pour chacun des paris
            $betsArray = $betRepository->findBetsByGameId($gameId);
            foreach ($betsArray as $bet) {
              if (
                $game->getGameWinner() === 1 && $bet->getBetAmount1() !== 0
              ) {
                $bet->setBetResult($bet->getBetAmount1() * $game->getTeam1Odds());
              } elseif ($game->getGameWinner() === 2 && $bet->getBetAmount2() !== 0) {
                $bet->setBetResult($bet->getBetAmount2() * $game->getTeam2Odds());
              } else {
                $bet->setBetResult(0);
              }
              // Enregistrement en BDD
              $betRepository->persist($bet);
              // Valider la transaction
              $betRepository->commit();
            }
          } else {
            throw new \Exception('Transaction non démarrée.');
          }

          // Rediriger vers la page Dashboard du Commentateur
          header('Location: ' . $routes->get('speakerDashboard')->getPath());
          exit();
        }
        // die(var_dump($_POST) . var_dump($errors));

        // Récupération des infos (nb de parieurs) pour empêcher l'affichage des erreurs en cas de rechargement de la page ci-après.
        $team1Bets = 0;
        $team2Bets = 0;
        foreach ($betsArray as $bet) {
          if ($bet->getBetAmount1() !== 0) {
            $team1Bets++;
          } elseif ($bet->getBetAmount2() !== 0) {
            $team2Bets++;
          }
        }
        $this->render('speaker/speaker-data-game', [
          'errors' => $errors,
          'game' => $game,
          'betsArray' => $betsArray,
          'team1Bets' => $team1Bets,
          'team2Bets' => $team2Bets
        ]);
      }
    } catch (\Exception $e) {
      // Annuler la transaction en cas d'erreur
      if ($gameRepository->inTransaction()) {
        $gameRepository->rollBack();
      }
      // Afficher la View error.php
      $this->render('errors/default', [
        'error' => $e->getMessage(),
        'redirection_text' => 'Retour au Dashboard',
        'redirection_slug' => '/speaker/dashboard'
      ]);
    }
  }
}
