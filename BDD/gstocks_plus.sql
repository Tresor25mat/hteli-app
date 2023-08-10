-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 16 août 2022 à 16:58
-- Version du serveur :  10.4.13-MariaDB
-- Version de PHP : 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gstocks_plus`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `ID_Article` varchar(100) NOT NULL,
  `ID_Cat_Article` int(10) UNSIGNED NOT NULL,
  `Cod_Article` varchar(20) NOT NULL,
  `Design_Article` varchar(100) NOT NULL,
  `Qte_Stock` int(11) NOT NULL,
  `PU` double NOT NULL,
  `PUA` double NOT NULL,
  `Cod_Barre` varchar(30) NOT NULL,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp(),
  `Date_Modif` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ID_Utilisateur` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`ID_Article`, `ID_Cat_Article`, `Cod_Article`, `Design_Article`, `Qte_Stock`, `PU`, `PUA`, `Cod_Barre`, `Date_Enreg`, `Date_Modif`, `ID_Utilisateur`) VALUES
('19b9f421ea3d490d04f129aa651b5863dec4cb1d', 4, '189', 'NOUVEAU', 150, 45000, 40000, '', '2022-07-23 04:03:40', '2022-07-24 03:28:54', 17),
('cca243faab3565ad65eb4b922a639bb05c970c8a', 5, 'SAP250', 'Costume', 28, 120000, 100000, '', '2022-07-23 12:09:01', '2022-07-23 12:12:22', 20);

-- --------------------------------------------------------

--
-- Structure de la table `article_stock`
--

