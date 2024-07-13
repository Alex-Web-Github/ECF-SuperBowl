<?php

namespace App\Entity;

class Team extends Entity
{
  protected ?int $team_id = null;
  protected ?string $team_name = '';
  protected ?string $team_country = '';
  protected ?string $team_players = '';


  public function validate(): array
  {
    $errors = [];
    if (empty($this->team_name)) {
      $errors['team_name'] = 'Le champs Nom ne peut pas être vide';
    }
    if (empty($this->team_country)) {
      $errors['team_country'] = 'Le champs Pays ne peut pas être vide';
    }
    if (empty($this->team_players) || count(explode(",", $this->team_players)) !== 11) {
      $errors['team_players'] = 'L\'équipe doit être composée de 11 joueurs';
    }
    return $errors;
  }


  public function getTeamId(): ?int
  {
    return $this->team_id;
  }

  public function setTeamId(?int $team_id): self
  {
    $this->team_id = $team_id;

    return $this;
  }

  public function getTeamName(): ?string
  {
    return $this->team_name;
  }

  public function setTeamName(?string $team_name): self
  {
    $this->team_name = $team_name;

    return $this;
  }

  public function getTeamCountry(): ?string
  {
    return $this->team_country;
  }

  public function setTeamCountry(?string $team_country): self
  {
    $this->team_country = $team_country;

    return $this;
  }

  public function getTeamPlayers(): ?string
  {
    return $this->team_players;
  }

  public function setTeamPlayers(?string $team_players): self
  {
    $this->team_players = $team_players;

    return $this;
  }
}
