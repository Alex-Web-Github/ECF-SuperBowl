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
        header('Location: ' . $routes->get('homepage')->getPath());
      }

      $errors = [];
      $team = new Team();
      $game = new Game();

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

        // TODO à corriger
        $errors = $team->validate();

        if (empty($errors)) {
          $teamRepository->persist($team);
          header('Location: ' . $routes->get('adminDashboard')->getPath());
        }
      }
      // Si le formulaire de création de match est soumis
      if (isset($_POST['createGame'])) {

        $game->hydrate($_POST);

        $gameRepository = new GameRepository();

        $errors = $game->validate();

        if (empty($errors)) {
          $gameRepository->persist($game);
          header('Location: ' . $routes->get('adminDashboard')->getPath());
        }
      }

      $teamRepository = new TeamRepository();
      $teams = $teamRepository->findAll();
      $playerRepository = new PlayerRepository();
      $playersList = $playerRepository->findAll();

      $this->render('admin/dashboard', [
        'players' => $playersList,
        'teams' => $teams,
        'errors' => $errors
      ]);
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage()
      ]);
    }
  }

  // public function addGameAction(RouteCollection $routes)
  // {
  //   try {
  //     $errors = [];
  //     $game = new Game();

  //     if (isset($_POST['createGame'])) {

  //       $game->hydrate($_POST);

  //       $gameRepository = new GameRepository();

  //       $errors = $game->validate();

  //       if (empty($errors)) {
  //         $gameRepository->persist($game);
  //         header('Location: ' . $routes->get('adminDashboard')->getPath());
  //       }
  //     }

  //     $teamRepository = new TeamRepository();
  //     $teams = $teamRepository->findAll();

  //     $this->render('admin/add-game', [
  //       'errors' => $errors,
  //       'teams' => $teams
  //     ]);
  //   } catch (\Exception $e) {
  //     $this->render('errors/default', [
  //       'error' => $e->getMessage()
  //     ]);
  //   }
  // }

  // public function addTeamAction(RouteCollection $routes)
  // {
  //   try {
  //     $errors = [];
  //     $team = new Team();

  //     if (isset($_POST['createTeam'])) {

  //       // On hydrate l'objet Team avec les données du formulaire
  //       $team->setTeamName($_POST['teamName']);
  //       $team->setTeamCountry($_POST['teamCountry']);
  //       // On récupère le tableau des joueurs sélectionnés depuis le formulaire grâce aux champs Input de type "hidden" contenant les Id des joueurs. Puis on le transforme en String pour le stocker dans la BDD (car MySql ne gère pas les tableaux).
  //       if (isset($_POST['selectedPlayers'])) {
  //         $selectedPlayers = $_POST['selectedPlayers'];
  //         $selectedPlayersString = implode(",", $selectedPlayers);
  //       } else {
  //         $selectedPlayersString = '';
  //       }

  //       $team->setTeamPlayers($selectedPlayersString);

  //       $teamRepository = new TeamRepository();

  //       // TODO à corriger
  //       $errors = $team->validate();

  //       if (empty($errors)) {
  //         $teamRepository->persist($team);
  //         header('Location: ' . $routes->get('adminDashboard')->getPath());
  //       }
  //     }

  //     $playerRepository = new PlayerRepository();
  //     $players = $playerRepository->findAll();

  //     $this->render('admin/dashboard', [
  //       'errors' => $errors,
  //       'players' => $players
  //     ]);
  //   } catch (\Exception $e) {
  //     $this->render('errors/default', [
  //       'error' => $e->getMessage()
  //     ]);
  //   }
  // }
}
