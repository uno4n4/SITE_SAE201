-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 06 mai 2025 à 09:41
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `utilisateur`
--
CREATE DATABASE IF NOT EXISTS `utilisateur` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `utilisateur`;

-- --------------------------------------------------------

--
-- Structure de la table `inscription_admin`
--

CREATE TABLE `inscription_admin` (
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Date_naissance` date NOT NULL,
  `Adresse_email` varchar(100) NOT NULL,
  `Numero_tel` varchar(10) NOT NULL,
  `Adresse` varchar(70) NOT NULL,
  `Pseudo` varchar(30) NOT NULL,
  `Mdp` varchar(255) NOT NULL,
  `Statut` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `inscription_agent`
--

CREATE TABLE `inscription_agent` (
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Date_naissance` date NOT NULL,
  `Adresse_email` varchar(100) NOT NULL,
  `Numero_tel` varchar(10) NOT NULL,
  `Adresse` varchar(70) NOT NULL,
  `Pseudo` varchar(30) NOT NULL,
  `Mdp` varchar(255) NOT NULL,
  `Statut` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscription_agent`
--

INSERT INTO `inscription_agent` (`Nom`, `Prenom`, `Date_naissance`, `Adresse_email`, `Numero_tel`, `Adresse`, `Pseudo`, `Mdp`, `Statut`) VALUES
('Gilet', 'Amel Yamina', '0000-00-00', 'Aamel2432@gmail.com', '', '', '', '$2y$10$yWsvMu3c1G8ZDhTOtesYq.H', 'accepté');

-- --------------------------------------------------------

--
-- Structure de la table `inscription_eleve`
--

CREATE TABLE `inscription_eleve` (
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Date_naissance` date NOT NULL,
  `Adresse_email` varchar(100) NOT NULL,
  `Numero_tel` varchar(10) NOT NULL,
  `Adresse` varchar(70) NOT NULL,
  `Num_etudiant` varchar(10) NOT NULL,
  `Formation` varchar(10) NOT NULL,
  `Td` varchar(10) NOT NULL,
  `Tp` varchar(10) NOT NULL,
  `Pseudo` varchar(30) NOT NULL,
  `Mdp` varchar(255) NOT NULL,
  `Statut` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscription_eleve`
--

INSERT INTO `inscription_eleve` (`Nom`, `Prenom`, `Date_naissance`, `Adresse_email`, `Numero_tel`, `Adresse`, `Num_etudiant`, `Formation`, `Td`, `Tp`, `Pseudo`, `Mdp`, `Statut`) VALUES
('Mathus', 'samantha', '2025-05-30', 'mathus.samantha@gmail.com', '0606060606', '1 rue de la rue', '982132', 'MMI1', 'TD1', 'TPA', '1234', '$2y$10$RKBF7/C2NsKduB4AMikDtOEUJ4c7t4zwcSsfE9xp7g52bfpQPTJBq', 'accepté'),
('blabla', 'Amel', '2025-05-24', 'mathus.samantha@gmail.com', '0698473775', '58 Rue René Leblond', '982132', 'MMI1', 'TD2', 'TPA', 'test', '$2y$10$DyZT0HJA8fqW2oN7al5xgur1a.rt7AazUN/yrYkCfztSqbzQtlnou', 'accepté'),
('samoura', 'diaba', '2025-05-30', 'Aamel2432@gmail.com', '0660610636', '58 Rue René Leblond', '982132', 'MMI1', 'TD1', 'TPF', '1234', '$2y$10$f8.rtUUXWdt.PdJk5ytMAesPwlLDHH0xuzH4BhkdcIXDXjGqnmQ7m', 'accepté'),
('samoura', 'diaba', '2025-05-16', 'mathus.samantha@gmail.com', '0698473775', '58 Rue René Leblond', '982132', 'MMI3', 'TD1', 'TPA', '1234', '$2y$10$H4h0RLJwK.9ARPsw0xeEJuOZRZeUWy2o/FI.pJLCDxFnWg3qdVPCC', 'accepté');

-- --------------------------------------------------------

--
-- Structure de la table `inscription_prof`
--

CREATE TABLE `inscription_prof` (
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Date_naissance` date NOT NULL,
  `Adresse_email` varchar(100) NOT NULL,
  `Numero_tel` varchar(10) NOT NULL,
  `Adresse` varchar(70) NOT NULL,
  `Pseudo` varchar(30) NOT NULL,
  `Mdp` varchar(255) NOT NULL,
  `Statut` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscription_prof`
--

INSERT INTO `inscription_prof` (`Nom`, `Prenom`, `Date_naissance`, `Adresse_email`, `Numero_tel`, `Adresse`, `Pseudo`, `Mdp`, `Statut`) VALUES
('Mathus', 'samantha', '2025-05-31', 'mathus.samantha@gmail.com', '0606060606', '1 rue de la rue', 'noob1233', '$2y$10$nDyb0HEjG3So7x.d5UGpweO0GA8iiDabg0ADrv.gTKNWjaVy9Tc7e', 'refusé');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
