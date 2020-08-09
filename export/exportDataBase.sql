-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 31, 2020 at 02:32 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `magasin_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `categorie_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `categorie_nom` varchar(255) NOT NULL,
  PRIMARY KEY (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categorie_id`, `categorie_nom`) VALUES
(1, 'Sport'),
(2, 'Enfant'),
(3, 'Électronique'),
(5, 'techno'),
(6, 'wowow');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_nom` varchar(255) NOT NULL,
  `client_prenom` varchar(255) NOT NULL,
  `client_adresse` varchar(255) NOT NULL,
  `client_telephone` varchar(255) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `client_nom`, `client_prenom`, `client_adresse`, `client_telephone`) VALUES
(1, 'John', 'Doe', '1234 rue wow', '438-123-4444'),
(8, 'rober', 'dupuis', '2324242rwe', '514-845-8842'),
(10, 'pierre', 'robert', '123', '438-888-4444'),
(11, 'Landry', 'Guillaume', '1238 rue du passet J3G 0Q9', '438-888-8843');

-- --------------------------------------------------------

--
-- Table structure for table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `commande_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `commande_adresse` varchar(255) NOT NULL,
  `commande_desc` varchar(255) DEFAULT NULL,
  `commande_etat` varchar(255) NOT NULL,
  `commande_fk_client` int(10) UNSIGNED NOT NULL,
  `commande_date` timestamp NOT NULL,
  PRIMARY KEY (`commande_id`),
  KEY `commande_fk_client` (`commande_fk_client`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `commandes`
--

INSERT INTO `commandes` (`commande_id`, `commande_adresse`, `commande_desc`, `commande_etat`, `commande_fk_client`, `commande_date`) VALUES
(2, '2141', '2', 'ongoing', 8, '2020-01-17 15:27:27'),
(3, '2324242rwe', '', 'ongoing', 8, '2020-01-17 15:28:05'),
(9, '1238', '...', 'En cours', 11, '2020-01-17 16:05:40'),
(11, '1234 rue wow', '', 'ongoing', 1, '2020-01-17 16:48:58'),
(12, '2324242rwe', '', 'ongoing', 8, '2020-01-17 16:49:05'),
(13, '2324242rwe', '', 'ongoing', 8, '2020-01-17 16:49:11'),
(14, '2324242rwe', '', 'ongoing', 8, '2020-01-17 16:49:42'),
(15, '1234 rue wow', '', 'ongoing', 1, '2020-01-17 16:49:48'),
(16, '1234 rue wow', '', 'ongoing', 1, '2020-01-17 16:50:21'),
(17, '1234 rue wow', 'sa', 'standby', 1, '2020-01-17 16:50:34'),
(18, '1234 rue wow', 'sa', 'standby', 1, '2020-01-17 16:51:22'),
(19, '1238 rue du passet J3G 0Q9', '', 'ongoing', 11, '2020-01-17 18:46:38'),
(20, '1238 rue du passet J3G 0Q9', '', 'ongoing', 11, '2020-01-17 18:59:25'),
(22, '1238 rue du passet J3G 0Q9', '', 'ongoing', 11, '2020-01-17 19:01:31'),
(23, '1238 rue du passet J3G 0Q9', '', 'ongoing', 11, '2020-01-17 19:01:42'),
(24, '1238 rue du passet J3G 0Q9', '', 'ongoing', 11, '2020-01-17 19:02:57'),
(25, '123', '', 'ongoing', 10, '2020-01-17 19:03:13'),
(26, '1238 rue du passet J3G 0Q9', '', 'En cours', 8, '2020-01-17 19:03:42'),
(28, '1238 rue du passet J3G 0Q9', 'JE VEUX RAPIDE', 'ongoing', 11, '2020-01-18 01:29:09'),
(29, '123', 'COMMENTAIRE 2', 'standby', 10, '2020-01-21 14:10:48'),
(30, '123', 'COMMENTAIRE 2', 'standby', 10, '2020-01-21 14:12:39'),
(31, '123', 'COMMENTAIRE 2', 'standby', 10, '2020-01-21 14:13:30'),
(32, '123', 'COMMENTAIRE 2', 'standby', 10, '2020-01-21 14:13:49'),
(36, '1238 rue du massif', '', 'canceled', 1, '2020-01-21 14:21:26'),
(38, '2324242rwe', '', 'ongoing', 8, '2020-01-21 14:23:55'),
(39, '2324242rwe', 'rapidement', 'standby', 8, '2020-01-21 14:24:17'),
(40, '2324242rwe', 'rapidement', 'standby', 8, '2020-01-21 14:28:01'),
(41, '123', '', 'ongoing', 10, '2020-01-21 14:30:08'),
(42, '123', '', 'ongoing', 10, '2020-01-21 14:30:15'),
(43, '2324242rwe', '', 'ongoing', 8, '2020-01-21 15:05:59'),
(44, '2324242rwe', '', 'ongoing', 8, '2020-01-21 15:06:11'),
(45, '123', '', 'ongoing', 10, '2020-01-21 15:10:50'),
(46, '123', '', 'ongoing', 10, '2020-01-21 15:11:24'),
(48, '123', '', 'ongoing', 10, '2020-01-21 15:12:51'),
(49, '123', '', 'ongoing', 10, '2020-01-21 15:12:59'),
(50, '1234 rue wow', '', 'ongoing', 1, '2020-01-21 15:13:09'),
(52, '123', '', 'ongoing', 10, '2020-01-21 15:14:20'),
(53, '1234 rue wow', '', 'ongoing', 1, '2020-01-21 16:04:32'),
(54, '1234 rue wow', '', 'ongoing', 1, '2020-01-21 16:04:39'),
(55, '1234 rue wow', '', 'ongoing', 1, '2020-01-21 16:05:09'),
(56, '1234 rue wow', '', 'ongoing', 1, '2020-01-21 16:10:24'),
(57, '1234 rue wow', '', 'ongoing', 1, '2020-01-21 16:10:29'),
(58, '1234 rue wow', '', 'ongoing', 1, '2020-01-21 16:10:44'),
(65, '1234 rue wow', '', 'ongoing', 1, '2020-01-21 21:08:38'),
(67, '123', '', 'ongoing', 10, '2020-01-23 15:56:33'),
(69, '1234 rue wow', '', 'En cours', 1, '2020-01-23 16:58:07'),
(70, '1234 rue wow', '', 'ongoing', 1, '2020-01-23 18:10:57'),
(71, '1234 rue wow', '', 'ongoing', 1, '2020-01-23 18:11:24'),
(72, '1234 rue wow', '', 'ongoing', 1, '2020-01-23 18:11:31'),
(73, '1234 rue wow', '', 'ongoing', 1, '2020-01-23 18:19:42'),
(74, '123', 'Rapide', 'En attente', 10, '2020-01-28 14:25:33'),
(75, '123', 'Rapide', 'En attente', 10, '2020-01-28 17:24:45'),
(76, '123', 'dddd', 'En cours', 10, '2020-01-28 20:15:57'),
(77, '1234 rue wow', '', 'En cours', 1, '2020-01-30 15:42:13'),
(78, '1234 rue wow', 'ress', 'En cours', 1, '2020-01-30 15:44:29'),
(79, '1234 rue wow', '', 'En cours', 1, '2020-01-30 15:45:25'),
(80, '1234 rue wow', '', 'En cours', 1, '2020-01-30 16:01:31'),
(81, '1234 rue wow', '', 'En cours', 1, '2020-01-30 16:01:58'),
(82, '1234 rue wow', '', 'En cours', 1, '2020-01-30 16:03:25'),
(83, '1234 rue wow', '', 'En cours', 1, '2020-01-30 16:09:07'),
(84, '1234 rue wow', '', 'En cours', 1, '2020-01-30 16:09:50'),
(85, '1234 rue wow', '', 'En cours', 1, '2020-01-30 16:29:48'),
(86, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:00:53'),
(87, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:01:15'),
(88, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:02:07'),
(89, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:04:48'),
(90, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:05:34'),
(91, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:07:17'),
(92, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:07:32'),
(93, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:07:56'),
(94, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:09:21'),
(95, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:09:38'),
(96, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:10:05'),
(97, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:12:01'),
(98, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:12:21'),
(99, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:13:00'),
(100, '2324242rwe', '', 'En cours', 8, '2020-01-30 17:26:06'),
(101, '2324242rwe', '', 'En cours', 8, '2020-01-30 17:26:50'),
(102, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:27:12'),
(103, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:28:58'),
(104, '1234 rue wow', 'test', 'En cours', 1, '2020-01-30 17:37:27'),
(105, '1234 rue wow', 'test', 'En cours', 1, '2020-01-30 17:37:37'),
(106, '1234 rue wow', 'test', 'En cours', 1, '2020-01-30 17:37:44'),
(107, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:40:15'),
(108, '1234 rue wow', '', 'En cours', 1, '2020-01-30 17:52:25'),
(109, '1234 rue wow', '', 'En cours', 1, '2020-01-30 18:17:25'),
(110, '1234 rue wow', '', 'En cours', 1, '2020-01-30 18:17:39'),
(111, '1234 rue wow', '', 'En cours', 1, '2020-01-30 18:19:41'),
(112, '1234 rue wow', '', 'En cours', 1, '2020-01-30 18:19:58'),
(113, '1234 rue wow', '', 'En cours', 1, '2020-01-30 18:21:05'),
(114, '1234 rue wow', '', 'En cours', 1, '2020-01-30 18:21:14'),
(115, '1234 rue wow', '', 'En cours', 1, '2020-01-30 18:23:52'),
(116, '1234 rue wow', '', 'En cours', 1, '2020-01-30 18:24:11'),
(117, '1234 rue wow', '', 'En cours', 1, '2020-01-30 18:24:20'),
(118, '1234 rue wow', '', 'En cours', 1, '2020-01-30 18:24:42'),
(119, '1234 rue wow', '', 'En cours', 1, '2020-01-30 18:24:59'),
(120, '1234 rue wow', '', 'En cours', 1, '2020-01-30 18:27:16'),
(121, '1234 rue wow', '', 'En cours', 1, '2020-01-31 00:02:39'),
(122, '1234 rue wow', '', 'En cours', 1, '2020-01-31 13:14:43'),
(123, '2324242rwe', 'lol', 'En attente', 8, '2020-01-31 13:34:17');

-- --------------------------------------------------------

--
-- Table structure for table `commandes_produits`
--

DROP TABLE IF EXISTS `commandes_produits`;
CREATE TABLE IF NOT EXISTS `commandes_produits` (
  `cp_fk_commandes` int(10) UNSIGNED NOT NULL,
  `cp_fk_produits` int(10) UNSIGNED NOT NULL,
  `qty_produit` int(11) NOT NULL,
  PRIMARY KEY (`cp_fk_commandes`,`cp_fk_produits`),
  KEY `cp_fk_commandes` (`cp_fk_produits`),
  KEY `cp_fk_produits` (`cp_fk_commandes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `commandes_produits`
