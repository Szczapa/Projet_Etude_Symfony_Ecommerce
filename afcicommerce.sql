-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 05 mai 2022 à 16:41
-- Version du serveur : 10.4.20-MariaDB
-- Version de PHP : 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `afcicommerce`
--
CREATE DATABASE IF NOT EXISTS `afcicommerce` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `afcicommerce`;

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D4E6F81A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `address`
--

INSERT INTO `address` (`id`, `user_id`, `name`, `firstname`, `lastname`, `company`, `address`, `postal`, `city`, `country`, `phone`) VALUES
(6, 4, 'kebab', 'michel', 'michele2', 'kebab avec la sauce', '452 rue de l\'oignon', '50000', 'boulette', 'FR', '0303030303'),
(7, 4, 'maison', 'aa', 'bb', NULL, '4555 dfezfddfs', '500', 'bb', 'BH', '0606060606');

-- --------------------------------------------------------

--
-- Structure de la table `carrier`
--

CREATE TABLE IF NOT EXISTS `carrier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `carrier`
--

INSERT INTO `carrier` (`id`, `name`, `description`, `price`) VALUES
(1, 'Calissimo', 'Un livraison presque en bon état dans un délai incertain de 24/48h parce qu\'on tien jamais nos délais.', 24);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Multimédia'),
(2, 'Livre'),
(3, 'Manteaux'),
(4, 'Echarpe'),
(5, 'T-shirts'),
(6, 'bonnet');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220427083146', '2022-04-27 10:32:42', 596),
('DoctrineMigrations\\Version20220427091546', '2022-04-27 11:16:04', 174),
('DoctrineMigrations\\Version20220428102126', '2022-04-28 12:21:40', 286),
('DoctrineMigrations\\Version20220428104043', '2022-04-28 12:40:50', 1041),
('DoctrineMigrations\\Version20220428120219', '2022-04-28 14:02:24', 111),
('DoctrineMigrations\\Version20220502132148', '2022-05-02 15:22:04', 942),
('DoctrineMigrations\\Version20220503091154', '2022-05-03 11:12:10', 468),
('DoctrineMigrations\\Version20220503092849', '2022-05-03 11:28:57', 1155),
('DoctrineMigrations\\Version20220503122732', '2022-05-03 14:27:37', 82),
('DoctrineMigrations\\Version20220505094244', '2022-05-05 11:43:01', 388),
('DoctrineMigrations\\Version20220505122536', '2022-05-05 14:25:49', 81);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `carrier_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `carrier_price` double NOT NULL,
  `delivery` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_paid` tinyint(1) NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F5299398A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order`
--

INSERT INTO `order` (`id`, `user_id`, `created_at`, `carrier_name`, `carrier_price`, `delivery`, `is_paid`, `reference`, `stripe_session_id`) VALUES
(1, 4, '2022-05-04 09:05:04', 'Calissimo', 24, 'aa bb<br>0606060606<br>4555 dfezfddfs<br>500 bb<br>BH', 0, '', NULL),
(2, 4, '2022-05-04 09:05:39', 'Calissimo', 24, 'aa bb<br>0606060606<br>4555 dfezfddfs<br>500 bb<br>BH', 0, '', NULL),
(3, 4, '2022-05-05 12:03:12', 'Calissimo', 24, 'aa bb<br>0606060606<br>4555 dfezfddfs<br>500 bb<br>BH', 0, '05052022-6273a0e004054', NULL),
(4, 4, '2022-05-05 14:29:03', 'Calissimo', 24, 'michel michele2<br>0303030303<br>kebab avec la sauce<br>452 rue de l\'oignon<br>50000 boulette<br>FR', 0, '05052022-6273c30f46225', NULL),
(5, 4, '2022-05-05 14:30:54', 'Calissimo', 24, 'aa bb<br>0606060606<br>4555 dfezfddfs<br>500 bb<br>BH', 0, '05052022-6273c37ebdc38', NULL),
(6, 4, '2022-05-05 14:46:13', 'Calissimo', 24, 'aa bb<br>0606060606<br>4555 dfezfddfs<br>500 bb<br>BH', 0, '05052022-6273c715e7dda', 'cs_test_b12bUqE4xxbiq5pm2cmtLGhhwCtqqjbqd9DmjQlnQqzhXc1wrAI11fuQgc'),
(7, 4, '2022-05-05 16:23:02', 'Calissimo', 24, 'aa bb<br>0606060606<br>4555 dfezfddfs<br>500 bb<br>BH', 0, '05052022-6273ddc6a12ff', 'cs_test_b1rJm6j0z7A4tdVCiggzSZd0ArXqIy19J28uzFWseIemKxEW5pAtyBPRyK'),
(8, 4, '2022-05-05 16:30:47', 'Calissimo', 24, 'aa bb<br>0606060606<br>4555 dfezfddfs<br>500 bb<br>BH', 0, '05052022-6273df974adfa', 'cs_test_b1KhQKfCMfATbQkdSENl9Q2H91eRva1jLg0izN5KQcfCzN9IuslqgyC3Jx'),
(9, 4, '2022-05-05 16:33:31', 'Calissimo', 24, 'aa bb<br>0606060606<br>4555 dfezfddfs<br>500 bb<br>BH', 1, '05052022-6273e03bd0edc', 'cs_test_b1G8P6kvChseOxBqJ62PLjHCKkhy4ehy1s6Y7TH6WMDkLV5lSb7fuEkNun');

