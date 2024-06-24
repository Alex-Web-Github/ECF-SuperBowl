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

      // On vérifie que l'utilisateur est connecté (même si le bouton "miser" est normalement caché pour les utilisateurs non connectés...), sinon -> Redirection vers page Accueil.
      if (!SecurityTools::isLogged()) {
        header('Location: ' . constant('URL_SUBFOLDER') . '/login');
        exit();
      }

      // On récupère les infos du Game sur lequel l'utilisateur veut miser
      $game = new Game();
      $gameRepository = new GameRepository();
      $game = $gameRepository->findOneById($id);

      // Redirection si le match n'existe pas OU est terminé OU est en cours
      if (!$game || $game->getGameStatus() === 'Terminé' || $game->getGameStatus() === 'En cours') {
        throw new \Exception('Ce match n\'existe pas ou est terminé ou en cours.');
      }

      // On récupère l'Id de l'utilisateur connecté
      $userId = SecurityTools::getCurrentUserId();

      /**
       **** On vérifie si l'utilisateur a déjà misé sur ce match ?
       */
      $betRepository = new BetRepository();
      // Je récupère une mise si elle existe pour le match, sinon je récupère "False".
      $existingBet = $betRepository->findOneByGameAndUser($id, $userId);

      if ($existingBet) {
        // On crée un message d'avertissement pour informer l'utilisateur qu'il a déjà misé sur ce match et je modifie le texte du bouton de validation.
        // Les mises existantes sont envoyées à la vue pour affichage (variable $existingBet).
        $errors['bet'] = [
          'message' => 'Vous avez déjà misé sur ce match mais vous pouvez modifier votre mise ci-dessous.</br>Attention, si vous mettez 0 pour les 2 mises, votre mise sera supprimée',
          'textButton' => 'Actualiser ma mise',
        ];
      }

      // On vérifie que le formulaire a été soumis
      if (isset($_POST['submitBet'])) {

        // Je filtre les données du formulaire contre les failles XSS
        $_POST['bet_amount1'] = strip_tags($_POST['bet_amount1']);
        $_POST['bet_amount2'] = strip_tags($_POST['bet_amount2']);

        // J'instancie un nouvel objet Bet
        $bet = new Bet();
        // Je "caste" les montants de mise en entier (elles arrivent sous la forme de chaînes de caractères)
        $bet->setBetAmount1((int)$_POST['bet_amount1']);
        $bet->setBetAmount2((int)$_POST['bet_amount2']);
        // On attribue l'Id du match et l'Id de1&&&&& l'utilisateur à la mise
        $bet->setGameId($id);
        $bet->setUserId($userId);
        $bet->setBetDate((new \DateTime('now', new \DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s'));

        // Important : si l'utilisateur a déjà misé, on récupère l'Id de la mise pour la modifier (variante UPDATE de la méthode persist() de BetRepository).
        if ($existingBet) {
          $bet->setBetId($existingBet->getBetId());
          // Validation des champs de l'objet Bet dans le cas d'un pari déjà existant : on autorise les mises nulles (en vue d'une suppression de la mise)
          $errors = $bet->validate(false);
        } else {
          $bet->setBetId(null);
          // Je valide les données dans l'objet Bet
          $errors = $bet->validate();
        }

        if (empty($errors)) {
          // Si les 2 mises sont nulles, et qu'il s'agit d'une actualisation de mise, alors on supprime la mise.
          if ($existingBet && $bet->getBetAmount1() === 0 && $bet->getBetAmount2() === 0) {
            $betRepository->deleteBetById($bet->getBetId());
          }

          // On enregistre la mise en base de données (cas d'une création de mise ou d'une modification de mise existante)
          $betRepository = new BetRepository();
          $betRepository->persist($bet);

          // Dans tous les cas, je redirige ensuite l'utilisateur vers son Dashboard.
          header('Location: ' . constant('URL_SUBFOLDER') . '/dashboard');
          exit();
        }
      }
      // On affiche la vue betForm.php
      $this->render('bet/betForm', [
        'game' => $game ?? [],
        'existingBet' => $existingBet ?? false,
        'error' => $errors
      ]);
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage(),
        'redirection_slug' => '/',
        'redirection_text' => 'Retour vers la page Accueil'
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

        // On récupère l'Id de l'utilisateur connecté
        $userId = SecurityTools::getCurrentUserId();

        foreach ($_POST['game_id'] as $key => $gameId) {

          // Je vérifie que l'utilisateur n'a pas déjà misé sur un/plusieurs des matchs sélectionnés
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

  public function deleteBetAction($id): void
  {
    try {
      $errors = [];

      // On vérifie que l'utilisateur est connecté
      if (!SecurityTools::isLogged()) {
        header('Location: ' . constant('URL_SUBFOLDER') . '/login');
        exit();
      }

      // On vérifie que l'Id de la mise est un nombre entier
      if (!is_numeric($id)) {
        throw new \Exception('L\'Id de la mise doit être un nombre entier');
      }

      // On récupère l'Id de l'utilisateur connecté
      $userId = SecurityTools::getCurrentUserId();

      // On vérifie que la mise appartient bien à l'utilisateur connecté
      $betRepository = new BetRepository();
      $bet = $betRepository->findOneById($id);
      if (!$bet || $bet->getUserId() !== $userId) {
        throw new \Exception('Cette mise ne vous appartient pas !');
      }

      // On supprime la mise
      $betRepository->deleteBetById($id);

      // On redirige l'utilisateur vers son dashboard
      header('Location: ' . constant('URL_SUBFOLDER') . '/dashboard');
      exit();
    } catch (\Exception $e) {
      $this->render('errors/default', [
        'error' => $e->getMessage(),
        'redirection_slug' => '/',
        'redirection_text' => 'Retour vers la page Accueil'
      ]);
    }
  }
}
