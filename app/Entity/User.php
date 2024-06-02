<?php

namespace App\Entity;

class User extends Entity
{

  protected ?int $user_id = null;
  protected ?string $user_first_name = '';
  protected ?string $user_last_name = '';
  protected ?string $user_email = '';
  protected ?string $user_password = '';
  protected ?string $user_role = '';

  public function validate(): array
  {
    $errors = [];
    if (isset($_POST['saveUser']) && empty($this->getUserFirstName())) {
      $errors['first_name'] = 'Le champ prénom ne doit pas être vide';
    }
    if (isset($_POST['saveUser']) && empty($this->getUserLastName())) {
      $errors['last_name'] = 'Le champ nom ne doit pas être vide';
    }
    if (empty($this->getUserEmail())) {
      $errors['email'] = 'Le champ email ne doit pas être vide';
    } else if (!filter_var($this->getUserEmail(), FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'L\'email n\'est pas valide';
    }
    if (empty($this->getUserPassword())) {
      $errors['password'] = 'Le champ mot de passe ne doit pas être vide';
    }
    return $errors;
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
   * Get the value of user_first_name
   */
  public function getUserFirstName(): ?string
  {
    return $this->user_first_name;
  }

  /**
   * Set the value of user_first_name
   */
  public function setUserFirstName(?string $user_first_name): self
  {
    $this->user_first_name = $user_first_name;

    return $this;
  }

  /**
   * Get the value of user_last_name
   */
  public function getUserLastName(): ?string
  {
    return $this->user_last_name;
  }

  /**
   * Set the value of user_last_name
   */
  public function setUserLastName(?string $user_last_name): self
  {
    $this->user_last_name = $user_last_name;

    return $this;
  }

  /**
   * Get the value of user_email
   */
  public function getUserEmail(): ?string
  {
    return $this->user_email;
  }

  /**
   * Set the value of user_email
   */
  public function setUserEmail(?string $user_email): self
  {
    $this->user_email = $user_email;

    return $this;
  }

  /**
   * Get the value of user_password
   */
  public function getUserPassword(): ?string
  {
    return $this->user_password;
  }

  /**
   * Set the value of user_password
   */
  public function setUserPassword(?string $user_password): self
  {
    $this->user_password = $user_password;

    return $this;
  }

  /**
   * Get the value of user_role
   */
  public function getUserRole(): ?string
  {
    return $this->user_role;
  }

  /**
   * Set the value of user_role
   */
  public function setUserRole(?string $user_role): self
  {
    $this->user_role = $user_role;

    return $this;
  }
}
