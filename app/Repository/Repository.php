<?php

namespace App\Repository;

use App\Db\Mysql;

class Repository
{
  protected \PDO $pdo;

  public function __construct()
  {
    // On récupère l'instance de la connexion à la BDD en utilisant le Singleton Mysql (getInstance)
    // getInstance() est une méthode statique : on l'appelle directement avec la classe Mysql suivie de ::
    $mysql = Mysql::getInstance();
    $this->pdo = $mysql->getPDO();
  }
}
