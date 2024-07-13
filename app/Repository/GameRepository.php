<?php

namespace App\Repository;

use App\Entity\Game;

class GameRepository extends Repository
{

  public function persist(Game $game): bool
  {

    if ($game->getGameId() !== null) {
      $query = $this->pdo->prepare(
        'UPDATE games SET game_date = :date, team1_id = :team1_id, team2_id = :team2_id, game_start = :start_time, game_end = :end_time, team1_odds = :team1_odds, team2_odds = :team2_odds, game_status = :game_status, game_score = :game_score, game_weather = :game_weather, game_winner = :game_winner WHERE game_id = :id'
      );

      $query->bindValue(':id', $game->getGameId(), $this->pdo::PARAM_INT);
    } else {
      // Si pas d'Id, il s'agit d'un nouveau game (& status = upcoming par défaut)
      $query = $this->pdo->prepare(
        'INSERT INTO games (game_date, team1_id, team2_id, game_start, game_end, team1_odds, team2_odds, game_status, game_score, game_weather) VALUES (:date, :team1_id, :team2_id, :start_time, :end_time, :team1_odds, :team2_odds, :game_status, :game_score, :game_weather, :game_winner)'
      );
      // Je définis ces 3 propriétés à la création d'un nouveau Game
      $game->setGameStatus('A venir');
      $game->setGameScore('0-0');
      $game->setGameWeather('-');
      $game->setGameWinner(0);
    }
    // nb: \PDO ne peut pas gérer les objets DateTime, je laisse mes propriétés date et heure en String
    $query->bindValue(':date', $game->getGameDate(), $this->pdo::PARAM_STR);
    $query->bindValue(':team1_id', $game->getTeam1Id(), $this->pdo::PARAM_INT);
    $query->bindValue(':team2_id', $game->getTeam2Id(), $this->pdo::PARAM_INT);
    $query->bindValue(':start_time', $game->getGameStart(), $this->pdo::PARAM_STR);
    $query->bindValue(':end_time', $game->getGameEnd(), $this->pdo::PARAM_STR);
    $query->bindValue(':team1_odds', $game->getTeam1Odds(), $this->pdo::PARAM_STR);
    $query->bindValue(':team2_odds', $game->getTeam2Odds(), $this->pdo::PARAM_STR);
    $query->bindValue(':game_status', $game->getGameStatus(), $this->pdo::PARAM_STR);
    $query->bindValue(':game_score', $game->getGameScore(), $this->pdo::PARAM_STR);
    $query->bindValue(':game_weather', $game->getGameWeather(), $this->pdo::PARAM_STR);
    $query->bindValue(':game_winner', $game->getGameWinner(), $this->pdo::PARAM_INT);

    return $query->execute();
  }

  public function updateStatus(string $nowTime, string $nowDate): bool
  {
    $query = $this->pdo->prepare("UPDATE games SET game_status = 'En cours' WHERE game_date = :date AND game_start <= :time AND game_end >= :time");
    $query->bindValue(':date', $nowDate, $this->pdo::PARAM_STR);
    $query->bindValue(':time', $nowTime, $this->pdo::PARAM_STR);
    $result1 = $query->execute();

    $query = $this->pdo->prepare("UPDATE games SET game_status = 'Terminé' WHERE game_date <= :date AND game_end < :time");
    $query->bindValue(':date', $nowDate, $this->pdo::PARAM_STR);
    $query->bindValue(':time', $nowTime, $this->pdo::PARAM_STR);
    $result2 = $query->execute();

    $query = $this->pdo->prepare("UPDATE games SET game_status = 'A venir' WHERE game_date >= :date AND game_start > :time");
    $query->bindValue(':date', $nowDate, $this->pdo::PARAM_STR);
    $query->bindValue(':time', $nowTime, $this->pdo::PARAM_STR);
    $result3 = $query->execute();

    return $result1 && $result2 && $result3;
  }

  public function findAll(): array
  {
    $query = $this->pdo->prepare("SELECT games.*, teams.team_name AS team1_name, teams2.team_name AS team2_name FROM games JOIN teams ON games.team1_id = teams.team_id JOIN teams AS teams2 ON games.team2_id = teams2.team_id ORDER BY game_date DESC, game_start DESC");
    $query->execute();
    $allGames = $query->fetchAll($this->pdo::FETCH_ASSOC);
    $gamesList = [];

    foreach ($allGames as $allGame) {
      // Je crée et j'hydrate un nouvel Objet Game avec les données de la BDD
      // puis le stocke dans un tableau
      $gamesList[] = Game::createAndHydrate($allGame);
    }
    return $gamesList;
  }

  public function findOneById(int $id): Game|bool
  {
    $query = $this->pdo->prepare("SELECT games.*, teams.team_name AS team1_name, teams2.team_name AS team2_name FROM games JOIN teams ON games.team1_id = teams.team_id JOIN teams AS teams2 ON games.team2_id = teams2.team_id WHERE game_id = :id");
    $query->bindValue(':id', $id, $this->pdo::PARAM_INT);
    $query->execute();
    $game = $query->fetch($this->pdo::FETCH_ASSOC);

    if ($game) {
      return Game::createAndHydrate($game);
    }
    return false;
  }

  public function findUpComingGames(): array|bool
  {
    $query = $this->pdo->prepare("SELECT games.*, teams.team_name AS team1_name, teams2.team_name AS team2_name FROM games JOIN teams ON games.team1_id = teams.team_id JOIN teams AS teams2 ON games.team2_id = teams2.team_id WHERE game_status = 'A venir' ORDER BY game_date DESC, game_start DESC");
    $query->execute();
    $upcomingGames = $query->fetchAll($this->pdo::FETCH_ASSOC);
    $gamesList = [];

    if ($upcomingGames) {
      foreach ($upcomingGames as $upcomingGame) {
        $gamesList[] = Game::createAndHydrate($upcomingGame);
      }
      return $gamesList;
    } else {
      return false;
    }
  }

  public function findDailyGames(): array|bool
  {
    $query = $this->pdo->prepare("SELECT games.*, teams.team_name AS team1_name, teams2.team_name AS team2_name FROM games JOIN teams ON games.team1_id = teams.team_id JOIN teams AS teams2 ON games.team2_id = teams2.team_id WHERE game_date = CURDATE() ORDER BY game_start ASC");
    $query->execute();
    $dailyGames = $query->fetchAll($this->pdo::FETCH_ASSOC);
    $gamesList = [];

    if ($dailyGames) {
      foreach ($dailyGames as $dailyGame) {
        $gamesList[] = Game::createAndHydrate($dailyGame);
      }
      return $gamesList;
    } else {
      return false;
    }
  }

  public function findOneByBetId(int $betId): Game|bool
  {
    $query = $this->pdo->prepare("SELECT games.*, teams.team_name AS team1_name, teams2.team_name AS team2_name FROM games JOIN teams ON games.team1_id = teams.team_id JOIN teams AS teams2 ON games.team2_id = teams2.team_id JOIN bets ON games.game_id = bets.game_id WHERE bets.bet_id = :bet_id");
    $query->bindValue(':bet_id', $betId, $this->pdo::PARAM_INT);
    $query->execute();
    $game = $query->fetch($this->pdo::FETCH_ASSOC);

    if ($game) {
      return Game::createAndHydrate($game);
    }
    return false;
  }
}
