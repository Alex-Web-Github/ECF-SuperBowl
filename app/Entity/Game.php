<?php

namespace App\Entity;

use DateInterval;

class Game extends Entity
{
  protected ?int $game_id = null;
  protected ?string $game_date = '';
  protected ?int $team1_id = null;
  protected ?int $team2_id = null;
  protected ?string $game_start = '';
  protected ?string $game_end = '';
  protected ?float $team1_odds = null;
  protected ?float $team2_odds = null;
  protected ?string $team1_name = '';
  protected ?string $team2_name = '';
  protected ?string $game_status = '';
  protected ?string $game_score = '';
  protected ?string $game_weather = '';

  // Validation du formulaire de création de match
  public function validate(): array
  {
    $errors = [];

    if (empty($this->game_date)) {
      $errors['game_date'] = 'La date ne doit pas être vide';
    }

    if (empty($this->team1_id) || (int)$this->team1_id === 0) {
      $errors['team1_id'] = 'L\'équipe 1 ne doit pas être vide';
    }

    if (empty($this->team2_id) || (int)$this->team2_id === 0) {
      $errors['team2_id'] = 'L\'équipe 2 ne doit pas être vide';
    }

    if ($this->team1_id === $this->team2_id) {
      $errors['team2_id'] = 'L\'équipe 2 doit être différente de l\'équipe 1';
    }

    if (empty($this->game_start)) {
      $errors['game_start'] = 'L\'heure de début ne doit pas être vide';
    }

    if (empty($this->game_end)) {
      $errors['game_end'] = 'L\'heure de fin ne doit pas être vide';
    } else if (isset($this->game_end) && isset($this->game_start)) {
      $game_end_copy = new \DateTime($this->game_end);
      $game_start_plus_one_hour = new \DateTime($this->game_start);
      $game_start_plus_one_hour->add(new DateInterval('PT1H'));
      if ($game_end_copy < $game_start_plus_one_hour) {
        $errors['game_end'] = 'L\'heure de fin doit être supérieure à l\'heure de début plus une heure';
      }
    }

    if (empty($this->team1_odds)) {
      $errors['team1_odds'] = 'La cote de l\'équipe 1 ne doit pas être vide';
    } else if ($this->team1_odds < 1) {
      $errors['team1_odds'] = 'La cote de l\'équipe 1 doit être supérieure à 1';
    } else if ($this->team1_odds > 10) {
      $errors['team1_odds'] = 'La cote de l\'équipe 1 doit être inférieure à 10';
    } else if (!is_numeric($this->team1_odds)) {
      $errors['team1_odds'] = 'La cote de l\'équipe 1 doit être un nombre';
    }

    if (empty($this->team2_odds)) {
      $errors['team2_odds'] = 'La cote de l\'équipe 2 ne doit pas être vide';
    } else if ($this->team2_odds < 1) {
      $errors['team2_odds'] = 'La cote de l\'équipe 2 doit être supérieure à 1';
    } else if ($this->team2_odds > 10) {
      $errors['team2_odds'] = 'La cote de l\'équipe 2 doit être inférieure à 10';
    } else if (!is_numeric($this->team2_odds)) {
      $errors['team2_odds'] = 'La cote de l\'équipe 2 doit être un nombre';
    }

    return $errors;
  }

  /**
   * Get the value of game_id
   */
  public function getGameId(): ?int
  {
    return $this->game_id;
  }

  /**
   * Set the value of game_id
   */
  public function setGameId(?int $game_id): self
  {
    $this->game_id = $game_id;

    return $this;
  }

  /**
   * Get the value of game_date
   */
  public function getGameDate(): ?string
  {
    return $this->game_date;
  }

  /**
   * Set the value of game_date
   */
  public function setGameDate(?string $game_date): self
  {
    $this->game_date = $game_date;

    return $this;
  }

  /**
   * Get the value of team1
   */
  public function getTeam1Id(): ?int
  {
    return $this->team1_id;
  }

  /**
   * Set the value of team1
   */
  public function setTeam1Id(?int $team1_id): self
  {
    $this->team1_id = (int)$team1_id;

    return $this;
  }

  /**
   * Get the value of team2
   */
  public function getTeam2Id(): ?int
  {
    return $this->team2_id;
  }

  /**
   * Set the value of team2
   */
  public function setTeam2Id(?int $team2_id): self
  {
    $this->team2_id = (int)$team2_id;

    return $this;
  }

  /**
   * Get the value of game_start
   */
  public function getGameStart(): ?string
  {
    return $this->game_start;
  }

  /**
   * Set the value of game_start
   */
  public function setGameStart(?string $game_start): self
  {
    $this->game_start = $game_start;

    return $this;
  }

  /**
   * Get the value of game_end
   */
  public function getGameEnd(): ?string
  {
    return $this->game_end;
  }

  /**
   * Set the value of game_end
   */
  public function setGameEnd(?string $game_end): self
  {
    $this->game_end = $game_end;

    return $this;
  }

  /**
   * Get the value of team1_odds
   */
  public function getTeam1Odds(): ?float
  {
    return $this->team1_odds;
  }

  /**
   * Set the value of team1_odds
   */
  public function setTeam1Odds(?float $team1_odds): self
  {
    $this->team1_odds = $team1_odds;

    return $this;
  }

  /**
   * Get the value of team2_odds
   */
  public function getTeam2Odds(): ?float
  {
    return $this->team2_odds;
  }

  /**
   * Set the value of team2_odds
   */
  public function setTeam2Odds(?float $team2_odds): self
  {
    $this->team2_odds = $team2_odds;

    return $this;
  }

  /**
   * Get the value of team1_name
   */
  public function getTeam1Name(): ?string
  {
    return $this->team1_name;
  }

  /**
   * Set the value of team1_name
   */
  public function setTeam1Name(?string $team1_name): self
  {
    $this->team1_name = $team1_name;

    return $this;
  }

  /**
   * Get the value of team2_name
   */
  public function getTeam2Name(): ?string
  {
    return $this->team2_name;
  }

  /**
   * Set the value of team2_name
   */
  public function setTeam2Name(?string $team2_name): self
  {
    $this->team2_name = $team2_name;

    return $this;
  }

  /**
   * Get the value of game_status
   */
  public function getGameStatus(): ?string
  {
    return $this->game_status;
  }

  /**
   * Set the value of game_status
   */
  public function setGameStatus(?string $game_status): self
  {
    $this->game_status = $game_status;

    return $this;
  }

  /**
   * Get the value of game_score
   */
  public function getGameScore(): ?string
  {
    return $this->game_score;
  }

  /**
   * Set the value of game_score
   */
  public function setGameScore(?string $game_score): self
  {
    $this->game_score = $game_score;

    return $this;
  }

  /**
   * Get the value of game_weather
   */
  public function getGameWeather(): ?string
  {
    return $this->game_weather;
  }

  /**
   * Set the value of game_weather
   */
  public function setGameWeather(?string $game_weather): self
  {
    $this->game_weather = $game_weather;

    return $this;
  }
}
