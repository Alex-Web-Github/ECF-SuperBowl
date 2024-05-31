<?php

namespace App\Repository;

use App\Entity\Team;

class TeamRepository extends Repository
{

  public function persist(Team $team)
  {
    if ($team->getTeamId() !== null) {
      $query = $this->pdo->prepare(
        'UPDATE teams SET team_name = :team_name, team_country = :team_country, team_players = :team_players WHERE team_id = :team_id'
      );
      $query->bindValue(':team_id', $team->getTeamId(), $this->pdo::PARAM_INT);
    } else {
      // Si pas d'Id, il s'agit d'une nouvelle équipe
      $query = $this->pdo->prepare(
        'INSERT INTO teams (team_name, team_country, team_players) VALUES (:team_name, :team_country, :team_players)'
      );
    }
    $query->bindValue(':team_name', $team->getTeamName(), $this->pdo::PARAM_STR);
    $query->bindValue(':team_country', $team->getTeamCountry(), $this->pdo::PARAM_STR);
    $query->bindValue(':team_players', $team->getTeamPlayers(), $this->pdo::PARAM_STR);

    return $query->execute();
  }


  public function findAll(): array
  {
    $query = $this->pdo->prepare("SELECT * FROM teams");
    $query->execute();
    $teams = $query->fetchAll($this->pdo::FETCH_ASSOC);
    $teamsList = [];
    // On hydrate les objets Team
    foreach ($teams as $team) {
      // Je stocke chaque objet Team dans un tableau
      // La méthode createAndHydrate est une méthode statique de la classe Team, qui est héritée de la classe Entity
      $teamsList[] = Team::createAndHydrate($team);
    }
    return $teamsList;
  }

  public function findOneById(int $teamId): Team|bool
  {
    $query = $this->pdo->prepare("SELECT * FROM teams WHERE team_id = :team_id");
    $query->bindValue(':team_id', $teamId, $this->pdo::PARAM_INT);
    $query->execute();
    $team = $query->fetch($this->pdo::FETCH_ASSOC);
    if ($team) {
      return Team::createAndHydrate($team);
    } else {
      return false;
    }
  }
}
