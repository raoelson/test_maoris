-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 23 sep. 2017 à 10:59
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `testmaoris`
--

-- --------------------------------------------------------

--
-- Structure de la table `liste_ami`
--

DROP TABLE IF EXISTS `liste_ami`;
CREATE TABLE IF NOT EXISTS `liste_ami` (
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`type_id`,`user_id`),
  KEY `IDX_B15DD227C54C8C93` (`type_id`),
  KEY `IDX_B15DD227A76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `liste_ami`
--

INSERT INTO `liste_ami` (`type_id`, `user_id`) VALUES
(9, 1),
(9, 3),
(9, 5);

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `age` int(11) NOT NULL,
  `famille` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `race` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nourriture` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id`, `nom`, `age`, `famille`, `race`, `nourriture`) VALUES
(9, 'farany_', 100, 'farany', 'race', 'nourrie');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_8D93D649C05FB297` (`confirmation_token`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`) VALUES
(1, 'raoelson', 'raoelson', 'raoelson@gmail.com', 'raoelson@gmail.com', 1, NULL, '$2y$13$Ux8etEf7ks76M2B8/vyxZuRo23jwSDKhk79RcbsIqXDL8ZbkNceJC', '2017-09-23 10:42:20', NULL, NULL, 'a:0:{}'),
(3, 'maoris', 'maoris', 'maoris@gmail.com', 'maoris@gmail.com\r\n', 1, NULL, '$2y$13$Ux8etEf7ks76M2B8/vyxZuRo23jwSDKhk79RcbsIqXDL8ZbkNceJC', '2017-09-23 02:52:31', NULL, NULL, 'a:0:{}'),
(4, 'dada', 'dada', 'dada@gmail.com', 'dada@gmail.com', 1, NULL, '$2y$13$6S8lknCLSViYgh2/tQOOnu41uwS877JXGZYmqrclfb1BgaDLn5Nce', '2017-09-23 10:23:07', NULL, NULL, 'a:0:{}'),
(5, 'sasa', 'sasa', 'sasa@gmail.com', 'sasa@gmail.com', 1, NULL, '$2y$13$df/dIyxXBFr1AdvRBOGEAO.iLYYcq6zhsLRnz6zePqiG6lbKsreQq', '2017-09-23 10:32:42', NULL, NULL, 'a:0:{}');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `liste_ami`
--
ALTER TABLE `liste_ami`
  ADD CONSTRAINT `FK_B15DD227A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_B15DD227C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
