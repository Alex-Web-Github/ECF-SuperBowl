<?php

namespace App\Controllers;

use App\Repository\GameRepository;
use App\Entity\Game;

class GameController extends Controller
{
  // public function list(): void
  // {
  //   $gameRepository = new GameRepository();
  //   $games = $gameRepository->findAll();
  //   $this->render('game/list', ['games' => $games]);
  // }

  // public function show(int $id): void
  // {
  //   $gameRepository = new GameRepository();
  //   $game = $gameRepository->findOneById($id);
  //   $this->render('game/show', ['game' => $game]);
  // }

  // public function add(): void
  // {
  //   $this->render('game/add');
  // }

  // public function create(): void
  // {
  //   try {
  //     $errors = [];
  //     $game = new Game();

  //     if (isset($_POST['createGame'])) {
  //       $game->hydrate($_POST);
  //       die();
  //       $gameRepository = new GameRepository();
  //       die(var_dump($game));

  //       $errors = $game->validate();

  //       if (empty($errors)) {
  //         $gameRepository->persist($game);
  //       }
  //       // $this->render('game/add', ['errors' => $errors]);
  //     }
  //   } catch (\Exception $e) {
  //     $this->render('errors/default', [
  //       'error' => $e->getMessage()
  //     ]);
  //   }
  // }

  // public function edit(int $id): void
  // {
  //   $gameRepository = new GameRepository();
  //   $game = $gameRepository->findOneById($id);
  //   $this->render('game/edit', ['game' => $game]);
  // }

  // public function update(int $id): void
  // {
  //   $gameRepository = new GameRepository();
  //   $game = $gameRepository->findOneById($id);
  //   $game->setGameDate($_POST['game_date']);
  //   $game->setTeam1($_POST['team1']);
  //   $game->setTeam2($_POST['team2']);
  //   $game->setGameStartTime($_POST['game_start_time']);
  //   $game->setGameEndTime($_POST['game_end_time']);
  //   $game->setTeam1Odds($_POST['team1_odds']);
  //   $game->setTeam2Odds($_POST['team2_odds']);

  //   $gameRepository->persist($game);

  //   header('Location: /game/list');
  // }

  // public function delete(int $id): void
  // {
  //   $gameRepository = new GameRepository();
  //   $gameRepository->delete($id);

  //   header('Location: /game/list');
  // }
}
