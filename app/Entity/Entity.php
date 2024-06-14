<?php

namespace App\Entity;

use App\Tools\StringTools;

class Entity
{

  public static function createAndHydrate(array $data): static
  {
    // Ici 'static' fait référence à la classe de l'enfant, alors que 'self' fait référence à la classe courante
    $entity = new static();
    $entity->hydrate($data);
    return $entity;
  }

  public function hydrate(array $data)
  {
    if (count($data) > 0) {
      // On parcourt le tableau de données $data
      foreach ($data as $key => $value) {
        // Pour chaque donnée, on appelle le "Setter"
        $methodName = 'set' . StringTools::toPascalCase($key);
        // exe: setUserFirstName pour la clé 'user_first_name'

        if (method_exists($this, $methodName)) {
          // TODO : ajouter ici un filtrage des données pour éviter les injections SQL ??
          // {$methodName}($value) est un appel dynamique de méthode, équivalent de $this->setFirstName($value);
          $this->{$methodName}($value);
        }
      }
    }
  }
}
