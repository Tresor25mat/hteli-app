-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 02 août 2022 à 15:20
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
-- Base de données : `bdd_sjl_data_wings`
--

-- --------------------------------------------------------

--
-- Structure de la table `agence`
--

CREATE TABLE `agence` (
  `ID_Agence` int(10) UNSIGNED NOT NULL,
  `ID_Cat_Agence` int(10) UNSIGNED NOT NULL,
  `ID_Ville` int(10) UNSIGNED NOT NULL,
  `Cod_Agence` varchar(30) NOT NULL,
  `Design_Agence` varchar(50) NOT NULL,
  `Nom_Contact` varchar(50) NOT NULL,
  `Adresse` varchar(50) NOT NULL,
  `Tel` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Commission` double NOT NULL,
  `Service_fee` double NOT NULL,
  `Fonds_disponible` double NOT NULL,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp(),
  `ID_Utilisateur` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `agence`
--

INSERT INTO `agence` (`ID_Agence`, `ID_Cat_Agence`, `ID_Ville`, `Cod_Agence`, `Design_Agence`, `Nom_Contact`, `Adresse`, `Tel`, `Email`, `Commission`, `Service_fee`, `Fonds_disponible`, `Date_Enreg`, `ID_Utilisateur`) VALUES
(5, 2, 1, '000001', 'COLLIBRI AIR', '', '', '', '', 10, 0, 5002, '2021-08-21 06:49:11', 1),
(6, 1, 1, '000002', 'SJL KINSHASA', '', '', '', '', 0, 0, 8190, '2021-08-21 07:48:15', 1),
(7, 2, 3, '000003', 'SJL KANANGA', '', '', '', '', 5, 0, 3500, '2021-08-21 07:59:13', 1),
(8, 2, 1, '000004', 'GENERAL INVESTMENT SERVICES', 'CHRISTIAN LOMOTO', '205, Avenue Mokoto', '+243818073562', 'tresor.matondo@chesd-rdc.org', 6, 0, 20000, '2021-09-15 09:19:16', 1);

-- --------------------------------------------------------

--
-- Structure de la table `agence_ville`
--

CREATE TABLE `agence_ville` (
  `ID_Agence_Ville` int(10) UNSIGNED NOT NULL,
  `ID_Agence` int(10) UNSIGNED NOT NULL,
  `ID_Ville` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `agence_ville`
--

INSERT INTO `agence_ville` (`ID_Agence_Ville`, `ID_Agence`, `ID_Ville`) VALUES
(2, 5, 5),
(4, 5, 2),
(8, 6, 8),
(9, 6, 4),
(10, 6, 5),
(11, 6, 9),
(12, 6, 3),
(13, 6, 1),
(14, 6, 7),
(15, 6, 10),
(16, 5, 4);

-- --------------------------------------------------------

--
-- Structure de la table `avion`
--

CREATE TABLE `avion` (
  `ID_Avion` int(10) UNSIGNED NOT NULL,
  `Design_Avion` varchar(30) NOT NULL,
  `Matriculation` varchar(30) NOT NULL,
  `Nombre_Places` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `avion`
--

INSERT INTO `avion` (`ID_Avion`, `Design_Avion`, `Matriculation`, `Nombre_Places`) VALUES
(1, 'EMBRAER ERJ145', 'D2-FIC', 50),
(2, 'EMBRAER ERJ135', 'D2-FIA', 37),
(3, 'EMBRAER ERJ135', 'D2-FIB', 37);

-- --------------------------------------------------------

--
-- Structure de la table `categorie_agence`
--

CREATE TABLE `categorie_agence` (
  `ID_Cat_Agence` int(10) UNSIGNED NOT NULL,
  `Design_Cat_Agence` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie_agence`
--

INSERT INTO `categorie_agence` (`ID_Cat_Agence`, `Design_Cat_Agence`) VALUES
(1, 'Agences SJL'),
(2, 'Agences Partenaires');

-- --------------------------------------------------------

--
-- Structure de la table `categorie_passager`
--

CREATE TABLE `categorie_passager` (
  `ID_Cat_Passager` int(10) UNSIGNED NOT NULL,
  `Design_Cat_Passager` varchar(30) NOT NULL,
  `Code_Cat_Passager` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie_passager`
--

INSERT INTO `categorie_passager` (`ID_Cat_Passager`, `Design_Cat_Passager`, `Code_Cat_Passager`) VALUES
(1, 'Adulte', 'ADT'),
(2, 'Enfant', 'CHD'),
(3, 'Bébé', 'INF');

-- --------------------------------------------------------

--
-- Structure de la table `categorie_vol`
--

CREATE TABLE `categorie_vol` (
  `ID_Cat_Vol` int(10) UNSIGNED NOT NULL,
  `Design_Cat_Vol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie_vol`
--

INSERT INTO `categorie_vol` (`ID_Cat_Vol`, `Design_Cat_Vol`) VALUES
(1, 'Aller-Retour'),
(2, 'Aller simple');

-- --------------------------------------------------------

--
-- Structure de la table `couleur_bagage`
--

CREATE TABLE `couleur_bagage` (
  `ID_Couleur` int(10) UNSIGNED NOT NULL,
  `Design_Couleur` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `nature_bagage`
--

CREATE TABLE `nature_bagage` (
  `ID_Nature` int(10) UNSIGNED NOT NULL,
  `Design_Nature` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Structure de la table `rapport_mail`
--

CREATE TABLE `rapport_mail` (
  `ID_Rapport` int(10) UNSIGNED NOT NULL,
  `Email` text NOT NULL,
  `Statut` varchar(50) NOT NULL,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `rapport_mail`
--

INSERT INTO `rapport_mail` (`ID_Rapport`, `Email`, `Statut`, `Date_Enreg`) VALUES
(1, 't.matondo@sjlaeronauticacongo-rdc.com, m.mbengani@sjlaeronauticacongo-rdc.com, ', 'Message envoyé', '2022-08-01 16:19:24');

-- --------------------------------------------------------

--
-- Structure de la table `table_aeroport`
--

CREATE TABLE `table_aeroport` (
  `ID_Aeroport` int(10) UNSIGNED NOT NULL,
  `ID_Ville` int(10) UNSIGNED NOT NULL,
  `Design_Aeroport` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_aeroport`
--

INSERT INTO `table_aeroport` (`ID_Aeroport`, `ID_Ville`, `Design_Aeroport`) VALUES
(1, 1, 'Aéroport International de N\'Djili'),
(2, 2, 'Aéroport de Mbuji Mayi'),
(3, 3, 'Aéroport de Kananga'),
(4, 5, 'Aéroport de Gemana'),
(5, 4, 'Aéroport de Gbadolite'),
(6, 6, 'Aéroport International de Lubumbashi'),
(7, 8, 'Aéroport de Buta Zega'),
(8, 7, 'Aéroport de Bunia'),
(9, 10, 'Aéroport de Kisangani'),
(10, 9, 'Aéroport d\'Isiro'),
(11, 11, 'Aéroport de Mbandaka'),
(12, 0, 'Aéroport de Goma');

-- --------------------------------------------------------

--
-- Structure de la table `table_annee`
--

CREATE TABLE `table_annee` (
  `ID_Annee` int(10) UNSIGNED NOT NULL,
  `Design_Annee` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `table_bagage`
--

CREATE TABLE `table_bagage` (
  `ID_Bagage` varchar(100) NOT NULL,
  `ID_Nature` int(10) UNSIGNED NOT NULL,
  `ID_Couleur` int(10) UNSIGNED NOT NULL,
  `ID_Passager_Vol` varchar(100) NOT NULL,
  `Numero_Bagage` varchar(10) NOT NULL,
  `Nombre` int(11) NOT NULL,
  `Poids` int(11) NOT NULL,
  `Observation` varchar(30) NOT NULL,
  `ID_Utilisateur` int(10) UNSIGNED NOT NULL,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `table_civilite`
--

CREATE TABLE `table_civilite` (
  `ID_Civilite` int(10) UNSIGNED NOT NULL,
  `Design_Civilite` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_civilite`
--

INSERT INTO `table_civilite` (`ID_Civilite`, `Design_Civilite`) VALUES
(1, 'Mr'),
(2, 'Mme'),
(3, 'Mlle');

-- --------------------------------------------------------

--
-- Structure de la table `table_classe`
--

CREATE TABLE `table_classe` (
  `ID_Classe` int(10) UNSIGNED NOT NULL,
  `Design_Classe` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_classe`
--

INSERT INTO `table_classe` (`ID_Classe`, `Design_Classe`) VALUES
(1, 'Economique '),
(2, 'Business'),
(3, 'First Class VIP');

-- --------------------------------------------------------

--
-- Structure de la table `table_client`
--

CREATE TABLE `table_client` (
  `ID_Client` varchar(100) NOT NULL,
  `ID_Civilite` int(10) UNSIGNED NOT NULL,
  `ID_Particularite` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `ID_Cat_Passager` int(10) UNSIGNED NOT NULL,
  `Prenom` varchar(30) NOT NULL,
  `Nom` varchar(30) NOT NULL,
  `Pnom` varchar(30) NOT NULL,
  `Sexe` varchar(1) NOT NULL,
  `Date_Naissance` date NOT NULL,
  `ID_Pays` int(10) UNSIGNED NOT NULL,
  `Num_Piece` varchar(30) NOT NULL,
  `Date_Expiration_Piece` date NOT NULL,
  `Tel` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Remarque` text DEFAULT NULL,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp(),
  `ID_Utilisateur` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_client`
--

INSERT INTO `table_client` (`ID_Client`, `ID_Civilite`, `ID_Particularite`, `ID_Cat_Passager`, `Prenom`, `Nom`, `Pnom`, `Sexe`, `Date_Naissance`, `ID_Pays`, `Num_Piece`, `Date_Expiration_Piece`, `Tel`, `Email`, `Remarque`, `Date_Enreg`, `ID_Utilisateur`) VALUES
('054fe008bfe8995d512fbfb13db837464277538c', 2, 0, 1, 'Rodette', 'Lumengo', 'Kiala', 'F', '2009-12-25', 1, '18032', '2021-09-22', '243818073562', 'jeanlimba@gmail.com', '', '2021-09-21 15:13:08', 1),
('08c8835a95d6de68c1c99204550756fbe5a46c0e', 2, 0, 2, 'HORNELLA', 'MAKETO', 'NGIZULU', 'F', '1995-05-14', 1, '250225', '2024-01-01', '+243818073562', '', NULL, '2022-08-01 04:56:59', 1),
('08ecc311f9097c51091bd2acce97d82ba2c0c3ae', 1, 0, 1, 'TRESOR', 'BAZOLA', 'NSANA', 'M', '1930-01-01', 1, '18032', '2021-10-07', '+243818073562', '', NULL, '2022-03-23 04:23:41', 1),
('0a8047594eb3f6f10b4164387d233270f85f5834', 1, 0, 1, 'Tresor', 'Matondo', 'Mvuete', 'M', '1992-03-18', 1, '18032', '2023-12-31', '+243818073562', 'tresor.matondo@chesd-rdc.org', 'RAS', '2021-08-30 13:33:57', 1),
('0adbcc82eedfef5c16d4695b548784888a18dabc', 2, 0, 1, 'Gina', 'Nsendo', '', 'F', '2009-12-18', 1, '180325', '2021-09-18', '2147483647', 'africaforward19@gmail.com', '', '2021-09-16 14:46:14', 1),
('0b6bfe8e8d4201c00f4f5afc0f9fa997d10d547e', 1, 0, 1, 'Epee-Samuel', 'Lagie', '', 'M', '2009-12-24', 1, '18032', '2021-09-30', '+243818073562', '', '', '2021-09-21 16:25:53', 1),
('0b6cd4e3b75fdeb313a755f681ba4a91734287de', 1, 0, 1, 'MBWEBWA', 'LUABO ', '', 'M', '2069-05-14', 1, '1643383', '2027-01-15', '5363062586', '', NULL, '2022-04-02 13:36:48', 1),
('13836d31e1cb7e78e0b2b1edfcfddb6e04c8bce1', 1, 0, 1, 'Aurelie', 'Matondo', 'Matondo', 'M', '2009-12-17', 1, '180325', '2021-09-22', '243818073562', 'aureliebazola27@gmail.com', '', '2021-09-20 06:17:07', 1),
('156affa961bf3697c0ec5449a078cf715d1e8560', 1, 0, 1, 'AURELIE', 'MATONDO', 'TENGELA', 'M', '1960-03-11', 1, '18032', '2022-03-23', '+243818073562', '', NULL, '2022-03-23 10:47:11', 1),
('15d9b4f6e269879d9814e20d57224757045a1e9f', 2, 0, 2, 'HORNELLA', 'MAKETO', 'NGIZULU', 'F', '1995-05-14', 1, '250225', '2024-01-01', '+243818073562', '', NULL, '2022-03-22 09:41:38', 1),
('16c1cb7142ac495708cf8c0ee5e4a35ea3a24ef0', 1, 0, 1, 'Nouveau', 'Matondo', 'Mvuete', 'M', '2009-12-25', 1, '18032', '2021-09-23', '243818073562', 'tresor.matondo@chesd-rdc.org', '', '2021-09-20 04:35:31', 1),
('17beb888384ade9cb3e22309ed04992ad1082357', 1, 0, 1, 'a', 'Bazola', 'a', 'M', '2009-12-11', 1, '18032', '2021-09-22', '243895163263', 'tresor.matondo@chesd-rdc.org', '', '2021-09-20 06:09:35', 1),
('18ca9777ae1267a7da13962b65cc51ed6c79a11e', 1, 0, 1, 'BIENVENUE', 'LOLA', 'WA LOLA', 'M', '1995-05-13', 1, '18032', '2023-06-30', '+243818073562', '', NULL, '2022-03-30 08:52:14', 1),
('1b79a4ff98d21e2157d642537352d8ab11524e58', 2, 0, 1, 'HORNELLA', 'MAKETO', 'NGIZULU', 'F', '1995-05-14', 1, '250225', '2024-01-01', '+243818073562', '', NULL, '2021-11-03 08:44:19', 1),
('1d635c79874be9fb0805827ba0cdebb715e5d4b0', 2, 0, 1, 'JACQUELINE', 'NKOSO  ', 'LOKAKAO', 'F', '2069-05-14', 1, '3036541', '2030-01-29', '9874724996', '', NULL, '2022-04-02 13:36:50', 1),
('1de6a7d6f536d9f6e5154da16451be795998952e', 1, 0, 1, 'BIENVENUE', 'LOLA', 'WA LOLA', 'M', '1995-05-13', 1, '18032', '2023-06-30', '+243818073562', '', NULL, '2021-11-04 11:06:57', 1),
('1e4ecd9b181f480f35b1bfe6d4c273790bc4e004', 1, 0, 1, 'Didi', 'Wandango', 'Dekayo', 'M', '2009-12-24', 1, '180325', '2021-09-23', '243818073562', 'jeanlimba@gmail.com', '', '2021-09-21 12:41:53', 1),
('1e5613d1c0685fd110d69ff3f42dd45ba63c78d3', 1, 0, 3, 'SERGE', 'MASUMU', 'NGUVULU', 'M', '1995-05-15', 1, '250225', '2024-01-02', '+243818073562', '', NULL, '2022-03-30 08:52:14', 1),
('1e76cd0011c5f1fd20db9ca3668e093036d08bff', 2, 0, 1, 'Ange', 'Nzuzi', 'Mvuete', 'F', '2002-11-12', 1, '180325', '2023-12-31', '2147483647', 'jhadisitombo@gmail.com', '', '2021-09-04 04:13:29', 1),
('1ecb9a08811911e6f593f4ddbe7797e857a46614', 1, 0, 3, 'SERGE', 'MASUMU', 'NGUVULU', 'M', '1995-05-15', 1, '250225', '2024-01-02', '+243818073562', '', NULL, '2022-08-01 04:59:33', 1),
('1ef8310a159cefad872f9beb3bfdb0a5ce042994', 1, 0, 3, 'SERGE', 'MASUMU', 'NGUVULU', 'M', '1995-05-15', 1, '250225', '2024-01-02', '+243818073562', '', NULL, '2021-11-04 11:07:00', 1),
('1f9f07a6ef489f9f72a0bea0657960184dde1a87', 1, 0, 1, 'CRISPIN', 'KABUE ', 'KABUE ', 'M', '1987-05-13', 1, '2339962', '2028-07-23', '7618893791', '', NULL, '2022-04-02 13:36:49', 1),
('20e7af747ff8ad99210a25a47e33d5dafe3ae83a', 1, 0, 1, 'JONATHAN', 'MASIALA', 'MVUETE', 'M', '1960-03-18', 1, '18032', '2021-10-07', '+243818073562', '', NULL, '2022-03-22 23:19:25', 1),
('21302f5d3ac59b25bb41806c2fee20967553d81a', 1, 0, 1, 'PIERRE', 'KAYEMBE', 'NKONGOLO ', 'M', '1987-05-13', 1, '18032', '2023-06-30', '99456441', '', NULL, '2022-04-02 13:36:45', 1),
('23418c2d6a5655a2d9c751e826d46340c83a181b', 1, 0, 1, 'Herve', 'Kabwe', 'Kasongo', 'M', '1990-12-12', 1, '180325', '2023-12-31', '2147483647', '', '', '2021-09-02 14:58:36', 1),
('24dc3021996ba55c57b4c69c7c5c761b57e7a02f', 1, 0, 1, 'TRESOR', 'MATONDO', 'MATONDO', 'M', '1980-07-13', 1, '8795557', '2021-10-07', '+243818073562', '', NULL, '2022-04-01 11:33:01', 1),
('257180fc80fb282bd7c10d19cbabcd99f5031e70', 1, 0, 1, 'JONATHAN', 'MASIALA', 'MVUETE', 'M', '1987-06-05', 1, '18032', '2021-11-04', '+243818073562', '', NULL, '2021-11-04 10:53:48', 1),
('2611fd2ff82e4b6c180ed4d237f4d843a8bff02c', 1, 0, 1, 'BIENVENUE', 'LOLA', 'WA LOLA', 'M', '1995-05-13', 1, '18032', '2023-06-30', '+243818073562', '', NULL, '2021-11-12 11:09:17', 1),
('274679a7c93916c74c73d96ef0da6ccbe94185fb', 1, 0, 1, 'Danau', 'Mambando', '', 'M', '2009-12-24', 1, '180325', '2021-09-29', '243818073562', '', '', '2021-09-21 16:22:04', 1),
('2784c943e2c4975880485eecc1d5f6eb7f0a4740', 1, 0, 1, 'TRESOR', 'MATONDO', 'MVUETE', 'M', '1970-01-01', 1, '18032', '2021-10-07', '+243820465078', 'tresor.matondo@chesd-rdc.org', '', '2021-10-26 10:18:51', 7),
('28a19b2373c76003f980302c53ce33d90064d5da', 2, 0, 1, 'Judith', 'Matondo', 'Matumona', 'F', '2009-12-03', 1, '18032', '2021-09-25', '2147483647', 'jeanlimba@gmail.com', '', '2021-09-17 13:47:52', 1),
('292a5b81dbc9223231e24e3952de3a9f30b064d2', 2, 0, 2, 'HORNELLA', 'MAKETO', 'NGIZULU', 'F', '1995-05-14', 1, '250225', '2024-01-01', '+243818073562', '', NULL, '2022-03-26 10:17:38', 1),
('2cca1325cc73b88d5547ea933ee80619508adf9c', 2, 0, 1, 'LAGINE', 'PIPINA', '', 'F', '2009-12-17', 1, '180325', '2021-09-23', '243818073562', '', '', '2021-09-22 18:50:33', 1),
('2d80c0965d99f7320a723110c37a0c2a5b88d017', 1, 0, 1, 'Malachie', 'Mbengani', 'Makiadi', 'M', '1990-12-12', 1, '18032', '2023-12-31', '2147483647', 'aureliebazola27@gmail.com', 'RAS', '2021-08-31 05:39:45', 1),
('2de2b2a5992f77e68a1ae42e21aa8904578c31f5', 2, 0, 1, 'JEANNE', 'MAMBELE', '', 'F', '2009-12-23', 1, '180325', '2021-09-30', '243895163263', '', '', '2021-09-22 18:44:32', 1),
('3011c266dadfe79ab29d775d0e7b437cdc42a03d', 1, 0, 1, 'DIDIER', 'KALOMBO', ' KABAMBA ', 'M', '1987-05-13', 1, '3268734', '2030-08-02', '10626668731', '', NULL, '2022-04-02 13:36:51', 1),
('30187b78007974be43dd1ff787193c78699e7b70', 1, 0, 1, 'Tresor', 'TRESOR MVUETE', 'Matondo', 'M', '2009-12-24', 1, '18032', '2021-09-23', '243895163263', '', '', '2021-09-20 05:35:30', 1),
('306d66c7650f61ee2ea74df60f94a5df7a38d0c0', 2, 0, 2, 'HORNELLA', 'MAKETO', 'NGIZULU', 'F', '1995-05-14', 1, '250225', '2024-01-01', '+243818073562', '', NULL, '2021-11-12 11:09:18', 1),
('3125a18e6e8eafeb516215ec5b6156b70c9f8ec6', 1, 0, 1, 'ANDRE', 'RWAHERU', 'RUHURA', 'M', '2009-12-10', 1, '180325', '2021-09-23', '243895163263', '', '', '2021-09-22 18:53:20', 1),
('3129828b4b15d7237f1740a6f479a7e57dad3ee4', 2, 0, 1, 'EULALIE', 'KUEDOLO', 'NGOMA', 'F', '1960-03-18', 1, '180323', '2021-10-08', '+243818073562', '', NULL, '2022-03-28 05:25:40', 7),
('31333f6c31adb2a4bf56378470ea5e31e0aa0a18', 1, 0, 1, 'Olivier', 'Bialufu', 'Nsana', 'M', '1971-03-18', 1, '18032', '2021-09-24', '2147483647', 'jeanlimba@gmail.com', '', '2021-09-16 11:41:42', 1),
('34afb859cc6beef0a56449ee069d9a024f3485f4', 2, 0, 1, 'HELèNE', 'KIOWA', 'NGOMA', 'F', '1960-03-11', 1, '8795557', '2021-10-07', '+243818073562', '', NULL, '2022-04-06 07:30:08', 1),
('35734729b3bf6c5be27adea2a8ee3ab736fa42fb', 1, 0, 1, 'BIENVENUE', 'LOLA', 'WA LOLA', 'M', '1995-05-13', 1, '18032', '2023-06-30', '+243818073562', '', NULL, '2022-03-26 10:17:38', 1),
('377d29230d5e5d213ad2e7a28fb38baa77bae1e4', 3, 0, 3, 'AURELIE', 'MATONDO', 'MVUETE', 'F', '2022-04-06', 1, '25524', '2021-10-06', '243820465078', '', NULL, '2022-04-06 07:59:51', 1),
('37a6a657966cc45edc532c0579f514e69d225a7b', 1, 0, 1, 'Serge', 'Ntoro', 'Andjana', 'M', '1930-01-01', 1, '18032', '2021-07-10', '243818073562', 'matondotresor5@gmail.com', 'RAS', '2021-10-05 11:16:46', 1),
('37c0cd1ffe289b118a280b0861dd814bcb399b03', 1, 0, 1, 'Dieudo', 'Nkembo', 'Mvuete', 'M', '1996-02-02', 1, '180325', '2023-12-25', '2147483647', 'matondotresor5@gmail.com', '', '2021-09-04 03:29:14', 1),
('3870bbcb1e31f72c6a7b718d79b2f88a64fac811', 1, 0, 1, 'Olivier', 'Bialufu', 'Nsana', 'M', '1970-10-25', 1, '180325', '2023-12-31', '+243818073562', 'aureliebazola27@gmail.com', '', '2021-09-03 10:26:48', 1),
('39479288a5c68081f85eb06f29dbe97e8ea7b35c', 2, 0, 2, 'HORNELLA', 'MAKETO', 'NGIZULU', 'F', '1995-05-14', 1, '250225', '2024-01-01', '+243818073562', '', NULL, '2021-11-04 11:06:59', 1),
('3bce2585d392b7ab1278a24a6116c72a901f1ec0', 1, 0, 1, 'DIDIER', 'KALOMBO', ' KABAMBA ', 'M', '1987-05-13', 1, '3268734', '2030-08-02', '10626668731', '', NULL, '2022-04-02 12:25:54', 1),
('3c942521c8425574efec1d4dd9558105dace298c', 1, 0, 1, 'Francois', 'Zioko', 'Mbenza', 'M', '2009-12-17', 1, '180325', '2021-09-23', '243818073562', 'jhadisitombo@gmail.com', '', '2021-09-21 13:12:04', 1),
('3eea54525949e7e223dc9807f49b1929da99eb5d', 1, 0, 1, 'BIENVENUE', 'LOLA', 'WA LOLA', 'M', '1995-05-13', 1, '18032', '2023-06-30', '+243818073562', '', NULL, '2021-11-04 10:49:16', 1),
('3fe3d9785c1a1b235747c766e303496fdc373550', 1, 0, 1, 'Tresor', 'Matondo', 'Mvuete', 'M', '1990-03-18', 1, '18032', '2021-10-01', '243818073562', '', '', '2021-09-30 09:45:11', 1),
('407ec6fbba150d63971d45c3d28446c33a0a0284', 1, 0, 1, 'KABEYA', 'NKONGOLO ', '', 'M', '2033-05-17', 1, '714611', '2025-01-05', '2355287646', '', NULL, '2022-04-02 12:25:51', 1),
('412978d8eadf20995fca9f7cfed7df6447e3515a', 2, 0, 1, 'HORNELLA', 'MAKETO', 'NGIZULU', 'F', '1995-05-14', 1, '250225', '2024-01-01', '+243818073562', '', NULL, '2021-11-03 09:55:44', 1),
('4271af83142a1cde3e992eb03cc61543b9842720', 1, 0, 1, 'Jonathan', 'Masiala', 'Mvuete', 'M', '2009-12-17', 1, '18032', '2021-09-23', '243895163263', 'jeanlimba@gmail.com', '', '2021-09-20 04:27:32', 1),
('43e85d77d9595173eadf27edd849b0d7373411bc', 1, 0, 1, 'Malachie', 'Mbengani', 'Makiadi', 'M', '1990-02-25', 1, '180325', '2023-12-31', '2147483647', 'matondotresor5@gmail.com', '', '2021-09-02 09:50:34', 1),
('445c33fcb33c721dc28a34877bac13ff83f4fdff', 2, 0, 1, 'MAGUY', 'NGOY ', 'MASANKA ', 'F', '1987-05-13', 1, '2804348', '2029-07-28', '9122781261', '', NULL, '2022-04-02 13:36:50', 1),
('45e6886e70a22abdf632612e547d1636ae2a3abf', 2, 0, 1, 'MELANI', 'YAKELI', 'YAPENZEKULA', 'F', '2009-12-25', 1, '18032', '2021-09-28', '243818073562', '', '', '2021-09-22 18:51:58', 1),
('46cc28834d56bb265a66c0fb93bd6e550c48bd7d', 1, 0, 1, 'VINCENT', 'KITSA', 'MBWECKY', 'M', '2009-12-17', 1, '180325', '2021-09-29', '243818073562', '', '', '2021-09-22 18:49:19', 1),
('4747876a2754039fba2a7736105ec29d231c2bdd', 1, 0, 1, 'Ladis', 'Mputu', 'Betu', 'M', '1960-12-31', 1, '18032', '2021-09-25', '243895163263', 'tresor.matondo@chesd-rdc.org', '', '2021-09-20 13:01:39', 1),
('47c91172f98d54a212ac317720eacb7a4759a81c', 1, 0, 1, 'Jonathan', 'Masiala', 'Mvuete', 'M', '2009-12-10', 1, '180325', '2021-09-22', '243895163263', '', '', '2021-09-20 06:02:30', 1),
('4917fa5cea1e284d940258cb7f47e1495b991e32', 2, 0, 1, 'EULALIE', 'KUEDOLO', 'NGOMA', 'F', '1960-03-18', 1, '8795557', '2021-10-07', '+243818073562', '', NULL, '2022-03-26 02:28:22', 1),
('49f686b382d57a87529e127de17a5cfc1f221ca6', 1, 0, 1, 'Eric', 'Mahese', 'Nlabanita', 'M', '2009-12-24', 1, '18032', '2021-09-24', '243818073562', '', '', '2021-09-21 16:27:58', 1),
('4cc9b5fb4322d679f6bc69176dd7f72ff5f01fbf', 1, 0, 1, 'Joseph', 'Lukondji', 'Kasongo', 'M', '1960-06-30', 1, '180325', '2023-12-31', '2147483647', 'jeanlimba@gmail.com', '', '2021-09-10 14:30:07', 1),
('4ecf6ffe85e98700c7653cacd8e2ffc4464348a8', 2, 0, 1, 'Elena', 'Dedebha', 'Amayo', 'F', '2009-12-24', 1, '18032', '2021-09-22', '243895163263', '', '', '2021-09-21 14:59:36', 1),
('4f3d2cac7888a97aace6bb4ce0a50381e644a4af', 1, 0, 1, 'AUGUSTIN', 'KASHALA ', '', 'M', '2069-05-14', 1, '3965313', '2032-02-08', '12882499936', '', NULL, '2022-04-02 13:36:51', 1),
('51881a511fba908a45a96a4ce70bc7021fe66cf4', 1, 0, 3, 'Mankueno', 'Nsila', '', 'M', '2021-09-16', 1, '18032', '2021-09-23', '243818073562', 'tresor.matondo@chesd-rdc.org', '', '2021-09-21 15:27:13', 1),
('518ce530c0154d2d09adac09b49ef18e524ee7d6', 1, 0, 1, 'AUGUSTIN', 'KASHALA ', '', 'M', '2069-05-14', 1, '3965313', '2032-02-08', '12882499936', '', NULL, '2022-04-02 12:25:54', 1),
('52e99cf92c0b73e5dbfc9896669f46549041f11c', 1, 0, 1, 'Ange', 'Nzuzi', 'Mvuete', 'M', '2009-12-27', 1, '18032', '2021-09-22', '243818073562', 'jhadisitombo@gmail.com', 'RAS', '2021-09-20 05:41:24', 1),
('53933ceedf738e95b6e84310540a3fffb73158fd', 2, 0, 1, 'Antoinette', 'Moni Kutido', 'Kamba', 'F', '2009-12-24', 1, '18032', '2021-09-22', '243818073562', '', '', '2021-09-21 15:45:56', 1),
('567ead7f40d19af84e341aa4e35426e1b0225f49', 1, 0, 1, 'TSHIKALA', 'NKUBA ', '', 'M', '2069-05-14', 1, '2572155', '2029-01-24', '8370837526', '', NULL, '2022-04-02 13:36:50', 1),
('5852b979a8e83cb37d88a5c4f09ef78292af42f2', 1, 0, 1, 'Isaac', 'Kayamba', 'Ilembejeka', 'M', '1987-06-05', 1, '18032', '2021-10-07', '+243818073562', '', '', '2021-10-20 11:04:48', 1),
('58ce1fca8d2ab132054d3c82dbc14a76605c483e', 1, 0, 1, 'TEST', 'TEST', 'TEST', 'M', '1960-03-18', 1, '8795557', '2022-04-08', '+243818073562', '', NULL, '2022-04-22 14:03:08', 7),
('59b13646bf426db4b7cb63491428c56e3378d196', 1, 0, 1, 'Tresor', 'Bazola', 'Matumona', 'M', '2009-12-17', 1, '18032', '2021-09-22', '243818073562', 'jhadisitombo@gmail.com', '', '2021-09-20 05:34:12', 1),
('5e51ffea2385b4d573c5e2e63493a7ce69894688', 1, 0, 1, 'TRéSOR', 'MATONDO', 'MVUETE', 'M', '1960-03-18', 1, '12455', '2023-12-12', '+243818073562', 'matondotresor5@gmail.com', NULL, '2022-07-04 23:40:03', 1),
('5fa08b601c643023ff64d924e1fd033eb0e5e185', 1, 0, 1, 'Malachie', 'Mbengani', 'Makiadi', 'M', '2009-12-11', 1, '180325', '2021-10-01', '243895163263', 'aureliebazola27@gmail.com', '', '2021-09-20 15:14:45', 1),
('612c8f06b272cb2105568b027aef07fa73aaec0a', 2, 0, 1, 'JACQUELINE', 'NKOSO  ', 'LOKAKAO', 'F', '2069-05-14', 1, '3036541', '2030-01-29', '9874724996', '', NULL, '2022-04-02 12:25:53', 1),
('61c317d3d4a9980223d8b7d19ff68fa048b9698f', 1, 0, 1, 'Ekuke', 'Oleko', '', 'M', '2009-12-24', 1, '180325', '2021-09-23', '243818073562', '', '', '2021-09-21 16:29:07', 1),
('63453edbdba72dcfe2e836c2b39a4d351cff8950', 1, 0, 1, 'Anicet', 'Mokonzi', '', 'M', '2009-12-24', 1, '18032', '2021-09-24', '243818073562', 'jeanlimba@gmail.com', '', '2021-09-21 12:29:28', 1),
('64aed0ab7820ff6d655d0f0320f29157dcda9ecd', 1, 0, 1, 'TEST', 'TET', 'TEST', 'M', '1960-03-18', 1, '12455', '2022-08-01', '+243818073562', 'matondojudith5@gmail.com', NULL, '2022-08-01 03:52:42', 1),
('65616c11aedd7cb68a9debc3037d8a3377f0a465', 1, 0, 1, 'FLORIBERT', 'MAKOLO ', 'NJILA ', 'M', '2069-05-14', 1, '2107769', '2028-01-20', '6866950056', '', NULL, '2022-04-02 12:25:53', 1),
('68762df08e1fe3ea6e941ed9fe7f1381e01d9b66', 1, 0, 1, 'SAMUEL', 'KABAMBI ', '', 'M', '2069-05-14', 1, '250225', '2024-01-01', '851400176', '', NULL, '2022-04-02 13:36:46', 1),
('698353c331dcb86adb436279d8af11bf26492fb2', 1, 0, 1, 'JUDITH', 'MATONDO', 'MATUMONA', 'M', '1980-07-13', 1, '8795557', '2022-03-23', '+243818073562', '', NULL, '2022-04-06 07:54:39', 1),
('698d0f9fdac4bde2cba61ab03f2c35f24c99cbc6', 1, 0, 1, 'ARSENE', 'KABUAYA ', 'BETU', 'M', '1987-05-13', 1, '4197506', '2032-08-11', '13634443671', '', NULL, '2022-04-02 13:36:52', 1),
('6a1d94879ede80ea6961a905889b4acc6175323e', 1, 0, 1, 'AURELIE', 'BAZOLA', 'MATUMONA', 'M', '1990-03-18', 1, '180323', '2021-11-04', '+243818073562', '', NULL, '2021-11-04 10:46:57', 1),
('6b7be619594aaef0edf99ce2acc0fb47919960e2', 1, 0, 1, 'TEST', 'TET', 'TEST', 'M', '1960-03-18', 1, '12455', '2022-07-28', '+243818073562', '', NULL, '2022-07-28 16:06:03', 1),
('6c43dc6c5383fdd6fc643f97d037e1e7e5465273', 1, 0, 1, 'Remy', 'Mokassa', 'Nsado', 'M', '2009-12-24', 1, '18032', '2021-09-23', '243818073562', 'tresor.matondo@chesd-rdc.org', '', '2021-09-21 12:56:27', 1),
('6caa002906b00895e6eac440f7909a2d45f6e9b2', 3, 0, 3, 'NOUVEAU', 'BAZOLA', 'NSANA', 'F', '1960-03-18', 1, '1803', '2021-10-05', '+243818073562', '', NULL, '2022-03-23 10:50:13', 1),
('6e1cbf57a529ffd0bf1a525b7579790077dd079d', 1, 0, 1, 'Joseph', 'Lukondji', 'Kasonga', 'M', '1970-01-01', 1, '18032', '2021-06-10', '243818073562', 'tresor.matondo@chesd-rdc.org', '', '2021-10-05 14:25:25', 1),
('6f2d3df5c5205a58e4d56930c9fa7e932c393072', 1, 0, 1, 'Ladis', 'Mputu', 'Betu', 'M', '1988-02-12', 1, '18032', '2021-12-31', '2147483647', '', '', '2021-09-03 11:26:37', 1),
('7003f623f6c5b46476f3ad3ad99233cf4d77d54e', 1, 0, 3, 'SERGE', 'MASUMU', 'NGUVULU', 'M', '1995-05-15', 1, '250225', '2024-01-02', '+243818073562', '', NULL, '2022-08-01 04:56:59', 1),
('705518689c28127cba5221132f2022c7887cf295', 1, 0, 1, 'TRESOR', 'MATONDO', 'MATONDO', 'M', '1987-06-04', 1, '18032', '2021-10-07', '+243818073562', '', NULL, '2022-03-22 23:32:45', 1),
('7102041214c78cd7fb1fceeb1119e1323089669d', 1, 0, 1, 'SERGE', 'MASUMU', 'NGUVULU', 'M', '1995-05-15', 1, '250225', '2024-01-02', '+243818073562', '', NULL, '2021-11-03 09:55:44', 1),
('7330d0e50bfce45d5630b7bb47513c6f9c459112', 1, 0, 1, 'TRESOR', 'BAZOLA', 'KASONGO', 'M', '1930-01-01', 1, '8795557', '2022-03-23', '+243818073562', '', NULL, '2022-04-06 07:15:25', 1),
('7456d853053454f219397cf1e19d09ec15e22121', 2, 0, 1, 'HORNELLA', 'MAKETO', 'NGIZULU', 'F', '1995-05-14', 1, '250225', '2024-01-01', '+243818073562', '', NULL, '2021-11-03 09:07:27', 1),
('74a2cc077b39536b3b72ec3d53a7195cc5011c67', 1, 0, 1, 'TRESOR', 'MATONDO', 'MATONDO', 'M', '1960-03-11', 1, '8795557', '2021-10-07', '+243818073562', '', NULL, '2022-03-28 05:23:47', 7),
('7542100c55b176b0e33fd1d9f89b1e8eea975220', 1, 0, 3, 'JONATHAN', 'MASIALA', 'MVUETE', 'M', '2022-07-31', 1, '12455', '2022-08-01', '+243818073562', 'l.mputu@sjlaeronauticacongo-rdc.org', NULL, '2022-08-01 02:57:36', 1),
('781eea5fc28d3cccf4f29c7add84c3bf9662752e', 1, 0, 1, 'DANNY', 'KALONJI  ', 'MUTOMBO', 'M', '1987-05-13', 1, '1875576', '2027-07-19', '6115006321', '', NULL, '2022-04-02 12:25:52', 1),
('7a6ccabaac26b673a28ac43d561b5b3bc6cf35af', 3, 0, 3, 'Aurelie', 'Bazola', 'Matumona', 'F', '2021-09-16', 1, '180325', '2021-09-22', '243895163263', 'jhadisitombo@gmail.com', '', '2021-09-20 16:11:39', 1),
('7acbc11869ff27184ea961b56d6b52d86424f409', 1, 0, 1, 'SERGE', 'MASUMU', 'MATONDO', 'M', '1987-06-05', 1, '18032', '2021-10-30', '+243818073562', '', NULL, '2021-10-27 10:51:37', 1),
('7ccdcecad9614b1c8c152097c1faf37fb25b2e39', 2, 0, 1, 'KAREN', 'ODIA ', 'TSHIBAMBI ', 'F', '2069-05-14', 1, '3500927', '2031-02-03', '11378612466', '', NULL, '2022-04-02 12:25:54', 1),
('7d6c9ff09ac5ed3a4f763349c4cb398e853f5326', 2, 0, 3, 'Aurelie', 'Bazola', 'Matumona', 'F', '2019-01-10', 1, '180325', '2023-12-31', '+243818073562', '', '', '2021-09-02 15:07:21', 1),
('7f00d024e82c69d869c2a768b4cc2c2fd2da3d04', 2, 0, 1, 'GLORIA', 'META ', 'TSHITENDA ', 'F', '2069-05-14', 1, '4429699', '2033-02-12', '14386387406', '', NULL, '2022-04-02 12:25:55', 1),
('7f64006e4b3a89b021cbdee2be0f6c1ee6395f2d', 3, 0, 1, 'GRACE', 'FUMUATU', 'KILULU', 'F', '1960-03-18', 1, '18032', '2021-10-07', '+243818073562', 'aureliebazola27@gmail.com', NULL, '2022-03-22 09:14:43', 1),
('82947cd4b7a23add6e248a7ccf07ad668d1c99a5', 2, 0, 1, 'Cheila', 'Besongo', 'Nkoyamboli', 'F', '2009-12-16', 1, '18032', '2021-09-23', '243818073562', 'aureliebazola27@gmail.com', '', '2021-09-21 14:14:17', 1),
('82ceb28ae0b467bc392e08d9829c097255843b30', 1, 0, 1, 'Dieudo', 'Nkembo', 'Mvuete', 'M', '1996-02-02', 1, '180325', '2023-12-31', '243818073562', 'africaforward19@gmail.com', '', '2021-09-18 07:50:43', 1),
('83baccce8bc87647879bbe681dd52c577fa19b6d', 1, 0, 3, 'SERGE', 'MASUMU', 'NGUVULU', 'M', '1995-05-15', 1, '250225', '2024-01-02', '+243818073562', '', NULL, '2022-03-23 05:15:18', 1),
('83e2977a1ca153596ced801db93eddd98b4cdfa0', 1, 0, 1, 'DANNY', 'KALONJI  ', 'MUTOMBO', 'M', '1987-05-13', 1, '1875576', '2027-07-19', '6115006321', '', NULL, '2022-04-02 13:36:48', 1),
('843ca714ceb4661596ff63a24c6a4b2f72a5a489', 3, 0, 2, 'Miradie', 'Landu', 'Mvuete', 'F', '2010-01-22', 1, '180325', '2023-12-31', '2147483647', '', '', '2021-09-10 14:27:09', 1),
('86a6b7ee679b85876d7a9de8b9ce6b21fe612f16', 1, 0, 1, 'Patrick Othniel', 'Banamwezi', 'Wilondja', 'M', '2009-12-10', 1, '18032', '2021-09-22', '243818073562', 'jeanlimba@gmail.com', '', '2021-09-21 15:35:45', 1),
('884acfd07b70a58d4315227f323514b48815ce90', 1, 0, 1, 'Aurelie', 'Bazola', 'Makiadi', 'M', '2009-12-25', 1, '180325', '2021-09-22', '243818073562', 'africaforward19@gmail.com', '', '2021-09-20 06:18:36', 1),
('8a0affe82bd4ed2d5a9fbdc92bd6a383360ac357', 1, 0, 1, 'DERNIER', 'MATONDO', 'MATONDO', 'M', '1930-01-01', 1, '8795557', '2021-10-15', '+243820465078', '', NULL, '2022-04-06 08:14:20', 1),
('8bf3308306254ab024d1c6e5bd51898c70e72969', 2, 0, 2, 'HORNELLA', 'MAKETO', 'NGIZULU', 'F', '1995-05-14', 1, '250225', '2024-01-01', '+243818073562', '', NULL, '2022-03-23 05:23:22', 1),
('90cd299bb507e2011e354220faa478858e42c211', 1, 0, 1, 'TEST', 'BAZOLA', 'MATUMONA', 'M', '1987-06-04', 1, '8795557', '2022-03-23', '+243818073562', '', NULL, '2022-04-06 07:56:51', 1),
('91d6fc64d31457fc2dc27c212647987aafd3f63e', 1, 0, 1, 'BIENVENUE', 'LOLA', 'WA LOLA', 'M', '1995-05-13', 1, '18032', '2023-06-30', '+243818073562', '', NULL, '2022-03-22 09:41:38', 1),
('9650f1c401195b34b73c2fa005a5daf7bddab8b0', 1, 0, 1, 'LADIS', 'MPUTU', 'BETU', 'M', '1987-06-04', 1, '18032', '2021-10-31', '+243818073562', '', NULL, '2021-10-27 12:47:37', 1),
('97f9bff65829414a34cd2a7ce537e1ad0949c375', 2, 0, 1, 'MAGUY', 'NGOY ', 'MASANKA ', 'F', '1987-05-13', 1, '2804348', '2029-07-28', '9122781261', '', NULL, '2022-04-02 12:25:53', 1),
('99ad4a4db5ccf9089134c35ebdedc83e86d40776', 1, 0, 1, 'PIERRE', 'KAYEMBE', 'NKONGOLO ', 'M', '1987-05-13', 1, '18032', '2023-06-30', '99456441', '', NULL, '2022-04-02 12:25:50', 1),
('99f4d1effafea6eab1e5439df3374deb68a3f3bb', 1, 0, 1, 'Tresor', 'Matondo', 'Mvuete', 'M', '1992-03-18', 1, '180325', '2021-10-10', '243818073562', 'jhadisitombo@gmail.com', '', '2021-09-20 04:18:56', 1),
('9bde5303c23e748bdd0e23784a97eaafd3a2a894', 1, 0, 1, 'Olivier', 'Bialufu', 'Nsana', 'M', '1980-03-12', 1, '18032', '2023-12-31', '2147483647', 'jhadisitombo@gmail.com', 'RAS', '2021-09-03 09:49:11', 1),
('9c7dc177fe7ff8b26c9281be81e71170969e0ff5', 1, 0, 1, 'NKONGOLO', 'KABEDI ', '', 'M', '2069-05-14', 1, '1178997', '2026-01-10', '3859175116', '', NULL, '2022-04-02 13:36:47', 1),
('9d81ad4b6e747609e8e3fb30851d675498955590', 2, 0, 1, 'Aurelie', 'Bazola', 'Kasongo', 'F', '1999-12-18', 1, '180325', '2023-12-31', '2147483647', 'jeanlimba@gmail.com', '', '2021-09-09 14:36:30', 1),
('9e436904c0b99070ef00d26d124497982bb9a4bc', 1, 0, 2, 'TEST', 'BAZOLA', 'TEST', 'M', '1960-03-18', 1, '8795557', '2021-10-07', '+243818073562', '', NULL, '2022-03-23 04:59:36', 1),
('9f1f8e3afb6195c1519a188c44bdccf3c2ddfe74', 1, 0, 1, 'Tresor', 'Bazola', 'Kasongo', 'M', '2009-12-03', 1, '18032', '2021-09-23', '243818073562', 'africaforward19@gmail.com', '', '2021-09-20 06:14:04', 1),
('9f933426a1bc4db0139c1d083bec389e55499a0f', 1, 0, 1, 'Jean-Claude', 'Bibamba', 'Nzioko', 'M', '2009-12-18', 1, '18032', '2021-09-23', '243818073562', 'tresor.matondo@chesd-rdc.org', '', '2021-09-21 13:31:55', 1),
('a0a3e818534bc26a958fbf6a63cb66bf61b73ad7', 1, 0, 3, 'SERGE', 'MASUMU', 'NGUVULU', 'M', '1995-05-15', 1, '250225', '2024-01-02', '+243818073562', '', NULL, '2021-11-12 11:09:18', 1),
('a117713a144f15677fbb69a49d36549b606de73f', 1, 0, 1, 'Test', 'test', 'Mvuete', 'M', '2009-12-10', 1, '180325', '2021-09-21', '243818073562', 'aureliebazola27@gmail.com', '', '2021-09-20 05:15:42', 1),
('a18f4e0e31ed9c5e786eabb31a19b683965024f2', 1, 0, 1, 'Malachie', 'Mbengani', 'Makiadi', 'M', '2009-12-24', 1, '180325', '2021-09-29', '243895163263', '', 'RAS', '2021-09-27 11:31:41', 1),
('a3c0c15b3ac97a12efb07a27fad90b5702f686f6', 1, 0, 1, 'WILLY', 'ILUNGA ', 'KAYEMBA ', 'M', '2015-05-19', 1, '946804', '2025-07-09', '3107231381', '', NULL, '2022-04-02 12:25:51', 1),
('a63f91aed17f58c9038c952dffe0547f33aa76bd', 1, 0, 1, 'BIENVENUE', 'LOLA', 'WA LOLA', 'M', '1995-05-13', 1, '18032', '2023-06-30', '+243818073562', '', NULL, '2022-03-23 05:23:22', 1),
('a9e8868bd11ea55a987f0eedc661c9c6c0a8528c', 1, 0, 1, 'Placide', 'Matiaba', 'Mbungu', 'M', '2009-12-24', 1, '18032', '2021-09-22', '243818073562', '', '', '2021-09-21 15:43:34', 1),
('aa46c0b42b8372b9d5285dd40195071898fd37e6', 1, 0, 1, 'TRESOR', 'MATONDO', 'KASONGO', 'M', '1930-01-01', 1, '18032', '2021-10-07', '+243818073562', '', NULL, '2022-03-29 14:38:07', 1),
('aa8912db8ca49d4d6b97ee29a735d2cf52eb5a73', 1, 0, 1, 'Mayiteleka', 'Mambandu', '', 'M', '2009-12-24', 1, '18032', '2021-09-22', '243818073562', 'tresor.matondo@chesd-rdc.org', '', '2021-09-21 16:24:03', 1),
('ac6991683abaff953afb3bea5616dbbf8d640b83', 2, 0, 1, 'ANTHO', 'MONAKEBA  ', 'MUBIAYI', 'F', '2051-05-16', 1, '482418', '2024-07-04', '1603343911', '', NULL, '2022-04-02 12:25:51', 1),
('adb0d85a033485b77ebce00de72ef10a6a9ecc10', 2, 0, 1, 'GLORIA', 'META ', 'TSHITENDA ', 'F', '2069-05-14', 1, '4429699', '2033-02-12', '14386387406', '', NULL, '2022-04-02 13:36:52', 1),
('ae9d7a693d46b6cbc80fd2054e13261a584307f7', 1, 0, 2, 'Christoph', 'Kumbembila', '', 'M', '2018-12-14', 1, '18032', '2021-09-22', '243818073562', 'aureliebazola27@gmail.com', '', '2021-09-21 15:20:12', 1),
('afabb5520b6db57272c25d50ca64fbdf2e708e18', 3, 0, 2, 'CONSOLES', 'MAMBELE', '', 'F', '2018-12-20', 1, '180325', '2021-09-23', '243818073562', '', '', '2021-09-22 18:45:51', 1),
('b08b8dc331b35936dae899ca70c0f7f1d2680a9e', 1, 0, 1, 'TRESOR', 'MATONDO', 'MVUETE', 'M', '1987-06-05', 1, '18032', '2021-10-07', '243820465078', '', '', '2021-10-26 10:23:28', 7),
('b294dfcc06fa1a607af84354b5cc632d13d540ae', 1, 0, 1, 'FYFY', 'NGOY', 'MASUKA', 'M', '1960-03-18', 1, '8795557', '2021-10-07', '+243818073562', '', NULL, '2022-03-30 08:47:37', 1),
('b43dfc267ef72ba15fbfe9808a685b31f1d65ea0', 1, 0, 1, 'Jose', 'Thessa', 'Meli', 'M', '2009-12-17', 1, '18032', '2021-09-22', '243818073562', 'aureliebazola27@gmail.com', '', '2021-09-21 12:34:19', 1),
('b45759374d1947cbb8bd5dd015838866bfe9eb1c', 1, 0, 1, 'Issa', 'Utshukunda', '', 'M', '2009-12-24', 1, '180325', '2021-09-22', '243818073562', 'jhadisitombo@gmail.com', '', '2021-09-21 14:39:28', 1),
('b5a3e87578e7bb43b33d0aad6f8abd8a6b97b02d', 2, 0, 1, 'LEA', 'MAMBELE', '', 'F', '2009-12-24', 1, '18032', '2021-09-23', '243818073562', '', '', '2021-09-22 18:42:53', 1),
('b5b5c962f4b0b6f7fdb2a7d05f5be397a27df066', 1, 0, 1, 'MBWEBWA', 'LUABO ', '', 'M', '2069-05-14', 1, '1643383', '2027-01-15', '5363062586', '', NULL, '2022-04-02 12:25:52', 1),
('b5e7bcbd25df65696cae800ed94aaf299f8072dc', 2, 0, 1, 'Judith', 'Matondo', 'Matumona', 'F', '1997-05-05', 1, '180325', '2023-12-31', '2147483647', 'aureliebazola27@gmail.com', '', '2021-09-04 04:08:16', 1),
('b82f53e84284e0bc9c84dc222fa126889b3a5652', 1, 0, 1, 'Aroya', 'Mokobe', '', 'M', '2009-12-24', 1, '18032', '2021-09-22', '243818073562', 'tresor.matondo@chesd-rdc.org', '', '2021-09-21 14:49:44', 1),
('b8fc2f1347f6deab37f5b6684238b06514bff243', 1, 0, 1, 'Aurelie', 'Bazola', 'Mvuete', 'M', '2009-12-10', 1, '18032', '2021-09-22', '243818073562', 'matondotresor5@gmail.com', '', '2021-09-20 05:48:40', 1),
('bd459e05ed07278a7540e793d698e8113d8b1151', 2, 0, 1, 'JOSÉPHINE', 'MBIYA ', 'MUKALA', 'F', '1987-05-13', 1, '3733120', '2031-08-07', '12130556201', '', NULL, '2022-04-02 13:36:51', 1),
('bf7423494d71f8fbc1994308e43d3dbb97e7f62a', 1, 0, 2, 'Blaise', 'Konde', 'Mabela', 'M', '2018-11-30', 1, '18032', '2021-09-22', '243818073562', 'jhadisitombo@gmail.com', '', '2021-09-21 15:17:06', 1),
('c1be4bc77d64c9d6c8f08cd1232cec9b8ca1cc6b', 1, 0, 1, 'JEAN', 'BANGASU', 'ANIZANGA', 'M', '2009-12-10', 1, '18032', '2021-09-23', '243818073562', '', '', '2021-09-22 18:54:33', 1),
('c2535d3b98379bb57d48adeabfcb8be461e2b3e0', 1, 0, 1, 'PATIENT', 'KAKULE', 'MBELA', 'M', '2009-12-26', 1, '180325', '2021-09-23', '243895163263', '', '', '2021-09-22 18:47:53', 1),
('c40bc5d35fcd981bed6c99ff864a885af03f8c0f', 1, 0, 2, 'Israel', 'Kayamba', 'Devie', '', '2018-12-13', 1, '180323', '2021-10-15', '243818073562', '', '', '2021-09-29 12:51:11', 1),
('c43dd98522f27b7d4b86cbccb92e6f3c9c9e8d0a', 1, 0, 1, 'Tresor', 'Matondo', 'Matumona', 'M', '2009-12-09', 1, '18032', '2021-09-10', '2147483647', 'africaforward19@gmail.com', '', '2021-09-09 13:28:06', 1),
('c4e1e2eb350b96a63a6fd51dccf14f9808e6bfbc', 1, 0, 1, 'ARSENE', 'KABUAYA ', 'BETU', 'M', '1987-05-13', 1, '4197506', '2032-08-11', '13634443671', '', NULL, '2022-04-02 12:25:54', 1),
('c589b004a5faa8d5b352e636eab110c75d081496', 2, 0, 1, 'KAREN', 'ODIA ', 'TSHIBAMBI ', 'F', '2069-05-14', 1, '3500927', '2031-02-03', '11378612466', '', NULL, '2022-04-02 13:36:51', 1),
('c8b4da00c9882e1e7b401f008966d1ba08bf144d', 2, 0, 2, 'HORNELLA', 'MAKETO', 'NGIZULU', 'F', '1995-05-14', 1, '250225', '2024-01-01', '+243818073562', '', NULL, '2021-11-04 10:49:17', 1),
('c8d2402d73f27aebd4372cf6e9c25c4648ad9c8c', 1, 0, 1, 'BIENVENUE', 'LOLA', 'WA LOLA', 'M', '1995-05-13', 1, '18032', '2023-06-30', '+243818073562', '', NULL, '2021-11-03 08:44:19', 1),
('c9c5bdb76d9b9923691f637c2508bd7b4073db2f', 1, 0, 1, 'WILLY', 'ILUNGA ', 'KAYEMBA ', 'M', '2015-05-19', 1, '946804', '2025-07-09', '3107231381', '', NULL, '2022-04-02 13:36:47', 1),
('ca8eafd4377c3f57b8b1220b4e4e1b80f7f06452', 3, 0, 1, 'AURELIE', 'MATONDO', 'NSANA', 'F', '1930-01-01', 1, '18032', '2022-03-23', '+243818073562', '', NULL, '2022-03-23 10:51:40', 1),
('cccb7ca197b26ab45f942c7ea8608193630f5610', 1, 0, 1, 'Bernard', 'Alinye', '', 'M', '2009-12-24', 1, '18032', '2021-09-22', '243818073562', 'africaforward19@gmail.com', '', '2021-09-21 15:48:49', 1),
('cd1787aa5f2afed5855c13b997c5caba106d9a77', 2, 0, 3, 'Aurelie', 'Bazola', 'Matumona', 'F', '2021-09-23', 1, '180325', '2021-10-08', '243818073562', 'jeanlimba@gmail.com', '', '2021-09-30 09:48:33', 1),
('cd4aa6554a4f49a5f5ce3bebee016b7af7825571', 1, 0, 1, 'SAMUEL', 'KABAMBI ', '', 'M', '2069-05-14', 1, '250225', '2024-01-01', '851400176', '', NULL, '2022-04-02 12:25:51', 1),
('cd7f98dc8c819802db8cc8b5a801e89daddfea86', 1, 0, 1, 'NKONGOLO', 'KABEDI ', '', 'M', '2069-05-14', 1, '1178997', '2026-01-10', '3859175116', '', NULL, '2022-04-02 12:25:52', 1),
('ce5d1e2ac99834142077b8828ff4e04625dee0fb', 1, 0, 1, 'TRESOR', 'TRESOR MVUETE', 'KASONGO', 'M', '1987-06-04', 1, '18032', '2022-03-23', '+243818073562', '', NULL, '2022-03-25 13:50:28', 1),
('cfcbf2f210062f87fdfebf1835ed85d0add57323', 1, 0, 1, 'Tresor', 'Bazola', 'Matondo', 'M', '2009-12-31', 3, '18032', '2021-09-30', '2147483647', 'jeanlimba@gmail.com', '', '2021-08-31 14:11:32', 1),
('cfee6c9d38bd8254e46c98df93124e507b51189c', 1, 0, 1, 'Benoit', 'Katula', '', 'M', '2009-12-24', 1, '180325', '2021-09-23', '243818073562', '', '', '2021-09-21 14:36:09', 1),
('cff28e840c25768bc1779afd4a043dc20038ff87', 3, 0, 1, 'AURELIE', 'BAZOLA', 'MATUMONA1', 'F', '1987-06-04', 1, '18032', '2021-10-07', '+243818073562', '', NULL, '2022-03-23 04:38:25', 1),
('d05ed61b87e5281ae94bbaaad8242b51786afbf7', 1, 0, 1, 'Ladis', 'Mputu', 'Betu', 'M', '1996-03-18', 1, '18032', '2021-09-25', '2147483647', 'jhadisitombo@gmail.com', '', '2021-09-15 12:39:21', 7),
('d112c057a72f3e413b29e6b4cdd8a600339be6f2', 1, 0, 1, 'TRESOR', 'MVUETE', 'MATONDO', 'M', '1980-07-13', 1, '18032', '2021-10-07', '+243818073562', 'matondotresor5@gmail.com', NULL, '2022-03-22 05:47:31', 1),
('d1480fe63422e75ad6fb7bd6d89543f720cc0f64', 1, 0, 1, 'BIENVENUE', 'LOLA', 'WA LOLA', 'M', '1995-05-13', 1, '18032', '2023-06-30', '+243818073562', '', NULL, '2022-08-01 04:56:59', 1),
('d24c6da70221e39f8312eca7490aa3632c09a049', 1, 0, 1, 'TEST', 'BAZOLA', 'MATONDO', 'M', '1987-06-05', 1, '8795557', '2021-10-07', '+243818073562', '', NULL, '2022-03-26 00:24:13', 1),
('d2d6fec583651de82ed80e5fe8c5910eb4737922', 1, 0, 1, 'KABEYA', 'ILUNGA ', '', 'M', '1987-05-13', 1, '1411190', '2026-07-14', '4611118851', '', NULL, '2022-04-02 13:36:48', 1),
('d447428f678c18f08f1245a089dc93f7d7229d67', 1, 0, 1, 'Tresor', 'Bazola', 'Mvuete', 'M', '2009-12-24', 1, '18032', '2021-09-25', '243895163263', 'jhadisitombo@gmail.com', '', '2021-09-20 04:39:19', 1),
('d484a780b5f495efb14b8934a3d76a21ceb955c7', 1, 0, 1, 'Test', 'Matondo', 'Nouveau', 'M', '1990-02-14', 1, '18032', '2023-12-31', '2147483647', 'jeanlimba@gmail.com', 'RAS', '2021-08-31 14:16:49', 1),
('d69bc8aac02c8ddaaa90e7e738098c04c2b687bd', 1, 0, 1, 'Guy-Guy', 'Kiyombo', 'Mussa', 'M', '2009-12-17', 1, '18032', '2021-09-22', '243818073562', 'jhadisitombo@gmail.com', '', '2021-09-21 16:07:26', 1),
('d772b1c0462b3e14a7f840ff09db65c4ba72a454', 1, 0, 1, 'Test', 'test', 'Mvuete', 'M', '2009-12-17', 1, '180325', '2021-09-24', '243895163263', 'jhadisitombo@gmail.com', '', '2021-09-20 04:31:48', 1),
('d782d9a408915238150eaa7858e4e2151ea0365a', 1, 0, 1, 'Jean-Claude', 'Likosi', 'Atambana', 'M', '2009-12-11', 1, '180325', '2021-09-23', '243818073562', 'jeanlimba@gmail.com', '', '2021-09-21 14:34:46', 1),
('d8654c2a568ccb8f49466386f65222faf8de003f', 1, 0, 2, 'AURELIE', 'BAZOLA', 'MATONDO', 'M', '1987-06-05', 1, '8795557', '2021-10-07', '+243818073562', '', NULL, '2022-04-06 07:24:04', 1),
('d9b3a4a80063491de905550bfb5def09340c29b4', 1, 0, 1, 'BIENVENUE', 'LOLA', 'WA LOLA', 'M', '1995-05-13', 1, '18032', '2023-06-30', '+243818073562', '', NULL, '2021-11-03 09:07:26', 1),
('da1c455c22eaa64df7c65105ca85cb4c01d184e0', 1, 0, 1, 'Obed', 'Ndele', 'Mbumba', 'M', '1970-02-14', 1, '180323', '2022-12-31', '+243820465078', '', '', '2021-10-20 09:05:06', 1),
('dd778d3d2c2c5c483b4b3d9d46bbf5594f79ab17', 3, 0, 3, 'AURELIE', 'KUEDOLO', 'BAYENGA', 'F', '2022-08-01', 1, '12455', '2022-08-01', '+243818073562', 'matondojudith5@gmail.com', NULL, '2022-08-01 02:56:03', 1),
('de26b49981f1b410858e8bfcd3b39189d3dd5934', 1, 0, 3, 'SERGE', 'MASUMU', 'NGUVULA', 'M', '1995-05-15', 1, '250225', '2024-01-02', '+243818073562', '', NULL, '2022-03-22 09:41:38', 1),
('df03069550c91dae85fb98fe50b09d6719349fe2', 3, 0, 1, 'Aurelie', 'Bazola', 'Matumona', 'F', '1997-02-18', 1, '18032', '2023-12-31', '2147483647', 'matondotresor5@gmail.com', '', '2021-08-31 14:13:45', 1),
('dfa59db5d1c9a0b5416ef7f282a952d9af8f9b01', 3, 0, 2, 'JUDITH', 'MATONDO', 'MATUMONA', 'F', '2007-03-18', 1, '12455', '2022-07-31', '+243818073562', 'matondojudith5@gmail.com', NULL, '2022-07-31 05:58:28', 1),
('e04ab6d79f4573f0feb022bf41ecbc2d1c88a51b', 1, 0, 3, 'SERGE', 'MASUMU', 'NGUVULU', 'M', '1995-05-15', 1, '250225', '2024-01-02', '+243818073562', '', NULL, '2021-11-04 10:49:20', 1),
('e1a8a924f51f563e69ddbc10f4037f0142efe304', 1, 0, 1, 'KABEYA', 'NKONGOLO ', '', 'M', '2033-05-17', 1, '714611', '2025-01-05', '2355287646', '', NULL, '2022-04-02 13:36:47', 1),
('e55c0283cada18614066c9fe8f207c0b7b82fbe7', 1, 0, 1, 'Max', 'Masamba', 'Mabela', 'M', '2009-12-25', 1, '18032', '2021-09-23', '243818073562', 'aureliebazola27@gmail.com', '', '2021-09-21 15:03:42', 1),
('e8f7d1ada2efe0fa6049fe1621170344e24e9dba', 1, 0, 1, 'BIENVENUE', 'LOLA', 'WA LOLA', 'M', '1995-05-13', 1, '18032', '2023-06-30', '+243818073562', '', NULL, '2021-11-03 09:55:44', 1),
('e9482a5b1d430dc6b2e9d673bdad2658391cd598', 1, 0, 1, 'Tresor', 'Matondo', 'Mvuete', 'M', '2009-12-01', 1, '18032', '2021-10-01', '2147483647', 'aureliebazola27@gmail.com', 'RAS', '2021-09-15 10:56:52', 7),
('eb135aab7c7c7c8dad37acaf85fd609ef83234e5', 1, 0, 1, 'NOUVEAU', 'BAZOLA', 'MVUETE', 'M', '1987-06-05', 1, '8795557', '2021-10-07', '+243818073562', '', NULL, '2022-04-06 08:17:29', 1),
('ec53bebfa474abd2c8717433530ec4e8addc5551', 1, 0, 1, 'Tresor', 'Matondo', 'Mvuete', 'M', '1992-03-18', 1, '180325', '2021-12-31', '2147483647', 'matondotresor5@gmail.com', 'RAS', '2021-09-02 09:35:57', 1),
('ecda9e12c3dfed4d2b7fb0a27a01966b442c379f', 1, 0, 1, 'BIENVENUE', 'LOLA', 'WA LOLA', 'M', '1995-05-13', 1, '18032', '2023-06-30', '+243818073562', '', NULL, '2022-08-01 04:59:33', 1),
('eee733fd8dcbb29604137200c59e6fbf1faee8b5', 1, 0, 1, 'Olivier', 'Bialufu', 'Nsana', 'M', '2009-12-17', 1, '180325', '2021-09-23', '243818073562', 'aureliebazola27@gmail.com', '', '2021-09-20 06:05:39', 1),
('ef2463a497a9bc96d3da96f829bd8589c28b98f2', 1, 0, 3, 'SERGE', 'MASUMU', 'NGUVULU', 'M', '1995-05-15', 1, '250225', '2024-01-02', '+243818073562', '', NULL, '2022-03-26 10:17:39', 1),
('efa0499f0b214f2617abf79f2b2787619aa4f0e8', 1, 0, 1, 'Justin', 'Botumbe', 'Lombo', 'M', '2009-12-24', 1, '18032', '2021-09-23', '243818073562', '', '', '2021-09-21 12:45:14', 1),
('f042f554c6624e39d9bf020feff62b9df10c7c9e', 1, 0, 1, 'FLORIBERT', 'MAKOLO ', 'NJILA ', 'M', '2069-05-14', 1, '2107769', '2028-01-20', '6866950056', '', NULL, '2022-04-02 13:36:49', 1),
('f3ebb64a14a91f2d1771a4e1431e9b1181a5cb42', 1, 0, 1, 'KABEYA', 'ILUNGA ', '', 'M', '1987-05-13', 1, '1411190', '2026-07-14', '4611118851', '', NULL, '2022-04-02 12:25:52', 1),
('f4cf15b848cd0d2098d4e728e47b43398244b234', 2, 0, 2, 'HORNELLA', 'MAKETO', 'NGIZULU', 'F', '1995-05-14', 1, '250225', '2024-01-01', '+243818073562', '', NULL, '2022-03-30 08:52:14', 1),
('f6279316f8f16681f375927bb91be7e601c720e2', 2, 0, 1, 'ANTHO', 'MONAKEBA  ', 'MUBIAYI', 'F', '2051-05-16', 1, '482418', '2024-07-04', '1603343911', '', NULL, '2022-04-02 13:36:46', 1),
('f6c9743697900ef09559208c1f0d9d169a160ca9', 1, 0, 1, 'CRISPIN', 'KABUE ', 'KABUE ', 'M', '1987-05-13', 1, '2339962', '2028-07-23', '7618893791', '', NULL, '2022-04-02 12:25:53', 1),
('f765aded7aee6af2c022fd653aed69026b594492', 2, 0, 1, 'JOSÉPHINE', 'MBIYA ', 'MUKALA', 'F', '1987-05-13', 1, '3733120', '2031-08-07', '12130556201', '', NULL, '2022-04-02 12:25:54', 1),
('f8f33c656ba203ea4855fca5c9576b1694bfd0f5', 1, 0, 1, 'Heritier', 'Muela', 'Mabiala', 'M', '1990-03-18', 1, '18032', '2021-09-23', '243818073562', 'jhadisitombo@gmail.com', '', '2021-09-20 14:35:49', 1),
('f9f18ee8f8546ac7e35e2ce78c5417fb239bed76', 1, 0, 1, 'TSHIKALA', 'NKUBA ', '', 'M', '2069-05-14', 1, '2572155', '2029-01-24', '8370837526', '', NULL, '2022-04-02 12:25:53', 1),
('fa0e63c27524a9cdb195c78cb7f6afa72473b770', 1, 0, 1, 'Richard', 'Mvuete', 'Mvila', 'M', '1960-05-05', 1, '18032', '2021-09-24', '243818073562', 'tresor.matondo@chesd-rdc.org', '', '2021-09-20 04:43:55', 1),
('fe650462c12dd5b900ceeb005dd988d080426415', 1, 0, 1, 'Judith', 'Matondo', 'Matumona', '', '2009-12-24', 1, '18032', '2021-10-22', '243818073562', 'jhadisitombo@gmail.com', '', '2021-09-29 04:39:10', 7),
('feac3554fd38c546ad9497ef0375637d2b6915e5', 1, 0, 1, 'Ladis', 'Mputu', 'Betu', 'M', '1988-01-17', 1, '180325', '2023-12-31', '2147483647', 'jeanlimba@gmail.com', 'RAS', '2021-09-03 09:56:27', 1);

-- --------------------------------------------------------

--
-- Structure de la table `table_commandant`
--

CREATE TABLE `table_commandant` (
  `ID_Commandant` int(10) UNSIGNED NOT NULL,
  `Nom_Commandant` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `table_email`
--

CREATE TABLE `table_email` (
  `ID_Email` int(10) UNSIGNED NOT NULL,
  `Email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `table_email`
--

INSERT INTO `table_email` (`ID_Email`, `Email`) VALUES
(1, 't.matondo@sjlaeronauticacongo-rdc.com'),
(2, 'm.mbengani@sjlaeronauticacongo-rdc.com');

-- --------------------------------------------------------

--
-- Structure de la table `table_escale_vol`
--

CREATE TABLE `table_escale_vol` (
  `ID_Escale_Vol` int(10) UNSIGNED NOT NULL,
  `ID_Vol` int(10) UNSIGNED NOT NULL,
  `ID_Aeroport` int(10) UNSIGNED NOT NULL,
  `Heure_Arrivee` time NOT NULL,
  `Heure_Depart` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_escale_vol`
--

INSERT INTO `table_escale_vol` (`ID_Escale_Vol`, `ID_Vol`, `ID_Aeroport`, `Heure_Arrivee`, `Heure_Depart`) VALUES
(2, 10, 10, '09:30:00', '10:00:00'),
(5, 10, 9, '10:45:00', '11:30:00'),
(7, 15, 10, '11:00:00', '11:25:00'),
(8, 15, 9, '11:55:00', '12:20:00'),
(9, 17, 10, '11:00:00', '11:25:00'),
(10, 28, 10, '10:30:00', '10:45:00'),
(12, 28, 9, '11:30:00', '12:00:00'),
(13, 5, 2, '10:00:00', '10:15:00'),
(15, 6, 4, '09:04:00', '10:00:00'),
(16, 8, 4, '08:10:00', '19:20:00'),
(17, 7, 4, '10:00:00', '10:30:00'),
(18, 4, 4, '09:00:00', '09:30:00');

-- --------------------------------------------------------

--
-- Structure de la table `table_franchise`
--

CREATE TABLE `table_franchise` (
  `ID_Franchise` int(10) UNSIGNED NOT NULL,
  `ID_Cat_Passager` int(10) UNSIGNED NOT NULL,
  `Checked_Bag` int(11) NOT NULL,
  `Hand_Bag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_franchise`
--

INSERT INTO `table_franchise` (`ID_Franchise`, `ID_Cat_Passager`, `Checked_Bag`, `Hand_Bag`) VALUES
(1, 1, 25, 5),
(2, 2, 25, 5),
(3, 3, 10, 0);

-- --------------------------------------------------------

--
-- Structure de la table `table_jour`
--

CREATE TABLE `table_jour` (
  `ID_Jour` int(10) UNSIGNED NOT NULL,
  `Design_Jour` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_jour`
--

INSERT INTO `table_jour` (`ID_Jour`, `Design_Jour`) VALUES
(0, 'Dimanche'),
(1, 'Lundi'),
(2, 'Mardi'),
(3, 'Mercredi'),
(4, 'Jeudi'),
(5, 'Vendredi'),
(6, 'Samedi');

-- --------------------------------------------------------

--
-- Structure de la table `table_mois`
--

CREATE TABLE `table_mois` (
  `ID_Mois` int(10) UNSIGNED NOT NULL,
  `Design_Mois` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_mois`
--

INSERT INTO `table_mois` (`ID_Mois`, `Design_Mois`) VALUES
(1, 'Janvier'),
(2, 'Février'),
(3, 'Mars'),
(4, 'Avril'),
(5, 'Mai'),
(6, 'Juin'),
(7, 'Juillet'),
(8, 'Août'),
(9, 'Septembre'),
(10, 'Octobre'),
(11, 'Novembre'),
(12, 'Décembre');

-- --------------------------------------------------------

--
-- Structure de la table `table_monnaie`
--

CREATE TABLE `table_monnaie` (
  `ID_Monnaie` int(10) UNSIGNED NOT NULL,
  `Design_Monnaie` varchar(30) NOT NULL,
  `Cod_Monnaie` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_monnaie`
--

INSERT INTO `table_monnaie` (`ID_Monnaie`, `Design_Monnaie`, `Cod_Monnaie`) VALUES
(1, 'Dollar', 'USD'),
(2, 'Franc congolais', 'CDF');

-- --------------------------------------------------------

--
-- Structure de la table `table_particularite`
--

CREATE TABLE `table_particularite` (
  `ID_Particularite` int(10) UNSIGNED NOT NULL,
  `Design_Particularite` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `table_passager_vol`
--

CREATE TABLE `table_passager_vol` (
  `ID_Passager_Vol` varchar(100) NOT NULL,
  `ID_Vente` varchar(100) NOT NULL,
  `ID_Vol_Date` int(10) UNSIGNED NOT NULL,
  `ID_Siege` int(10) UNSIGNED NOT NULL,
  `Numero_Passager_Vol` varchar(20) NOT NULL,
  `Tchecked` int(11) NOT NULL DEFAULT 0,
  `Embarque` int(11) NOT NULL DEFAULT 0,
  `Vol_Number` int(11) NOT NULL,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp(),
  `Date_Modif` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_passager_vol`
--

INSERT INTO `table_passager_vol` (`ID_Passager_Vol`, `ID_Vente`, `ID_Vol_Date`, `ID_Siege`, `Numero_Passager_Vol`, `Tchecked`, `Embarque`, `Vol_Number`, `Date_Enreg`, `Date_Modif`) VALUES
('023c60f219e74d2b0c9e1c64a235679164cf6040', '319564e0b51f735367ab0d0d2d3ed41f29f2bb7c', 28, 0, '8882123114221', 0, 0, 1, '2022-08-01 02:57:36', '2022-08-01 02:57:36'),
('083fb4338cef70c45bdb5accfdcdf94699f019c9', '08d5419589187213192d626da528d023639b5b76', 17, 0, '8882123173043', 0, 0, 2, '2022-04-06 07:56:52', '2022-04-06 07:56:52'),
('0a4ada9f459dc5d2f5c6f8c0bd4816c2abb83be0', 'b66bfc000ac51f397f634f261cdc91a984ec0bde', 21, 0, '8882123209905', 0, 0, 1, '2022-04-02 13:36:48', '2022-04-02 13:36:48'),
('0c89e422de2ee15a65b98869ad9054f1ae2df726', 'b2222b7ba71104dae5d78f95c635221dc6ade86c', 21, 0, '8882123678094', 0, 0, 1, '2022-04-02 13:36:51', '2022-04-02 13:36:51'),
('0cae6e8041fcfb0e4152cc007de45871febca85f', '5bd4ca77082251edb8adfcecec8ebc632e368004', 4, 0, '8882123141600', 0, 0, 1, '2022-04-02 12:25:52', '2022-04-02 12:25:52'),
('0fce478849f93dc09d85b18d2b242d9ff9fccb7a', '0c44fed0b1048297deb0ea08d0dd6e736afd8e57', 50, 0, '8882123183328', 0, 0, 2, '2022-08-01 03:52:42', '2022-08-01 03:52:42'),
('12a8308125d3a482f8370963f7b2488c2bb2de48', '2b6d3019509b5c845d8d012574aa1b9fd2e2b9be', 21, 0, '8882123517476', 0, 0, 1, '2022-04-02 13:36:52', '2022-04-02 13:36:52'),
('1813956ef89b787b7ad1debd25539f697c0ee634', '58cd8ae305288eb8c8e69e9f72dcf7e1d103d2c9', 21, 0, '8882123284441', 0, 0, 1, '2022-04-02 13:36:51', '2022-04-02 13:36:51'),
('1a3a4b5ff38702b70f81ac15d0fd9d0b3fa3912e', 'b76c2b8057fdd856b8d30e7783dc33eddcb784e9', 4, 0, '8882123125358', 0, 0, 1, '2022-04-02 12:25:51', '2022-04-02 12:25:51'),
('27d5abffe92ed9968cd5d645a5832d2bb8b17108', '58bb4acc3176c215eb6a2720c76c96a5f95d1f38', 21, 0, '8882123506804', 0, 0, 1, '2022-04-02 13:36:50', '2022-04-02 13:36:50'),
('29e0e0f2db50ebc6c4761326c0aa8bc2a5bd8c03', '7ca5522598dbd84b87605acd4601d14ac3af6b82', 4, 0, '8882123135584', 0, 0, 1, '2022-04-06 08:14:20', '2022-04-06 08:14:20'),
('2ad85124def2346e97fb64585611ee53f09c4079', 'ae5d2678e630e94db8675c1a652720d4465c21fb', 4, 0, '8882123111904', 0, 0, 1, '2022-04-02 12:25:54', '2022-04-02 12:25:54'),
('3215e63fd557693a12dc69b80c06f3a2140c0e9d', 'ddb93661b51b9160091240b0afb9224506eccfab', 4, 0, '8882123341708', 0, 0, 1, '2022-04-06 07:24:04', '2022-04-06 07:24:04'),
('35b072862e85f6971d809528b4938aec8341296f', '0e5f767c47f4f5cd31d1b138271f876e059ced5a', 20, 0, '8882123134715', 0, 0, 2, '2022-04-06 08:17:29', '2022-04-06 08:17:29'),
('37c5afe3b55f88ba025cacefc6fe00b64eb1a24e', '4772de308660164e21e23e208d90060cf3049734', 4, 0, '8882123207823', 0, 0, 1, '2022-04-02 12:25:51', '2022-04-02 12:25:51'),
('381fc29dfa5d63b9fb9ce998ae250a3eac476914', '38893bead4799c27068973fdcc0e11826570dfd5', 21, 0, '8882123124795', 0, 0, 1, '2022-04-02 13:36:50', '2022-04-02 13:36:50'),
('3a1b30e1b15c5b620c1174ebe48ecc55a63bbfea', '7f2d54734aa12368d688249af2278a0557d32f68', 21, 0, '8882123125503', 0, 0, 1, '2022-04-02 13:36:48', '2022-04-02 13:36:48'),
('3e3dc16d79e91218dad1b8c6ad8a2d83cec63d7f', 'ad7242616548c4092d13a0ded02f1b68de1a0435', 21, 0, '8882123695562', 0, 0, 1, '2022-04-02 13:36:50', '2022-04-02 13:36:50'),
('433d279311d7227983268ebb9917875d3b8e6fd1', 'b3add856b83dfa2aa989e8e18b14fd901847dc7f', 4, 0, '8882123213473', 0, 0, 1, '2022-04-02 12:25:55', '2022-04-02 12:25:55'),
('43956dc295ba5b4830bd08d5da95cc98bb8f5e37', '9177f6e7020fcef583f437e7e83128ce9a31e113', 28, 0, '8882123115314', 0, 0, 1, '2022-08-01 04:56:59', '2022-08-01 04:56:59'),
('44b13f37b235ee1be58a4d927de45b1ac1fff5a4', '61f94ca2331902a32ec7a782cbf7a485cfd51875', 4, 0, '8882123154199', 0, 0, 1, '2022-04-02 12:25:53', '2022-04-02 12:25:53'),
('489bc690b3644601a30a593b62709a3aa7f8346a', '76e91292aea843a2c42174f9185b22a5760cfbff', 20, 0, '8882123148935', 0, 0, 2, '2022-04-06 07:15:25', '2022-04-06 07:15:25'),
('49b264967424c34be6d77aa5d674c5a4dc85ece0', '2591a357958af84a987297d0c09fb241a91caecc', 20, 0, '8882123149437', 0, 0, 2, '2022-04-06 07:59:51', '2022-04-06 07:59:51'),
('52b4afff0edfb1ec6cc896c74fa7848fbaa9f039', '41900fbba9156e9482a089741d6929014e9c4ba3', 24, 0, '8882123162491', 0, 0, 1, '2022-07-04 23:40:03', '2022-07-04 23:40:03'),
('55abb352181a3960b2794e5ccd1381f0d1587553', '65663976c7251f34e4fcc225a4cf3d8041c50054', 21, 0, '8882123277799', 0, 0, 1, '2022-04-02 13:36:50', '2022-04-02 13:36:50'),
('56a78038c7caeaa243076dd6adcc0759a00af3e1', 'ddb93661b51b9160091240b0afb9224506eccfab', 20, 0, '8882123192506', 0, 0, 2, '2022-04-06 07:24:04', '2022-04-06 07:24:04'),
('57241ad5bbe465d09de11d8b6db77b7d2df065ba', 'b049c890cc13a7a5a88e446153381e537d8f5d54', 21, 0, '8882123311946', 0, 0, 1, '2022-04-02 13:36:52', '2022-04-02 13:36:52'),
('5fd4e1a98e178a678a35eec4132c5ced9b2fdbef', 'fbf00a3fc9cd3e0879db2d3df1b32e1feb5e71f3', 28, 0, '8882123148700', 0, 0, 1, '2022-08-01 04:56:59', '2022-08-01 04:56:59'),
('6419fe5d6b9be429da4b418b7b5f5e1d8af345c6', '78f917f3622b27b7687cc322d14a9e28e95b8e4b', 28, 0, '8882123147779', 0, 0, 1, '2022-08-01 02:56:03', '2022-08-01 02:56:03'),
('645fffc149606911c70536570ae24369601bcedb', 'c63209560281aefc6d9f88f0fee3fee2de608b2b', 28, 0, '8882123965066', 0, 0, 1, '2022-08-01 04:59:33', '2022-08-01 04:59:33'),
('6c7c551b7bd6c53cfd9a3784b856669c4a9b398d', '016229673ba361d4d770125ea9869e047b6ed123', 4, 0, '8882123962112', 0, 0, 1, '2022-04-02 12:25:52', '2022-04-02 12:25:52'),
('6f8673a5d3e37e39684707fa728e91394c5faa23', '5329f6c59fde331c40de535d4a786b6376af92dc', 4, 0, '8882123142518', 0, 0, 1, '2022-04-02 12:25:52', '2022-04-02 12:25:52'),
('6fda4ade30c415347da1f33b3163987b6522eb71', '0e5f767c47f4f5cd31d1b138271f876e059ced5a', 4, 0, '8882123807329', 0, 0, 1, '2022-04-06 08:17:29', '2022-04-06 08:17:29'),
('700897ac94d0ab1679a4512a6adbbb2e73b76831', '30a56447dcdd0c78771175b46db39593879661f0', 27, 0, '8882123317133', 0, 0, 1, '2022-07-28 16:06:03', '2022-07-28 16:06:03'),
('7425c53f38091c3084284f976462c3379e6a3082', '7bc2a6aee47e85a51bd60608df52ecd4e1493d2a', 21, 0, '8882123149701', 0, 0, 1, '2022-04-02 13:36:49', '2022-04-02 13:36:49'),
('744ba3fc837e5897f68b9b53fd2c576a8ba20afb', 'f1014b235d53b7d07492bfec2d58a9eb80f28664', 21, 0, '8882123389631', 0, 0, 1, '2022-04-02 13:36:48', '2022-04-02 13:36:48'),
('74cd381ad5e992e1c9eb2c3e3997c75616d9f7f0', '58e58b84784fe0ebd15150efef72b2606978e5fb', 21, 0, '8882123149052', 0, 0, 1, '2022-04-02 13:36:47', '2022-04-02 13:36:47'),
('785c59b9e73df3c144f4e88383af0e337c2b98bf', '7ca5522598dbd84b87605acd4601d14ac3af6b82', 20, 0, '8882123201530', 0, 0, 2, '2022-04-06 08:14:20', '2022-04-06 08:14:20'),
('7c7a851889c424c5efc43f5af8d4d987744f3447', '0c44fed0b1048297deb0ea08d0dd6e736afd8e57', 28, 0, '8882123391470', 0, 0, 1, '2022-08-01 03:52:42', '2022-08-01 03:52:42'),
('82bc39198257e4dc1b987355ae08fc17f434d0b0', '6d728e53531a1f2328f1f529c54789ab1393aa6e', 7, 0, '8882123663530', 0, 0, 1, '2022-04-22 14:03:08', '2022-04-22 14:03:08'),
('8c75278ac64900044c6014168094d2804b697c05', 'e6006bcc7cfe79201d8c1ec8523a2fd58af441dd', 28, 0, '8882123187254', 0, 0, 1, '2022-08-01 04:56:59', '2022-08-01 04:56:59'),
('8df2f345f26d4d935483a7d9aab743bba1d4af78', '1ebff72d63885f5410a0b923ad6910669712177b', 21, 0, '8882123264989', 0, 0, 1, '2022-04-01 11:33:01', '2022-04-01 11:33:01'),
('8e43a09a043311649dd487e66383cf040b6d2cd0', '02adc253fd2c0a0def534d98264c2ace8ae8bb2f', 4, 0, '8882123930447', 0, 0, 1, '2022-04-02 12:25:54', '2022-04-02 12:25:54'),
('904ec7ad63db2d3fa8dd5d9896ef66e82e5c9fcf', '7520bdffe961390862e221945ba1613dc2ee6b03', 4, 0, '8882123168924', 0, 0, 1, '2022-04-02 12:25:52', '2022-04-02 12:25:52'),
('9b14594cfc4e314c6075d45632d5d3e7f227dc25', 'dc96b73c448f0c6849651626413ca19da620ec8f', 21, 0, '8882123137222', 0, 0, 1, '2022-04-02 13:36:46', '2022-04-02 13:36:46'),
('af33d5de76ff106d121754b78090ef258f964c69', 'e0f94c03fe23136a35fdefd8af2ff2029fe626a4', 21, 0, '8882123163215', 0, 0, 1, '2022-04-02 13:36:51', '2022-04-02 13:36:51'),
('b05578c4de2d1d5124cb73f726941f63254daff3', '2591a357958af84a987297d0c09fb241a91caecc', 5, 0, '8882123100931', 0, 0, 1, '2022-04-06 07:59:51', '2022-04-06 07:59:51'),
('b08c8f105b94a8b70b0bbb66dff8ef8577667a5f', '95648e53c8e4bff1f5cf299f22c59ec81381766c', 4, 0, '8882123208664', 0, 0, 1, '2022-04-02 12:25:53', '2022-04-02 12:25:53'),
('b67f489e59b868c7fe714b26b89259e756f3d729', '077f0b6de2162d35eee9b06c38cbff6086f159bc', 21, 0, '8882123109326', 0, 0, 1, '2022-04-02 13:36:46', '2022-04-02 13:36:46'),
('b6aaeb3430fd8020417947b9e021afff28c2b4b8', '150e2152dd47615701593a7c320bb0ecdc005c17', 4, 0, '8882123193414', 0, 0, 1, '2022-04-02 12:25:53', '2022-04-02 12:25:53'),
('c4b3fb13f607b7837a5e270a9b2d678230d8f90d', 'c64ab3e7fd232e2b993b114970dc82082cd6dacf', 4, 0, '8882123169742', 0, 0, 1, '2022-04-06 07:54:39', '2022-04-06 07:54:39'),
('c506f14eb5567306b6f018a01b1955b879e68d6d', '00ee9a0c961daa9c78102d6391e9ff66a5d635bd', 4, 0, '8882123179499', 0, 0, 1, '2022-04-02 12:25:54', '2022-04-02 12:25:54'),
('c815e4ddd8410c2ec3327bf66ab91b6449d29d56', 'dda33160a345bac6b15946382737198b032df04d', 21, 0, '8882123871242', 0, 0, 1, '2022-04-02 13:36:52', '2022-04-02 13:36:52'),
('cbf3c05ffe35e1fba2fd713b68641766584bc4f5', '08d5419589187213192d626da528d023639b5b76', 4, 0, '8882123121330', 0, 0, 1, '2022-04-06 07:56:51', '2022-04-06 07:56:51'),
('cc32151935905dcdb3629f51dd22aa8f8dbbe1b1', '3f65a292ae6150f1167b1d4189390d6877032ebe', 4, 0, '8882123124763', 0, 0, 1, '2022-04-02 12:25:54', '2022-04-02 12:25:54'),
('cc860f389be89ed0f5faae14acd84851f486cdcd', '64586f5dabd53aabdf2da6c4e841a10cb5b038e5', 4, 0, '8882123686085', 0, 0, 1, '2022-04-02 12:25:51', '2022-04-02 12:25:51'),
('cdf23a32024bfa6495f00caf7796aa67b1ccd809', '9df462d48d251f016eb6719a0d3195f955221de2', 4, 0, '8882123123394', 0, 0, 1, '2022-04-02 12:25:54', '2022-04-02 12:25:54'),
('d2d4c98bf2ffded521d5befa23f35798e10d0a1d', '65debaaf4874905ecc67882fe03028aa5bbbe178', 20, 0, '8882123135008', 0, 0, 2, '2022-04-06 07:30:09', '2022-04-06 07:30:09'),
('d7e2ea504e1b9d117d367e0fd38f70c70714d204', '6f17297a814e3f42addf6d2c2ce02d1d401d2431', 4, 0, '8882123546300', 0, 0, 1, '2022-04-02 12:25:51', '2022-04-02 12:25:51'),
('dad27d019b593c6998324c980ef31f6300587b1e', '25f034df5c000379de61e7aa61b009f8291fc33f', 4, 0, '8882123609143', 0, 0, 1, '2022-04-02 12:25:53', '2022-04-02 12:25:53'),
('daf74bdb84912d96286073289ee1cb692e35b685', '65debaaf4874905ecc67882fe03028aa5bbbe178', 5, 0, '8882123106837', 0, 0, 1, '2022-04-06 07:30:08', '2022-04-06 07:30:08'),
('dc171f9b3721ae16e7850000a73e1bff4386b759', 'b7b411c27d7ebe65d0dcda0430b93a5bb33b9724', 21, 0, '8882123129820', 0, 0, 1, '2022-04-02 13:36:47', '2022-04-02 13:36:47'),
('e04d3dcae05f578e005da730c27af4b3ce5d1950', '7d99f0ce82d7e69c75c8251dd7b73dd05dae766b', 21, 0, '8882123718551', 0, 0, 1, '2022-04-02 13:36:47', '2022-04-02 13:36:47'),
('e9c670685d1471135b73d386ce034ef8baf3926e', '33d5a2f0128beb644809eff90bc471812f910b7b', 28, 0, '8882123150894', 0, 0, 1, '2022-08-01 04:59:33', '2022-08-01 04:59:33'),
('efeebc43138c9bcf92bbba1f7ea5bfe19fc816bc', '76e91292aea843a2c42174f9185b22a5760cfbff', 4, 0, '8882123719625', 0, 0, 1, '2022-04-06 07:15:25', '2022-04-06 07:15:25'),
('f0b1587629bdbe2882d04b06065b20614aa9f843', '82f02893b1fda472535bdae2b966fcd39b2d0ce5', 4, 0, '8882123123919', 0, 0, 1, '2022-04-02 12:25:55', '2022-04-02 12:25:55'),
('f0deedee115f9a4eac7e4913b008b245333a5efa', '8fdebe91e251b58dcdeeff958224b6c3eda805cc', 4, 0, '8882123142285', 0, 0, 1, '2022-04-02 12:25:52', '2022-04-02 12:25:52'),
('f7c70b06fdf5f2ee1f4f7b57d5c0e786316c9520', 'f6dd0d4dbd6e4c9327b7b04334882588b3b9a8c1', 28, 0, '8882123372087', 0, 0, 1, '2022-07-31 05:58:28', '2022-07-31 05:58:28'),
('fccf4dcb5d09565afeecf7ff19410a63a3cfa7df', 'ad4fc0c4eb13677ec940cd239a0082ff562939a2', 21, 0, '8882123125918', 0, 0, 1, '2022-04-02 13:36:48', '2022-04-02 13:36:48');

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
(1, 'République Démocratique du Congo'),
(2, 'Chine'),
(3, 'Gabon'),
(4, 'République du Congo');

-- --------------------------------------------------------

--
-- Structure de la table `table_siege`
--

CREATE TABLE `table_siege` (
  `ID_Siege` int(10) UNSIGNED NOT NULL,
  `ID_Avion` int(10) UNSIGNED NOT NULL,
  `Design_Siege` varchar(10) NOT NULL,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `table_statut`
--

CREATE TABLE `table_statut` (
  `ID_Statut` int(10) UNSIGNED NOT NULL,
  `Design_Statut` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_statut`
--

INSERT INTO `table_statut` (`ID_Statut`, `Design_Statut`) VALUES
(1, 'Admin'),
(2, 'User_IT'),
(3, 'User_Finance'),
(4, 'Vendeur'),
(5, 'User_Checkin'),
(6, 'Chef_Escale');

-- --------------------------------------------------------

--
-- Structure de la table `table_tarif`
--

CREATE TABLE `table_tarif` (
  `ID_Tarif` int(10) UNSIGNED NOT NULL,
  `ID_Ville_Depart` int(10) UNSIGNED NOT NULL,
  `ID_Ville_Arrivee` int(10) UNSIGNED NOT NULL,
  `ID_Cat_Vol` int(10) UNSIGNED NOT NULL,
  `ID_Classe` int(10) UNSIGNED NOT NULL,
  `ID_Monnaie` int(10) UNSIGNED NOT NULL,
  `Montant_Billet_Adulte` double NOT NULL,
  `Taxe_Adulte` double NOT NULL,
  `Montant_Billet_Enfant` double NOT NULL,
  `Taxe_Enfant` double NOT NULL,
  `Montant_Billet_Bebe` double NOT NULL,
  `Taxe_Bebe` double NOT NULL,
  `Offre_Soumis_Condition` int(11) NOT NULL DEFAULT 0,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp(),
  `Date_Modif` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ID_Utilisateur` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_tarif`
--

INSERT INTO `table_tarif` (`ID_Tarif`, `ID_Ville_Depart`, `ID_Ville_Arrivee`, `ID_Cat_Vol`, `ID_Classe`, `ID_Monnaie`, `Montant_Billet_Adulte`, `Taxe_Adulte`, `Montant_Billet_Enfant`, `Taxe_Enfant`, `Montant_Billet_Bebe`, `Taxe_Bebe`, `Offre_Soumis_Condition`, `Date_Enreg`, `Date_Modif`, `ID_Utilisateur`) VALUES
(6, 1, 4, 2, 1, 0, 300, 0, 165, 0, 65, 0, 1, '2021-08-20 13:51:41', '2021-09-10 13:31:45', 1),
(7, 5, 3, 2, 1, 0, 250, 0, 140, 0, 50, 0, 0, '2021-08-20 16:00:14', '2021-08-29 19:56:24', 1),
(8, 1, 3, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, '2021-08-20 16:46:33', '2021-08-29 19:56:24', 1),
(9, 1, 2, 2, 1, 0, 230, 20, 145, 10, 40, 5, 0, '2021-08-25 14:57:08', '2021-08-29 19:56:24', 1),
(10, 1, 2, 1, 1, 0, 400, 50, 250, 20, 100, 20, 0, '2021-09-03 11:22:23', '2021-09-04 04:05:11', 1),
(11, 2, 1, 2, 1, 0, 222, 0, 120, 0, 60, 0, 0, '2021-09-04 03:26:34', '2021-09-04 03:26:34', 1),
(12, 1, 8, 2, 1, 0, 266, 0, 130, 0, 60, 0, 0, '2021-09-16 11:35:05', '2021-09-16 11:35:05', 1),
(13, 1, 10, 2, 1, 0, 102.52, 57.48, 57.87, 42.13, 24.95, 25.05, 0, '2021-09-21 12:54:45', '2021-09-21 12:54:45', 1),
(14, 1, 9, 2, 1, 0, 198.21, 67.79, 111.87, 48.13, 30.05, 24.95, 0, '2021-09-21 13:02:57', '2021-09-21 13:02:57', 1),
(15, 10, 9, 2, 1, 0, 75.79, 30.21, 42.25, 22.75, 32.5, 17.5, 0, '2021-09-21 16:02:12', '2021-09-21 16:05:36', 1),
(16, 8, 10, 2, 1, 0, 75.79, 30.21, 42.25, 22.75, 32.5, 17.5, 0, '2021-09-22 18:41:35', '2021-09-22 18:41:35', 1),
(17, 1, 7, 2, 1, 0, 305, 0, 200, 0, 100, 0, 0, '2021-10-26 10:15:34', '2021-10-26 10:15:34', 1),
(18, 7, 1, 2, 1, 0, 305, 0, 200, 0, 100, 0, 0, '2021-10-26 10:16:19', '2021-10-26 10:16:19', 1);

-- --------------------------------------------------------

--
-- Structure de la table `table_tarif_excedent`
--

CREATE TABLE `table_tarif_excedent` (
  `ID_Tarif` int(10) UNSIGNED NOT NULL,
  `ID_Ville_Depart` int(10) UNSIGNED NOT NULL,
  `ID_Ville_Arrivee` int(10) UNSIGNED NOT NULL,
  `Montant_Kilos` double NOT NULL,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp(),
  `Date_Modif` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ID_Utilisateur` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `table_vente`
--

CREATE TABLE `table_vente` (
  `ID_Vente` varchar(100) NOT NULL,
  `ID_Client` varchar(100) NOT NULL,
  `ID_Cat_Vol` int(10) UNSIGNED NOT NULL,
  `ID_Tarif` int(10) UNSIGNED NOT NULL,
  `Numero_PNR` varchar(10) NOT NULL,
  `Numero_Billet` varchar(20) NOT NULL,
  `Montant_Paye` double NOT NULL,
  `Taxe_Paye` double NOT NULL,
  `Utilisateur` varchar(50) DEFAULT NULL,
  `Date_Vente` date NOT NULL,
  `Statut` int(11) NOT NULL DEFAULT 1,
  `Annulation` int(11) NOT NULL DEFAULT 0,
  `Remboursement` int(11) NOT NULL DEFAULT 0,
  `Mod_Insertion` int(11) NOT NULL DEFAULT 0,
  `ID_Utilisateur` int(10) UNSIGNED NOT NULL,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp(),
  `Date_Modif` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_vente`
--

INSERT INTO `table_vente` (`ID_Vente`, `ID_Client`, `ID_Cat_Vol`, `ID_Tarif`, `Numero_PNR`, `Numero_Billet`, `Montant_Paye`, `Taxe_Paye`, `Utilisateur`, `Date_Vente`, `Statut`, `Annulation`, `Remboursement`, `Mod_Insertion`, `ID_Utilisateur`, `Date_Enreg`, `Date_Modif`) VALUES
('002aa1301bdebe276c9b128056cbbd9bff64f31d', '99f4d1effafea6eab1e5439df3374deb68a3f3bb', 1, 10, 'Y0YWE', '8882123154714', 400, 50, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 04:18:56', '2021-09-20 04:18:56'),
('00ee9a0c961daa9c78102d6391e9ff66a5d635bd', '612c8f06b272cb2105568b027aef07fa73aaec0a', 2, 6, 'L8ZTL', '8882123110494', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:53', '2022-04-02 12:25:53'),
('016229673ba361d4d770125ea9869e047b6ed123', 'a3c0c15b3ac97a12efb07a27fad90b5702f686f6', 2, 6, '26MJI', '8882123349076', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:51', '2022-04-02 12:25:51'),
('02adc253fd2c0a0def534d98264c2ace8ae8bb2f', '7ccdcecad9614b1c8c152097c1faf37fb25b2e39', 2, 6, 'H8ZGM', '8882123215690', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:54', '2022-04-02 12:25:54'),
('042eb481af6cb647bcf1112390e6e5064e2259d7', '5852b979a8e83cb37d88a5c4f09ef78292af42f2', 2, 12, 'Y5ZWI', '8882123766838', 266, 0, NULL, '2021-10-20', 1, 0, 0, 0, 1, '2021-10-20 11:04:48', '2021-10-20 11:04:48'),
('05d4096145bcb533c429d057efde1689e1dc4981', '20e7af747ff8ad99210a25a47e33d5dafe3ae83a', 2, 6, 'K4NDA', '8882123312549', 300, 0, NULL, '2022-03-23', 1, 0, 0, 0, 1, '2022-03-22 23:19:26', '2022-03-22 23:19:26'),
('077f0b6de2162d35eee9b06c38cbff6086f159bc', '68762df08e1fe3ea6e941ed9fe7f1381e01d9b66', 2, 17, '33ZJB', '8882123101152', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:46', '2022-04-02 13:36:46'),
('078319e07dc465ec88327b66147902be6875868c', 'd24c6da70221e39f8312eca7490aa3632c09a049', 1, 6, '41MZE', '8882123146177', 600, 0, NULL, '2022-03-26', 1, 0, 0, 0, 1, '2022-03-26 00:24:13', '2022-03-26 00:24:13'),
('08d5419589187213192d626da528d023639b5b76', '90cd299bb507e2011e354220faa478858e42c211', 1, 6, 'K0NTQ', '8882123609112', 600, 0, NULL, '2022-04-06', 1, 0, 0, 0, 1, '2022-04-06 07:56:51', '2022-04-06 07:56:51'),
('0b6b7c048b5e9bbc7f5b7097bb7b4859f17f835f', '30187b78007974be43dd1ff787193c78699e7b70', 2, 9, '24YJD', '8882123803603', 230, 20, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 05:35:30', '2021-09-20 05:35:30'),
('0c44fed0b1048297deb0ea08d0dd6e736afd8e57', '64aed0ab7820ff6d655d0f0320f29157dcda9ecd', 1, 6, '07NGZ', '8882123209988', 600, 0, NULL, '2022-08-01', 1, 0, 0, 0, 1, '2022-08-01 03:52:42', '2022-08-01 03:52:42'),
('0e5f767c47f4f5cd31d1b138271f876e059ced5a', 'eb135aab7c7c7c8dad37acaf85fd609ef83234e5', 1, 6, '18ZJC', '8882123607298', 600, 0, NULL, '2022-04-06', 1, 0, 0, 0, 1, '2022-04-06 08:17:29', '2022-04-06 08:17:29'),
('139111d4ec0358c01bfb6311e2737141b3ceb1c8', 'cd1787aa5f2afed5855c13b997c5caba106d9a77', 2, 12, '51MTE', '8882123883285', 60, 0, NULL, '2021-09-30', 1, 0, 0, 0, 1, '2021-09-30 09:48:34', '2021-09-30 09:48:34'),
('150e2152dd47615701593a7c320bb0ecdc005c17', '97f9bff65829414a34cd2a7ce537e1ad0949c375', 2, 6, 'W4ZTI', '8882123182407', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:53', '2022-04-02 12:25:53'),
('1623650001968906a43adb18fa87eeb5b009a228', '51881a511fba908a45a96a4ce70bc7021fe66cf4', 2, 14, 'Y3MZY', '8882123200767', 30.05, 24.95, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 15:27:14', '2021-09-21 15:27:14'),
('16673bd2249a04e60cede4578a1a32810c45e6f0', '18ca9777ae1267a7da13962b65cc51ed6c79a11e', 2, 6, '27NZN', '8882123161290', 300, 0, NULL, '2022-03-30', 1, 0, 0, 0, 1, '2022-03-30 08:52:14', '2022-03-30 08:52:14'),
('18d785fea8591d4453d9191b76d13f84c0c702ff', '3c942521c8425574efec1d4dd9558105dace298c', 2, 14, 'K9NZG', '8882123241013', 198.21, 67.79, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 13:12:05', '2021-09-21 13:12:05'),
('1ab66044c5465ce2ab85405ab28cd6b1e6356db5', '257180fc80fb282bd7c10d19cbabcd99f5031e70', 1, 17, 'I1NJY', '8882123814288', 610, 0, NULL, '2021-11-04', 0, 1, 0, 0, 1, '2021-11-04 10:53:48', '2021-11-04 10:54:33'),
('1e8307488df8c200b5b91ebb64c1cf75a4828ee9', '9f1f8e3afb6195c1519a188c44bdccf3c2ddfe74', 2, 9, '42MZA', '8882123131956', 230, 20, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 06:14:04', '2021-09-20 06:14:04'),
('1ebff72d63885f5410a0b923ad6910669712177b', '24dc3021996ba55c57b4c69c7c5c761b57e7a02f', 2, 17, 'I1ZMY', '8882123264484', 305, 0, NULL, '2022-04-01', 1, 0, 0, 0, 1, '2022-04-01 11:33:01', '2022-04-01 11:33:01'),
('1f9c67f2326a53929f30c5712a1db3f56018b47f', 'fa0e63c27524a9cdb195c78cb7f6afa72473b770', 1, 10, '53YZY', '8882123105988', 400, 50, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 04:43:55', '2021-09-20 04:43:55'),
('21883cb325c2c6834d0e69d11410c8832f49f660', 'aa8912db8ca49d4d6b97ee29a735d2cf52eb5a73', 2, 15, '47ODN', '8882123189075', 75.79, 30.21, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 16:24:03', '2021-09-21 16:24:03'),
('226d50c9139a7a9c924abcae00515adb76b0399f', 'bf7423494d71f8fbc1994308e43d3dbb97e7f62a', 2, 14, '23ZDU', '8882123108442', 111.87, 48.13, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 15:17:06', '2021-09-21 15:17:06'),
('22fe405ef6b0ae3ef360c2f24528e91d415fe6e1', 'b8fc2f1347f6deab37f5b6684238b06514bff243', 2, 9, 'M5ZTQ', '8882123176985', 230, 20, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 05:48:40', '2021-09-20 05:48:40'),
('23bb4d60170c3dfdca4dd6a27e3b46420b504055', 'b294dfcc06fa1a607af84354b5cc632d13d540ae', 1, 6, 'I3YJR', '8882123141317', 600, 0, NULL, '2022-03-30', 1, 0, 0, 0, 1, '2022-03-30 08:47:37', '2022-03-30 08:47:37'),
('24778d39dc007ceca1e9d7635236bf7ab9d7d817', '7d6c9ff09ac5ed3a4f763349c4cb398e853f5326', 2, 9, '30NZH', '8882123176138', 230, 20, NULL, '2021-09-13', 1, 0, 0, 0, 1, '2021-09-13 08:20:56', '2021-09-13 08:20:56'),
('2591a357958af84a987297d0c09fb241a91caecc', '377d29230d5e5d213ad2e7a28fb38baa77bae1e4', 1, 6, '55MWE', '8882123836442', 130, 0, NULL, '2022-04-06', 1, 0, 0, 0, 1, '2022-04-06 07:59:51', '2022-04-06 07:59:51'),
('25f034df5c000379de61e7aa61b009f8291fc33f', '65616c11aedd7cb68a9debc3037d8a3377f0a465', 2, 6, 'M7MDM', '8882123189916', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:53', '2022-04-02 12:25:53'),
('26cf2a7d86efb9ba7ad341601aa1cacf4dedc0aa', '2611fd2ff82e4b6c180ed4d237f4d843a8bff02c', 2, 17, 'J7ZJJ', '8882123213805', 305, 0, NULL, '2021-11-12', 1, 0, 0, 0, 1, '2021-11-12 11:09:18', '2021-11-12 11:09:18'),
('28c2e20d1856c640fd6e1a8e36251ebb6f3ee849', '83baccce8bc87647879bbe681dd52c577fa19b6d', 2, 6, 'J4MMU', '8882123854439', 65, 0, NULL, '2022-03-23', 1, 0, 0, 0, 1, '2022-03-23 05:15:19', '2022-03-23 05:15:19'),
('28e488dbe12c2563d6629b4762dabbec7d75fb58', '4ecf6ffe85e98700c7653cacd8e2ffc4464348a8', 2, 14, 'L5NDG', '8882123146547', 198.21, 67.79, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 14:59:36', '2021-09-21 14:59:36'),
('2b6d3019509b5c845d8d012574aa1b9fd2e2b9be', '4f3d2cac7888a97aace6bb4ce0a50381e644a4af', 2, 17, '22ZDM', '8882123399102', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:52', '2022-04-02 13:36:52'),
('2d8d387f62a98beaaa3f2f6a7729e38659983dc1', '45e6886e70a22abdf632612e547d1636ae2a3abf', 2, 16, '40ZDM', '8882123166015', 75.79, 30.21, NULL, '2021-09-22', 1, 0, 0, 0, 1, '2021-09-22 18:51:58', '2021-09-22 18:51:58'),
('2ecc6969a824fa25491dedc143c7c676e73c2e4c', '39479288a5c68081f85eb06f29dbe97e8ea7b35c', 2, 18, 'J0YZY', '8882123734875', 200, 0, NULL, '2021-11-04', 1, 0, 0, 0, 1, '2021-11-04 11:06:59', '2021-11-04 11:06:59'),
('30a56447dcdd0c78771175b46db39593879661f0', '6b7be619594aaef0edf99ce2acc0fb47919960e2', 2, 6, 'H9NTY', '8882123200908', 300, 0, NULL, '2022-07-28', 1, 0, 0, 0, 1, '2022-07-28 16:06:03', '2022-07-28 16:06:03'),
('319564e0b51f735367ab0d0d2d3ed41f29f2bb7c', '7542100c55b176b0e33fd1d9f89b1e8eea975220', 2, 6, '54NTY', '8882123205232', 65, 0, NULL, '2022-08-01', 1, 0, 0, 0, 1, '2022-08-01 02:57:36', '2022-08-01 02:57:36'),
('33429569eda00d3965e142e37a9f661299ca0e22', 'afabb5520b6db57272c25d50ca64fbdf2e708e18', 2, 16, '04MJK', '8882123962485', 42.25, 22.75, NULL, '2021-09-22', 1, 0, 0, 0, 1, '2021-09-22 18:45:51', '2021-09-22 18:45:51'),
('33918b99c7fa379c079910ae06cb88e19fccff6d', 'e9482a5b1d430dc6b2e9d673bdad2658391cd598', 2, 6, '52MTH', '8882123173555', 300, 0, NULL, '2021-09-15', 1, 0, 0, 0, 7, '2021-09-15 10:56:52', '2021-09-15 10:56:52'),
('339594c67baf8a63655982bfac20e47f9562aaeb', '9f933426a1bc4db0139c1d083bec389e55499a0f', 2, 14, '57NTK', '8882123172837', 198.21, 67.79, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 13:31:56', '2021-09-21 13:31:56'),
('33d5a2f0128beb644809eff90bc471812f910b7b', 'ecda9e12c3dfed4d2b7fb0a27a01966b442c379f', 2, 6, 'K5NWE', '8882123169506', 300, 0, NULL, '2022-08-01', 1, 0, 0, 0, 1, '2022-08-01 04:59:33', '2022-08-01 04:59:33'),
('38893bead4799c27068973fdcc0e11826570dfd5', '1f9f07a6ef489f9f72a0bea0657960184dde1a87', 2, 17, '46OTN', '8882123119388', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:50', '2022-04-02 13:36:50'),
('39b47912691c85d25a1592d807e5d8b0f8aca06d', '4cc9b5fb4322d679f6bc69176dd7f72ff5f01fbf', 2, 6, 'I8NDC', '8882123172495', 300, 0, NULL, '2021-09-10', 1, 0, 0, 0, 7, '2021-09-10 14:30:07', '2021-09-12 12:38:47'),
('3b2d8a44ff61a906085ff660f58bf7f4593b7a73', '91d6fc64d31457fc2dc27c212647987aafd3f63e', 2, 6, 'Y9ZDH', '8882123194340', 300, 0, NULL, '2022-03-22', 0, 1, 0, 0, 1, '2022-03-22 09:41:38', '2022-03-22 22:57:54'),
('3c9a6aa78adf6da8e0ee5006fe6c69e8258e8042', '1e4ecd9b181f480f35b1bfe6d4c273790bc4e004', 2, 12, '53YTZ', '8882123828585', 266, 0, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 12:41:53', '2021-09-21 12:41:53'),
('3d4a53a1b6622e62dec04fcc28505336a7246099', '1b79a4ff98d21e2157d642537352d8ab11524e58', 2, 17, '09YTU', '8882123180788', 305, 0, NULL, '2021-11-03', 1, 0, 0, 0, 1, '2021-11-03 08:44:19', '2021-11-03 08:44:19'),
('3e1bc7d8e6710e77d885e01d999b53b2e821fe06', '412978d8eadf20995fca9f7cfed7df6447e3515a', 2, 17, 'X3YMM', '8882123178579', 305, 0, NULL, '2021-11-03', 1, 0, 0, 0, 1, '2021-11-03 09:55:44', '2021-11-03 09:55:44'),
('3ed215a5f13206ddef5791a469bfd31433958f35', '5fa08b601c643023ff64d924e1fd033eb0e5e185', 1, 6, 'K3MJE', '8882123183205', 600, 0, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 15:14:45', '2021-09-20 15:14:45'),
('3f65a292ae6150f1167b1d4189390d6877032ebe', '3bce2585d392b7ab1278a24a6116c72a901f1ec0', 2, 6, '20NWE', '8882123677585', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:54', '2022-04-02 12:25:54'),
('415f2625710d01fc7d3b7ee084ac08a6e4a8536a', 'c8d2402d73f27aebd4372cf6e9c25c4648ad9c8c', 2, 17, '19ZJI', '8882123167170', 305, 0, NULL, '2021-11-03', 1, 0, 0, 0, 1, '2021-11-03 08:44:19', '2021-11-03 08:44:19'),
('41900fbba9156e9482a089741d6929014e9c4ba3', '5e51ffea2385b4d573c5e2e63493a7ce69894688', 2, 6, '56MDB', '8882123177543', 300, 0, NULL, '2022-07-05', 1, 0, 0, 0, 1, '2022-07-04 23:40:03', '2022-07-04 23:40:03'),
('41bd01768cd298515d3587888021b0517ac4e7a5', 'd447428f678c18f08f1245a089dc93f7d7229d67', 1, 10, 'I7ZDA', '8882123186812', 400, 50, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 04:39:19', '2021-09-20 04:39:19'),
('425c63c13acae02489a7e3e48042d9ced1c366c7', '3125a18e6e8eafeb516215ec5b6156b70c9f8ec6', 2, 16, '18YZY', '8882123802030', 75.79, 30.21, NULL, '2021-09-22', 1, 0, 0, 0, 1, '2021-09-22 18:53:20', '2021-09-22 18:53:20'),
('42a0424e8813ccfa1ab309b4450468e843e83533', '4747876a2754039fba2a7736105ec29d231c2bdd', 1, 6, 'H0MDQ', '8882123125662', 600, 0, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 13:01:39', '2021-09-20 13:01:39'),
('43ceb00e5b1f22fcda3d7c13e8cb7753dad738f4', '16c1cb7142ac495708cf8c0ee5e4a35ea3a24ef0', 1, 10, 'J7ZWI', '8882123177093', 400, 50, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 04:35:31', '2021-09-20 04:35:31'),
('4467f196150c0b8a18feb0105289e08994e42939', '13836d31e1cb7e78e0b2b1edfcfddb6e04c8bce1', 2, 9, '23N2Y', '8882123195856', 230, 20, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 06:17:07', '2021-09-20 06:17:07'),
('4772de308660164e21e23e208d90060cf3049734', '407ec6fbba150d63971d45c3d28446c33a0a0284', 2, 6, '31MMR', '8882123776876', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:51', '2022-04-02 12:25:51'),
('47e53462a048a2bbc6472c86732fa74e9b4162bd', 'a63f91aed17f58c9038c952dffe0547f33aa76bd', 2, 6, 'L1NTM', '8882123114889', 300, 0, NULL, '2022-03-23', 1, 0, 0, 0, 1, '2022-03-23 05:23:22', '2022-03-23 05:23:22'),
('48530b173b9f827e7d863ef5c2a65fdc5c5e8104', 'd782d9a408915238150eaa7858e4e2151ea0365a', 2, 14, '18MZB', '8882123119919', 198.21, 67.79, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 14:34:46', '2021-09-21 14:34:46'),
('496ea3101528a3cd500ef66f9a273addc35012d3', 'cff28e840c25768bc1779afd4a043dc20038ff87', 1, 6, '23ZWE', '8882123114036', 600, 0, NULL, '2022-03-23', 2, 0, 0, 0, 1, '2022-03-23 04:38:25', '2022-03-23 05:46:42'),
('4acdbc3da8a43db23a1798b36d00b82e18f84771', '2784c943e2c4975880485eecc1d5f6eb7f0a4740', 2, 17, 'J4ZGJ', '8882123165591', 305, 0, NULL, '2021-10-26', 1, 0, 0, 0, 7, '2021-10-26 10:18:52', '2021-10-26 10:18:52'),
('4cc30c1fb6af31796de9cc17ee0a4df4f46d24d3', '47c91172f98d54a212ac317720eacb7a4759a81c', 2, 9, 'J0MZB', '8882123142530', 230, 20, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 06:02:30', '2021-09-20 06:02:30'),
('4e38649c51297cd7b6a282bf774149f1b2bc2032', '843ca714ceb4661596ff63a24c6a4b2f72a5a489', 2, 6, 'Z3ODY', '8882123161374', 165, 0, NULL, '2021-09-10', 1, 0, 0, 0, 7, '2021-09-10 14:27:09', '2021-09-12 12:38:47'),
('4eda37e2738dd8483746116750925f1110f034cb', 'e04ab6d79f4573f0feb022bf41ecbc2d1c88a51b', 2, 17, 'K1YTM', '8882123821928', 100, 0, NULL, '2021-11-04', 1, 0, 0, 0, 1, '2021-11-04 10:49:21', '2021-11-04 10:49:21'),
('5329f6c59fde331c40de535d4a786b6376af92dc', 'cd7f98dc8c819802db8cc8b5a801e89daddfea86', 2, 6, 'Y1OWY', '8882123281953', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:52', '2022-04-02 12:25:52'),
('545ba637550e208e8e78254fb568854ffd2c6ed3', '7f64006e4b3a89b021cbdee2be0f6c1ee6395f2d', 1, 6, '16YME', '8882123166552', 600, 0, NULL, '2022-03-22', 0, 0, 1, 0, 1, '2022-03-22 09:14:43', '2022-03-22 23:10:20'),
('58bb4acc3176c215eb6a2720c76c96a5f95d1f38', '1d635c79874be9fb0805827ba0cdebb715e5d4b0', 2, 17, 'I5YJR', '8882123114583', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:50', '2022-04-02 13:36:50'),
('58cd8ae305288eb8c8e69e9f72dcf7e1d103d2c9', 'c589b004a5faa8d5b352e636eab110c75d081496', 2, 17, 'J6ZDH', '8882123210406', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:51', '2022-04-02 13:36:51'),
('58e58b84784fe0ebd15150efef72b2606978e5fb', 'e1a8a924f51f563e69ddbc10f4037f0142efe304', 2, 17, 'L1NTH', '8882123538239', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:47', '2022-04-02 13:36:47'),
('5a8ed922bfe90aa9875f28af81dd5c0ecced3966', 'fe650462c12dd5b900ceeb005dd988d080426415', 1, 10, '45ZWQ', '8882123195531', 400, 50, NULL, '2021-09-29', 2, 0, 0, 0, 7, '2021-09-29 04:39:10', '2021-09-29 14:31:06'),
('5bd4ca77082251edb8adfcecec8ebc632e368004', 'f3ebb64a14a91f2d1771a4e1431e9b1181a5cb42', 2, 6, 'K7NGN', '8882123443276', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:52', '2022-04-02 12:25:52'),
('5e022c2b2dc2159550dfb3019cfded2ce46a7e3f', '3129828b4b15d7237f1740a6f479a7e57dad3ee4', 1, 6, 'W7MJJ', '8882123920951', 600, 0, NULL, '2022-03-28', 1, 0, 0, 0, 7, '2022-03-28 05:25:40', '2022-03-28 05:25:40'),
('61685139f7a468c27be28131ecf312364176d4bb', '59b13646bf426db4b7cb63491428c56e3378d196', 2, 9, '29ODU', '8882123946658', 230, 20, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 05:34:13', '2021-09-20 05:34:13'),
('61f94ca2331902a32ec7a782cbf7a485cfd51875', 'f6c9743697900ef09559208c1f0d9d169a160ca9', 2, 6, 'M1OTR', '8882123118775', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:53', '2022-04-02 12:25:53'),
('62e174ffb5e0bb88dc3da223e905f16e8464ae48', 'd05ed61b87e5281ae94bbaaad8242b51786afbf7', 2, 6, 'L4MTC', '8882123184933', 300, 0, NULL, '2021-09-15', 1, 0, 0, 0, 7, '2021-09-15 12:39:21', '2021-09-16 14:57:48'),
('644c79ea97be3e638ac80808315ab4d1a2f982b3', 'b08b8dc331b35936dae899ca70c0f7f1d2680a9e', 2, 18, '05YZC', '8882123114585', 305, 0, NULL, '2021-10-26', 1, 0, 0, 0, 7, '2021-10-26 10:23:28', '2021-10-26 10:23:28'),
('64586f5dabd53aabdf2da6c4e841a10cb5b038e5', '99ad4a4db5ccf9089134c35ebdedc83e86d40776', 2, 6, '13ODZ', '8882123449705', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:51', '2022-04-02 12:25:51'),
('65663976c7251f34e4fcc225a4cf3d8041c50054', '445c33fcb33c721dc28a34877bac13ff83f4fdff', 2, 17, '24NJM', '8882123988609', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:50', '2022-04-02 13:36:50'),
('65debaaf4874905ecc67882fe03028aa5bbbe178', '34afb859cc6beef0a56449ee069d9a024f3485f4', 1, 6, 'K9ZWJ', '8882123943089', 600, 0, NULL, '2022-04-06', 1, 0, 0, 0, 1, '2022-04-06 07:30:08', '2022-04-06 07:30:08'),
('67209f86a2017dc0ef7c154c6f34444dead54f94', '53933ceedf738e95b6e84310540a3fffb73158fd', 2, 14, 'Y1MDL', '8882123141309', 198.21, 67.79, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 15:45:56', '2021-09-21 15:45:56'),
('67c13d5add6cb28054ef13ea831f23179bb21f2c', 'a18f4e0e31ed9c5e786eabb31a19b683965024f2', 1, 10, 'J6MTN', '8882123441695', 400, 50, NULL, '2021-09-27', 1, 0, 0, 0, 1, '2021-09-27 11:31:41', '2021-09-27 11:31:41'),
('68532db867aac0b00626c8598849944d5346e7ae', '306d66c7650f61ee2ea74df60f94a5df7a38d0c0', 2, 17, '16MZJ', '8882123108481', 200, 0, NULL, '2021-11-12', 1, 0, 0, 0, 1, '2021-11-12 11:09:18', '2021-11-12 11:09:18'),
('6a4198e7529b80465ad37ccf3302f463ffa6d3b4', '9650f1c401195b34b73c2fa005a5daf7bddab8b0', 1, 17, '07MTK', '8882123255155', 610, 0, NULL, '2021-10-27', 2, 0, 0, 0, 1, '2021-10-27 12:47:37', '2021-10-27 14:11:00'),
('6b05866d9c991184349c890907edb5d73b50f30b', '6c43dc6c5383fdd6fc643f97d037e1e7e5465273', 2, 13, 'W7NTG', '8882123102458', 102.52, 57.48, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 12:56:28', '2021-09-21 12:56:28'),
('6d728e53531a1f2328f1f529c54789ab1393aa6e', '58ce1fca8d2ab132054d3c82dbc14a76605c483e', 2, 6, '38MJH', '8882123259986', 300, 0, NULL, '2022-04-22', 1, 0, 0, 0, 7, '2022-04-22 14:03:08', '2022-04-22 14:03:08'),
('6ddc83e34db60b6c7bd402b288131c65ef5ccac7', '31333f6c31adb2a4bf56378470ea5e31e0aa0a18', 2, 12, 'K6YZG', '8882123138745', 266, 0, NULL, '2021-09-16', 1, 0, 0, 0, 1, '2021-09-16 11:41:43', '2021-09-16 14:57:48'),
('6e71c8f9f4b6aff870053f8b4e3ac095823d5790', '1e5613d1c0685fd110d69ff3f42dd45ba63c78d3', 2, 6, '39MWM', '8882123188685', 65, 0, NULL, '2022-03-30', 1, 0, 0, 0, 1, '2022-03-30 08:52:14', '2022-03-30 08:52:14'),
('6f17297a814e3f42addf6d2c2ce02d1d401d2431', 'ac6991683abaff953afb3bea5616dbbf8d640b83', 2, 6, 'X6NZI', '8882123993977', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:51', '2022-04-02 12:25:51'),
('719630c3796e2efbff2944a451f45f80512ffff9', '28a19b2373c76003f980302c53ce33d90064d5da', 2, 12, '56NJM', '8882123804079', 266, 0, NULL, '2021-09-17', 1, 0, 0, 0, 1, '2021-09-17 13:47:52', '2021-09-17 13:47:52'),
('719956bede9d7bb879b5bee6333c6966753fb4e2', '884acfd07b70a58d4315227f323514b48815ce90', 2, 9, '57OTU', '8882123716841', 230, 20, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 06:18:36', '2021-09-20 06:18:36'),
('719d1f4e8cda04f978304c2f1310f84395f23521', 'a9e8868bd11ea55a987f0eedc661c9c6c0a8528c', 2, 14, '59ZDF', '8882123574227', 198.21, 67.79, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 15:43:34', '2021-09-21 15:43:34'),
('723d17c9d366db1abb14af6aff1a26e24591bf9f', 'ef2463a497a9bc96d3da96f829bd8589c28b98f2', 2, 6, 'Z4ZDE', '8882123925957', 65, 0, NULL, '2022-03-26', 1, 0, 0, 0, 1, '2022-03-26 10:17:39', '2022-03-26 10:17:39'),
('726e543245098ad10d6fc1a8e762bbd21cd8b112', '82ceb28ae0b467bc392e08d9829c097255843b30', 2, 6, '28ZTU', '8882123121812', 300, 0, NULL, '2021-09-18', 1, 0, 0, 0, 1, '2021-09-18 07:50:43', '2021-09-18 07:50:43'),
('751d900cdd309d54297d69589872aeb0abab03bc', '52e99cf92c0b73e5dbfc9896669f46549041f11c', 2, 9, 'X2ZDK', '8882123847252', 230, 20, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 05:41:24', '2021-09-20 05:41:24'),
('7520bdffe961390862e221945ba1613dc2ee6b03', 'b5b5c962f4b0b6f7fdb2a7d05f5be397a27df066', 2, 6, 'Y8MGJ', '8882123606589', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:52', '2022-04-02 12:25:52'),
('76e91292aea843a2c42174f9185b22a5760cfbff', '7330d0e50bfce45d5630b7bb47513c6f9c459112', 1, 6, 'L5OTE', '8882123499932', 600, 0, NULL, '2022-04-06', 1, 0, 0, 0, 1, '2022-04-06 07:15:25', '2022-04-06 07:15:25'),
('78f917f3622b27b7687cc322d14a9e28e95b8e4b', 'dd778d3d2c2c5c483b4b3d9d46bbf5594f79ab17', 2, 6, 'M9OTE', '8882123287653', 65, 0, NULL, '2022-08-01', 0, 1, 0, 0, 1, '2022-08-01 02:56:03', '2022-08-01 04:58:40'),
('7b2363e1e39097ce93b3c419a42454cd4373972e', 'cfee6c9d38bd8254e46c98df93124e507b51189c', 2, 14, 'Y9MZY', '8882123122616', 198.21, 67.79, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 14:36:09', '2021-09-21 14:36:09'),
('7bc2a6aee47e85a51bd60608df52ecd4e1493d2a', 'f042f554c6624e39d9bf020feff62b9df10c7c9e', 2, 17, 'J9MME', '8882123736414', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:49', '2022-04-02 13:36:49'),
('7c3b49dfb2276b73ce5566792f122449b0973504', '705518689c28127cba5221132f2022c7887cf295', 2, 6, 'Z6YJQ', '8882123115510', 300, 0, NULL, '2022-03-23', 1, 0, 0, 0, 1, '2022-03-22 23:32:45', '2022-03-22 23:32:45'),
('7ca5522598dbd84b87605acd4601d14ac3af6b82', '8a0affe82bd4ed2d5a9fbdc92bd6a383360ac357', 1, 6, 'H1NTU', '8882123152959', 600, 0, NULL, '2022-04-06', 1, 0, 0, 0, 1, '2022-04-06 08:14:20', '2022-04-06 08:14:20'),
('7d26838de51d722f954eba720872eccf05865e78', 'd9b3a4a80063491de905550bfb5def09340c29b4', 2, 18, 'Y8NJG', '8882123352741', 305, 0, NULL, '2021-11-03', 1, 0, 0, 0, 1, '2021-11-03 09:07:27', '2021-11-03 09:07:27'),
('7d99f0ce82d7e69c75c8251dd7b73dd05dae766b', 'f6279316f8f16681f375927bb91be7e601c720e2', 2, 17, '54OWY', '8882123359953', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:46', '2022-04-02 13:36:46'),
('7ed517a99867c3ea1a39c1ead07b2928bf2c1909', 'c40bc5d35fcd981bed6c99ff864a885af03f8c0f', 1, 12, 'K8NTE', '8882123168246', 260, 0, NULL, '2021-09-29', 2, 0, 0, 0, 1, '2021-09-29 12:51:11', '2021-09-29 14:42:51'),
('7f2d54734aa12368d688249af2278a0557d32f68', '9c7dc177fe7ff8b26c9281be81e71170969e0ff5', 2, 17, 'Y1ZDU', '8882123698686', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:48', '2022-04-02 13:36:48'),
('7f6f1e3040b3cb8d6fb9495fd33fdd592a6fbfc4', '49f686b382d57a87529e127de17a5cfc1f221ca6', 2, 15, '24ZJF', '8882123150794', 75.79, 30.21, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 16:27:58', '2021-09-21 16:27:58'),
('7fdcc357fec6fcb8c2a23406931d3b7ef254e98f', '61c317d3d4a9980223d8b7d19ff68fa048b9698f', 2, 15, 'K4Y2M', '8882123207590', 75.79, 30.21, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 16:29:07', '2021-09-21 16:29:07'),
('8052bbfd9de6e18a86584b556a662f0a095bdf79', 'de26b49981f1b410858e8bfcd3b39189d3dd5934', 2, 6, '16MMJ', '8882123699064', 65, 0, NULL, '2022-03-22', 0, 1, 0, 0, 1, '2022-03-22 09:41:38', '2022-03-22 22:58:11'),
('826046df0002fd3938279a05b08e426fb13f36b2', '274679a7c93916c74c73d96ef0da6ccbe94185fb', 2, 15, '28MDQ', '8882123890203', 75.79, 30.21, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 16:22:04', '2021-09-21 16:22:04'),
('82f02893b1fda472535bdae2b966fcd39b2d0ce5', 'c4e1e2eb350b96a63a6fd51dccf14f9808e6bfbc', 2, 6, 'M2MDI', '8882123183262', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:55', '2022-04-02 12:25:55'),
('840c2b58eeb0206be1ff1701a13c4becb42e9ff4', 'c1be4bc77d64c9d6c8f08cd1232cec9b8ca1cc6b', 2, 16, 'W2YZJ', '8882123133808', 75.79, 30.21, NULL, '2021-09-22', 1, 0, 0, 0, 1, '2021-09-22 18:54:33', '2021-09-22 18:54:33'),
('88098c093ce206142ca15e74b526f4b143e6e248', '7a6ccabaac26b673a28ac43d561b5b3bc6cf35af', 1, 6, 'W8OTH', '8882123176985', 130, 0, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 16:11:40', '2021-09-20 16:11:40'),
('89ca923ae77b71ff87eada631452b042413ca163', '3eea54525949e7e223dc9807f49b1929da99eb5d', 2, 17, 'J2YTK', '8882123673673', 305, 0, NULL, '2021-11-04', 1, 0, 0, 0, 1, '2021-11-04 10:49:16', '2021-11-04 10:49:16'),
('8c1f437ecc32b43834d5650d2ae4c47b0b3aa293', '0adbcc82eedfef5c16d4695b548784888a18dabc', 2, 12, 'X9ZJQ', '8882123545646', 266, 0, NULL, '2021-09-16', 1, 0, 0, 0, 1, '2021-09-16 14:46:15', '2021-09-16 14:57:48'),
('8fdebe91e251b58dcdeeff958224b6c3eda805cc', '781eea5fc28d3cccf4f29c7add84c3bf9662752e', 2, 6, 'K5ZWJ', '8882123485356', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:52', '2022-04-02 12:25:52'),
('9177f6e7020fcef583f437e7e83128ce9a31e113', '08c8835a95d6de68c1c99204550756fbe5a46c0e', 2, 6, '32N2Y', '8882123165646', 165, 0, NULL, '2022-08-01', 0, 1, 0, 0, 1, '2022-08-01 04:56:59', '2022-08-01 04:59:04'),
('91b6b142b2b43f82c51455e49ba9c7989032f9ed', '7456d853053454f219397cf1e19d09ec15e22121', 2, 18, 'I0NMI', '8882123265079', 305, 0, NULL, '2021-11-03', 1, 0, 0, 0, 1, '2021-11-03 09:07:27', '2021-11-03 09:07:27'),
('928dfddc776491932009ad015655b1aaf5599c8b', 'cccb7ca197b26ab45f942c7ea8608193630f5610', 2, 14, '49ZGZ', '8882123983539', 198.21, 67.79, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 15:48:49', '2021-09-21 15:48:49'),
('9303639e6e515d5093fed672a165bd003f598c64', '4271af83142a1cde3e992eb03cc61543b9842720', 1, 10, 'W2MZY', '8882123124397', 400, 50, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 04:27:32', '2021-09-20 04:27:32'),
('94bfab318ea1894a8d9bbee9f4c4100b55898218', 'd112c057a72f3e413b29e6b4cdd8a600339be6f2', 2, 6, 'I5ZMF', '8882123178977', 300, 0, NULL, '2022-03-22', 1, 0, 0, 0, 1, '2022-03-22 05:47:32', '2022-03-22 05:47:32'),
('94e95b0ca6ad54de50c4b42cb1ba4a9d815c08af', '6e1cbf57a529ffd0bf1a525b7579790077dd079d', 2, 12, 'L7OTV', '8882123178923', 266, 0, NULL, '2021-10-05', 1, 0, 0, 0, 1, '2021-10-05 14:25:25', '2021-10-05 14:25:25'),
('95648e53c8e4bff1f5cf299f22c59ec81381766c', 'f9f18ee8f8546ac7e35e2ce78c5417fb239bed76', 2, 6, '22NDH', '8882123390176', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:53', '2022-04-02 12:25:53'),
('98f3697a53f5e36d8b0698221dd3ca28dd4ff118', 'e8f7d1ada2efe0fa6049fe1621170344e24e9dba', 2, 17, 'M3MZY', '8882123142152', 305, 0, NULL, '2021-11-03', 1, 0, 0, 0, 1, '2021-11-03 09:55:44', '2021-11-03 09:55:44'),
('9a2706efccc6a925e41fce6cc4c683f58cd903e8', 'c8b4da00c9882e1e7b401f008966d1ba08bf144d', 2, 17, 'Y1NZA', '8882123694560', 200, 0, NULL, '2021-11-04', 1, 0, 0, 0, 1, '2021-11-04 10:49:17', '2021-11-04 10:49:17'),
('9b71c43f5070a6b1d5a97d20bbaa4e6363132677', '74a2cc077b39536b3b72ec3d53a7195cc5011c67', 2, 6, '39MWM', '8882123602454', 300, 0, NULL, '2022-03-28', 1, 0, 0, 0, 7, '2022-03-28 05:23:47', '2022-03-28 05:23:47'),
('9dde3c47c3f27acb1d88551e03476303345814b0', 'b82f53e84284e0bc9c84dc222fa126889b3a5652', 2, 14, 'K7ZTN', '8882123194039', 198.21, 67.79, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 14:49:44', '2021-09-21 14:49:44'),
('9df462d48d251f016eb6719a0d3195f955221de2', 'f765aded7aee6af2c022fd653aed69026b594492', 2, 6, 'M4NDY', '8882123189183', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:54', '2022-04-02 12:25:54'),
('9dfcdef8fc9215dc6cbfc62e446c8fadf3b7a29b', '86a6b7ee679b85876d7a9de8b9ce6b21fe612f16', 2, 13, 'M9Y2R', '8882123144425', 102.52, 57.48, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 15:35:45', '2021-09-21 15:35:45'),
('9e3608c14dc05881fbe7b51de94dc0d0815366e8', 'ce5d1e2ac99834142077b8828ff4e04625dee0fb', 2, 6, 'Z4NJA', '8882123214342', 300, 0, NULL, '2022-03-25', 1, 0, 0, 0, 1, '2022-03-25 13:50:31', '2022-03-25 13:50:31'),
('a090af3b99ccee8abe431e43b8bed020ab86fd25', 'b45759374d1947cbb8bd5dd015838866bfe9eb1c', 2, 14, '57MGF', '8882123348471', 198.21, 67.79, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 14:39:28', '2021-09-21 14:39:28'),
('a7b9df477044e6f6cb33a856d238280a8d22d037', 'f8f33c656ba203ea4855fca5c9576b1694bfd0f5', 1, 6, 'I0OWR', '8882123597832', 600, 0, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 14:35:49', '2021-09-20 14:35:49'),
('aa20e694a401db42a9cfec71bbe5b1075efcc17e', 'eee733fd8dcbb29604137200c59e6fbf1faee8b5', 2, 9, 'Y6MGU', '8882123135681', 230, 20, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 06:05:39', '2021-09-20 06:05:39'),
('ab8840866211d103ac2ddc29baa3b7ec90763cfd', '9e436904c0b99070ef00d26d124497982bb9a4bc', 2, 6, '41ODQ', '8882123186138', 165, 0, NULL, '2022-03-23', 1, 0, 0, 0, 1, '2022-03-23 04:59:37', '2022-03-23 04:59:37'),
('ad4fc0c4eb13677ec940cd239a0082ff562939a2', '83e2977a1ca153596ced801db93eddd98b4cdfa0', 2, 17, '02ZMM', '8882123129717', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:48', '2022-04-02 13:36:48'),
('ad7242616548c4092d13a0ded02f1b68de1a0435', '567ead7f40d19af84e341aa4e35426e1b0225f49', 2, 17, '35MJQ', '8882123131468', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:50', '2022-04-02 13:36:50'),
('ae5d2678e630e94db8675c1a652720d4465c21fb', '518ce530c0154d2d09adac09b49ef18e524ee7d6', 2, 6, '10ZDI', '8882123667628', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:54', '2022-04-02 12:25:54'),
('b049c890cc13a7a5a88e446153381e537d8f5d54', '698d0f9fdac4bde2cba61ab03f2c35f24c99cbc6', 2, 17, '08OWM', '8882123508573', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:52', '2022-04-02 13:36:52'),
('b2222b7ba71104dae5d78f95c635221dc6ade86c', 'bd459e05ed07278a7540e793d698e8113d8b1151', 2, 17, 'Y6MJJ', '8882123435782', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:51', '2022-04-02 13:36:51'),
('b2cf2a86c4a88461632d5bb5ad05243f9752657a', '46cc28834d56bb265a66c0fb93bd6e550c48bd7d', 2, 16, 'J8ZJJ', '8882123174870', 75.79, 30.21, NULL, '2021-09-22', 1, 0, 0, 0, 1, '2021-09-22 18:49:20', '2021-09-22 18:49:20'),
('b353e3618e2b94915f36749f43ad76cc59ba9144', '1de6a7d6f536d9f6e5154da16451be795998952e', 2, 18, '11M2U', '8882123187208', 305, 0, NULL, '2021-11-04', 1, 0, 0, 0, 1, '2021-11-04 11:06:58', '2021-11-04 11:06:58'),
('b3add856b83dfa2aa989e8e18b14fd901847dc7f', '7f00d024e82c69d869c2a768b4cc2c2fd2da3d04', 2, 6, 'H1ZGQ', '8882123534226', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:55', '2022-04-02 12:25:55'),
('b66bfc000ac51f397f634f261cdc91a984ec0bde', 'd2d6fec583651de82ed80e5fe8c5910eb4737922', 2, 17, '24YMZ', '8882123156572', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:48', '2022-04-02 13:36:48'),
('b69065d34c939798300c6d4d9a8ebde24e86f9c0', '8bf3308306254ab024d1c6e5bd51898c70e72969', 2, 6, '56MDY', '8882123738629', 165, 0, NULL, '2022-03-23', 1, 0, 0, 0, 1, '2022-03-23 05:23:22', '2022-03-23 05:23:22'),
('b76c2b8057fdd856b8d30e7783dc33eddcb784e9', 'cd4aa6554a4f49a5f5ce3bebee016b7af7825571', 2, 6, '25YZJ', '8882123115032', 300, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 12:25:51', '2022-04-02 12:25:51'),
('b7b411c27d7ebe65d0dcda0430b93a5bb33b9724', 'c9c5bdb76d9b9923691f637c2508bd7b4073db2f', 2, 17, 'I9NDE', '8882123189439', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:47', '2022-04-02 13:36:47'),
('b87b987ddcc6316e81ed98e2147760510ed88171', '292a5b81dbc9223231e24e3952de3a9f30b064d2', 2, 6, '38YJK', '8882123215122', 165, 0, NULL, '2022-03-26', 1, 0, 0, 0, 1, '2022-03-26 10:17:39', '2022-03-26 10:17:39'),
('bc76c55dd82cd90340a8290d77e426570fdfd7ee', 'c43dd98522f27b7d4b86cbccb92e6f3c9c9e8d0a', 1, 6, '32NMM', '8882123271385', 600, 0, NULL, '2021-09-10', 1, 0, 0, 0, 7, '2021-09-10 14:13:15', '2021-09-12 12:38:47'),
('c3160279cd5056a120f421995f89d7440b608141', '0b6bfe8e8d4201c00f4f5afc0f9fa997d10d547e', 2, 15, 'X1NJA', '8882123136440', 75.79, 30.21, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 16:25:53', '2021-09-21 16:25:53'),
('c33291b9bd6ee23ad7979de29b652bd613f66f3c', 'b43dfc267ef72ba15fbfe9808a685b31f1d65ea0', 2, 12, 'Z9MJK', '8882123755671', 266, 0, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 12:34:19', '2021-09-21 12:34:19'),
('c5f7cea136cd863fd6086b6a912d457078052933', '4917fa5cea1e284d940258cb7f47e1495b991e32', 2, 6, 'M0N2N', '8882123209164', 300, 0, NULL, '2022-03-26', 1, 0, 0, 0, 1, '2022-03-26 02:28:22', '2022-03-26 02:28:22'),
('c6077cc4b28b0a5ae00f7ed88d78b8e8eee23b0c', 'da1c455c22eaa64df7c65105ca85cb4c01d184e0', 2, 12, 'W2NZD', '8882123150550', 266, 0, NULL, '2021-10-20', 0, 1, 0, 0, 1, '2021-10-20 09:05:06', '2021-10-20 11:55:36'),
('c63209560281aefc6d9f88f0fee3fee2de608b2b', '1ecb9a08811911e6f593f4ddbe7797e857a46614', 2, 6, 'Z3MJA', '8882123135636', 65, 0, NULL, '2022-08-01', 1, 0, 0, 0, 1, '2022-08-01 04:59:33', '2022-08-01 04:59:33'),
('c64ab3e7fd232e2b993b114970dc82082cd6dacf', '698353c331dcb86adb436279d8af11bf26492fb2', 2, 6, '09YWI', '8882123152728', 300, 0, NULL, '2022-04-06', 1, 0, 0, 0, 1, '2022-04-06 07:54:39', '2022-04-06 07:54:39'),
('c7d9dcfc5459dfa6a6aa281ac8a04e53a3a61e86', 'b5a3e87578e7bb43b33d0aad6f8abd8a6b97b02d', 2, 16, 'K2OWR', '8882123160087', 75.79, 30.21, NULL, '2021-09-22', 1, 0, 0, 0, 1, '2021-09-22 18:42:53', '2021-09-22 18:42:53'),
('c836b0eed1a79f6705c8574efdc3062a1cbf18c6', '3fe3d9785c1a1b235747c766e303496fdc373550', 2, 12, 'Z6NMI', '8882123380445', 266, 0, NULL, '2021-09-30', 1, 0, 0, 0, 1, '2021-09-30 09:45:11', '2021-09-30 09:45:11'),
('c9389bfcd315782407d27990de0d727638055696', 'c2535d3b98379bb57d48adeabfcb8be461e2b3e0', 2, 16, 'Z7ODL', '8882123152738', 75.79, 30.21, NULL, '2021-09-22', 1, 0, 0, 0, 1, '2021-09-22 18:47:54', '2021-09-22 18:47:54'),
('cb58858571adc6c7d7342352974f6c564b72340e', '2de2b2a5992f77e68a1ae42e21aa8904578c31f5', 2, 16, '13ODG', '8882123177728', 75.79, 30.21, NULL, '2021-09-22', 1, 0, 0, 0, 1, '2021-09-22 18:44:32', '2021-09-22 18:44:32'),
('cb5bf245e0fb2385566150faf37a8f2ac9262038', 'e55c0283cada18614066c9fe8f207c0b7b82fbe7', 2, 14, '19YMY', '8882123915468', 198.21, 67.79, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 15:03:43', '2021-09-21 15:03:43'),
('cd93a16b1908a89c3aa1750146e6723b177f93e6', 'ca8eafd4377c3f57b8b1220b4e4e1b80f7f06452', 2, 6, '54M2E', '8882123710815', 300, 0, NULL, '2022-03-23', 1, 0, 0, 0, 1, '2022-03-23 10:51:40', '2022-03-23 10:51:40'),
('cf735fb120574fdf4ab65c8cb8fa338e87e14e7e', 'a0a3e818534bc26a958fbf6a63cb66bf61b73ad7', 2, 17, '37MZV', '8882123190978', 100, 0, NULL, '2021-11-12', 0, 1, 0, 0, 1, '2021-11-12 11:09:18', '2021-11-12 11:16:53'),
('d0ac6fedc630d4991b985d2fae43625c8374fb1e', 'efa0499f0b214f2617abf79f2b2787619aa4f0e8', 2, 12, 'H7YZZ', '8882123164648', 266, 0, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 12:45:14', '2021-09-21 12:45:14'),
('d2e0a78392242d260b5b92901239270dc0cad010', '37a6a657966cc45edc532c0579f514e69d225a7b', 1, 12, 'L6MGE', '8882123186757', 532, 0, NULL, '2021-10-05', 1, 0, 0, 0, 1, '2021-10-05 11:16:46', '2021-10-05 11:16:46'),
('d38bba7eac6af481e552d89415375eaad37ebc5a', 'f4cf15b848cd0d2098d4e728e47b43398244b234', 2, 6, '43YMJ', '8882123118047', 165, 0, NULL, '2022-03-30', 1, 0, 0, 0, 1, '2022-03-30 08:52:14', '2022-03-30 08:52:14'),
('d44654baf8ba2acb2f83d3e91065b0e92ebaf8e7', 'ae9d7a693d46b6cbc80fd2054e13261a584307f7', 2, 14, '05NJU', '8882123147216', 111.87, 48.13, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 15:20:12', '2021-09-21 15:20:12'),
('d51253a9250c3be5c8d5ae156eafeb86d22ae764', '35734729b3bf6c5be27adea2a8ee3ab736fa42fb', 2, 6, 'X8MJU', '8882123783349', 300, 0, NULL, '2022-03-26', 1, 0, 0, 0, 1, '2022-03-26 10:17:38', '2022-03-26 10:17:38'),
('d83574706feaf9000a99fe2551104b5b6ad56fdb', '15d9b4f6e269879d9814e20d57224757045a1e9f', 2, 6, 'Z7NTC', '8882123988783', 165, 0, NULL, '2022-03-22', 0, 1, 0, 0, 1, '2022-03-22 09:41:38', '2022-03-22 22:57:30'),
('dc96b73c448f0c6849651626413ca19da620ec8f', '21302f5d3ac59b25bb41806c2fee20967553d81a', 2, 17, '58NMI', '8882123135515', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:45', '2022-04-02 13:36:45'),
('dce24f65ad9a21cbe0689f7c1532b5fc2aa6188f', '17beb888384ade9cb3e22309ed04992ad1082357', 2, 9, 'L9MJR', '8882123104300', 230, 20, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 06:09:35', '2021-09-20 06:09:35'),
('dda33160a345bac6b15946382737198b032df04d', 'adb0d85a033485b77ebce00de72ef10a6a9ecc10', 2, 17, 'H7MZM', '8882123111274', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:52', '2022-04-02 13:36:52'),
('ddb93661b51b9160091240b0afb9224506eccfab', 'd8654c2a568ccb8f49466386f65222faf8de003f', 1, 6, 'I8OTM', '8882123182446', 330, 0, NULL, '2022-04-06', 1, 0, 0, 0, 1, '2022-04-06 07:24:04', '2022-04-06 07:24:04'),
('dfd08fb7cdc60686a01057aef16e9089be97b84c', '6caa002906b00895e6eac440f7909a2d45f6e9b2', 2, 6, 'K0MDH', '8882123212595', 65, 0, NULL, '2022-03-23', 1, 0, 0, 0, 1, '2022-03-23 10:50:13', '2022-03-23 10:50:13'),
('e0f94c03fe23136a35fdefd8af2ff2029fe626a4', '3011c266dadfe79ab29d775d0e7b437cdc42a03d', 2, 17, 'M0OTR', '8882123182643', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:51', '2022-04-02 13:36:51'),
('e48ad8ed658ad4e15bc6410c911ce5ebbed6c169', '7acbc11869ff27184ea961b56d6b52d86424f409', 2, 18, '47YWQ', '8882123689751', 305, 0, NULL, '2021-10-27', 2, 0, 0, 0, 1, '2021-10-27 10:51:37', '2021-10-27 11:16:33'),
('e59e6aa4fb6d0e85ed1e73de955fd437f97f77e5', 'a117713a144f15677fbb69a49d36549b606de73f', 2, 6, '53ZTZ', '8882123157724', 300, 0, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 05:15:42', '2021-09-20 05:15:42'),
('e6006bcc7cfe79201d8c1ec8523a2fd58af441dd', '7003f623f6c5b46476f3ad3ad99233cf4d77d54e', 2, 6, 'W0MDZ', '8882123161509', 65, 0, NULL, '2022-08-01', 0, 1, 0, 0, 1, '2022-08-01 04:56:59', '2022-08-01 04:58:55'),
('e76fd22934ebeff1dd2bddebb98292c6b8a043cb', 'd69bc8aac02c8ddaaa90e7e738098c04c2b687bd', 2, 15, '20ZMQ', '8882123126481', 75.79, 30.21, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 16:07:26', '2021-09-21 16:07:26'),
('e82a471aa2b53cae07e1d1d682dab6fc93a3cdee', '2cca1325cc73b88d5547ea933ee80619508adf9c', 2, 16, 'Y0YTQ', '8882123135315', 75.79, 30.21, NULL, '2021-09-22', 1, 0, 0, 0, 1, '2021-09-22 18:50:33', '2021-09-22 18:50:33'),
('e8cfa8f2f59098a6f6883d402a0fe504dcd502f0', '82947cd4b7a23add6e248a7ccf07ad668d1c99a5', 2, 14, 'J8ZME', '8882123268970', 198.21, 67.79, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 14:14:17', '2021-09-21 14:14:17'),
('efe94e01014d8d62b173b9483d6827b7eab5d132', 'd772b1c0462b3e14a7f840ff09db65c4ba72a454', 1, 10, 'L0OTR', '8882123980143', 400, 50, NULL, '2021-09-20', 1, 0, 0, 0, 1, '2021-09-20 04:31:48', '2021-09-20 04:31:48'),
('f0ab7802f5578d0d6b907fe3c493ca3247905091', '156affa961bf3697c0ec5449a078cf715d1e8560', 2, 6, 'H4YJC', '8882123230787', 300, 0, NULL, '2022-03-23', 1, 0, 0, 0, 1, '2022-03-23 10:47:11', '2022-03-23 10:47:11'),
('f1014b235d53b7d07492bfec2d58a9eb80f28664', '0b6cd4e3b75fdeb313a755f681ba4a91734287de', 2, 17, 'W8MTR', '8882123525230', 305, 0, NULL, '2022-04-02', 1, 0, 0, 0, 1, '2022-04-02 13:36:48', '2022-04-02 13:36:48'),
('f4352bcc73464083852a1bb64e5ab460579cd1e2', 'aa46c0b42b8372b9d5285dd40195071898fd37e6', 1, 6, 'Z1NTJ', '8882123594631', 600, 0, NULL, '2022-03-29', 1, 0, 0, 0, 1, '2022-03-29 14:38:07', '2022-03-29 14:38:07'),
('f5141cb919cca7ebea6b08883e8f270f6a55ab2f', '1ef8310a159cefad872f9beb3bfdb0a5ce042994', 2, 18, 'X6NDF', '8882123202478', 100, 0, NULL, '2021-11-04', 1, 0, 0, 0, 1, '2021-11-04 11:07:00', '2021-11-04 11:07:00'),
('f6dd0d4dbd6e4c9327b7b04334882588b3b9a8c1', 'dfa59db5d1c9a0b5416ef7f282a952d9af8f9b01', 2, 6, 'K2ZDB', '8882123202920', 165, 0, NULL, '2022-07-31', 1, 0, 0, 0, 1, '2022-07-31 05:58:28', '2022-07-31 05:58:28'),
('f976d7af1e09cb3d75be26acc6f79ad58ac7ad02', '08ecc311f9097c51091bd2acce97d82ba2c0c3ae', 2, 6, '35NMQ', '8882123333290', 300, 0, NULL, '2022-03-23', 1, 0, 0, 0, 1, '2022-03-23 04:23:41', '2022-03-23 04:23:41'),
('f9b9e062b48d952b810bbc08f6a0e9e40566b7da', '6a1d94879ede80ea6961a905889b4acc6175323e', 2, 17, 'I2OWU', '8882123346433', 305, 0, NULL, '2021-11-04', 1, 0, 0, 0, 1, '2021-11-04 10:46:57', '2021-11-04 10:46:57'),
('fa271a985d85a2b98bedcfeed02636f60fbba93d', '63453edbdba72dcfe2e836c2b39a4d351cff8950', 2, 12, 'Y9NZF', '8882123375456', 266, 0, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 12:29:28', '2021-09-21 12:29:28'),
('fbbfcf8eb9994526476fa421c412f8824fe7742d', '054fe008bfe8995d512fbfb13db837464277538c', 2, 14, 'I5ZMN', '8882123108470', 198.21, 67.79, NULL, '2021-09-21', 1, 0, 0, 0, 1, '2021-09-21 15:13:08', '2021-09-21 15:13:08'),
('fbf00a3fc9cd3e0879db2d3df1b32e1feb5e71f3', 'd1480fe63422e75ad6fb7bd6d89543f720cc0f64', 2, 6, 'M6MDB', '8882123582017', 300, 0, NULL, '2022-08-01', 0, 1, 0, 0, 1, '2022-08-01 04:56:59', '2022-08-01 04:58:48'),
('fd4016416fbe71d80c04e29cdb4b9054936a37f3', '7102041214c78cd7fb1fceeb1119e1323089669d', 2, 17, '00MDE', '8882123181695', 305, 0, NULL, '2021-11-03', 1, 0, 0, 0, 1, '2021-11-03 09:55:44', '2021-11-03 09:55:44');

-- --------------------------------------------------------

--
-- Structure de la table `table_vente_excedent`
--

CREATE TABLE `table_vente_excedent` (
  `ID_Vente` varchar(100) NOT NULL,
  `ID_Passager_Vol` varchar(100) NOT NULL,
  `ID_Tarif` int(10) UNSIGNED NOT NULL,
  `Numero_Recu` varchar(10) NOT NULL,
  `Nombre_Kilos` int(11) NOT NULL,
  `Montant_Paye` double NOT NULL,
  `Utilisateur` varchar(50) DEFAULT NULL,
  `ID_Utilisateur` int(10) UNSIGNED NOT NULL,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp(),
  `Date_Modif` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `table_vol`
--

CREATE TABLE `table_vol` (
  `ID_Vol` int(10) UNSIGNED NOT NULL,
  `ID_Aeroport_Depart` int(10) UNSIGNED NOT NULL,
  `ID_Aeroport_Arrivee` int(10) UNSIGNED NOT NULL,
  `ID_Jour` int(10) UNSIGNED NOT NULL,
  `ID_Avion` int(10) UNSIGNED NOT NULL,
  `Num_Vol` varchar(10) NOT NULL,
  `Date_Debut` date NOT NULL,
  `Date_Fin` date NOT NULL,
  `Heure_Depart` time NOT NULL,
  `Heure_Arrivee` time NOT NULL,
  `Duree_Vol` time NOT NULL,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp(),
  `Date_Modif` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ID_Utilisateur` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_vol`
--

INSERT INTO `table_vol` (`ID_Vol`, `ID_Aeroport_Depart`, `ID_Aeroport_Arrivee`, `ID_Jour`, `ID_Avion`, `Num_Vol`, `Date_Debut`, `Date_Fin`, `Heure_Depart`, `Heure_Arrivee`, `Duree_Vol`, `Date_Enreg`, `Date_Modif`, `ID_Utilisateur`) VALUES
(1, 7, 5, 1, 2, 'YY 141', '1970-01-01', '1970-01-01', '11:27:00', '11:29:00', '00:00:00', '2022-03-21 11:23:26', '2022-03-21 11:23:26', 1),
(4, 1, 5, 6, 3, 'YY 141', '2022-03-26', '2022-04-23', '08:30:00', '12:00:00', '01:20:00', '2022-03-21 13:55:17', '2022-03-26 09:25:29', 1),
(5, 1, 3, 2, 3, 'YY 141', '2022-03-22', '2022-04-26', '08:00:00', '11:00:00', '00:00:00', '2022-03-21 22:49:27', '2022-03-21 22:49:27', 1),
(6, 8, 10, 1, 3, 'YY 106', '2022-04-04', '2022-04-04', '08:20:00', '10:30:00', '01:30:00', '2022-03-21 23:08:43', '2022-04-01 11:20:44', 1),
(7, 5, 1, 5, 3, 'YY 122', '2022-03-25', '2022-04-29', '08:30:00', '12:00:00', '01:35:00', '2022-03-22 09:12:34', '2022-04-01 11:21:09', 1),
(8, 1, 8, 5, 3, 'YY 140', '2022-04-01', '2022-04-01', '07:30:00', '10:00:00', '02:30:00', '2022-04-01 11:22:01', '2022-04-01 11:22:01', 1),
(9, 1, 9, 5, 3, 'YY 141', '2022-04-01', '2022-04-01', '07:30:00', '09:30:00', '01:30:00', '2022-04-01 11:59:23', '2022-04-01 11:59:23', 1),
(10, 1, 8, 2, 2, 'YY 106', '2022-04-05', '2022-04-05', '07:30:00', '10:30:00', '02:30:00', '2022-04-02 11:44:15', '2022-04-02 11:44:15', 1),
(11, 1, 5, 6, 2, 'YY 140', '2022-07-09', '2022-07-30', '08:30:00', '10:30:00', '01:30:00', '2022-07-04 21:23:07', '2022-07-04 21:23:07', 1),
(12, 1, 5, 6, 2, 'YY 140', '2022-08-06', '2022-12-31', '08:30:00', '10:30:00', '02:00:00', '2022-07-31 05:55:14', '2022-08-01 03:50:18', 1),
(13, 5, 1, 6, 2, 'YY 141', '2022-08-06', '2022-12-31', '11:30:00', '12:30:00', '01:00:00', '2022-08-01 03:48:35', '2022-08-01 04:19:57', 1),
(14, 1, 9, 0, 2, 'YY 140', '2022-08-07', '2022-08-07', '08:30:00', '12:00:00', '02:30:00', '2022-08-01 04:18:09', '2022-08-01 04:18:09', 1);

-- --------------------------------------------------------

--
-- Structure de la table `table_vol_date`
--

CREATE TABLE `table_vol_date` (
  `ID_Vol_Date` int(10) UNSIGNED NOT NULL,
  `ID_Vol` int(10) UNSIGNED NOT NULL,
  `ID_Commandant` int(10) UNSIGNED NOT NULL,
  `Date_Vol` date NOT NULL,
  `Nombre_Places` int(11) NOT NULL,
  `Limit_Enfant` int(11) NOT NULL DEFAULT 0,
  `Limit_Bebe` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_vol_date`
--

INSERT INTO `table_vol_date` (`ID_Vol_Date`, `ID_Vol`, `ID_Commandant`, `Date_Vol`, `Nombre_Places`, `Limit_Enfant`, `Limit_Bebe`) VALUES
(3, 4, 0, '2022-03-26', 37, 0, 0),
(4, 4, 0, '2022-04-02', 37, 0, 0),
(5, 4, 0, '2022-04-09', 37, 0, 0),
(6, 4, 0, '2022-04-16', 37, 0, 0),
(7, 4, 0, '2022-04-23', 37, 0, 0),
(8, 5, 0, '2022-03-22', 37, 0, 0),
(10, 5, 0, '2022-04-05', 37, 0, 0),
(11, 5, 0, '2022-04-12', 34, 0, 0),
(12, 5, 0, '2022-04-19', 37, 0, 0),
(14, 6, 0, '2022-04-04', 34, 0, 0),
(15, 7, 0, '2022-03-25', 37, 0, 0),
(16, 7, 0, '2022-04-01', 37, 0, 0),
(17, 7, 0, '2022-04-08', 37, 0, 0),
(18, 7, 0, '2022-04-15', 37, 0, 0),
(19, 7, 0, '2022-04-22', 37, 0, 0),
(20, 7, 0, '2022-04-29', 37, 0, 0),
(21, 8, 0, '2022-04-01', 37, 0, 0),
(22, 9, 0, '2022-04-01', 37, 0, 0),
(23, 10, 0, '2022-04-05', 30, 0, 0),
(24, 11, 0, '2022-07-09', 37, 0, 0),
(25, 11, 0, '2022-07-16', 37, 0, 0),
(26, 11, 0, '2022-07-23', 37, 0, 0),
(27, 11, 0, '2022-07-30', 37, 0, 0),
(28, 12, 0, '2022-08-06', 37, 1, 2),
(29, 12, 0, '2022-08-13', 37, 0, 0),
(30, 12, 0, '2022-08-20', 37, 0, 0),
(31, 12, 0, '2022-08-27', 37, 0, 0),
(32, 12, 0, '2022-09-03', 37, 0, 0),
(33, 12, 0, '2022-09-10', 37, 0, 0),
(34, 12, 0, '2022-09-17', 37, 0, 0),
(35, 12, 0, '2022-09-24', 37, 0, 0),
(36, 12, 0, '2022-10-01', 37, 0, 0),
(37, 12, 0, '2022-10-08', 37, 0, 0),
(38, 12, 0, '2022-10-15', 37, 0, 0),
(39, 12, 0, '2022-10-22', 37, 0, 0),
(40, 12, 0, '2022-10-29', 37, 0, 0),
(41, 12, 0, '2022-11-05', 37, 0, 0),
(42, 12, 0, '2022-11-12', 37, 0, 0),
(43, 12, 0, '2022-11-19', 37, 0, 0),
(44, 12, 0, '2022-11-26', 37, 0, 0),
(45, 12, 0, '2022-12-03', 37, 0, 0),
(46, 12, 0, '2022-12-10', 37, 0, 0),
(47, 12, 0, '2022-12-17', 37, 0, 0),
(48, 12, 0, '2022-12-24', 37, 0, 0),
(49, 12, 0, '2022-12-31', 37, 0, 0),
(50, 13, 0, '2022-08-06', 37, 1, 2),
(51, 13, 0, '2022-08-13', 37, 0, 0),
(52, 13, 0, '2022-08-20', 37, 0, 0),
(53, 13, 0, '2022-08-27', 37, 0, 0),
(54, 13, 0, '2022-09-03', 37, 0, 0),
(55, 13, 0, '2022-09-10', 37, 0, 0),
(56, 13, 0, '2022-09-17', 37, 0, 0),
(57, 13, 0, '2022-09-24', 37, 0, 0),
(58, 13, 0, '2022-10-01', 37, 0, 0),
(59, 13, 0, '2022-10-08', 37, 0, 0),
(60, 13, 0, '2022-10-15', 37, 0, 0),
(61, 13, 0, '2022-10-22', 37, 0, 0),
(62, 13, 0, '2022-10-29', 37, 0, 0),
(63, 13, 0, '2022-11-05', 37, 0, 0),
(64, 13, 0, '2022-11-12', 37, 0, 0),
(65, 13, 0, '2022-11-19', 37, 0, 0),
(66, 13, 0, '2022-11-26', 37, 0, 0),
(67, 13, 0, '2022-12-03', 37, 0, 0),
(68, 13, 0, '2022-12-10', 37, 0, 0),
(69, 13, 0, '2022-12-17', 37, 0, 0),
(70, 13, 0, '2022-12-24', 37, 0, 0),
(71, 13, 0, '2022-12-31', 37, 0, 0),
(72, 14, 0, '2022-08-07', 37, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `telephone`
--

CREATE TABLE `telephone` (
  `ID_Telephone` int(10) UNSIGNED NOT NULL,
  `Numero_Telephone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `telephone`
--

INSERT INTO `telephone` (`ID_Telephone`, `Numero_Telephone`) VALUES
(1, '243818073562'),
(2, '243899648081');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `ID_Utilisateur` int(10) UNSIGNED NOT NULL,
  `ID_Profil` int(11) NOT NULL,
  `ID_Agence` int(10) UNSIGNED NOT NULL,
  `Prenom` varchar(30) NOT NULL,
  `Nom` varchar(30) NOT NULL,
  `Tel` varchar(15) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Login` varchar(30) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Photo` varchar(30) NOT NULL,
  `Statut` varchar(30) NOT NULL,
  `Etat` int(11) NOT NULL DEFAULT 0,
  `Entreprise` varchar(50) NOT NULL,
  `Date_Enreg` timestamp NOT NULL DEFAULT current_timestamp(),
  `Date_Modif` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Active` int(11) NOT NULL DEFAULT 0,
  `Command` int(11) NOT NULL DEFAULT 0,
  `Loged` int(11) NOT NULL DEFAULT 0,
  `Logged` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ID_Utilisateur`, `ID_Profil`, `ID_Agence`, `Prenom`, `Nom`, `Tel`, `Email`, `Login`, `Password`, `Photo`, `Statut`, `Etat`, `Entreprise`, `Date_Enreg`, `Date_Modif`, `Active`, `Command`, `Loged`, `Logged`) VALUES
(1, 2, 0, 'admin', '', '+243818073562', 'matondotresor5@gmail.com', 'admin', 'ef507e66a8f9cfb2243ce21f5bd6e41d101f5692', 'IMG_UTILISATEUR_88105510.PNG', 'Admin', 0, 'SJL AERONAUTICA CONGO', '2020-01-29 04:37:02', '2022-08-01 16:24:40', 1, 0, 0, 0),
(7, 1, 8, 'Judith', 'Matondo', '+24382 229 42 2', 'matondotresor5@gmail.com', 'judith.matondo3', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '', 'Vendeur', 0, '', '2021-08-21 13:23:24', '2022-07-28 09:41:53', 1, 0, 0, 0),
(8, 2, 5, 'Tresor', 'Matondo', '+243818073562', 'matondojudith5@gmail.com', 'tresor.matondo3', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '', 'Chef_Escale', 0, '', '2022-07-28 09:19:46', '2022-07-28 09:41:54', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `ID_Ville` int(10) UNSIGNED NOT NULL,
  `Design_Ville` varchar(30) NOT NULL,
  `Cod_Ville` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`ID_Ville`, `Design_Ville`, `Cod_Ville`) VALUES
(1, 'Kinshasa', 'FIH'),
(2, 'Mbujimayi', 'MJM'),
(3, 'Kananga', 'KGA'),
(4, 'Gbadolite', 'BDT'),
(5, 'Gemena', 'GMA'),
(6, 'Lubumbashi', 'FBM'),
(7, 'Bunia', 'BUX'),
(8, 'Buta', 'BZU'),
(9, 'Isiro', 'IRP'),
(10, 'Kisangani', 'FKI'),
(11, 'Mbandaka', 'MDK'),
(12, 'Goma', 'GOM');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agence`
--
ALTER TABLE `agence`
  ADD PRIMARY KEY (`ID_Agence`),
  ADD KEY `ID_Ville` (`ID_Ville`),
  ADD KEY `ID_Cat_Agence` (`ID_Cat_Agence`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`);

--
-- Index pour la table `agence_ville`
--
ALTER TABLE `agence_ville`
  ADD PRIMARY KEY (`ID_Agence_Ville`),
  ADD KEY `ID_Agence` (`ID_Agence`),
  ADD KEY `ID_Ville` (`ID_Ville`);

--
-- Index pour la table `avion`
--
ALTER TABLE `avion`
  ADD PRIMARY KEY (`ID_Avion`);

--
-- Index pour la table `categorie_agence`
--
ALTER TABLE `categorie_agence`
  ADD PRIMARY KEY (`ID_Cat_Agence`);

--
-- Index pour la table `categorie_passager`
--
ALTER TABLE `categorie_passager`
  ADD PRIMARY KEY (`ID_Cat_Passager`);

--
-- Index pour la table `categorie_vol`
--
ALTER TABLE `categorie_vol`
  ADD PRIMARY KEY (`ID_Cat_Vol`);

--
-- Index pour la table `couleur_bagage`
--
ALTER TABLE `couleur_bagage`
  ADD PRIMARY KEY (`ID_Couleur`);

--
-- Index pour la table `nature_bagage`
--
ALTER TABLE `nature_bagage`
  ADD PRIMARY KEY (`ID_Nature`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`ID_Profil`);

--
-- Index pour la table `rapport_mail`
--
ALTER TABLE `rapport_mail`
  ADD PRIMARY KEY (`ID_Rapport`);

--
-- Index pour la table `table_aeroport`
--
ALTER TABLE `table_aeroport`
  ADD PRIMARY KEY (`ID_Aeroport`),
  ADD KEY `ID_Ville` (`ID_Ville`);

--
-- Index pour la table `table_annee`
--
ALTER TABLE `table_annee`
  ADD PRIMARY KEY (`ID_Annee`);

--
-- Index pour la table `table_bagage`
--
ALTER TABLE `table_bagage`
  ADD PRIMARY KEY (`ID_Bagage`),
  ADD KEY `ID_Nature` (`ID_Nature`),
  ADD KEY `ID_Couleur` (`ID_Couleur`),
  ADD KEY `ID_Passager_Vol` (`ID_Passager_Vol`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`);

--
-- Index pour la table `table_civilite`
--
ALTER TABLE `table_civilite`
  ADD PRIMARY KEY (`ID_Civilite`);

--
-- Index pour la table `table_classe`
--
ALTER TABLE `table_classe`
  ADD PRIMARY KEY (`ID_Classe`);

--
-- Index pour la table `table_client`
--
ALTER TABLE `table_client`
  ADD PRIMARY KEY (`ID_Client`),
  ADD KEY `ID_Pays` (`ID_Pays`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`),
  ADD KEY `ID_Civilite` (`ID_Civilite`),
  ADD KEY `ID_Particularite` (`ID_Particularite`),
  ADD KEY `ID_Cat_Passager` (`ID_Cat_Passager`);

--
-- Index pour la table `table_commandant`
--
ALTER TABLE `table_commandant`
  ADD PRIMARY KEY (`ID_Commandant`);

--
-- Index pour la table `table_email`
--
ALTER TABLE `table_email`
  ADD PRIMARY KEY (`ID_Email`) USING BTREE;

--
-- Index pour la table `table_escale_vol`
--
ALTER TABLE `table_escale_vol`
  ADD PRIMARY KEY (`ID_Escale_Vol`),
  ADD KEY `ID_Vol` (`ID_Vol`),
  ADD KEY `ID_Aeroport` (`ID_Aeroport`) USING BTREE;

--
-- Index pour la table `table_franchise`
--
ALTER TABLE `table_franchise`
  ADD PRIMARY KEY (`ID_Franchise`),
  ADD KEY `ID_Cat_Passager` (`ID_Cat_Passager`);

--
-- Index pour la table `table_jour`
--
ALTER TABLE `table_jour`
  ADD PRIMARY KEY (`ID_Jour`);

--
-- Index pour la table `table_mois`
--
ALTER TABLE `table_mois`
  ADD PRIMARY KEY (`ID_Mois`);

--
-- Index pour la table `table_monnaie`
--
ALTER TABLE `table_monnaie`
  ADD PRIMARY KEY (`ID_Monnaie`);

--
-- Index pour la table `table_particularite`
--
ALTER TABLE `table_particularite`
  ADD PRIMARY KEY (`ID_Particularite`);

--
-- Index pour la table `table_passager_vol`
--
ALTER TABLE `table_passager_vol`
  ADD PRIMARY KEY (`ID_Passager_Vol`),
  ADD KEY `ID_Vente` (`ID_Vente`),
  ADD KEY `ID_Vol_Date` (`ID_Vol_Date`) USING BTREE,
  ADD KEY `ID_Siege` (`ID_Siege`);

--
-- Index pour la table `table_pays`
--
ALTER TABLE `table_pays`
  ADD PRIMARY KEY (`ID_Pays`);

--
-- Index pour la table `table_siege`
--
ALTER TABLE `table_siege`
  ADD PRIMARY KEY (`ID_Siege`),
  ADD KEY `ID_Avion` (`ID_Avion`);

--
-- Index pour la table `table_statut`
--
ALTER TABLE `table_statut`
  ADD PRIMARY KEY (`ID_Statut`);

--
-- Index pour la table `table_tarif`
--
ALTER TABLE `table_tarif`
  ADD PRIMARY KEY (`ID_Tarif`),
  ADD KEY `ID_Ville_Depart` (`ID_Ville_Depart`),
  ADD KEY `ID_Ville_Arrivee` (`ID_Ville_Arrivee`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`),
  ADD KEY `ID_Classe` (`ID_Classe`),
  ADD KEY `ID_Monnaie` (`ID_Monnaie`),
  ADD KEY `ID_Cat_Vol` (`ID_Cat_Vol`);

--
-- Index pour la table `table_tarif_excedent`
--
ALTER TABLE `table_tarif_excedent`
  ADD PRIMARY KEY (`ID_Tarif`),
  ADD KEY `ID_Ville_Depart` (`ID_Ville_Depart`),
  ADD KEY `ID_Ville_Arrivee` (`ID_Ville_Arrivee`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`);

--
-- Index pour la table `table_vente`
--
ALTER TABLE `table_vente`
  ADD PRIMARY KEY (`ID_Vente`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`),
  ADD KEY `ID_Cat_Vol` (`ID_Cat_Vol`),
  ADD KEY `ID_Client` (`ID_Client`),
  ADD KEY `ID_Tarif` (`ID_Tarif`) USING BTREE;

--
-- Index pour la table `table_vente_excedent`
--
ALTER TABLE `table_vente_excedent`
  ADD PRIMARY KEY (`ID_Vente`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`),
  ADD KEY `ID_Tarif` (`ID_Tarif`) USING BTREE,
  ADD KEY `ID_Passager_Vol` (`ID_Passager_Vol`) USING BTREE;

--
-- Index pour la table `table_vol`
--
ALTER TABLE `table_vol`
  ADD PRIMARY KEY (`ID_Vol`) USING BTREE,
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`),
  ADD KEY `ID_Jour` (`ID_Jour`),
  ADD KEY `ID_Avion` (`ID_Avion`),
  ADD KEY `ID_Aeroport_Depart` (`ID_Aeroport_Depart`) USING BTREE,
  ADD KEY `ID_Aeroport_Arrivee` (`ID_Aeroport_Arrivee`) USING BTREE;

--
-- Index pour la table `table_vol_date`
--
ALTER TABLE `table_vol_date`
  ADD PRIMARY KEY (`ID_Vol_Date`),
  ADD KEY `ID_Vol` (`ID_Vol`),
  ADD KEY `ID_Commandant` (`ID_Commandant`);

--
-- Index pour la table `telephone`
--
ALTER TABLE `telephone`
  ADD PRIMARY KEY (`ID_Telephone`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`ID_Utilisateur`),
  ADD KEY `ID_Agence` (`ID_Agence`);

--
-- Index pour la table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`ID_Ville`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agence`
--
ALTER TABLE `agence`
  MODIFY `ID_Agence` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `agence_ville`
--
ALTER TABLE `agence_ville`
  MODIFY `ID_Agence_Ville` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `avion`
--
ALTER TABLE `avion`
  MODIFY `ID_Avion` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `categorie_agence`
--
ALTER TABLE `categorie_agence`
  MODIFY `ID_Cat_Agence` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `categorie_passager`
--
ALTER TABLE `categorie_passager`
  MODIFY `ID_Cat_Passager` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `categorie_vol`
--
ALTER TABLE `categorie_vol`
  MODIFY `ID_Cat_Vol` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `couleur_bagage`
--
ALTER TABLE `couleur_bagage`
  MODIFY `ID_Couleur` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `nature_bagage`
--
ALTER TABLE `nature_bagage`
  MODIFY `ID_Nature` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `profil`
  MODIFY `ID_Profil` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `rapport_mail`
--
ALTER TABLE `rapport_mail`
  MODIFY `ID_Rapport` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `table_aeroport`
--
ALTER TABLE `table_aeroport`
  MODIFY `ID_Aeroport` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `table_annee`
--
ALTER TABLE `table_annee`
  MODIFY `ID_Annee` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `table_civilite`
--
ALTER TABLE `table_civilite`
  MODIFY `ID_Civilite` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `table_classe`
--
ALTER TABLE `table_classe`
  MODIFY `ID_Classe` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `table_commandant`
--
ALTER TABLE `table_commandant`
  MODIFY `ID_Commandant` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `table_email`
--
ALTER TABLE `table_email`
  MODIFY `ID_Email` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `table_escale_vol`
--
ALTER TABLE `table_escale_vol`
  MODIFY `ID_Escale_Vol` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `table_franchise`
--
ALTER TABLE `table_franchise`
  MODIFY `ID_Franchise` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `table_jour`
--
ALTER TABLE `table_jour`
  MODIFY `ID_Jour` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `table_mois`
--
ALTER TABLE `table_mois`
  MODIFY `ID_Mois` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `table_monnaie`
--
ALTER TABLE `table_monnaie`
  MODIFY `ID_Monnaie` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `table_pays`
--
ALTER TABLE `table_pays`
  MODIFY `ID_Pays` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `table_siege`
--
ALTER TABLE `table_siege`
  MODIFY `ID_Siege` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `table_statut`
--
ALTER TABLE `table_statut`
  MODIFY `ID_Statut` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `table_tarif`
--
ALTER TABLE `table_tarif`
  MODIFY `ID_Tarif` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `table_tarif_excedent`
--
ALTER TABLE `table_tarif_excedent`
  MODIFY `ID_Tarif` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `table_vol`
--
ALTER TABLE `table_vol`
  MODIFY `ID_Vol` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `table_vol_date`
--
ALTER TABLE `table_vol_date`
  MODIFY `ID_Vol_Date` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT pour la table `telephone`
--
ALTER TABLE `telephone`
  MODIFY `ID_Telephone` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ID_Utilisateur` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `ID_Ville` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