--

INSERT INTO `commandes_produits` (`cp_fk_commandes`, `cp_fk_produits`, `qty_produit`) VALUES
(9, 1, 2),
(12, 1, 2),
(14, 1, 2),
(26, 1, 3),
(28, 1, 1),
(29, 1, 3),
(30, 1, 3),
(32, 1, 3),
(36, 2, 4),
(45, 1, 2),
(45, 2, 2),
(46, 1, 2),
(46, 2, 2),
(48, 2, 2),
(48, 3, 31),
(49, 2, 2),
(49, 3, 31),
(50, 1, 1),
(50, 2, 1),
(50, 3, 1),
(53, 1, 2),
(53, 2, 2),
(56, 2, 2),
(57, 1, 2),
(57, 2, 2),
(58, 1, 2),
(58, 2, 2),
(65, 3, 22),
(67, 1, 2),
(69, 3, 0),
(70, 1, 1),
(70, 2, 1),
(70, 3, 1),
(70, 5, 1),
(71, 1, 1),
(71, 2, 1),
(71, 3, 1),
(71, 5, 1),
(72, 1, 1),
(72, 2, 1),
(72, 3, 1),
(72, 5, 1),
(73, 3, 500),
(74, 1, 1),
(74, 3, 1),
(75, 1, 1),
(75, 3, 1),
(76, 1, 2),
(77, 1, 2),
(77, 2, 2),
(77, 3, 12),
(78, 1, 12),
(78, 2, 12),
(79, 5, 3),
(80, 2, 1),
(80, 3, 1),
(81, 2, 1),
(81, 3, 1),
(82, 2, 1),
(83, 2, 1),
(84, 2, 1),
(98, 2, 2),
(99, 2, 12),
(99, 3, 2),
(100, 2, 2),
(102, 1, 2),
(102, 2, 2),
(103, 1, 3),
(103, 2, 3),
(104, 2, 12),
(105, 1, 2),
(105, 2, 2),
(106, 1, 1),
(106, 2, 1),
(106, 3, 1),
(106, 5, 1),
(107, 1, 2),
(107, 2, 2),
(108, 3, 13),
(108, 5, 13),
(109, 2, 13),
(110, 1, 1),
(112, 2, 12),
(114, 2, 12),
(115, 1, 1),
(117, 1, 12),
(119, 2, 2),
(120, 2, 900),
(121, 1, 1),
(122, 1, 12),
(123, 1, 12),
(123, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `produit_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `produit_nom` varchar(255) NOT NULL,
  `produit_desc` varchar(255) NOT NULL,
  `produit_prix` decimal(6,2) UNSIGNED NOT NULL,
  `produit_qty` int(10) UNSIGNED NOT NULL,
  `produit_fk_categories` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`produit_id`),
  KEY `produit_fk_categories` (`produit_fk_categories`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produits`
--

INSERT INTO `produits` (`produit_id`, `produit_nom`, `produit_desc`, `produit_prix`, `produit_qty`, `produit_fk_categories`) VALUES
(1, 'Bâton Hockey', 'Bâton ultra perfomant', '102.99', 13, 1),
(2, 'Jouet de robot', 'jouet de', '47.99', 2, 1),
(3, 'Mope', 'Mope pour les travailleurs', '20.00', 58, 5),
(5, 'Robot', 'Jouet de jeux pour les enfants', '20.99', 57, 5);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `utilisateur_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `utilisateur_type` varchar(255) NOT NULL,
  `utilisateur_nom` varchar(255) NOT NULL,
  `utilisateur_mot_passe` varchar(255) NOT NULL,
  PRIMARY KEY (`utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`utilisateur_id`, `utilisateur_type`, `utilisateur_nom`, `utilisateur_mot_passe`) VALUES
(1, 'A', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918'),
(2, 'G', 'gestion', '55971efb40a4a3e668c7997edfb68a8fe9ffc45798badc28062ef7682b856e17'),
(3, 'V', 'vendeur', '3fe6dd5dd172cef095720595fe45bac03bdfd9844d68a5b7dfc20320437aba92');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commande_fk_client` FOREIGN KEY (`commande_fk_client`) REFERENCES `clients` (`client_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `commandes_produits`
--
ALTER TABLE `commandes_produits`
  ADD CONSTRAINT `cp_fk_commandes` FOREIGN KEY (`cp_fk_commandes`) REFERENCES `commandes` (`commande_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cp_fk_produits` FOREIGN KEY (`cp_fk_produits`) REFERENCES `produits` (`produit_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produit_fk_categories` FOREIGN KEY (`produit_fk_categories`) REFERENCES `categories` (`categorie_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
