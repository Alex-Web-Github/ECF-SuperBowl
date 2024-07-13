<?php

namespace App\Entity;

class Player extends Entity
{
  protected ?int $player_id = null;
  protected ?string $player_firstname = '';
  protected ?string $player_lastname = '';
  protected ?string $player_number = '';


  public function getPlayerId(): ?int
  {
    return $this->player_id;
  }

  public function setPlayerId(?int $player_id): self
  {
    $this->player_id = $player_id;

    return $this;
  }

  public function getPlayerFirstname(): ?string
  {
    return $this->player_firstname;
  }

  public function setPlayerFirstname(?string $player_firstname): self
  {
    $this->player_firstname = $player_firstname;

    return $this;
  }

  public function getPlayerLastname(): ?string
  {
    return $this->player_lastname;
  }

  public function setPlayerLastname(?string $player_lastname): self
  {
    $this->player_lastname = $player_lastname;

    return $this;
  }

  public function getPlayerNumber(): ?string
  {
    return $this->player_number;
  }

  public function setPlayerNumber(?string $player_number): self
  {
    $this->player_number = $player_number;

    return $this;
  }
}
