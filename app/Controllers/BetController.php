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

      // On récupère les infos du match ($game) sur lequel l'utilisateur veut miser
      $game = new Game();
      $gameRepository = new GameRepository();
      $game = $gameRepository->findOneById($id);

      // Redirection si le match n'existe pas ou est terminé
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
        // On récupère les Data de la mise déjà existante pour les afficher dans la View.
        $existingBet->setBetAmount1(floatval($existingBet->getBetAmount1()));
        $existingBet->setBetAmount2(floatval($existingBet->getBetAmount2()));
        // On crée un message d'erreur pour informer l'utilisateur qu'il a déjà misé sur ce match et exporter ces données dans la vue.
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
      $gamesList = [];

      // On vérifie que l'utilisateur est connecté
      // if (!SecurityTools::isLogged()) {
      //   header('Location: ' . constant('URL_SUBFOLDER') . '/login');
      //   exit();
      // }

      // On récupère les matchs sur lesquels l'utilisateur peut miser (ie: status='A venir')
      $gameRepository = new GameRepository();
      $gamesList = $gameRepository->findUpcomingGames();

      // Si aucun match n'est disponible, on redirige l'utilisateur vers la page d'accueil
      if (!$gamesList) {
        throw new \Exception('Aucun match disponible pour le moment.');
      }


      // On vérifie que le formulaire a été soumis
      // if (isset($_POST['submitBetMultiple'])) {
      //   // On récupère l'Id de l'utilisateur connecté
      //   $userId = SecurityTools::getCurrentUserId();

      //   // On récupère les données du formulaire
      //   $bets = $_POST['bets'];

      //   // On valide les données
      //   foreach ($bets as $bet) {
      //     $bet['bet_amount1'] = floatval($bet['bet_amount1']);
      //     $bet['bet_amount2'] = floatval($bet['bet_amount2']);

      //     $errors = (new Bet($bet))->validate();
      //     if (!empty($errors)) {
      //       break;
      //     }
      //   }

      //   // S'il n'y a pas d'erreurs
      //   if (empty($errors)) {
      //     // On enregistre les mises en base de données
      //     $betRepository = new BetRepository();
      //     $betRepository->persistMultiple($bets, $userId);

      //     // On redirige l'utilisateur vers son dashboard
      //     header('Location: ' . constant('URL_SUBFOLDER') . '/dashboard');
      //     exit();
      //   }
      // }

      // On affiche la vue
      $this->render('bet/betMultipleForm', [
        'games' => $gamesList,
        'errors' => $errors,
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
