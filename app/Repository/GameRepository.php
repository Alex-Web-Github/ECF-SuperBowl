<?php

namespace App\Repository;

use App\Entity\Game;

class GameRepository extends Repository
{

  public function persist(Game $game): bool
  {

    if ($game->getGameId() !== null) {
      $query = $this->pdo->prepare(
        'UPDATE games SET game_date = :date, team1_id = :team1, team2_id = :team2, game_start = :start_time, game_end = :end_time, team1_odds = :team1_odds, team2_odds = :team2_odds WHERE game_id = :id'
      );
      $query->bindValue(':id', $game->getGameId(), $this->pdo::PARAM_INT);
    } else {
      // Si pas d'Id, il s'agit d'un nouveau game
      $query = $this->pdo->prepare(
        'INSERT INTO games (game_date, team1_id, team2_id, game_start, game_end, team1_odds, team2_odds) VALUES (:date, :team1, :team2, :start_time, :end_time, :team1_odds, :team2_odds)'
      );
    }
    // nb: Nécessaire car \PDO ne peut pas gérer les objets DateTime, je laisse mes propriétés date et heure en String
    $query->bindValue(':date', $game->getGameDate(), $this->pdo::PARAM_STR);
    $query->bindValue(':team1', $game->getTeam1(), $this->pdo::PARAM_INT);
    $query->bindValue(':team2', $game->getTeam2(), $this->pdo::PARAM_INT);
    $query->bindValue(':start_time', $game->getGameStart(), $this->pdo::PARAM_STR);
    $query->bindValue(':end_time', $game->getGameEnd(), $this->pdo::PARAM_STR);
    $query->bindValue(':team1_odds', $game->getTeam1Odds(), $this->pdo::PARAM_STR);
    $query->bindValue(':team2_odds', $game->getTeam2Odds(), $this->pdo::PARAM_STR);

    return $query->execute();
  }
}
