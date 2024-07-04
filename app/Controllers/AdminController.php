<?php

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;
use App\Tools\SecurityTools;
use App\Entity\Game;
use App\Repository\GameRepository;
use App\Entity\Team;
use App\Repository\TeamRepository;
use App\Repository\PlayerRepository;


class AdminController extends Controller
{

  public function dashboardAction(RouteCollection $routes)
  {
    try {

      // Si l'utilisateur n'est pas un Admin, on le redirige vers la page d'accueil
      if (SecurityTools::isAdmin() === false) {
        header('Location: ' . $routes->get('all-games')->getPath());
        exit();
      }

      $errors = [];
      $team = new Team();
      $game = new Game();
      // Par défaut, c'est l'onglet "Les matches" qui est actif
      $activeTab = '';

      // Si le formulaire de création d'équipe est soumis
      if (isset($_POST['createTeam'])) {
        // On hydrate l'objet Team avec les données du formulaire
        $team->setTeamName($_POST['teamName']);
        $team->setTeamCountry($_POST['teamCountry']);
        // On récupère le tableau des joueurs sélectionnés depuis le formulaire grâce aux champs Input de type "hidden" contenant les Id des joueurs. Puis on le transforme en String pour le stocker dans la BDD (car MySql ne gère pas les tableaux).
        if (isset($_POST['selectedPlayers'])) {
          $selectedPlayers = $_POST['selectedPlayers'];
          $selectedPlayersString = implode(",", $selectedPlayers);
        } else {
          $selectedPlayersString = '';
        }

        $team->setTeamPlayers($selectedPlayersString);

        $teamRepository = new TeamRepository();

        $errors = $team->validate();

        if (empty($errors)) {
          $teamRepository->persist($team);
          // Pour afficher un message de succès, on ajoute un message dans le tableau $errors
          $errors['teamCreate'] = [
            'message' => 'Votre équipe a été créée avec succès.',
          ];
          // J'initialise le tableau $_POST pour éviter de réafficher les données du formulaire
          $_POST = [];
        } else {
          // Je rends 'active' l'onglet "Les équipes & joueurs" pour afficher les erreurs s'il y en a
          $activeTab = 'team';
        }
      }

      // Si le formulaire de création de match est soumis
      if (isset($_POST['createGame'])) {

        $_POST['team1_id'] = (int) $_POST['team1_id'];
        $_POST['team2_id'] = (int) $_POST['team2_id'];
        // die(var_dump($_POST));

        $game->hydrate($_POST);
        // die(var_dump($game));

        $errors = $game->validate();

        if (empty($errors)) {
          $gameRepository = new GameRepository();
          $gameRepository->persist($game);
          // Pour afficher un message de succès, on ajoute un message dans le tableau $errors
          $errors['gameCreate'] = [
            'message' => 'Votre match a été créé avec succès.',
          ];
          // J'initialise le tableau $_POST pour éviter de réafficher les données du formulaire
          $_POST = [];
        }
      }

      // Je récupère la liste des équipes et des joueurs pour les afficher dans le formulaire en vue de la création d'un Game
      $teamRepository = new TeamRepository();
      $teams = $teamRepository->findAll();
      $playerRepository = new PlayerRepository();
      $playersList = $playerRepository->findAll();

      // Je rends la vue avec les données nécessaires
      $this->render('admin/dashboard', [
        'players' => $playersList,
        'teams' => $teams,
        'error' => $errors,
        'activeTab' => $activeTab
      ]);
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage()
      ]);
    }
  }
}
