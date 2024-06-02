<?php

namespace App\Entity;

use DateInterval;

class Bet extends Entity
{
  protected ?int $bet_id = null;
  protected ?int $game_id = null;
  protected ?int $user_id = null;
  protected ?float $bet_amount1 = null;
  protected ?float $bet_amount2 = null;
  protected ?string $bet_date = '';

  // Pour plus de précisions, les montants des mises seront stockés dans la BDD sous forme DECIMAL(10,2) pour conserver 2 chiffres après la virgule et une taille maximale de 10 chiffres. Mais en PHP, on les stockera sous forme de float car le type DECIMAL n'existe pas.

  // Validation du formulaire de création de pari
  public function validate(): array
  {
    $errors = [];

    if ($this->bet_amount1 === null || $this->bet_amount1 === '') {
      $errors['bet_amount1'] = 'La mise pour l\'équipe 1 ne doit pas être vide';
    } else if ($this->bet_amount1 < 0 || $this->bet_amount1 > 1000) {
      $errors['bet_amount1'] = 'La mise pour l\'équipe 1 doit être comprise entre 0 et 1000';
    }

    if ($this->bet_amount2 === null || $this->bet_amount2 === '') {
      $errors['bet_amount2'] = 'La mise pour l\'équipe 2 ne doit pas être vide';
    } else if ($this->bet_amount2 < 0 || $this->bet_amount2 > 1000) {
      $errors['bet_amount2'] = 'La mise pour l\'équipe 2 doit être comprise entre 0 et 1000';
    }

    if ($this->bet_amount1 === 0.0 && $this->bet_amount2 === 0.0) {
      $errors['bet_amount1'] = 'Vous ne pouvez pas miser 0 pour les 2 équipes';
      $errors['bet_amount2'] = 'Vous ne pouvez pas miser 0 pour les 2 équipes';
    }
    return $errors;
  }


  /**
   * Get the value of bet_id
   */
  public function getBetId(): ?int
  {
    return $this->bet_id;
  }

  /**
   * Set the value of bet_id
   */
  public function setBetId(?int $bet_id): self
  {
    $this->bet_id = $bet_id;

    return $this;
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
   * Get the value of user_id
   */
  public function getUserId(): ?int
  {
    return $this->user_id;
  }

  /**
   * Set the value of user_id
   */
  public function setUserId(?int $user_id): self
  {
    $this->user_id = $user_id;

    return $this;
  }

  /**
   * Get the value of bet_amount1
   */
  public function getBetAmount1(): ?float
  {
    return $this->bet_amount1;
  }

  /**
   * Set the value of bet_amount1
   */
  public function setBetAmount1(?float $bet_amount1): self
  {
    $this->bet_amount1 = $bet_amount1;

    return $this;
  }

  /**
   * Get the value of bet_amount2
   */
  public function getBetAmount2(): ?float
  {
    return $this->bet_amount2;
  }

  /**
   * Set the value of bet_amount2
   */
  public function setBetAmount2(?float $bet_amount2): self
  {
    $this->bet_amount2 = $bet_amount2;

    return $this;
  }

  /**
   * Get the value of bet_date
   */
  public function getBetDate(): ?string
  {
    return $this->bet_date;
  }

  /**
   * Set the value of bet_date
   */
  public function setBetDate(?string $bet_date): self
  {
    $this->bet_date = $bet_date;

    return $this;
  }
}
