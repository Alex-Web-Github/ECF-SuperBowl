<?php

namespace App\Repository;

use App\Db\Mysql;

class Repository
{
  protected \PDO $pdo;

  public function __construct()
  {
    try {
      // On récupère l'instance de la connexion à la BDD en utilisant le Singleton Mysql (getInstance)
      // getInstance() est une méthode statique : on l'appelle directement avec la classe Mysql suivie de ::
      $mysql = Mysql::getInstance();
      $this->pdo = $mysql->getPDO();
      // Pour renvoyer les erreurs SQL directement dans le navigateur (à commenter en production)
      $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

      // Pour récupérer les résultats des requêtes SELECT sous forme d'objets (à commenter si on préfère les tableaux associatifs)
      // $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
    } catch (\Exception $e) {
      die($e->getMessage());
    }
  }
}
