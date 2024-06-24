<?php

namespace App\Repository;

use App\Entity\Bet;


class BetRepository extends Repository
{

  public function persist(Bet $bet): void
  {
    if ($bet->getBetId() !== null) {
      $query = $this->pdo->prepare(
        'UPDATE bets SET game_id = :game_id, user_id = :user_id, bet_amount1 = :bet_amount1, bet_amount2 = :bet_amount2, bet_date = :bet_date WHERE bet_id = :id'
      );
      $query->bindValue(':id', $bet->getBetId(), $this->pdo::PARAM_INT);
    } else {
      $query = $this->pdo->prepare(
        'INSERT INTO bets (game_id, user_id, bet_amount1, bet_amount2, bet_date) VALUES (:game_id, :user_id, :bet_amount1, :bet_amount2, :bet_date)'
      );
    }

    $query->bindValue(':game_id', $bet->getGameId(), $this->pdo::PARAM_INT);
    $query->bindValue(':user_id', $bet->getUserId(), $this->pdo::PARAM_INT);
    $query->bindValue(':bet_amount1', $bet->getBetAmount1(), $this->pdo::PARAM_INT);
    $query->bindValue(':bet_amount2', $bet->getBetAmount2(), $this->pdo::PARAM_INT);
    $query->bindValue(':bet_date', $bet->getBetDate(), $this->pdo::PARAM_STR);

    $query->execute();
  }

  // Renvoit un pari si il existe (sinon False) pour un match et un utilisateur donnés
  public function findOneByGameAndUser(int $gameId, int $userId): Bet|bool
  {
    $query = $this->pdo->prepare('SELECT * FROM bets WHERE game_id = :game_id AND user_id = :user_id');
    $query->bindValue(':game_id', $gameId, $this->pdo::PARAM_INT);
    $query->bindValue(':user_id', $userId, $this->pdo::PARAM_INT);
    $query->execute();
    $bet = $query->fetch($this->pdo::FETCH_ASSOC);
    if ($bet) {
      return $bet = Bet::createAndHydrate($bet);
    } else {
      return false;
    }
  }

  public function findAllByUser(int $userId): array|bool
  {
    $query = $this->pdo->prepare('SELECT * FROM bets WHERE user_id = :user_id');
    $query->bindValue(':user_id', $userId, $this->pdo::PARAM_INT);
    $query->execute();
    $bets = $query->fetchAll($this->pdo::FETCH_ASSOC);
    $betsArray = [];
    if ($bets) {
      foreach ($bets as $bet) {
        $betsArray[] = Bet::createAndHydrate($bet);
      }
      return $betsArray;
    } else {
      return False;
    }
  }

  public function findAllBetsWithGameByUser($userId): array|bool
  {
    $sql = "SELECT bets.*, games.*, team1.team_name as team1_name, team2.team_name as team2_name 
        FROM bets 
        INNER JOIN games ON bets.game_id = games.game_id 
        INNER JOIN teams as team1 ON games.team1_id = team1.team_id 
        INNER JOIN teams as team2 ON games.team2_id = team2.team_id 
        WHERE bets.user_id = :userId";

    $query = $this->pdo->prepare($sql);
    $query->bindValue(':userId', $userId, $this->pdo::PARAM_INT);
    $query->execute();
    $betsArray = $query->fetchAll($this->pdo::FETCH_ASSOC);
    if ($betsArray) {
      return $betsArray;
    } else {
      return false;
    }
  }

  public function deleteBetById(int $betId): void
  {
    $query = $this->pdo->prepare('DELETE FROM bets WHERE bet_id = :id');
    $query->bindValue(':id', $betId, $this->pdo::PARAM_INT);
    $query->execute();
  }

  public function findOneById(int $betId): Bet|bool
  {
    $query = $this->pdo->prepare('SELECT * FROM bets WHERE bet_id = :id');
    $query->bindValue(':id', $betId, $this->pdo::PARAM_INT);
    $query->execute();
    $bet = $query->fetch($this->pdo::FETCH_ASSOC);
    if ($bet) {
      return Bet::createAndHydrate($bet);
    } else {
      return false;
    }
  }
}
