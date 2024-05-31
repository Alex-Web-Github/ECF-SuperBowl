<?php

namespace App\Controllers;

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
}
