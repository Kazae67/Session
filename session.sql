-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour session
CREATE DATABASE IF NOT EXISTS `session` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `session`;

-- Listage de la structure de table session. admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_880E0D76E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session.admin : ~2 rows (environ)
INSERT INTO `admin` (`id`, `last_name`, `first_name`, `email`, `password`) VALUES
	(1, 'Yasin', 'Akgedik', 'Kazae@gmail.com', 'azeaze'),
	(2, 'Yasinz', 'Akgedikz', 'Kazaze@gmail.com', '$2y$10$Fp.Qu9VIW2vu9rw6EEC88uskr75HBkbkk0Gle0LQ0u2dKUFZXsVoy');

-- Listage de la structure de table session. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table session.doctrine_migration_versions : ~2 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230820213343', '2023-08-20 23:34:33', 289),
	('DoctrineMigrations\\Version20230821001522', '2023-08-21 02:15:39', 28);

-- Listage de la structure de table session. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table session. module
CREATE TABLE IF NOT EXISTS `module` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label_module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session.module : ~0 rows (environ)
INSERT INTO `module` (`id`, `label_module`, `duration`) VALUES
	(17, 'lol', 2),
	(18, 'lol', 2),
	(19, 'lol', 2);

-- Listage de la structure de table session. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `nb_limit` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session.session : ~2 rows (environ)
INSERT INTO `session` (`id`, `label`, `date_start`, `date_end`, `nb_limit`) VALUES
	(1, 'Initialisation comptabilité', '2018-06-10 00:00:00', '2018-06-21 00:00:00', 2),
	(2, 'Initialisation à word et excel', '2018-06-17 00:00:00', '2018-01-29 00:00:00', 4);

-- Listage de la structure de table session. session_module
CREATE TABLE IF NOT EXISTS `session_module` (
  `session_id` int NOT NULL,
  `module_id` int NOT NULL,
  PRIMARY KEY (`session_id`,`module_id`),
  KEY `IDX_634F2C71613FECDF` (`session_id`),
  KEY `IDX_634F2C71AFC2B591` (`module_id`),
  CONSTRAINT `FK_634F2C71613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_634F2C71AFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session.session_module : ~0 rows (environ)

-- Listage de la structure de table session. stagiaire
CREATE TABLE IF NOT EXISTS `stagiaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session.stagiaire : ~2 rows (environ)
INSERT INTO `stagiaire` (`id`, `last_name`, `first_name`) VALUES
	(1, 'Lola', 'Lila'),
	(2, 'LOOOL', 'rarara');

-- Listage de la structure de table session. stagiaire_session
CREATE TABLE IF NOT EXISTS `stagiaire_session` (
  `stagiaire_id` int NOT NULL,
  `session_id` int NOT NULL,
  PRIMARY KEY (`stagiaire_id`,`session_id`),
  KEY `IDX_D32D02D4BBA93DD6` (`stagiaire_id`),
  KEY `IDX_D32D02D4613FECDF` (`session_id`),
  CONSTRAINT `FK_D32D02D4613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_D32D02D4BBA93DD6` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaire` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session.stagiaire_session : ~2 rows (environ)
INSERT INTO `stagiaire_session` (`stagiaire_id`, `session_id`) VALUES
	(1, 1),
	(2, 2);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
