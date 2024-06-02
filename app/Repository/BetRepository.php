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
    $query->bindValue(':bet_amount1', $bet->getBetAmount1(), $this->pdo::PARAM_STR);
    $query->bindValue(':bet_amount2', $bet->getBetAmount2(), $this->pdo::PARAM_STR);
    $query->bindValue(':bet_date', $bet->getBetDate(), $this->pdo::PARAM_STR);

    $query->execute();
  }

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

  public function delete(int $betId): void
  {
    $query = $this->pdo->prepare('DELETE FROM bets WHERE bet_id = :id');
    $query->bindValue(':id', $betId, $this->pdo::PARAM_INT);
    $query->execute();
  }
}
