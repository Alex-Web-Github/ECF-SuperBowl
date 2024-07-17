-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 17 juil. 2024 à 12:14
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecf_superbowl`
--

-- --------------------------------------------------------

--
-- Structure de la table `bets`
--

CREATE TABLE `bets` (
  `bet_id` int UNSIGNED NOT NULL,
  `game_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `bet_amount1` smallint UNSIGNED NOT NULL,
  `bet_amount2` smallint UNSIGNED NOT NULL,
  `bet_date` varchar(255) NOT NULL,
  `bet_result` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `bets`
--

INSERT INTO `bets` (`bet_id`, `game_id`, `user_id`, `bet_amount1`, `bet_amount2`, `bet_date`, `bet_result`) VALUES
(99, 48, 47, 990, 0, '12/07/2024', 2574.00);

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE `games` (
  `game_id` int UNSIGNED NOT NULL,
  `team1_id` int UNSIGNED NOT NULL,
  `team2_id` int UNSIGNED NOT NULL,
  `team1_odds` float NOT NULL,
  `team2_odds` float NOT NULL,
  `game_date` varchar(255) NOT NULL,
  `game_start` varchar(255) NOT NULL,
  `game_end` varchar(255) NOT NULL,
  `game_status` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `game_score` tinytext NOT NULL,
  `game_weather` tinytext NOT NULL,
  `game_winner` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `games`
--

INSERT INTO `games` (`game_id`, `team1_id`, `team2_id`, `team1_odds`, `team2_odds`, `game_date`, `game_start`, `game_end`, `game_status`, `game_score`, `game_weather`, `game_winner`) VALUES
(40, 29, 31, 1, 10, '2024-06-30', '09:00', '11:00', 'Terminé', '5-1', 'nuageux', 0),
(42, 29, 31, 1, 10, '2024-07-04', '12:00', '13:00', 'Terminé', '2-7', 'soleil', 0),
(43, 29, 31, 1, 10, '2024-07-04', '11:00', '12:00', 'Terminé', '2-4', 'neige', 0),
(47, 31, 32, 1, 10, '2024-07-11', '16:00', '18:30', 'Terminé', '10-1', 'Neige', 0),
(48, 30, 33, 2.6, 8.2, '2024-07-13', '09:00', '11:17', 'Terminé', '4-2', 'Soleil', 1);

-- --------------------------------------------------------

--
-- Structure de la table `players`
--

CREATE TABLE `players` (
  `player_id` int UNSIGNED NOT NULL,
  `player_firstname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `player_lastname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `player_number` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `players`
--

INSERT INTO `players` (`player_id`, `player_firstname`, `player_lastname`, `player_number`) VALUES
(1, 'Tom', 'Brady', 12),
(2, 'Aaron', 'Rodgers', 12),
(3, 'Patrick', 'Mahomes', 15),
(4, 'Russell', 'Wilson', 3),
(5, 'Drew', 'Brees', 9),
(6, 'Lamar', 'Jackson', 8),
(7, 'Josh', 'Allen', 17),
(8, 'Dak', 'Prescott', 4),
(9, 'Deshaun', 'Watson', 4),
(10, 'Kyler', 'Murray', 1),
(11, 'Joe', 'Montana', 16),
(12, 'Jerry', 'Rice', 80),
(13, 'Peyton', 'Manning', 18),
(14, 'Brett', 'Favre', 4),
(15, 'Emmitt', 'Smith', 22),
(16, 'Barry', 'Sanders', 20),
(17, 'Dan', 'Marino', 13),
(18, 'Steve', 'Young', 8),
(19, 'Troy', 'Aikman', 8),
(20, 'Terrell', 'Davis', 30),
(21, 'Randy', 'Moss', 84),
(22, 'James', 'Johnson', 1),
(23, 'John', 'Williams', 2),
(24, 'Robert', 'Brown', 3),
(25, 'Michael', 'Jones', 4),
(26, 'William', 'Miller', 5),
(27, 'David', 'Davis', 6),
(28, 'Richard', 'Garcia', 7),
(29, 'Joseph', 'Rodriguez', 8),
(30, 'Charles', 'Wilson', 9),
(31, 'Thomas', 'Martinez', 10),
(32, 'Christopher', 'Anderson', 11);

-- --------------------------------------------------------

--
-- Structure de la table `teams`
--

CREATE TABLE `teams` (
  `team_id` int UNSIGNED NOT NULL,
  `team_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `team_country` varchar(255) NOT NULL,
  `team_players` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `teams`
--

INSERT INTO `teams` (`team_id`, `team_name`, `team_country`, `team_players`) VALUES
(29, 'Dallas Cowboys', 'USA', '1,2,3,4,5,6,7,8,9,10,11'),
(30, 'Washington Redskins', 'USA', '22,23,24,25,26,27,28,29,30,31,32'),
(31, 'Pontus', 'France', '3,4,5,6,7,8,9,10,11,12,13'),
(32, 'Frenchies', 'France', '14,15,16,17,18,19,20,21,22,24,28'),
(33, 'Chicago Hawks', 'Suisse', '8,9,10,16,17,25,26,29,30,32,32'),
(44, 'test', 'test', '2,3,4,5,6,7,8,9,10,11,12');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int UNSIGNED NOT NULL,
  `user_first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_token` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_is_checked` tinyint(1) DEFAULT NULL,
  `user_created_at` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `user_first_name`, `user_last_name`, `user_role`, `user_email`, `user_password`, `user_token`, `user_is_checked`, `user_created_at`) VALUES
(12, 'Alex', 'Foulc', 'admin', 'alexandre-foulc@orange.fr', '$2y$10$d9cJ/2TnuFi5QvaFGDCUQOjQ1zfjQlqV.h6ww.OvJCFjqNuC4Nyte', 'D666c0ee7b74293.52480970', 1, ''),
(47, 'AlexUser', 'Foulc', 'user', 'alexandre.foulc@gmail.com', '$2y$10$ztUyrUCdZZ3NWTdv8ZLsXuiR7r4h6NCxhxbTCf1C7tHcrUPL2x3hq', 'D666c47261eb931.14799079', 1, '2024-06-21 12:44:26'),
(70, 'AlexSpeaker', 'Foulc', 'speaker', 'speaker@test.fr', '$2y$10$QdYZISmzNlj014jgmBqDX.nvlC1cXDbL4L8qP3Zmz8PTaozIwZMAW', 'D6687bbb36254e6.09537223', 1, '2024-07-05 09:24:03');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bets`
--
ALTER TABLE `bets`
  ADD PRIMARY KEY (`bet_id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`),
  ADD KEY `team1_id` (`team1_id`),
  ADD KEY `team2_id` (`team2_id`);

--
-- Index pour la table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`player_id`);

--
-- Index pour la table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`team_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bets`
--
ALTER TABLE `bets`
  MODIFY `bet_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT pour la table `teams`
--
ALTER TABLE `teams`
  MODIFY `team_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bets`
--
ALTER TABLE `bets`
  ADD CONSTRAINT `bets_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bets_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`team1_id`) REFERENCES `teams` (`team_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `games_ibfk_2` FOREIGN KEY (`team2_id`) REFERENCES `teams` (`team_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
