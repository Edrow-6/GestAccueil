-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 08 juin 2021 à 15:17
-- Version du serveur :  10.5.10-MariaDB-1:10.5.10+maria~buster
-- Version de PHP : 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gest_accueil`
--

-- --------------------------------------------------------

--
-- Structure de la table `identifiants`
--

CREATE TABLE `identifiants` (
  `nom` varchar(20) NOT NULL,
  `icon` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `identifiants`
--

INSERT INTO `identifiants` (`nom`, `icon`) VALUES
('Carte d\'identité', 'id-card-alt'),
('Passeport', 'passport'),
('Permis de conduire', 'id-badge');

-- --------------------------------------------------------

--
-- Structure de la table `motifs`
--

CREATE TABLE `motifs` (
  `nom` varchar(255) NOT NULL,
  `couleur` varchar(20) NOT NULL COMMENT 'gray, red, yellow, green, blue, indigo, purple, pink'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `motifs`
--

INSERT INTO `motifs` (`nom`, `couleur`) VALUES
('Intervenant', 'blue'),
('Technicien', 'green'),
('Touriste', 'yellow'),
('Visiteur', 'red');

-- --------------------------------------------------------

--
-- Structure de la table `statuts`
--

CREATE TABLE `statuts` (
  `nom` varchar(20) NOT NULL,
  `couleur` varchar(20) NOT NULL,
  `icon` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `statuts`
--

INSERT INTO `statuts` (`nom`, `couleur`, `icon`) VALUES
('en attente', 'yellow', 'clock'),
('expirée', 'gray', 'times-circle'),
('validée', 'green', 'check-circle');

-- --------------------------------------------------------

--
-- Structure de la table `visites`
--

CREATE TABLE `visites` (
  `id` int(11) NOT NULL,
  `type_id` varchar(20) DEFAULT NULL,
  `num_id` varchar(80) DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `societe` varchar(255) NOT NULL,
  `motif` varchar(255) NOT NULL,
  `lieu_rdv` varchar(255) NOT NULL,
  `commentaires` text NOT NULL,
  `date_arrivee` date NOT NULL,
  `heure_arrivee` time(5) NOT NULL,
  `date_depart` date NOT NULL,
  `heure_depart` time(5) NOT NULL,
  `statut` varchar(20) DEFAULT NULL,
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifie_le` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `visites`
--

INSERT INTO `visites` (`id`, `type_id`, `num_id`, `nom`, `prenom`, `societe`, `motif`, `lieu_rdv`, `commentaires`, `date_arrivee`, `heure_arrivee`, `date_depart`, `heure_depart`, `statut`, `cree_le`, `modifie_le`) VALUES
(35, NULL, '1500000000000', 'Dnst', 'Cédric', 'Dawbee', 'Touriste', 'Bureau du service Informatique', 'Ce commentaire', '2002-04-06', '06:30:00.00000', '2021-06-16', '06:01:00.00000', 'en attente', '2021-06-07 08:02:39', '2021-06-07 08:02:39'),
(36, 'Carte d\'identité', '1596809080', 'Test', 'Test', 'test', 'Technicien', 'Ici', 'Nope', '2002-04-06', '06:06:00.00000', '2002-06-04', '04:04:00.00000', 'validée', '2021-06-08 10:58:45', '2021-06-08 10:58:45'),
(37, NULL, NULL, 'Dujardin', 'Jean', 'Bricedenice', 'Touriste', 'Sur la plage', 'J\'aime faire du surf', '2021-04-09', '22:49:00.00000', '2021-05-15', '16:09:00.00000', 'en attente', '2021-06-07 08:40:16', '2021-06-07 08:40:16'),
(38, NULL, NULL, 'Dujardin', 'Jean', 'Bricedenice2', 'Touriste', 'Sur la plage', 'J\'aime faire du surf', '2021-04-09', '22:49:00.00000', '2021-05-15', '16:09:00.00000', 'en attente', '2021-06-07 08:36:04', '2021-06-07 08:36:04'),
(39, NULL, NULL, 'Calvin', 'Denissot', '', 'Visiteur', 'Devant la porte', '', '2021-04-02', '06:08:00.00000', '2021-06-20', '05:07:00.00000', 'en attente', '2021-06-07 08:29:28', '2021-06-07 08:29:28'),
(40, NULL, NULL, 'Morningstar', 'Lucifer', 'Enfer', 'Intervenant', 'Bureau du diable', '666', '2021-06-03', '12:50:00.00000', '2021-06-22', '19:48:00.00000', 'en attente', '2021-06-07 08:32:32', '2021-06-07 08:32:32'),
(41, 'Carte d\'identité', NULL, 'awoo', 'knoc', 'Néant', 'Technicien', 'Mamamiam', '', '2002-06-04', '10:10:00.00000', '6002-04-08', '16:07:00.00000', 'validée', '2021-06-08 10:58:41', '2021-06-08 10:58:41');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `identifiants`
--
ALTER TABLE `identifiants`
  ADD PRIMARY KEY (`nom`);

--
-- Index pour la table `motifs`
--
ALTER TABLE `motifs`
  ADD PRIMARY KEY (`nom`);

--
-- Index pour la table `statuts`
--
ALTER TABLE `statuts`
  ADD PRIMARY KEY (`nom`);

--
-- Index pour la table `visites`
--
ALTER TABLE `visites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `motifs_fk` (`motif`),
  ADD KEY `statuts_fk` (`statut`),
  ADD KEY `type_id_fk` (`type_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `visites`
--
ALTER TABLE `visites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `visites`
--
ALTER TABLE `visites`
  ADD CONSTRAINT `motifs_fk` FOREIGN KEY (`motif`) REFERENCES `motifs` (`nom`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `statuts_fk` FOREIGN KEY (`statut`) REFERENCES `statuts` (`nom`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `type_id_fk` FOREIGN KEY (`type_id`) REFERENCES `identifiants` (`nom`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
