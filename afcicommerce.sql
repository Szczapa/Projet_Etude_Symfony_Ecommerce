-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 06 juil. 2022 à 14:55
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

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
-- Structure de la table `actuality`
--

CREATE TABLE IF NOT EXISTS `actuality` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `actuality`
--

INSERT INTO `actuality` (`id`, `title`, `image`, `created_at`, `content`, `subtitle`, `post`) VALUES
(1, 'Elder scroll 6', 'a48b7de6d05dc8832eb1159932fd280af1141517.jpg', '2022-06-17 15:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed blandit, nibh id efficitur dignissim, nibh ante blandit dui, quis venenatis magna nibh vel velit. Morbi ac ex sit amet lectus vulputate blandit sit amet eu elit. Fusce suscipit porta purus quis gravida. Aliquam vel lorem non massa varius cursus id facilisis enim. Mauris ipsum velit, vulputate eu ornare in, auctor sodales elit. Sed eleifend commodo ante, nec gravida est. Nulla sagittis ultricies neque varius accumsan. Integer sed sem eleifend, vulputate ante nec, malesuada mauris. Vivamus et ornare libero. Cras ultrices eros sit amet felis tristique, quis porttitor elit mollis. Nulla dolor nunc, vulputate in justo in, semper lacinia nisi.', 'le jeu tant attendue', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `address`
--

INSERT INTO `address` (`id`, `user_id`, `name`, `firstname`, `lastname`, `company`, `address`, `postal`, `city`, `country`, `phone`) VALUES
(6, 4, 'kebab', 'michel', 'michele2', 'kebab avec la sauce', '452 rue de l\'oignon', '50000', 'boulette', 'FR', '0303030303'),
(7, 4, 'maison', 'aa', 'bb', NULL, '4555 dfezfddfs', '500', 'bb', 'BH', '0606060606'),
(8, 8, 'Mon adresse', 'adam', 'gilabert', NULL, '451 chemin du nouveau monde', '59250', 'halluin', 'FR', '0647000000'),
(9, 1, 'Ma maison', 'Adam', 'Gilabert', NULL, '451 chemin du nouveau monde', '59250', 'halluin', 'FR', '0647010000');

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
(1, 'Calissimo', 'Une livraison presque parfaite dans des délais presque respectés ! Toutefois le colis sera peut-être en morceaux!', 1190);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Coopération'),
(2, 'Solo'),
(3, 'Multi-Joueur'),
(4, 'Plateau'),
(5, 'Stratégie'),
(6, 'Abonnement'),
(7, 'Carte Bonus');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526CA76ED395` (`user_id`),
  KEY `IDX_9474526C4584665A` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `product_id`, `title`, `comment`, `note`) VALUES
(1, 1, 1, 'Un super jeu', 'HOHOHO voici un super jeux ', 5),
(2, 2, 1, '123', 'gfdsgf', 1);

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
('DoctrineMigrations\\Version20220505122536', '2022-05-05 14:25:49', 81),
('DoctrineMigrations\\Version20220614141925', '2022-06-14 16:19:41', 36),
('DoctrineMigrations\\Version20220614154531', '2022-06-14 17:45:37', 644),
('DoctrineMigrations\\Version20220615130130', '2022-06-15 15:01:47', 393),
('DoctrineMigrations\\Version20220615140008', '2022-06-15 16:00:12', 120),
('DoctrineMigrations\\Version20220616084351', '2022-06-16 10:43:57', 286),
('DoctrineMigrations\\Version20220617112306', '2022-06-17 13:23:53', 184),
('DoctrineMigrations\\Version20220617113300', '2022-06-17 13:33:05', 86),
('DoctrineMigrations\\Version20220617114337', '2022-06-17 13:43:43', 35),
('DoctrineMigrations\\Version20220620094115', '2022-06-20 11:41:25', 647),
('DoctrineMigrations\\Version20220620094804', '2022-06-20 11:48:10', 62),
('DoctrineMigrations\\Version20220704092523', '2022-07-04 11:32:24', 200),
('DoctrineMigrations\\Version20220704094640', '2022-07-04 11:46:47', 100),
('DoctrineMigrations\\Version20220704122546', '2022-07-04 14:25:50', 142);

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

CREATE TABLE IF NOT EXISTS `favoris` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `favoris` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8933C432A76ED395` (`user_id`),
  KEY `IDX_8933C4324584665A` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `favoris`
--

INSERT INTO `favoris` (`id`, `favoris`, `user_id`, `product_id`) VALUES
(1, 0, 1, 2),
(2, 0, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `header`
--

CREATE TABLE IF NOT EXISTS `header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `btn_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `btn_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `header`
--

INSERT INTO `header` (`id`, `title`, `content`, `btn_title`, `btn_url`, `image`) VALUES
(3, 'Summer Game Fest', 'Lancé en 2020 en pleine pandémie, le Summer Game Fest est devenu l’événement central remplaçant le légendaire E3, ce dernier étant en perte de vitesse progressive et peinant à se renouveler. Cette année encore, l’E3 n’aura pas lieu, mais Geoff Keighley revient en force avec cette troisième édition du Summer Game Fest durant laquelle de nombreux éditeurs seront présents : EA, 2K, Activision, Capcom, Gearbox, Bandai Namco ou encore Square Enix pour ne citer qu’eux.', 'Suivre :', 'https://www.twitch.tv/thegameawards', '3bc63874d6cf6cb7c70fbc547050bf35a73ac98a.jpg'),
(4, 'Xbox Show Case', 'La conférence Xbox à ne pas rater pour être au courant de leur actualité jeu vidéos', 'Voir :', '#', '3249dc4c61b0fb663398029d4dad60649f8ceb8a.jpg');

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
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F5299398A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order`
--

INSERT INTO `order` (`id`, `user_id`, `created_at`, `carrier_name`, `carrier_price`, `delivery`, `reference`, `stripe_session_id`, `state`) VALUES
(1, 1, '2022-06-16 11:06:25', 'Calissimo', 1190, 'Adam Gilabert<br>0647010000<br>451 chemin du nouveau monde<br>59250 halluin<br>FR', '16062022-62aaf291bd7af', NULL, 0),
(2, 1, '2022-06-16 14:10:50', 'Calissimo', 1190, 'Adam Gilabert<br>0647010000<br>451 chemin du nouveau monde<br>59250 halluin<br>FR', '16062022-62ab1dcaa0ce8', 'cs_test_b16WzDNfcUpkrKcOThMsUvx3deksrwdCxaVdduPpsIGGhZ3rmGXWieExna', 1),
(3, 1, '2022-06-17 10:58:52', 'Calissimo', 1190, 'Adam Gilabert<br>0647010000<br>451 chemin du nouveau monde<br>59250 halluin<br>FR', '17062022-62ac424cea6b7', 'cs_test_b1rN6cSnHJh9ZJQEoCSQaddO6RIGVI2EDXOqWFwvxphzqZdwtmadjzjd1z', 3);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order_details`
--

INSERT INTO `order_details` (`id`, `my_order_id`, `product`, `quantity`, `price`, `total`) VALUES
(1, 1, 'Pac Man Collection', 1, 7000, 7000),
(2, 2, 'It take two', 1, 3999, 3999),
(3, 3, 'It takes two', 1, 3999, 3999);

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
  `price` double NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_best` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04AD12469DE2` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `slug`, `subtitle`, `description`, `price`, `image`, `is_best`) VALUES
(1, 1, 'It takes two', 'it-take-two', 'Le jeu de coopération de l\'année', 'It Takes Two est un jeu de plateforme, d\'action et de coopération. Au coeur d\'une famille qui se déchire, vous incarnez les deux poupées qui prennent vie, représentant les parents qui vont devoir passer des épreuves dans l\'imaginaire de leur fille.', 3999, '69aa25ebaa3251a65d8650b751a17ee4f895fb87.png', 1),
(2, 2, 'God of war', 'god-of-war', 'Combattez au côté du dieu de la Guerre', 'God of War est un jeu d\'action mythologique sur PS2. Incarnez Kratos, un anti-héros à la fois banni et honni par les dieux de la Grèce antique. Afin de sauver votre âme, obéissez aux ordres divins et partez combattre des créatures et monstres légendaires dans des combats d\'une violence inouïe mais toujours magnifiquement orchestrés.', 1500, '9f8171584824234d4479511eb8293c68b60b909c.png', 0),
(3, 6, 'Xbox Game Pass', 'xbox-game-pass', 'Le service de streaming jeu vidéo du moment', 'Jouez à des centaines de jeux PC exceptionnels avec des amis, y compris les nouveaux titres disponibles dès le jour de leur sortie et bénéficiez d’un abonnement EA Play. De nouveaux jeux sont régulièrement ajoutés, vous avez toujours une nouveauté à découvrir.', 1000, 'fc05da1ed26114d845bbff6e183df949ed767ccf.png', 1),
(4, 7, 'League of Legend Riot Point', 'league-of-legend-riot-point', 'L\'un des meilleur moyen d\'acheter ses skins', 'Les Riot Points (précédemment appelés Points de Combat) représentent une des deux méthodes de paiement utilisées dans la boutique. Ils peuvent être acquis en utilisant de l\'argent réel et ils peuvent être utilisés afin d\'acheter des Champions, des Skin, des Bonus, ou d\'autres achats qui n\'affecteront pas le fil ou le résultat d\'une partie mais l\'apparence des personnages.', 1000, '0c2a850a47a1b555a69c1cd4ddb1633eb6d3b1df.png', 0),
(5, 3, 'World of Warcraft', 'world-of-warcraft', 'Le MMO RPG historique', 'Pénétrez dans le jeu en ligne n°1 dans le monde grâce à la collection complète de World of Warcraft. Cette collection épique rassemble le jeu World of Warcraft ainsi que The Burning Crusade et Warth of the Lich King, ses deux premières extensions ! Créez de nouveaux héros et accomplissez des quêtes jusqu\'au niveau 80. Explorez les trois immenses continents de l\'univers de World of Warcraft tandis que vous luttez et vivez l\'aventure aux côtés de vos amis.', 2499, 'a45d6c6d50011348bde2beb21ee2c658151900ff.png', 0);

-- --------------------------------------------------------

--
-- Structure de la table `reset_password`
--

CREATE TABLE IF NOT EXISTS `reset_password` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B9983CE5A76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`) VALUES
(1, 'adam.gilabert@gt2sformation.fr', '[\"ROLE_ADMIN\"]', '$2y$13$Lh8wU7B1GVmdoF0wi.ErYuR1hIYawMlW2hB8GePa4MmG34y1qWNh2', 'Adam', 'Gilabert'),
(2, 'michelmichel@michel.com', '[]', '$2y$13$qJRicGcXs2Kt94tlv.eRkuEvlcoxEUJiowg/QJ51Z2CyttlIPzz2u', 'michel', 'michel');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `FK_D4E6F81A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD CONSTRAINT `FK_8933C4324584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_8933C432A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

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

--
-- Contraintes pour la table `reset_password`
--
ALTER TABLE `reset_password`
  ADD CONSTRAINT `FK_B9983CE5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
