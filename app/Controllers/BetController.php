<?php

namespace App\Controllers;

use App\Entity\Bet;
use App\Entity\Game;
use App\Repository\GameRepository;
use App\Repository\BetRepository;
use App\Tools\SecurityTools;


class BetController extends Controller
{

  public function betAction($id): void
  {
    try {
      $errors = [];
      $bet = new Bet();

      // On vérifie que l'utilisateur est connecté, même si le bouton "miser" est caché pour les utilisateurs non connectés
      if (!SecurityTools::isLogged()) {
        header('Location: ' . constant('URL_SUBFOLDER') . '/login');
        exit();
      }

      // On récupère les infos du Game sur lequel l'utilisateur veut miser
      $game = new Game();
      $gameRepository = new GameRepository();
      $game = $gameRepository->findOneById($id);

      // Redirection si le match n'existe pas ou est terminé ou en cours
      if (!$game || $game->getGameStatus() === 'Terminé' || $game->getGameStatus() === 'En cours') {
        header('Location: ' . constant('URL_SUBFOLDER') . '/');
        exit();
      }

      // On récupère l'Id de l'utilisateur connecté
      $userId = SecurityTools::getCurrentUserId();

      // On vérifie que l'utilisateur n'a pas déjà misé sur ce match
      $betRepository = new BetRepository();
      $existingBet = $betRepository->findOneByGameAndUser($id, $userId);

      if ($existingBet) {
        // On récupère les Data de la mise déjà existante pour les afficher dans les champs Input du formulaire
        $existingBet->setBetAmount1(floatval($existingBet->getBetAmount1()));
        $existingBet->setBetAmount2(floatval($existingBet->getBetAmount2()));
        // On crée un message d'avertissement pour informer l'utilisateur qu'il a déjà misé sur ce match et j'injecte les données de ce pari dans la vue avec modificatiuon du texte du boutonj de validation.
        $errors['bet'] = [
          'message' => 'Vous avez déjà misé sur ce match. Vous pouvez modifier votre mise ci-dessous (Attention, si vous mettez 0 pour les 2 mises, votre mise sera supprimée)',
          'betAmount1Old' => $existingBet->getBetAmount1(),
          'betAmount2Old' => $existingBet->getBetAmount2(),
          'textButton' => 'Actualiser ma mise',
        ];
      }

      // On vérifie que le formulaire a été soumis
      if (isset($_POST['submitBet'])) {

        // Important : si l'utilisateur a déjà misé, on récupère l'Id de la mise pour la modifier
        if ($existingBet) {
          $bet->setBetId($existingBet->getBetId());
        }

        // Les données du formulaire concernant les mises sont renvoyées sous la forme de String. Il faut donc les convertir en Float par la fonction PHP floatval().
        $bet->setBetAmount1(floatval($_POST['bet_amount1']));
        $bet->setBetAmount2(floatval($_POST['bet_amount2']));

        // On attribue l'Id du match et l'Id de l'utilisateur à la mise
        $bet->setGameId($id);
        $bet->setUserId($userId);
        $bet->setBetDate((new \DateTime('now', new \DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s'));

        // Si les 2 mises sont nulles (comme ils sont de type Float, il faut écrire 0.0 et simplement 0 !), et qu'il s'agit d'une actualisation de mise, alors on supprime la mise
        if (null !== $bet->getBetId() && $bet->getBetAmount1() === 0.0 && $bet->getBetAmount2() === 0.0) {
          $betRepository->delete($bet->getBetId());
          // On crée un message de confirmation pour informer l'utilisateur que sa mise a été supprimée
          $errors['bet'] = [
            'message' => 'Votre mise a été supprimée.'
          ];
        }

        // On valide les données
        $errors = $bet->validate();

        // S'il n'y a pas d'erreurs
        if (empty($errors)) {
          // On enregistre la mise en base de données
          $betRepository = new BetRepository();
          $betRepository->persist($bet);

          // On redirige l'utilisateur vers son dashboard
          header('Location: ' . constant('URL_SUBFOLDER') . '/dashboard');
          exit();
        }
      }

      // On affiche la vue
      $this->render('bet/betForm', [
        'game' => $game,
        'error' => $errors,
      ]);
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage()
      ]);
    }
  }

  public function betMultipleAction(): void
  {
    try {
      $errors = [];
      $errors['betSelection'] = '';

      // On récupère les matchs sur lesquels l'utilisateur peut miser (ie: avec un status 'A venir')
      $gameRepository = new GameRepository();
      $gamesList = $gameRepository->findUpcomingGames();

      // Si aucun match n'est disponible, on redirige l'utilisateur vers la page d'accueil
      if (!$gamesList) {
        throw new \Exception('Aucun match disponible pour le moment.');
      }

      // On vérifie que le formulaire a été soumis et n'est pas vide
      if (isset($_POST['submitBetSelection']) && !empty($_POST['games'])) {

        // On récupère l'Id de l'utilisateur connecté
        $userId = SecurityTools::getCurrentUserId();
        // Je récupère les Id des Games sélectionnés
        $gamesSelectionArray = [];
        foreach ($_POST['games'] as $gameId) {
          $gamesSelectionArray[] = $gameId;
        }

        // On redirige l'utilisateur vers la page de configuration des paris multiples (les Id des Games sélectionnés sont dans la liste des paramètres de l'URL - Méthode GET)
        header('Location: ' . constant('URL_SUBFOLDER') . '/bet/multiple/config?games=' . implode(',', $gamesSelectionArray));
        exit();
      } elseif (isset($_POST['submitBetSelection']) && empty($_POST['games'])) {
        // Si l'utilisateur n'a pas sélectionné de match, on affiche un message d'erreur
        $errors['betSelection'] = 'Sélectionnez au moins un match .';
      }

      // On affiche la vue betMultipleForm.php
      $this->render('bet/betMultipleForm', [
        'gamesList' => $gamesList ?? [],
        'error' => $errors ?? [],
      ]);
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage(),
        'redirection_slug' => '/',
        'redirection_text' => 'Retour vers la page Accueil'
      ]);
    }
  }

  public function betMultipleConfigAction(): void
  {
    try {
      $errors = [];

      // On vérifie que l'utilisateur est connecté
      // Pour empêcher l'accès à la page de configuration par l'URL
      if (!SecurityTools::isLogged()) {
        header('Location: ' . constant('URL_SUBFOLDER') . '/login');
        exit();
      }

      // On vérifie que l'utilisateur a sélectionné des matchs
      if (!isset($_GET['games']) || empty($_GET['games'])) {
        throw new \Exception('Aucun match sélectionné.');
      }

      // Je récupère les Id des Games sélectionnés (Méthode GET) et je les mets dans un tableau
      $gamesSelectionArray = explode(',', $_GET['games']);

      // On récupère les données des matchs sélectionnés pour les afficher dans la vue
      $gameRepository = new GameRepository();

      $gamesSelectedData = [];
      // pour chaque Id de match sélectionné, je récupère les données du match sous la forme d'un tableau contenant des objets Game
      foreach ($gamesSelectionArray as $gameId) {
        $game = $gameRepository->findOneById($gameId);
        if ($game) {
          $gamesSelectedData[] = $game;
        }
      }

      // SUBMIT : On vérifie que le formulaire a été soumis et n'est pas vide
      if (isset($_POST['submitBetMultipleConfig'])) {
        // die(var_dump($_POST));

        // On récupère l'Id de l'utilisateur connecté
        $userId = SecurityTools::getCurrentUserId();

        foreach ($_POST['game_id'] as $key => $gameId) {

          // Je vérifie que l'utilisateur n'a pas déjà misé sur un des matchs sélectionnés
          $betRepository = new BetRepository();
          $existingBet = $betRepository->findOneByGameAndUser($gameId, $userId);
          if ($existingBet) {
            // Je récupère la date du match pour configurer le message d'erreur
            $game = $gameRepository->findOneById($gameId);
            $errors['bet'] = [
              'message' => 'Vous avez déjà misé sur le match du ' . $game->getGameDate() . '. Veuillez refaire votre sélection.',
              'redirection_slug' => constant('URL_SUBFOLDER') . '/bet/multiple',
              'redirection_text' => 'Retour à la sélection de matchs'
            ];
            break;
          }

          // Je récupère les données pour chaque pari selon l'Id du match puis j'instancie un nouvel objet Bet.
          // L'indice $key permet de retrouver les mises correspondantes aux GameId considéré.
          $bet = new Bet();
          $bet->setGameId($gameId);
          $bet->setUserId($userId);
          $bet->setBetDate((new \DateTime('now', new \DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s'));
          $bet->setBetAmount1(floatval($_POST['bet_amount1'][$key]));
          $bet->setBetAmount2(floatval($_POST['bet_amount2'][$key]));

          // On valide les données
          $errors = $bet->validate();

          // S'il n'y a pas d'erreurs
          if (empty($errors)) {
            // On enregistre la mise en base de données
            $betRepository = new BetRepository();
            $betRepository->persist($bet);
          }
        }

        // On redirige l'utilisateur vers la page ...
        //
      }

      // On affiche la vue betMultipleConfigForm.php
      $this->render('bet/betMultipleConfigForm', [
        'gamesSelectedData' => $gamesSelectedData ?? [],
        'error' => $errors ?? [],
      ]);
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage(),
        'redirection_slug' => '/',
        'redirection_text' => 'Retour vers la page Accueil'
      ]);
    }
  }
}
