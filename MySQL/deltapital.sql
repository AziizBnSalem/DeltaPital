-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 07 mai 2025 à 10:21
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `deltapital`
--

-- --------------------------------------------------------

--
-- Structure de la table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `approved_appointments`
--

DROP TABLE IF EXISTS `approved_appointments`;
CREATE TABLE IF NOT EXISTS `approved_appointments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'approved',
  `approval_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `approved_appointments`
--

INSERT INTO `approved_appointments` (`id`, `user_name`, `date`, `time`, `status`, `approval_date`) VALUES
(13, 'a', '2025-05-22', '03:35:00', 'approved', '2025-05-07 02:34:18'),
(16, 'az', '2025-05-23', '03:40:00', 'approved', '2025-05-07 02:37:49'),
(17, 'client@gmail.com', '2025-05-08', '21:14:00', 'approved', '2025-05-07 08:14:14'),
(18, 'client@gmail.com', '2025-05-15', '21:14:00', 'approved', '2025-05-07 08:29:09'),
(20, 'client@gmail.com', '2025-05-27', '21:34:00', 'approved', '2025-05-07 08:33:01'),
(21, 'client@gmail.com', '2025-05-15', '21:34:00', 'approved', '2025-05-07 08:33:01'),
(23, 'client@gmail.com', '2025-05-09', '10:05:00', 'approved', '2025-05-07 09:12:43');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `user_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`user_name`, `date`, `time`) VALUES
('aziz', '2024-12-04', '05:42:00'),
('client', '2024-12-05', '17:44:00'),
('client', '2024-12-13', '13:46:00'),
('client', '2024-12-11', '14:36:00'),
('user', '2024-12-11', '15:23:00'),
('user', '2024-12-05', '03:26:00'),
('aziz', '2024-12-28', '15:32:00'),
('badia', '2024-12-28', '16:00:00'),
('badia', '2024-12-28', '16:01:00'),
('userr', '2025-01-15', '18:25:00'),
('userr', '2025-01-10', '18:30:00');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(0, 'med amine', 'aziz.ben@gmail.com', 'a', 'medecin', '2025-05-07 10:06:41', '2025-05-07 10:06:41'),
(0, 'Aziz', 'mohamedaziz.bensalem@gmail.com', 'a', 'user', '2025-05-07 10:04:37', '2025-05-07 10:04:37'),
(0, 'Medecin', 'Medecin@gmail.com', 'a', 'Medecin', '2025-05-07 10:02:42', '2025-05-07 10:02:42'),
(0, 'admin', 'admin@gmail.com', 'a', 'user_admin', '2025-05-07 10:02:10', '2025-05-07 10:02:10'),
(0, 'thouraya', 'aa.a.a.a@j', 'a', 'super_admin', '2025-05-07 10:09:07', '2025-05-07 10:09:07');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