CREATE TABLE `article_stock` (
  `ID_Article_Stock` varchar(100) NOT NULL,
  `ID_Article` varchar(100) NOT NULL,
  `Qte` int(11) NOT NULL,
  `Confirm` int(11) NOT NULL DEFAULT 0,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp(),
  `Date_Modif` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ID_Utilisateur` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `article_stock`
--

INSERT INTO `article_stock` (`ID_Article_Stock`, `ID_Article`, `Qte`, `Confirm`, `Date_Enreg`, `Date_Modif`, `ID_Utilisateur`) VALUES
('28e35da498f59e35501637c2538bd22c3a78e23a', '19b9f421ea3d490d04f129aa651b5863dec4cb1d', 100, 1, '2022-07-23 04:03:40', '2022-07-23 04:03:40', 17),
('6eae363f491c89f29ef811c938b2321f8ece5a12', '19b9f421ea3d490d04f129aa651b5863dec4cb1d', 10, 1, '2022-07-24 03:05:16', '2022-07-24 03:05:16', 17),
('9b40c5d273b02052885813e41a4e6f83f9900c13', 'cca243faab3565ad65eb4b922a639bb05c970c8a', 10, 1, '2022-07-23 12:10:17', '2022-07-23 12:10:17', 20),
('b23d66c035f21b0dd34ddc09277a00f8a5146216', 'cca243faab3565ad65eb4b922a639bb05c970c8a', 20, 1, '2022-07-23 12:09:01', '2022-07-23 12:09:01', 20),
('cbff7c3ef40b2fd0bb989e24ae8b1335a1a4a10f', '19b9f421ea3d490d04f129aa651b5863dec4cb1d', 20, 1, '2022-07-23 04:03:48', '2022-07-23 04:03:48', 17);

-- --------------------------------------------------------

--
-- Structure de la table `categorie_article`
--

CREATE TABLE `categorie_article` (
  `ID_Cat_Article` int(10) UNSIGNED NOT NULL,
  `Design_Cat_Article` varchar(50) NOT NULL,
  `ID_Utilisateur` int(10) UNSIGNED NOT NULL,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie_article`
--

INSERT INTO `categorie_article` (`ID_Cat_Article`, `Design_Cat_Article`, `ID_Utilisateur`, `Date_Enreg`) VALUES
(1, 'Matériels de réparation', 1, '2021-11-22 14:43:14'),
(2, 'Accessoires', 0, '2022-01-11 13:22:16'),
(4, 'TEST', 17, '2022-07-21 10:38:14'),
(5, 'Habillement', 20, '2022-07-23 12:05:22');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `ID_Commande` varchar(100) NOT NULL,
  `ID_Vente` varchar(100) NOT NULL,
  `ID_Article` varchar(100) NOT NULL,
  `Qte_Commande` int(10) UNSIGNED NOT NULL,
  `Confirm` int(11) NOT NULL DEFAULT 0,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp(),
  `Date_Modif` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ID_Utilisateur` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`ID_Commande`, `ID_Vente`, `ID_Article`, `Qte_Commande`, `Confirm`, `Date_Enreg`, `Date_Modif`, `ID_Utilisateur`) VALUES
('c2008fd787c525de2ad1df55232717b738d13529', '8d5210cd818bd1a6534f2c479b4d9acb8adf28f9', '19b9f421ea3d490d04f129aa651b5863dec4cb1d', 10, 1, '2022-07-24 03:28:51', '2022-07-24 03:28:54', 17),
('c2cd2c1e1e5d7abd7722ed5ebd984fc0fa701742', 'cb5ef94e960adbe971d369ab3e799c52340b25c1', 'cca243faab3565ad65eb4b922a639bb05c970c8a', 2, 0, '2022-07-23 12:12:09', '2022-07-23 12:12:09', 20),
('fc6530af6f2ca9f160468ad1098106e4c464b888', '28d4cec902d20e06816329093625ed1fe70644e4', '19b9f421ea3d490d04f129aa651b5863dec4cb1d', 25, 1, '2022-07-24 02:30:54', '2022-07-24 02:30:58', 17);

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE `entreprise` (
  `ID_Entreprise` int(10) UNSIGNED NOT NULL,
  `ID_Ville` int(10) UNSIGNED NOT NULL,
  `ID_Pays` int(10) UNSIGNED NOT NULL,
  `Design_Entreprise` varchar(50) NOT NULL,
  `Adresse` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `entreprise`
--

INSERT INTO `entreprise` (`ID_Entreprise`, `ID_Ville`, `ID_Pays`, `Design_Entreprise`, `Adresse`) VALUES
(1, 0, 0, 'GLOBAL TECHNOLOGIES SERVICES', ''),
(2, 0, 0, 'CRESMAC', 'Kinshasa'),
(3, 0, 0, 'CRESMAC', 'Kinshasa'),
(4, 14, 1, 'ENGEN', 'Ngiri-ngiri'),
(5, 1, 1, 'CRESMAC', 'Kinshasa');

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `ID_Profil` int(10) UNSIGNED NOT NULL,
  `Design_Profil` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`ID_Profil`, `Design_Profil`) VALUES
(1, 'Femme'),
(2, 'Homme');

-- --------------------------------------------------------

--
-- Structure de la table `table_client`
--

CREATE TABLE `table_client` (
  `ID_Client` varchar(100) NOT NULL,
  `Prenom` varchar(30) NOT NULL,
  `Nom` varchar(30) NOT NULL,
  `Pnom` varchar(30) NOT NULL,
  `Tel` varchar(15) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `ID_Utilisateur` int(10) UNSIGNED NOT NULL,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_client`
--

INSERT INTO `table_client` (`ID_Client`, `Prenom`, `Nom`, `Pnom`, `Tel`, `Email`, `ID_Utilisateur`, `Date_Enreg`) VALUES
('09a658d8abb516583fc606a4b825e069243d5485', 'Teste', 'Limba', '', '+24382 229 42 2', '', 15, '2021-11-29 11:29:48'),
('0a46e4893cb4e35a536034dcc31fcf4c9261a9b7', 'Junior', 'Hadisi', '', '+24382 229 42 2', '', 15, '2021-11-29 11:31:30'),
('0abfe3b9408a8a419fb98304dbb23a9364a0751e', 'test', 'Kapya', '', '+243820981313', '', 15, '2021-11-29 11:02:51'),
('10b51c6d7ae6b73d7538947220a3044b6f8d0c2c', 'Ladis', 'Mputu', '', '+24382 229 42 2', '', 15, '2021-11-29 11:20:30'),
('13233e06b3a56edf8ba8ed4356a3fbb60afb800a', 'Joel', 'Ikuma', '', '+24382 229 42 2', 'africaforward19@gmail.com', 15, '2021-11-29 11:39:47'),
('16cc98ea6a2146c9a4f56940f9921cd706d76540', 'Junior', 'Matondo', '', '+24382 229 42 2', '', 16, '2022-01-17 09:19:47'),
('2b87aaad9955a8b97546ac0bc641a92e76108e90', 'Junior', 'Matondo', '', '+24382 229 42 2', '', 15, '2021-11-29 14:37:35'),
('2e5b4858607a5749e95313c1e30cd7d82bb81f5d', 'Junior', 'Hadisi', '', '+243818073562', 'africaforward19@gmail.com', 15, '2021-11-29 10:57:22'),
('515e3e42f2ab1e4689fe9b93310ab8cf732cefa8', 'Trésor', 'Matondo', '', '+24382 229 42 2', '', 15, '2021-11-29 10:23:12'),
('7d533aa8d494529f7452890854bb06b11ebfcd47', 'Junior', 'Matondo', '', '+24382 229 42 2', '', 15, '2021-12-16 15:07:30'),
('828b205835c128a401c19753ded0f6a7bca40d1f', 'Junior', 'User', '', '+243818073562', 'matondotresor5@gmail.com', 15, '2021-12-22 09:36:15'),
('8c46b8644fb88b2b141cee7b1177ca5c0d15dc71', 'Tresor', 'Matondo', '', '+243818073562', '', 20, '2022-07-23 12:12:22'),
('925793e717a4976672a3ee5bfb17863dfd9d9116', 'test', 'User', '', '+24382 229 42 2', '', 15, '2021-11-29 11:27:01'),
('9656c6bb4bb2731e362082fd3733777cda679387', 'Tresor', 'Matondo', '', '+243818073562', '', 17, '2022-07-23 06:03:09'),
('a01246387e890aa349c942339443bd070164fd00', 'test', 'Kapya', '', '+243814353071', '', 16, '2022-01-15 14:03:55'),
('a676ddccc5497d68350dff4b3f3ca1333479444e', 'Jean', 'Limba', '', '+243819873603', '', 16, '2022-01-15 13:48:50'),
('b7158a42e38067a8b9f084be123aed8eed7b8d34', 'Junior', 'Hadisi', '', '+24382 229 42 2', '', 15, '2021-12-05 05:47:45'),
('b837b207d88cae2bb77990852f0a6f2a31511e9e', 'Junior', 'Hadisi', '', '+243841040033', '', 16, '2022-01-16 05:54:49'),
('c2a5d2523c02a88033d00b0787d787672caff6ef', 'Aurélie', 'Bazola', '', '+243814353071', '', 16, '2022-01-18 15:42:31'),
('f306bfd0b04e30db95e515d8f73fdcf0fe06a5d3', 'Judith', 'Matondo', '', '+243819873603', '', 16, '2022-01-15 15:41:03'),
('f5272187a592e1b9b1baf0194c916f1342d79c73', 'Judith', 'TSHIBI', '', '+243818073562', '', 17, '2022-07-24 02:31:26'),
('f66764076a97b9b155d10ab182ad59496c140f94', 'Judith', 'TSHIBI', '', '+243818073562', 'matondojudith5@gmail.com', 17, '2022-07-24 03:28:54');

-- --------------------------------------------------------

--
-- Structure de la table `table_pays`
--

CREATE TABLE `table_pays` (
  `ID_Pays` int(10) UNSIGNED NOT NULL,
  `Design_Pays` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_pays`
--

INSERT INTO `table_pays` (`ID_Pays`, `Design_Pays`) VALUES
(1, 'République Démocratique du Congo');

-- --------------------------------------------------------

--
-- Structure de la table `table_vente`
--

CREATE TABLE `table_vente` (
  `ID_Vente` varchar(100) NOT NULL,
  `ID_Client` varchar(100) NOT NULL,
  `Num_Facture` varchar(20) NOT NULL,
  `Date_Vente` date NOT NULL,
  `Montant_Paye` double NOT NULL,
  `Discount` double NOT NULL,
  `Confirm` int(11) NOT NULL DEFAULT 1,
  `Confirm_Discount` int(11) NOT NULL DEFAULT 0,
  `ID_Utilisateur` int(10) UNSIGNED NOT NULL,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp(),
  `Date_Modif` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_vente`
--

INSERT INTO `table_vente` (`ID_Vente`, `ID_Client`, `Num_Facture`, `Date_Vente`, `Montant_Paye`, `Discount`, `Confirm`, `Confirm_Discount`, `ID_Utilisateur`, `Date_Enreg`, `Date_Modif`) VALUES
('1b0c7b44c839680fe07fe795758a89f56afd64f4', '16cc98ea6a2146c9a4f56940f9921cd706d76540', '0010/GTS/KIN/2022', '2022-01-17', 22200, 0, 1, 0, 16, '2022-01-17 09:19:12', '2022-01-17 09:19:47'),
('28d4cec902d20e06816329093625ed1fe70644e4', '9656c6bb4bb2731e362082fd3733777cda679387', '0001/GSP/RES/2022', '2022-07-23', 1125000, 5000, 1, 0, 17, '2022-07-23 06:01:02', '2022-07-24 02:30:58'),
('373d8eb6cab36ad08927bb702f84796e3054ebac', '7d533aa8d494529f7452890854bb06b11ebfcd47', '0009/GTS/KIN/2021', '2021-12-16', 600000, 0, 1, 0, 15, '2021-12-16 15:04:13', '2021-12-16 15:07:31'),
('3bccb5808e4052fb871dbff9094be64f206c0d08', '2e5b4858607a5749e95313c1e30cd7d82bb81f5d', '0002/GTS/KIN/2021', '2021-11-29', 0, 0, 1, 0, 15, '2021-11-29 10:57:17', '2021-11-29 10:57:17'),
('3cd20cc2fbdac11199c44da6e2e8035f55502e6f', 'b7158a42e38067a8b9f084be123aed8eed7b8d34', '0008/GTS/KIN/2021', '2021-12-05', 8000, 0, 1, 0, 15, '2021-12-05 05:47:35', '2021-12-05 05:47:45'),
('61cb3ed76a894c503eecc43bb199c3660eb5fc6b', '515e3e42f2ab1e4689fe9b93310ab8cf732cefa8', '0001/GTS/KIN/2021', '2021-11-29', 0, 0, 1, 0, 15, '2021-11-29 10:23:00', '2021-11-29 10:23:00'),
('6f6a10fb07ce676e613d8c2f731e7bab00bdfcf3', '925793e717a4976672a3ee5bfb17863dfd9d9116', '0004/GTS/KIN/2021', '2021-11-29', 0, 0, 1, 0, 15, '2021-11-29 11:26:58', '2021-11-29 11:27:01'),
('726fa7bed812e4363861e81c234df3579b307402', '09a658d8abb516583fc606a4b825e069243d5485', '0005/GTS/KIN/2021', '2021-11-29', 0, 0, 1, 0, 15, '2021-11-29 11:29:43', '2021-11-29 11:29:49'),
('8bfd08850f84b5604f5630347453ed3a5162a439', '13233e06b3a56edf8ba8ed4356a3fbb60afb800a', '0006/GTS/KIN/2021', '2021-11-29', 2000, 0, 1, 0, 15, '2021-11-29 11:39:40', '2021-11-29 11:39:47'),
('8d5210cd818bd1a6534f2c479b4d9acb8adf28f9', 'f66764076a97b9b155d10ab182ad59496c140f94', '0002/GSP/RES/2022', '2022-07-24', 450000, 0, 1, 0, 17, '2022-07-24 03:28:51', '2022-07-24 03:28:54'),
('931a5d2e1ee59b51396de66094ee26c1308f069d', '0abfe3b9408a8a419fb98304dbb23a9364a0751e', '0003/GTS/KIN/2021', '2021-11-29', 0, 0, 1, 0, 15, '2021-11-29 11:02:46', '2021-11-29 11:02:46'),
('cb5ef94e960adbe971d369ab3e799c52340b25c1', '8c46b8644fb88b2b141cee7b1177ca5c0d15dc71', '0001/GSP/NGE/2022', '2022-07-23', 240000, 10000, 1, 0, 20, '2022-07-23 12:12:09', '2022-07-23 12:12:22'),
('eb6deb16bdd8f4fff230727a6db13592705a0de7', '2b87aaad9955a8b97546ac0bc641a92e76108e90', '0007/GTS/KIN/2021', '2021-11-29', 6000, 0, 1, 0, 15, '2021-11-29 14:37:30', '2021-11-29 14:37:35');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `ID_Utilisateur` int(10) UNSIGNED NOT NULL,
  `ID_Entreprise` int(10) UNSIGNED NOT NULL,
  `ID_Profil` int(10) UNSIGNED NOT NULL,
  `Prenom` varchar(30) NOT NULL,
  `Nom` varchar(30) NOT NULL,
  `Tel` varchar(15) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Login` varchar(30) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Photo` varchar(30) NOT NULL,
  `Statut` varchar(30) NOT NULL,
  `Etat` int(11) NOT NULL DEFAULT 0,
  `Active` int(11) NOT NULL DEFAULT 0,
  `Command` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ID_Utilisateur`, `ID_Entreprise`, `ID_Profil`, `Prenom`, `Nom`, `Tel`, `Email`, `Login`, `Password`, `Photo`, `Statut`, `Etat`, `Active`, `Command`) VALUES
(1, 0, 0, 'admin', '', '+243818073562', 'matondotresor5@gmail.com', 'admin', 'ef507e66a8f9cfb2243ce21f5bd6e41d101f5692', 'IMG_UTILISATEUR_83206140.JPG', 'Admin', 0, 1, 0),
(17, 2, 2, 'Tresor', 'Matondo', '+243818073562', 'matondotresor5@gmail.com', 'tresor.matondo2', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '', 'User', 0, 1, 0),
(20, 4, 1, 'Judith', 'Matondo', '+243818073562', 'matondojudith5@gmail.com', 'judith.matondo3', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '', 'User', 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `ID_Ville` int(10) UNSIGNED NOT NULL,
  `Design_Ville` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`ID_Ville`, `Design_Ville`) VALUES
(1, 'Kinshasa'),
(12, 'Kananga'),
(13, 'Moanda'),
(14, 'Matadi');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`ID_Article`),
  ADD KEY `ID_Cat_Article` (`ID_Cat_Article`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`);

--
-- Index pour la table `article_stock`
--
ALTER TABLE `article_stock`
  ADD PRIMARY KEY (`ID_Article_Stock`),
  ADD KEY `ID_Article` (`ID_Article`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`);

--
-- Index pour la table `categorie_article`
--
ALTER TABLE `categorie_article`
  ADD PRIMARY KEY (`ID_Cat_Article`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`ID_Commande`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`),
  ADD KEY `ID_Avion` (`ID_Vente`),
  ADD KEY `ID_Destination` (`ID_Article`),
  ADD KEY `ID_Taux` (`Qte_Commande`);

--
-- Index pour la table `entreprise`
--
ALTER TABLE `entreprise`
  ADD PRIMARY KEY (`ID_Entreprise`),
  ADD KEY `ID_Ville` (`ID_Ville`),
  ADD KEY `ID_Pays` (`ID_Pays`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`ID_Profil`);

--
-- Index pour la table `table_client`
--
ALTER TABLE `table_client`
  ADD PRIMARY KEY (`ID_Client`) USING BTREE,
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`);

--
-- Index pour la table `table_pays`
--
ALTER TABLE `table_pays`
  ADD PRIMARY KEY (`ID_Pays`);

--
-- Index pour la table `table_vente`
--
ALTER TABLE `table_vente`
  ADD PRIMARY KEY (`ID_Vente`),
  ADD KEY `ID_Agence` (`ID_Client`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`ID_Utilisateur`),
  ADD KEY `ID_Entreprise` (`ID_Entreprise`) USING BTREE,
  ADD KEY `ID_Profil` (`ID_Profil`);

--
-- Index pour la table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`ID_Ville`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie_article`
--
ALTER TABLE `categorie_article`
  MODIFY `ID_Cat_Article` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `entreprise`
--
ALTER TABLE `entreprise`
  MODIFY `ID_Entreprise` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `profil`
  MODIFY `ID_Profil` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `table_pays`
--
ALTER TABLE `table_pays`
  MODIFY `ID_Pays` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ID_Utilisateur` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `ID_Ville` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
