<?php

namespace App\Entity;

use DateInterval;

class Bet extends Entity
{
  protected ?int $bet_id = null;
  protected ?int $game_id = null;
  protected ?int $user_id = null;
  protected ?int $bet_amount1 = null;
  protected ?int $bet_amount2 = null;
  protected ?string $bet_date = '';
  protected ?float $bet_result = null;

  // Dans ma BDD, je stocke les mises dans des colonnes de type SMALLINT UNSIGNED : plage de valeurs entre 0 et 65535 (pour un INPUT max à 1000 euros, c'est suffisant).

  // Validation du formulaire de création de pari
  public function validate(bool $nullBetsNotAllowed = true): array
  {
    $errors = [];
    // Condition si $this->bet_amount1 n'est pas un entier compris entre 0 et 1000
    if (!is_numeric($this->bet_amount1) || $this->bet_amount1 < 0 || $this->bet_amount1 > 1000) {
      $errors['bet_amount1'] = 'La mise doit être un nombre entier compris entre 0 et 1000';
    }
    // Condition si $this->bet_amount2 n'est pas un entier compris entre 0 et 1000
    if (!is_numeric($this->bet_amount2) || $this->bet_amount2 < 0 || $this->bet_amount2 > 1000) {
      $errors['bet_amount2'] = 'La mise doit être un nombre entier compris entre 0 et 1000';
    }
    // Condition si les 2 mises sont strictement supérieures à 0
    if ($this->bet_amount1 > 0 && $this->bet_amount2 > 0) {
      $errors['bet_amount2'] = $errors['bet_amount1'] = 'Vous devez mettre une mise à zéro pour une des deux équipes';
    }

    if ($nullBetsNotAllowed) {
      // J'ajoute la condition de validation : si $this->bet_amount1 et $this->bet_amount2 sont nulles
      if ($this->bet_amount1 === 0 && $this->bet_amount2 === 0) {
        $errors['bet_amount2'] = $errors['bet_amount1'] = 'Vous devez miser sur au moins une équipe';
      }
      return $errors;
    } else {
      return $errors;
    }
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
  public function getBetAmount1(): ?int
  {
    return $this->bet_amount1;
  }

  /**
   * Set the value of bet_amount1
   */
  public function setBetAmount1(?int $bet_amount1): self
  {
    $this->bet_amount1 = $bet_amount1;

    return $this;
  }

  /**
   * Get the value of bet_amount2
   */
  public function getBetAmount2(): ?int
  {
    return $this->bet_amount2;
  }

  /**
   * Set the value of bet_amount2
   */
  public function setBetAmount2(?int $bet_amount2): self
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

  /**
   * Get the value of bet_result
   */
  public function getBetResult(): ?float
  {
    return $this->bet_result;
  }

  /**
   * Set the value of bet_result
   */
  public function setBetResult(?float $bet_result): self
  {
    $this->bet_result = $bet_result;

    return $this;
  }
}
