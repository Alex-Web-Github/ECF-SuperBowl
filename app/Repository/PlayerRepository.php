<?php

namespace App\Repository;

use App\Entity\Player;

class PlayerRepository extends Repository
{

  public function findAll(): array
  {
    $query = $this->pdo->prepare("SELECT * FROM players");
    $query->execute();
    $players = $query->fetchAll($this->pdo::FETCH_ASSOC);
    $playersList = [];
    foreach ($players as $player) {
      $playersList[] = Player::createAndHydrate($player);
    }

    return $playersList;
  }
}
