-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 29 sep. 2021 à 22:32
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mygames`
--

-- --------------------------------------------------------

--
-- Structure de la table `consoles`
--

DROP TABLE IF EXISTS `consoles`;
CREATE TABLE IF NOT EXISTS `consoles` (
  `PK_consoles` int(11) NOT NULL AUTO_INCREMENT,
  `names_consoles` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`PK_consoles`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `consoles`
--

INSERT INTO `consoles` (`PK_consoles`, `names_consoles`) VALUES
(1, 'xbox'),
(2, 'playstation'),
(3, 'pc'),
(4, 'nintendo');

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

DROP TABLE IF EXISTS `game`;
CREATE TABLE IF NOT EXISTS `game` (
  `PK_game` int(11) NOT NULL AUTO_INCREMENT,
  `name_game` varchar(150) DEFAULT NULL,
  `describe_game` text,
  `date_game` date DEFAULT NULL,
  `img_game` varchar(255) NOT NULL,
  `bg_game` varchar(255) DEFAULT NULL,
  `date_ajout_game` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `theme` varchar(155) DEFAULT NULL,
  PRIMARY KEY (`PK_game`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `game`
--

INSERT INTO `game` (`PK_game`, `name_game`, `describe_game`, `date_game`, `img_game`, `bg_game`, `date_ajout_game`, `theme`) VALUES
(1, 'CyberPunk 2077', 'Cyberpunk 2077 est un jeu d’action-aventure en monde ouvert qui se déroule à Night City, une mégalopole obsédée par le pouvoir, la séduction et les modifications corporelles. \r\nVous incarnez V, mercenaire hors-la-loi à la recherche d’un implant unique qui serait la clé de l’immortalité.', '2020-12-10', '259811648CyberPunk.jfif', 'bgCyber.jpg', '2021-10-02 18:45:59', NULL),
(2, 'Ark Survival Evolved', 'En tant qu\'homme ou femme échoué nu, mourant de froid et de faim sur une île mystérieuse, vous devrez chasser, récolter, fabriquer des objets, faire pousser des plantes et construire des abris pour survivre.', '2017-08-03', 'ark.jpg', 'bgArk.JPG', '2021-09-13 18:44:28', NULL),
(4, 'Empyrion', 'Empyrion - Galactic Survival est un monde 3D ouvert, une aventure de survie spatiale dans laquelle vous pouvez naviguer à travers l\'espace et attérrir sur les planètes. Construisez, explorez, combattez et survivez dans une galaxie hostile pleine de dangers cachés.', '2020-08-05', 'empyrion.jpg', 'bgEmpyrion.jpg', '2021-09-29 18:10:59', NULL),
(17, 'Conan Exiles', 'Jeu de survie multijoueur en ligne, désormais agrémenté de montures et de combat monté, dans le monde de Conan le barbare. Survivez dans un monde immense de type bac à sable, construisez votre propre maison, fondez un royaume et dominez vos ennemis, en mode solo ou multijoueur.', '2018-05-08', '415623203ConanExiles.jpeg', '339699708BgConanExiles.jpg', '2021-09-29 18:10:59', NULL),
(20, 'Atlas', 'Mettez les voiles pour l’expérience pirate ultime! Embarquez pour une grande aventure aux côtés de milliers d’autres joueurs dans l’un des plus grands mondes de jeu jamais construits (et réclamez même un morceau de celui-ci pour appeler le vôtre). Construisez votre navire, rassemblez votre équipage, naviguez en haute mer et devenez une légende des pirates!', '2018-09-23', '154657454atlas.jpg', '1198149620bgAtlas.jpg', '2021-09-29 18:10:59', NULL),
(21, 'Black Desert Online', 'Black Desert est un MMORPG dans un monde vivant en constante évolution. Découvrez des combats rapides et dynamiques, chassez des monstres, terrassez des boss gigantesques, battez-vous aux côtés de vos partenaires de guilde lors de guerres, apprenez de nombreux métiers...', '2021-09-24', '1204716622blackDesert.jpg', '1969996633bgBlackDesert.jpg', '2021-09-29 18:10:59', NULL),
(24, 'Skyrim', 'La rennaissance du fantastique, le nouveau chapitre très attendu de la saga Elder Scrolls nous arrive des créateurs du jeu de l\'année 2006 et 2008, Bethesda Game Studios. Skyrim réinvente et révolutionne le monde ouvert, ramenant à la vie un monde complet que vous pourrez librement explorer.', '2011-11-11', '261947040skyrim.jfif', '694152942bgSkyrim.jfif', '2021-09-29 23:30:07', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `game_consoles`
--

DROP TABLE IF EXISTS `game_consoles`;
CREATE TABLE IF NOT EXISTS `game_consoles` (
  `PK_game_consoles` int(11) NOT NULL AUTO_INCREMENT,
  `FK_game` int(11) DEFAULT NULL,
  `FK_consoles` int(11) DEFAULT NULL,
  PRIMARY KEY (`PK_game_consoles`),
  KEY `FK_game` (`FK_game`),
  KEY `FK_consoles` (`FK_consoles`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `game_consoles`
--

INSERT INTO `game_consoles` (`PK_game_consoles`, `FK_game`, `FK_consoles`) VALUES
(34, 1, 3),
(3, 2, 1),
(4, 2, 2),
(5, 2, 3),
(6, 4, 3),
(33, 1, 2),
(32, 1, 1),
(98, 24, 3),
(93, 17, 2),
(92, 17, 1),
(88, 20, 1),
(89, 20, 2),
(90, 20, 3),
(91, 21, 3),
(94, 17, 3);

-- --------------------------------------------------------

--
-- Structure de la table `game_genre`
--

DROP TABLE IF EXISTS `game_genre`;
CREATE TABLE IF NOT EXISTS `game_genre` (
  `FK_genre` int(11) DEFAULT NULL,
  `FK_game` int(11) DEFAULT NULL,
  KEY `FK_genre` (`FK_genre`),
  KEY `FK_game` (`FK_game`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `game_genre`
--

INSERT INTO `game_genre` (`FK_genre`, `FK_game`) VALUES
(3, 17),
(2, 17),
(1, 17),
(11, 2),
(12, 2),
(13, 4),
(12, 4),
(11, 4),
(4, 4),
(2, 24),
(1, 24),
(8, 1),
(2, 1),
(9, 24),
(4, 24),
(4, 20),
(8, 20),
(9, 20),
(11, 20),
(12, 20),
(1, 21),
(2, 21),
(3, 21),
(4, 21),
(4, 17),
(8, 17),
(9, 17),
(12, 17);

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE IF NOT EXISTS `genre` (
  `PK_genre` int(11) NOT NULL AUTO_INCREMENT,
  `name_genre` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`PK_genre`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`PK_genre`, `name_genre`) VALUES
(1, 'action'),
(2, 'rpg'),
(3, 'mmorpg'),
(4, 'open-world'),
(5, 'simulation'),
(6, 'sport'),
(7, 'course'),
(8, 'bac à sable'),
(9, 'aventure'),
(10, 'stratégie'),
(11, 'construction'),
(12, 'survie'),
(13, 'simulation spatial');

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `member_PK` int(11) NOT NULL AUTO_INCREMENT,
  `member_name` varchar(80) DEFAULT NULL,
  `member_mail` varchar(200) DEFAULT NULL,
  `member_password` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `date_member` datetime DEFAULT CURRENT_TIMESTAMP,
  `level` varchar(100) NOT NULL,
  PRIMARY KEY (`member_PK`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`member_PK`, `member_name`, `member_mail`, `member_password`, `status`, `date_member`, `level`) VALUES
(1, 'remy', 'wetterene.remy@gmail.com', '$2y$10$qJZQ00dQn3gwTCqikXrEuuBXfH2oTwZRIrqh8A/9IS/r9vSLnpbnC', 0, '2021-09-20 00:05:42', 'admin'),
(2, 'test', 'test@gmail.com', '$2y$10$qJZQ00dQn3gwTCqikXrEuuBXfH2oTwZRIrqh8A/9IS/r9vSLnpbnC', 0, '2021-09-23 21:16:34', 'membre'),
(3, 'Boderio', 'Boderio@academy.com', NULL, 0, '2021-09-27 20:27:06', 'batDev');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