-- --------------------------------------------------------

--
-- Structure de la table `order_details`
--

CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `my_order_id` int(11) NOT NULL,
  `product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `total` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_845CA2C1BFCDF877` (`my_order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order_details`
--

INSERT INTO `order_details` (`id`, `my_order_id`, `product`, `quantity`, `price`, `total`) VALUES
(1, 1, 'Bonnet Rouge pour l\'hiver', 2, 1000, 2000),
(2, 2, 'Bonnet Rouge pour l\'hiver', 2, 1000, 2000),
(3, 3, 'Bonnet Rouge pour l\'hiver', 1, 1000, 1000),
(4, 3, 'Echarpe en coton', 2, 900, 1800),
(5, 4, 'Bonnet Rouge pour l\'hiver', 1, 1000, 1000),
(6, 4, 'Echarpe en coton', 2, 900, 1800),
(7, 5, 'Bonnet Rouge pour l\'hiver', 3, 1000, 3000),
(8, 5, 'Echarpe en coton', 2, 900, 1800),
(9, 6, 'Bonnet Rouge pour l\'hiver', 3, 1000, 3000),
(10, 6, 'Echarpe en coton', 2, 900, 1800),
(11, 7, 'Bonnet Rouge pour l\'hiver', 3, 1000, 3000),
(12, 7, 'Echarpe en coton', 2, 900, 1800),
(13, 8, 'Bonnet Rouge pour l\'hiver', 3, 1000, 3000),
(14, 8, 'Echarpe en coton', 2, 900, 1800),
(15, 9, 'Bonnet Rouge pour l\'hiver', 3, 1000, 3000),
(16, 9, 'Echarpe en coton', 2, 900, 1800);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` float NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04AD12469DE2` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `slug`, `subtitle`, `description`, `prix`, `image`) VALUES
(8, 6, 'Bonnet Rouge pour l\'hiver', 'bonnet-rouge-pour-lhiver', 'Un beau bonnet rouge', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque varius urna vel commodo ornare. Donec in vulputate augue, sit amet tincidunt lorem. Ut ipsum felis, egestas in consectetur quis, fermentum sit amet mauris. Cras sit amet lacinia nibh. Nunc a nibh diam. Mauris id faucibus nulla, vel bibendum odio. Donec accumsan vehicula odio, vitae sollicitudin ex tempor tincidunt. Aenean in volutpat est. Maecenas posuere elementum ipsum, ut faucibus mi. Duis non mi ex. Maecenas sit amet urna porttitor, dapibus odio non, interdum nunc. Praesent pretium metus at sagittis porttitor. Praesent ac dapibus elit, eget malesuada nibh. Nunc massa erat, dictum vitae venenatis quis, hendrerit consectetur neque. Quisque non placerat fe', 1000, '778389005b8b89acba32e013aaa5f3b4165d4f12.jpg'),
(9, 6, 'Bonnet homme ski', 'bonnet-homme-ski', 'un Bonnet parfait pour le ski', 'In hac habitasse platea dictumst. Aenean urna justo, eleifend eu lacus eu, condimentum fermentum mauris. Sed in sem ut sapien laoreet porttitor. Proin viverra magna vitae ornare aliquam. Sed a accumsan turpis. Nam viverra fringilla aliquet. Vestibulum vel elementum est. Aenean auctor diam eget libero vehicula rutrum. Mauris egestas mauris ipsum, quis fermentum ipsum volutpat ac. Mauris vitae luctus arcu. Sed egestas leo velit, ac hendrerit quam pretium quis. Nam felis diam, viverra vel tincidunt at, rutrum quis odio. Ut eu dolor nec tortor dictum ultrices.', 1500, '67e3451e3ea9a562b6d707664711834f2b2b6b73.jpg'),
(10, 4, 'Echarpe en coton', 'echarpe-en-coton', 'une belle écharpe pour les soirée un peu fraiche', 'Vivamus id condimentum nisl. Praesent placerat, tortor venenatis condimentum semper, nunc justo lobortis nibh, et suscipit neque lorem in elit. In suscipit consequat scelerisque. Phasellus nec fringilla erat, nec scelerisque sapien. Vestibulum consequat ullamcorper lorem id rhoncus. Nam vel venenatis neque. Vestibulum eget ante turpis. Etiam et nunc ex. Nulla id sagittis lectus. Curabitur faucibus, leo sagittis finibus scelerisque, dolor metus consectetur velit, sit amet rhoncus ex risus in nisl. Nulla facilisi. Duis leo nunc, congue vel egestas sed, euismod imperdiet magna. Vestibulum gravida tortor elit, quis mollis est pellentesque suscipit. Fusce vitae risus vitae justo malesuada luctus. Nam non eros lacinia, auctor neque a, vestibulum diam.', 900, 'aca02aadfd8aea53c9b99f75005af23c12df50dd.jpg'),
(11, 4, 'Echarpe femme', 'echarpe-femme', 'Une belle écharpe a offrir pour madame', 'Donec mattis laoreet mauris, vel euismod lorem bibendum et. In nec orci vitae nisl lobortis eleifend id sed elit. Aenean iaculis laoreet hendrerit. Quisque gravida tellus et ante pulvinar, a vestibulum justo laoreet. Nulla tempor velit neque, eget ultricies leo malesuada vel. Quisque ullamcorper id felis nec suscipit. Vestibulum eget sem facilisis, finibus nibh vitae, cursus turpis.', 900, '830152d93c5810a273ec63521753e781ed94e338.jpg'),
(12, 3, 'Manteau homme', 'manteau-homme', 'un beau manteau', 'Donec mattis laoreet mauris, vel euismod lorem bibendum et. In nec orci vitae nisl lobortis eleifend id sed elit. Aenean iaculis laoreet hendrerit. Quisque gravida tellus et ante pulvinar, a vestibulum justo laoreet. Nulla tempor velit neque, eget ultricies leo malesuada vel. Quisque ullamcorper id felis nec suscipit. Vestibulum eget sem facilisis, finibus nibh vitae, cursus turpis.', 500, 'a309eae6b3a4eed36ef99a97e88151bd123ad0dd.jpg'),
(13, 3, 'Manteau Dame', 'manteau-dame', 'un beau manteau pour madame', 'Donec mattis laoreet mauris, vel euismod lorem bibendum et. In nec orci vitae nisl lobortis eleifend id sed elit. Aenean iaculis laoreet hendrerit. Quisque gravida tellus et ante pulvinar, a vestibulum justo laoreet. Nulla tempor velit neque, eget ultricies leo malesuada vel. Quisque ullamcorper id felis nec suscipit. Vestibulum eget sem facilisis, finibus nibh vitae, cursus turpis.', 500, '41a1d589711d20df7a1515adeeca7bfa8714a4fa.jpg'),
(14, 5, 'tshirt blanc', 'tshirt-blanc', 'un tshirt blanc', 'Donec mattis laoreet mauris, vel euismod lorem bibendum et. In nec orci vitae nisl lobortis eleifend id sed elit. Aenean iaculis laoreet hendrerit. Quisque gravida tellus et ante pulvinar, a vestibulum justo laoreet. Nulla tempor velit neque, eget ultricies leo malesuada vel. Quisque ullamcorper id felis nec suscipit. Vestibulum eget sem facilisis, finibus nibh vitae, cursus turpis.', 2500, '9c32d14d78ddb427d91885516a85e1c99510af10.jpg'),
(15, 5, 'tshirt noir', 'tshirt-noir', 'un tshirt noir', 'Donec mattis laoreet mauris, vel euismod lorem bibendum et. In nec orci vitae nisl lobortis eleifend id sed elit. Aenean iaculis laoreet hendrerit. Quisque gravida tellus et ante pulvinar, a vestibulum justo laoreet. Nulla tempor velit neque, eget ultricies leo malesuada vel. Quisque ullamcorper id felis nec suscipit. Vestibulum eget sem facilisis, finibus nibh vitae, cursus turpis.', 2500, 'aca4e3cb8c9b98e4aa7301002bed99070174e167.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`) VALUES
(1, 'Robet@robert.fr', '[]', 'robert', 'robert', 'robert'),
(3, 'orel@orel.com', '[]', 'orel', 'orel', 'orel'),
(4, 'michel@michel.com', '[]', '$2y$13$Mrjdkc4isRF9qb7PnncJOuIou6MSdAXawjnwNQVSTOIvwC/eKhSTy', 'michel', 'michel');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `FK_D4E6F81A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `FK_845CA2C1BFCDF877` FOREIGN KEY (`my_order_id`) REFERENCES `order` (`id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
