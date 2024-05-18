<?php

namespace App\Db;

class Mysql
{
  private $db_name;
  private $db_user;
  private $db_password;
  private $db_port;
  private $db_host;
  private $pdo = null;

  // cette propriété est statique pour pouvoir être partagée entre les différentes instances de la classe Mysql (voir getInstance())
  private static $_instance = null;

  private function __construct()
  {
    require_once APP_ROOT . '/config/config.php';

    $this->db_name = DB_NAME;

    $this->db_user = DB_USER;

    $this->db_password = DB_PASS;

    $this->db_port = DB_PORT;

    $this->db_host = DB_HOST;
  }

  public static function getInstance(): self
  //// Design Pattern Singleton //////////////

  // Permet de n'avoir qu'une seule instance de la classe Mysql dans la mémoire de PHP et de la réutiliser à chaque fois que l'on en a besoin
  {
    if (is_null(self::$_instance)) {
      self::$_instance = new Mysql();
    }
    return self::$_instance;
  }

  public function getPDO(): \PDO
  {
    if (is_null($this->pdo)) {
      $this->pdo = new \PDO('mysql:dbname=' . $this->db_name . ';charset=utf8;host=' . $this->db_host . ':' . $this->db_port, $this->db_user, $this->db_password);
    }
    return $this->pdo;
  }
}
