-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 25 avr. 2022 à 07:25
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `socr`
--

-- --------------------------------------------------------

--
-- Structure de la table `anomalies`
--

DROP TABLE IF EXISTS `anomalies`;
CREATE TABLE IF NOT EXISTS `anomalies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_anomalie_id` int(11) DEFAULT NULL,
  `anomalie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_anomalie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E2C64AC5E5F36606` (`type_anomalie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `anomalies`
--

INSERT INTO `anomalies` (`id`, `type_anomalie_id`, `anomalie`, `code_anomalie`) VALUES
(1, 1, 'FEUX ARRIERE GAUCHE', '101');

-- --------------------------------------------------------

--
-- Structure de la table `anomalies_type`
--

DROP TABLE IF EXISTS `anomalies_type`;
CREATE TABLE IF NOT EXISTS `anomalies_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `anomalie_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `anomalies_type`
--

INSERT INTO `anomalies_type` (`id`, `anomalie_type`) VALUES
(1, 'EQUIPEMENT');

-- --------------------------------------------------------

--
-- Structure de la table `bundle_controles`
--

DROP TABLE IF EXISTS `bundle_controles`;
CREATE TABLE IF NOT EXISTS `bundle_controles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `centres`
--

DROP TABLE IF EXISTS `centres`;
CREATE TABLE IF NOT EXISTS `centres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `province_id` int(11) NOT NULL,
  `centre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3BA7EA52E946114A` (`province_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `centres`
--

INSERT INTO `centres` (`id`, `province_id`, `centre`, `code`, `numero`) VALUES
(1, 1, 'SOCR', '23', 1);

-- --------------------------------------------------------

--
-- Structure de la table `controles`
--

DROP TABLE IF EXISTS `controles`;
CREATE TABLE IF NOT EXISTS `controles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usages_id` int(11) DEFAULT NULL,
  `verificateur_id` int(11) DEFAULT NULL,
  `centre_id` int(11) DEFAULT NULL,
  `ajouteur_id` int(11) DEFAULT NULL,
  `retireur_id` int(11) DEFAULT NULL,
  `immatriculation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enregistrement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proprietaire` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anomalies` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `papiers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_expiration` date NOT NULL,
  `papiers_retirers` tinyint(1) NOT NULL,
  `created_at` date NOT NULL,
  `date_retrait` date DEFAULT NULL,
  `heure_retrait` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B10ABA6DF78A9799` (`usages_id`),
  KEY `IDX_B10ABA6D517E6C75` (`verificateur_id`),
  KEY `IDX_B10ABA6D463CD7C3` (`centre_id`),
  KEY `IDX_B10ABA6D7268CC77` (`ajouteur_id`),
  KEY `IDX_B10ABA6DD226F8C2` (`retireur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `controles`
--

INSERT INTO `controles` (`id`, `usages_id`, `verificateur_id`, `centre_id`, `ajouteur_id`, `retireur_id`, `immatriculation`, `enregistrement`, `proprietaire`, `adresse`, `telephone`, `anomalies`, `papiers`, `date_expiration`, `papiers_retirers`, `created_at`, `date_retrait`, `heure_retrait`) VALUES
(1, 1, 1, NULL, 1, NULL, '1283TBC', '102/SOCR/OR/22', 'RAKOTOARISOA', '102', '258258258', 'Doctrine\\Common\\Collections\\ArrayCollection@00000000596ebc470000000046dc52e4', 'Doctrine\\Common\\Collections\\ArrayCollection@00000000596ebc460000000046dc52e4', '2022-06-05', 1, '2022-04-22', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20191104111422', '2022-04-22 06:02:39');

-- --------------------------------------------------------

--
-- Structure de la table `papiers`
--

DROP TABLE IF EXISTS `papiers`;
CREATE TABLE IF NOT EXISTS `papiers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `papier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `papiers`
--

INSERT INTO `papiers` (`id`, `papier`) VALUES
(1, 'CARNET D\'ENTRETIEN'),
(2, 'CARTE GRISE'),
(3, 'PERMIS DE CONDUIRE');

-- --------------------------------------------------------

--
-- Structure de la table `professions`
--

DROP TABLE IF EXISTS `professions`;
CREATE TABLE IF NOT EXISTS `professions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profession` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `professions`
--

INSERT INTO `professions` (`id`, `profession`) VALUES
(1, 'SUPERADMIN'),
(2, 'ADMIN'),
(3, 'VERIFICATEUR'),
(4, 'SECRETAIRE');

-- --------------------------------------------------------

--
-- Structure de la table `provinces`
--

DROP TABLE IF EXISTS `provinces`;
CREATE TABLE IF NOT EXISTS `provinces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `provinces`
--

INSERT INTO `provinces` (`id`, `province`) VALUES
(1, 'ANTANANARIVO');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'ROLE_SUPERADMIN'),
(2, 'ADMIN'),
(3, 'VERIFICATEUR'),
(4, 'SECRETAIRE');

-- --------------------------------------------------------

--
-- Structure de la table `thread_anom`
--

DROP TABLE IF EXISTS `thread_anom`;
CREATE TABLE IF NOT EXISTS `thread_anom` (
  `controles_id` int(11) NOT NULL,
  `anomalies_id` int(11) NOT NULL,
  PRIMARY KEY (`controles_id`,`anomalies_id`),
  KEY `IDX_B540DF53D8B132DE` (`controles_id`),
  KEY `IDX_B540DF5389B45173` (`anomalies_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `thread_anomalies`
--

DROP TABLE IF EXISTS `thread_anomalies`;
CREATE TABLE IF NOT EXISTS `thread_anomalies` (
  `controles_id` int(11) NOT NULL,
  `anomalies_id` int(11) NOT NULL,
  PRIMARY KEY (`controles_id`,`anomalies_id`),
  KEY `IDX_6DAC6579D8B132DE` (`controles_id`),
  KEY `IDX_6DAC657989B45173` (`anomalies_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `thread_anomalies`
--

INSERT INTO `thread_anomalies` (`controles_id`, `anomalies_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `thread_pap`
--

DROP TABLE IF EXISTS `thread_pap`;
CREATE TABLE IF NOT EXISTS `thread_pap` (
  `controles_id` int(11) NOT NULL,
  `papiers_id` int(11) NOT NULL,
  PRIMARY KEY (`controles_id`,`papiers_id`),
  KEY `IDX_880ECA8BD8B132DE` (`controles_id`),
  KEY `IDX_880ECA8BD704DEB9` (`papiers_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `thread_papiers`
--

DROP TABLE IF EXISTS `thread_papiers`;
CREATE TABLE IF NOT EXISTS `thread_papiers` (
  `controles_id` int(11) NOT NULL,
  `papiers_id` int(11) NOT NULL,
  PRIMARY KEY (`controles_id`,`papiers_id`),
  KEY `IDX_26F3519CD8B132DE` (`controles_id`),
  KEY `IDX_26F3519CD704DEB9` (`papiers_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `thread_papiers`
--

INSERT INTO `thread_papiers` (`controles_id`, `papiers_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `usages`
--

DROP TABLE IF EXISTS `usages`;
CREATE TABLE IF NOT EXISTS `usages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profession_id` int(11) NOT NULL,
  `centre_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_inscription` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  KEY `IDX_8D93D649FDEF8996` (`profession_id`),
  KEY `IDX_8D93D649463CD7C3` (`centre_id`),
  KEY `IDX_8D93D649D60322AC` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `profession_id`, `centre_id`, `role_id`, `username`, `roles`, `password`, `nom`, `prenom`, `date_inscription`) VALUES
(1, 1, 1, 1, 'superadmin@cr.mg', '[\"ROLE_SUPERADMIN\"]', '$2y$12$2fYB4H.Mkwe0VDmpCe/MJ.oGX1ZK94QT7363tyPIaHFHs1nBIVUZ2', 'dgsr', 'dgsr', '2022-04-22');

-- --------------------------------------------------------

--
-- Structure de la table `utilisations`
--

DROP TABLE IF EXISTS `utilisations`;
CREATE TABLE IF NOT EXISTS `utilisations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utilisation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validite` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisations`
--

INSERT INTO `utilisations` (`id`, `utilisation`, `validite`) VALUES
(1, 'TAXI BROUSE', 5);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `anomalies`
--
ALTER TABLE `anomalies`
  ADD CONSTRAINT `FK_E2C64AC5E5F36606` FOREIGN KEY (`type_anomalie_id`) REFERENCES `anomalies_type` (`id`);

--
-- Contraintes pour la table `centres`
--
ALTER TABLE `centres`
  ADD CONSTRAINT `FK_3BA7EA52E946114A` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`);

--
-- Contraintes pour la table `controles`
--
ALTER TABLE `controles`
  ADD CONSTRAINT `FK_B10ABA6D463CD7C3` FOREIGN KEY (`centre_id`) REFERENCES `centres` (`id`),
  ADD CONSTRAINT `FK_B10ABA6D517E6C75` FOREIGN KEY (`verificateur_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_B10ABA6D7268CC77` FOREIGN KEY (`ajouteur_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_B10ABA6DD226F8C2` FOREIGN KEY (`retireur_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_B10ABA6DF78A9799` FOREIGN KEY (`usages_id`) REFERENCES `utilisations` (`id`);

--
-- Contraintes pour la table `thread_anom`
--
ALTER TABLE `thread_anom`
  ADD CONSTRAINT `FK_B540DF5389B45173` FOREIGN KEY (`anomalies_id`) REFERENCES `anomalies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B540DF53D8B132DE` FOREIGN KEY (`controles_id`) REFERENCES `controles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `thread_anomalies`
--
ALTER TABLE `thread_anomalies`
  ADD CONSTRAINT `FK_6DAC657989B45173` FOREIGN KEY (`anomalies_id`) REFERENCES `anomalies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_6DAC6579D8B132DE` FOREIGN KEY (`controles_id`) REFERENCES `controles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `thread_pap`
--
ALTER TABLE `thread_pap`
  ADD CONSTRAINT `FK_880ECA8BD704DEB9` FOREIGN KEY (`papiers_id`) REFERENCES `papiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_880ECA8BD8B132DE` FOREIGN KEY (`controles_id`) REFERENCES `controles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `thread_papiers`
--
ALTER TABLE `thread_papiers`
  ADD CONSTRAINT `FK_26F3519CD704DEB9` FOREIGN KEY (`papiers_id`) REFERENCES `papiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_26F3519CD8B132DE` FOREIGN KEY (`controles_id`) REFERENCES `controles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D649463CD7C3` FOREIGN KEY (`centre_id`) REFERENCES `centres` (`id`),
  ADD CONSTRAINT `FK_8D93D649D60322AC` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `FK_8D93D649FDEF8996` FOREIGN KEY (`profession_id`) REFERENCES `professions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
