<?php

namespace App\Entity;

class User extends Entity
{

  protected ?int $id = null;
  protected ?string $first_name = '';
  protected ?string $last_name = '';
  protected ?string $email = '';
  protected ?string $password = '';
  protected ?string $role = '';

  // Remarque : "?int" signifie que le type retourné est de type int ou null
  public function getId(): ?int
  {
    return $this->id;
  }
  public function setId(?int $id): self
  {
    $this->id = $id;
    return $this;
  }

  public function getEmail(): ?string
  {
    return $this->email;
  }
  public function setEmail(?string $email): self
  {
    $this->email = $email;
    return $this;
  }

  public function getPassword(): ?string
  {
    return $this->password;
  }

  public function setPassword(?string $password): self
  {
    $this->password = $password;

    return $this;
  }

  public function getFirstName(): ?string
  {
    return $this->first_name;
  }
  public function setFirstName(?string $first_name): self
  {
    $this->first_name = $first_name;
    return $this;
  }

  public function getLastName(): ?string
  {
    return $this->last_name;
  }
  public function setLastName(?string $last_name): self
  {
    $this->last_name = $last_name;
    return $this;
  }

  public function getRole(): ?string
  {
    return $this->role;
  }
  public function setRole(?string $role): self
  {
    $this->role = $role;

    return $this;
  }


  /*
        Pourrait être déplacé dans une classe UserValidator
        c'est juste pour vérifier si les champs sont bien remplis et l'email de type "email"
    */
  public function validate(): array
  {
    $errors = [];
    if (empty($this->getFirstName())) {
      $errors['first_name'] = 'Le champ prénom ne doit pas être vide';
    }
    if (empty($this->getLastName())) {
      $errors['last_name'] = 'Le champ nom ne doit pas être vide';
    }
    if (empty($this->getEmail())) {
      $errors['email'] = 'Le champ email ne doit pas être vide';
    } else if (!filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'L\'email n\'est pas valide';
    }
    return $errors;
  }

  /*
        Pourrait être déplacé dans une classe Security
    */
  public function verifyPassword(string $password): bool
  {
    if (password_verify($password, $this->password)) {
      return true;
    } else {
      return false;
    }
  }
}
