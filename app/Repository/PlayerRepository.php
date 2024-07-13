<?php

namespace App\Repository;

use App\Entity\Player;

class PlayerRepository extends Repository
{

  // Renvoie la liste de tous les joueurs de la table players sous forme de tableau d'objets Player
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

  // Renvoie un objet Player contenant les données d'un joueur selon son Id
  public function findOneById(int $id): Player|bool
  {
    $query = $this->pdo->prepare("SELECT * FROM players WHERE player_id = :id");
    $query->bindValue(':id', $id, $this->pdo::PARAM_INT);
    $query->execute();
    $player = $query->fetch($this->pdo::FETCH_ASSOC);

    if ($player) {
      return Player::createAndHydrate($player);
    }
    return false;
  }
}
