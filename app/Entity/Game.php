<?php

namespace App\Entity;

use DateInterval;

class Game extends Entity
{
  protected ?int $game_id = null;
  protected ?string $game_date = '';
  protected ?int $team1 = null;
  protected ?int $team2 = null;
  protected ?string $game_start = '';
  protected ?string $game_end = '';
  protected ?float $team1_odds = null;
  protected ?float $team2_odds = null;


  public function validate(): array
  {
    $errors = [];

    if (empty($this->game_date)) {
      $errors['game_date'] = 'La date ne doit pas être vide';
    }

    if (empty($this->team1)) {
      $errors['team1'] = 'L\'équipe 1 ne doit pas être vide';
    }

    if (empty($this->team2) || $this->team1 === $this->team2) {
      $errors['team2'] = 'L\'équipe 2 ne doit pas être vide et différente de l\'équipe 1';
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
  public function getTeam1(): ?string
  {
    return $this->team1;
  }

  /**
   * Set the value of team1
   */
  public function setTeam1(?string $team1): self
  {
    $this->team1 = intval($team1);

    return $this;
  }

  /**
   * Get the value of team2
   */
  public function getTeam2(): ?string
  {
    return $this->team2;
  }

  /**
   * Set the value of team2
   */
  public function setTeam2(?string $team2): self
  {
    $this->team2 = intval($team2);

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
    $this->team1_odds = floatval($team1_odds);

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
    $this->team2_odds = floatval($team2_odds);

    return $this;
  }
}
