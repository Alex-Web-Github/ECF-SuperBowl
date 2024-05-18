<?php

namespace App\Controllers;

class Controller
{

  public function render(string $path, array $params = []): void
  {
    $filePath = APP_ROOT . '/views/' . $path . '.php';

    try {
      if (!file_exists($filePath)) {
        throw new \Exception("Fichier non trouvé : " . $filePath);
      } else {
        // Cette fonction crée les variables dont les noms sont les index de ce tableau, et leur affecte la valeur associée
        extract($params);
        require_once $filePath;
      }
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage()
      ]);
    }
  }
}
