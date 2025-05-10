-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 10 mai 2025 à 17:32
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

DROP TABLE IF EXISTS `inscription_admin`;
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

DROP TABLE IF EXISTS `inscription_agent`;
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
('domingues', 'clara', '0000-00-00', 'clara@gmail.com', '', '', 'domingues.clara', '$2y$10$CccikOy/.mMjJADYChtpEerYfAv6xnVK4UK47cfGRx/thwnq5gQ8u', 'accepté'),
('prsn', 'test', '0000-00-00', 'testpersonne@gmail.com', '', '', 'prsn.test', '$2y$10$V1lWwcfDt1pjl5uaQQsFOeJDTFZEwijsNYqkxMOPAoT8BP8jXHeIS', 'accepté');

-- --------------------------------------------------------

--
-- Structure de la table `inscription_eleve`
--

DROP TABLE IF EXISTS `inscription_eleve`;
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
('samoura', 'diaba', '2025-05-23', 'mathus.samantha@gmail.com', '0660610636', '58 Rue René Leblond', '982132', 'MMI1', 'TD3', 'TPA', 'diabasmr', '$2y$10$QbQ6QLxPCv.RGRkVg8y/7Oii5holXJM4EG5FL5AppuAWays3CA8Ta', 'accepté');

-- --------------------------------------------------------

--
-- Structure de la table `inscription_prof`
--

DROP TABLE IF EXISTS `inscription_prof`;
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
('test', 'prof', '2025-05-23', 'test@gmail.com', '000000000', '1 rue de la rue', 'noob1233', '$2y$10$2A2vdyJezSPPt3oCUTYK7.Q5KaJ9Xh1Ba3F2wsCCOP5PxuCs85ofK', 'accepté');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `inscription_admin`
--
ALTER TABLE `inscription_admin`
  ADD PRIMARY KEY (`Pseudo`),
  ADD UNIQUE KEY `unique_email` (`Adresse_email`);

--
-- Index pour la table `inscription_agent`
--
ALTER TABLE `inscription_agent`
  ADD PRIMARY KEY (`Pseudo`);

--
-- Index pour la table `inscription_eleve`
--
ALTER TABLE `inscription_eleve`
  ADD PRIMARY KEY (`Pseudo`);

--
-- Index pour la table `inscription_prof`
--
ALTER TABLE `inscription_prof`
  ADD PRIMARY KEY (`Pseudo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
