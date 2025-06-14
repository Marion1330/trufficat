-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 30 mai 2025 à 15:36
-- Version du serveur : 8.0.42-0ubuntu0.22.04.1
-- Version de PHP : 8.1.2-1ubuntu2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `trufficat`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresses`
--

CREATE TABLE `adresses` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `titre` varchar(100) DEFAULT 'Adresse principale',
  `adresse` varchar(255) NOT NULL,
  `complement` varchar(255) DEFAULT NULL,
  `code_postal` varchar(20) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `departement` varchar(100) DEFAULT NULL,
  `pays` varchar(100) NOT NULL,
  `telephone` varchar(30) NOT NULL,
  `is_defaut` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `adresses`
--

INSERT INTO `adresses` (`id`, `user_id`, `nom`, `prenom`, `titre`, `adresse`, `complement`, `code_postal`, `ville`, `departement`, `pays`, `telephone`, `is_defaut`) VALUES
(42, 12, 'ministrateur', 'Ad', 'Adresse principale', '87', '', '13400', 'Aubagne', 'Bouches-du-Rhône', 'France', '098765432', 1),
(43, 17, 'Dupont', 'Marie', 'Adresse principale', '15 rue des Lilas', 'Apt 3B', '75011', 'Paris', 'Paris', 'France', '0612345678', 1),
(44, 18, 'Martin', 'Thomas', 'Adresse principale', '28 avenue Victor Hugo', '', '69003', 'Lyon', 'Rhône', 'France', '0723456789', 1),
(45, 19, 'Petit', 'Sophie', 'Adresse principale', '7 boulevard de la Mer', 'Résidence Les Pins', '13008', 'Marseille', 'Bouches-du-Rhône', 'France', '0634567890', 1),
(46, 20, 'Bernard', 'Lucas', 'Adresse principale', '42 rue du Commerce', '', '44000', 'Nantes', 'Loire-Atlantique', 'France', '0745678901', 1),
(47, 20, 'Bernard', 'Lucas', 'Adresse principale', '42 rue du Commerce', '', '44000', 'Nantes', 'Loire-Atlantique', 'France', '0745678901', 1),
(48, 21, 'Robert', 'Emma', 'Adresse principale', '12 place de la République', '4ème étage', '31000', 'Toulouse', 'Haute-Garonne', 'France', '0656789012', 1),
(49, 14, 'cli', 'ent', 'Adresse principale', '76', '', '13400', 'Aubagne', 'Vienne', 'France', '0987654', 1),
(53, 12, 'Webber', 'Marion', 'Adresse par défaut', '10 rue chaulan', '', '13400', 'Aubagne', 'Bouches-du-Rhône', 'France', '0762069989', 0),
(54, 15, 'clie', 'nt', 'Adresse par défaut', '54', '', '13400', 'aubagne', 'Pouilles', 'Italie', '2154854', 1),
(55, 22, 'Moreau', 'Louis', 'Adresse par défaut', '3 rue des Fleurs', '', '67000', 'Strasbourg', 'Bas-Rhin', 'France', '0767890123', 1),
(56, 23, 'Laurent', 'Julie', 'Adresse par défaut', '56 avenue des Champs', 'Bât A', '59000', 'Lille', 'Nord', 'France', '0678901234', 1),
(57, 24, 'Garcia', 'Antoine', 'Adresse par défaut', '18 rue de la Paix', '', '33000', 'Bordeaux', 'Gironde', 'France', '0689012345', 1),
(58, 25, 'Roux', 'Chloé', 'Adresse par défaut', '9 avenue Jean Jaurès', 'Résidence du Parc', '06000', 'Nice', 'Alpes-Maritimes', 'France', '0690123456', 1),
(59, 26, 'Leroy', 'Paul', 'Adresse par défaut', '25 rue des Roses', '', '35000', 'Rennes', 'Ille-et-Vilaine', 'France', '0701234567', 1),
(60, 27, 'test', 'test', 'Adresse par défaut', '987', '', '8755', 'nimes', 'Luxembourg', 'Luxembourg', '0988', 1);

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `numero_commande` varchar(50) DEFAULT NULL,
  `adresse_livraison` text,
  `paypal_payment_id` varchar(255) DEFAULT NULL,
  `paypal_payer_id` varchar(255) DEFAULT NULL,
  `date_paiement` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `adresse_livraison_id` int NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `statut` enum('en_attente','validee','en_preparation','expediee','livree','annulee') NOT NULL DEFAULT 'en_attente',
  `date_commande` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `user_id`, `numero_commande`, `adresse_livraison`, `paypal_payment_id`, `paypal_payer_id`, `date_paiement`, `created_at`, `updated_at`, `adresse_livraison_id`, `total`, `statut`, `date_commande`, `date_modification`) VALUES
(13, 12, 'CMD-2025-77468', '10 rue chaulan, 13400 Aubagne', '58A43684CA5118201', '2L63NZ2CR6UQC', '2025-05-28 12:34:17', NULL, NULL, 42, '87.73', 'validee', '2025-05-28 12:30:38', '2025-05-28 12:34:17'),
(14, 17, 'CMD-2025-78901', '15 rue des Lilas, Apt 3B, 75011 Paris', NULL, NULL, '2025-05-28 15:05:14', NULL, NULL, 43, '45.98', 'validee', '2025-05-28 13:05:14', '2025-05-28 13:05:14'),
(15, 18, 'CMD-2025-78902', '28 avenue Victor Hugo, 69003 Lyon', NULL, NULL, '2025-05-27 14:35:00', NULL, NULL, 44, '89.47', 'en_preparation', '2025-05-27 12:30:00', '2025-05-28 13:05:34'),
(16, 19, 'CMD-2025-78903', '7 boulevard de la Mer, Résidence Les Pins, 13008 Marseille', NULL, NULL, NULL, NULL, NULL, 45, '258.98', 'en_attente', '2025-05-28 07:15:00', '2025-05-28 13:05:59'),
(17, 20, 'CMD-2025-78904', '42 rue du Commerce, 44000 Nantes', NULL, NULL, '2025-05-26 16:50:00', NULL, NULL, 46, '167.72', 'expediee', '2025-05-26 14:45:00', '2025-05-28 13:06:32'),
(18, 21, 'CMD-2025-78905', '12 place de la République, 4ème étage, 31000 Toulouse', NULL, NULL, '2025-05-25 11:25:00', NULL, NULL, 47, '108.93', 'livree', '2025-05-25 09:20:00', '2025-05-28 13:06:50'),
(19, 14, 'CMD-2025-74235', '76, 13400 Aubagne', '4XP85415TJ5596355', '2L63NZ2CR6UQC', '2025-05-28 13:10:48', NULL, NULL, 49, '5.99', 'validee', '2025-05-28 13:10:24', '2025-05-28 13:10:48'),
(20, 12, 'CMD-2025-59752', '10 rue chaulan, 13400 Aubagne', '821806554X005993W', '2L63NZ2CR6UQC', '2025-05-28 15:32:51', NULL, NULL, 42, '25.94', 'validee', '2025-05-28 15:32:27', '2025-05-28 15:32:51'),
(21, 12, 'CMD-2025-74694', '10 rue chaulan, 13400 Aubagne', '2J229507MB748723Y', '2L63NZ2CR6UQC', '2025-05-28 15:57:33', NULL, NULL, 42, '5.99', 'validee', '2025-05-28 15:57:08', '2025-05-28 15:57:33'),
(22, 12, 'CMD-2025-74739', '10 rue chaulan, 13400 Aubagne', NULL, NULL, NULL, NULL, NULL, 42, '43.85', 'en_attente', '2025-05-30 12:08:35', '2025-05-30 12:08:35'),
(23, 12, 'CMD-2025-25550', '10 rue chaulan, 13400 Aubagne', '67U11684AG775505C', '2L63NZ2CR6UQC', '2025-05-30 12:09:52', NULL, NULL, 42, '43.85', 'validee', '2025-05-30 12:08:47', '2025-05-30 12:09:52'),
(24, 12, 'CMD-2025-51331', '10 rue chaulan, 13400 Aubagne', '74Y93599TM913562R', '2L63NZ2CR6UQC', '2025-05-30 12:26:20', NULL, NULL, 42, '71.98', 'validee', '2025-05-30 12:25:50', '2025-05-30 12:26:20'),
(25, 12, 'CMD-2025-00391', '10 rue chaulan, 13400 Aubagne', '8V620111P0910610C', '2L63NZ2CR6UQC', '2025-05-30 12:31:56', NULL, NULL, 42, '25.99', 'expediee', '2025-05-30 12:31:47', '2025-05-30 13:18:06');

-- --------------------------------------------------------

--
-- Structure de la table `commande_produits`
--

CREATE TABLE `commande_produits` (
  `id` int NOT NULL,
  `commande_id` int NOT NULL,
  `produit_id` int NOT NULL,
  `quantite` int NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL,
  `total_ligne` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commande_produits`
--

INSERT INTO `commande_produits` (`id`, `commande_id`, `produit_id`, `quantite`, `prix_unitaire`, `total_ligne`, `created_at`, `updated_at`) VALUES
(18, 13, 48, 1, '32.84', '0.00', NULL, NULL),
(19, 13, 30, 1, '5.99', '0.00', NULL, NULL),
(20, 13, 46, 1, '3.95', '0.00', NULL, NULL),
(21, 13, 34, 1, '44.95', '0.00', NULL, NULL),
(22, 14, 7, 2, '5.99', '11.98', NULL, NULL),
(23, 14, 6, 1, '3.49', '3.49', NULL, NULL),
(24, 14, 11, 1, '8.95', '8.95', NULL, NULL),
(25, 14, 14, 3, '0.95', '2.85', NULL, NULL),
(26, 14, 18, 1, '13.41', '13.41', NULL, NULL),
(27, 14, 12, 1, '8.09', '8.09', NULL, NULL),
(28, 15, 2, 1, '23.90', '23.90', NULL, NULL),
(29, 15, 5, 2, '13.69', '27.38', NULL, NULL),
(30, 15, 8, 1, '14.99', '14.99', NULL, NULL),
(31, 15, 9, 1, '16.99', '16.99', NULL, NULL),
(32, 15, 13, 1, '8.50', '8.50', NULL, NULL),
(33, 16, 1, 1, '26.99', '26.99', NULL, NULL),
(34, 16, 4, 1, '32.99', '32.99', NULL, NULL),
(35, 16, 10, 1, '199.99', '199.99', NULL, NULL),
(36, 17, 15, 1, '25.99', '25.99', NULL, NULL),
(37, 17, 16, 1, '75.19', '75.19', NULL, NULL),
(38, 17, 17, 1, '91.53', '91.53', NULL, NULL),
(39, 17, 7, 5, '5.99', '29.95', NULL, NULL),
(40, 18, 3, 1, '75.95', '75.95', NULL, NULL),
(41, 18, 11, 2, '8.95', '17.90', NULL, NULL),
(42, 18, 12, 1, '8.09', '8.09', NULL, NULL),
(43, 18, 6, 2, '3.49', '6.98', NULL, NULL),
(44, 19, 7, 1, '5.99', '0.00', NULL, NULL),
(45, 20, 24, 1, '19.95', '0.00', NULL, NULL),
(46, 20, 7, 1, '5.99', '0.00', NULL, NULL),
(47, 21, 7, 1, '5.99', '0.00', NULL, NULL),
(48, 22, 24, 1, '19.95', '0.00', NULL, NULL),
(49, 22, 2, 1, '23.90', '0.00', NULL, NULL),
(50, 23, 24, 1, '19.95', '0.00', NULL, NULL),
(51, 23, 2, 1, '23.90', '0.00', NULL, NULL),
(52, 24, 27, 2, '35.99', '0.00', NULL, NULL),
(53, 25, 15, 1, '25.99', '0.00', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `paniers`
--

CREATE TABLE `paniers` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('actif','commande') DEFAULT 'actif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `paniers`
--

INSERT INTO `paniers` (`id`, `user_id`, `date_creation`, `status`, `created_at`, `updated_at`) VALUES
(1, 12, '2025-05-23 13:23:10', 'actif', '2025-05-23 15:23:10', '2025-05-23 13:23:10'),
(2, 13, '2025-05-23 19:28:04', 'actif', '2025-05-23 17:28:04', '2025-05-23 17:28:04'),
(3, 14, '2025-05-28 13:10:21', 'actif', '2025-05-28 11:10:21', '2025-05-28 11:10:21');

-- --------------------------------------------------------

--
-- Structure de la table `panier_produits`
--

CREATE TABLE `panier_produits` (
  `id` int NOT NULL,
  `panier_id` int NOT NULL,
  `produit_id` int NOT NULL,
  `quantite` int NOT NULL DEFAULT '1',
  `prix_unitaire` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `panier_produits`
--

INSERT INTO `panier_produits` (`id`, `panier_id`, `produit_id`, `quantite`, `prix_unitaire`) VALUES
(3, 2, 7, 13, '5.99');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text,
  `animal` enum('chien','chat') NOT NULL,
  `categorie` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `prix` decimal(10,2) NOT NULL,
  `stock` int DEFAULT '0',
  `is_vedette` tinyint(1) DEFAULT '0',
  `age` enum('junior','adulte','senior') DEFAULT NULL,
  `saveur` varchar(100) DEFAULT NULL,
  `sterilise` tinyint(1) DEFAULT NULL,
  `marque` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `animal`, `categorie`, `image`, `prix`, `stock`, `is_vedette`, `age`, `saveur`, `sterilise`, `marque`, `created_at`, `updated_at`) VALUES
(1, 'Royal Canin - Croquettes Maxi Adult pour Chien de Grande Taille 4KG', 'Description\r\nL\'aliment ROYAL CANIN® Maxi Adult est spécialement conçu pour répondre aux besoins nutritionnels de votre chien. Cet aliment convient aux grands chiens âgés de 15 mois et plus dont le poids adulte se situe entre 26 et 44 kg\r\n\r\nLes besoins nutritionnels d\'un chien de grande taille varient considérablement par rapport à ceux de plus petite taille. C\'est pourquoi il est essentiel de lui offrir une alimentation équilibrée adaptée à sa taille et à ses autres sensibilités spécifiques.\r\n\r\nL\'aliment ROYAL CANIN Maxi Adult est spécialement conçu pour répondre aux besoins nutritionnels de votre chien. Cet aliment convient aux grands chiens âgés de 15 mois et plus dont le poids adulte se situe entre 26 et 44 kg. Les grands chiens peuvent avoir les os et les articulations particulièrement sensibles, aussi est-il crucial de les préserver de l\'usure que peut entraîner leur taille. ROYAL CANIN Maxi Adult aidera votre chien à conserver un poids de forme idéal.\r\n\r\nROYAL CANIN Maxi Adult contient également une formule exclusive qui contribue à renforcer la santé digestive de votre chien. De plus, elle est enrichie en acides gras oméga-3 (EPA et DHA) bénéfiques à l\'entretien de la peau de votre chien, pour qu\'elle reste saine et bien nourrie.\r\n\r\n \r\n\r\n    Haute digestibilité\r\n    Renforcement des os et des articulations\r\n    Soutien optimal de la santé\r\n    Taille de croquette adaptée\r\n    Oméga-3 : EPA-DHA', 'chien', 'croquettes', 'images/produits/1747946359_d784cd489f488bb260fd.jpg', '26.99', 0, 0, 'adulte', 'Poulet', 0, 'Royal Canin', '2025-05-23 00:13:53', '2025-05-30 10:28:02'),
(2, '  Pro Plan Pro Plan - Croquettes All Size Light Sterilised Poulet pour Chien 3kg', '\r\n\r\nEfficacité prouvée pour la perte et la gestion du poids, grâce à une teneur élevée en protéines et des niveaux optimaux de glucides complexes et en fibres : ce qui aide à réduire la sensation de faim, tout en maintenant la masse musculaire et en soutenant la bonne santé des articulations\r\n\r\nEfficacité prouvée pour une perte de poids saine et le maintien du poids chez les chiens adultes ou stérilisés de toutes tailles. Formulé avec des morceaux de poulet de haute qualité.\r\n\r\nLes croquettes PURINA PRO PLAN ont une efficacité prouvée chez les chiens en surpoids. Sa formule permet de cibler une réduction de la masse grasse, tout en maintenant la masse musculaire pendant la perte de poids. On constate une réduction de 60% du tissu graisseux en seulement 12 semaines.\r\n\r\nCes croquettes sont composées de nutriments spécifiques et d\'une teneur en fibres adaptée pour aider à réduire la sensation de faim du chien, bien qu\'étant faible en matières grasses et calories.\r\n\r\nLes croquettes sont prouvées pour favoriser une perte de poids progressive, grâce à un niveau élevé de protéines, aux glucides complexes et à une teneur adaptée en fibres.\r\n\r\nElles contribuent également à réduire la surcharge de travail du c½ur en cas de surpoids et aident au maintien du poids de forme en prévenant la prise de poids à travers le maintien de la masse musculaire et la combustion des calories des chiens en surpoids ou stérilisés.\r\n\r\nAvantages du produit :\r\n\r\n \r\n\r\n    Faible en matières grasses - Favorise une perte de poids progressive\r\n    Aide à prévenir la prise de poids\r\n    Aide à réduire la sensation de faim\r\n    Soutient la bonne santé des articulations\r\n\r\n \r\n\r\nLa recette contient des morceaux de poulet de haute qualité, des antioxydants d\'origine naturelle et elle est sans colorants ajoutés', 'chien', 'croquettes-sterilise', 'images/produits/1747946605_09eed09b193900224881.png', '23.90', 18, 1, 'adulte', 'Poulet', 1, 'Purina', '2025-05-23 00:13:53', '2025-05-30 10:09:52'),
(3, 'Nutrivia Nature Plus - Croquettes Naturelles au Poulet Frais pour Chien de Toutes Races - 12Kg ', 'Croquettes naturelles de très haute qualité sans céréales pour le bien être au naturel des chiens adultes de toutes races, à partir de 12 mois.\r\n\r\nAliment complet au poulet frais, formulé pour une digestion facile et une bonne fonction hépatique, enrichi avec des probiotiques et des antioxydants pour une meilleure immunité.\r\n\r\nNutrivia Nature Plus est formulé:\r\n\r\nSans additifs\r\nSans conservateurs\r\nSans ogm\r\n\r\nNutrivia Nature Plus est également formulé d\'herbes naturelles, très bénéfiques pour leur organisme:\r\n\r\nLe romarin: aide à réduire le stress oxydatif du système nerveux et contribue au bon fonctionnement des fonctions cérébrales\r\nL\'églantier et l\'Argousier: contiennent une grande quantité de vitamine C qui stimule le système immunitaire\r\nGraine de charbon: favorise la purification du tube digestif pour faciliter une bonne digestion\r\nYucca: aide à réduire la production de métabolique aromatique dans l\'intestin et contribue à réduire le caractère aromatique des excréments\r\n\r\nNutrivia Nature Plus contient aussi des probiotiques, qui aident à soutenir l\'équilibre de la flore intestinale.', 'chien', 'alimentation-sans-cereales', 'images/produits/1747947238_a5594e2cfe5f2b36ac8c.png', '75.95', 80, 0, 'adulte', 'Poulet', 0, 'Nutriva Nature Plus', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(4, 'Edgard & Cooper - Croquettes BIO au Boeuf et Poulet pour Chien 2.5Kg', ' Aliment complet et sans céréales « MERVEILLEUX » pour chiens adultes : b½uf et poulet élevé en liberté, betterave, tomate, carotte, chou frisé et noix de coco\r\n\r\nAliment complet.\r\n\r\nDes aliments savoureux avec un maximum de viande fraîche. Des aliments naturels et savoureux bons pour eux, bien pour nous et notre planète. Nous utilisons exclusivement du poulet et du boeuf frais (ni séchés, ni précuits, ni hautement transformés ou sous forme de farine animale) pour favoriser la bonne digestion. Nous y ajoutons un cocktail hyper sain de fruits, de légumes et d\'herbes fraîches. Ensuite, nous cuisons lentement le tout par petites portions afin d\'en conserver tout le goût et les bienfaits.\r\n\r\nD\'extraordinaires ingrédients soigneusement sélectionnés pour une parfaite alimentation :\r\n\r\nBoeuf et poulet frais bio, avec des legumes, fruits et herbes bio\r\nL\'élevage bio répond à des normes plus strictes en termes de bien-être animal. Les animaux sont élevés en plein air et avec beaucoup d\'espace pour qu\'ils puissent s\'épanouir et grandir\r\nL\'agriculture bio contribue à lutter contre le changement climatique en maintenant le carbone dans le sol. Elle protège également les plantes, les insectes et les oiseaux\r\nSans ingrédients génétiquement modifiés ni conservateurs artificiels ni pesticides, la nourriture bio est le choix le plus sûr pour votre animal\r\n\r\nRecette sans céréales.\r\n', 'chien', 'alimentation-bio', 'images/produits/1747947498_1083c6761c38ec177bc7.png', '32.99', 149, 0, 'adulte', 'Boeuf', 0, 'Edgard & Cooper', '2025-05-23 00:13:53', '2025-05-28 10:04:46'),
(5, 'Royal Canin - Sachets Sterilised en Mousse pour Chien - 12X85g ', ' Aliment humide pour chiens stérilisés de toutes tailles, aide à maintenir un poids idéal, programme CCN\r\n\r\nAprès la stérilisation, le métabolisme de votre chien ralentit, et il peut arriver que votre animal préfère le canapé à l’aventure, tout en gardant le même solide appétit aux heures des repas. Nous savons qu’une alimentation équilibrée peut aider les animaux à mieux faire face aux problèmes de santé. Cet aliment est le fruit de décennies de recherche scientifique avancée en nutrition canine destinée à renforcer la santé des chiens stérilisés comme le vôtre.\r\n\r\nROYAL CANIN Sterilised mousse convient aux chiens de toutes tailles et est spécialement conçu à partir de nutriments actifs afin de satisfaire l’appétit de votre chien tout en préservant sa forme et sa vitalité. Cette savoureuse formule est enrichie en protéines hautement digestibles, parfaitement adaptées aux besoins spécifiques de votre chien.\r\n\r\nLes protéines que contient cet aliment aident votre chien à maintenir sa masse musculaire, tout en réduisant l’apport en calories et en matières grasses. De plus, la teneur modérée en matières grasses de ROYAL CANIN Sterilised mousse, ainsi que son mélange optimal de fibres alimentaires, favorise le maintien du poids idéal de votre chien, tout en lui procurant une sensation de satiété. En plus de cette délicieuse pâtée, notre programme nutritionnel Sterilised est également disponible sous forme de croquettes croustillantes. Toutes deux sont parfaitement équilibrées sur le plan nutritionnel et tout à fait complémentaires.\r\n\r\nPourquoi ne pas essayer la pâtée en accompagnement des croquettes ? Donnez à votre chien la formule ROYAL CANIN Sterilised mousse et découvrez les bienfaits de nutriments de haute qualité spécifiquement dosés pour qu’il reste plein de vie et en parfaite santé.\r\n', 'chien', 'boites-sachets', 'images/produits/1747947757_4fc936eb3c31960886c7.png', '13.69', 200, 0, 'adulte', 'Poulet', 1, 'Royal Canin', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(6, 'Royal Canin - Friandises Training Treats pour Chien - 110g ', ' Convenant aux chiens de plus de 6 mois, les friandises ROYAL CANIN® TRAINING TREATS sont conçues par des vétérinaires et approuvées par les chiens. Ces friandises contiennent une combinaison scientifique d’ingrédients, appuyée par plus de 50 ans de recherche et d’observation dans le domaine de la nutrition canine. Que vous enseigniez à votre chien des instructions de base ou des exercices plus complexes, les friandises ROYAL CANIN® TRAINING TREATS offrent un équilibre parfait entre saveur et nutrition.\r\n\r\nRécompensez les progrès de votre chien, une friandise à la fois. Lorsqu’il est question d’éduquer votre chien, nous savons qu’un encouragement positif est essentiel. C’est pourquoi nous avons créé ROYAL CANIN® TRAINING TREATS, afin que vous puissiez récompenser votre chien avec ces savoureuses friandises.\r\n\r\nFormulées par des vétérinaires, approuvées par les chiens.\r\n\r\nLes friandises ROYAL CANIN® TRAINING TREATS sont spécialement formulées pour les chiots de plus de 6 mois, avec une combinaison scientifique d’ingrédients, appuyée par plus de 50 ans de recherche et d’observation dans le domaine de la nutrition canine. Que vous enseigniez à votre chien des instructions de base ou des exercices plus complexes, les friandises ROYAL CANIN® TRAINING TREATS offrent un équilibre parfait entre saveur et nutrition.\r\n\r\nFriandises à faible teneur en calories pour soutenir la santé cérébrale à toutes les étapes de la vie.\r\n\r\nLes friandises ROYAL CANIN® TRAINING TREATS sont formulées avec du DHA et des vitamines C et E pour contribuer au bon fonctionnement cérébral des chiots jusqu’aux chiens matures. Avec moins de 3 calories par unité, ces friandises hypocaloriques sont conçues pour aider à maintenir la santé de votre chien tout en récompensant son bon comportement.\r\n\r\nCompatibles avec les aliments ROYAL CANIN formulés pour des animaux en bonne santé.\r\n\r\nNos friandises pour l’éducation sont élaborées pour compléter n’importe quel aliment de la gamme ROYAL CANIN conçue pour des animaux en bonne santé. Si votre chien est quotidiennement nourri avec un aliment de maintenance, les friandises ROYAL CANIN® TRAINING TREATS s’y associent parfaitement comme de savoureuses récompenses. Cela permet à votre chien de maintenir sa routine alimentaire tout en bénéficiant d’un soutien ciblé à son éducation.\r\n\r\nAvec moins de 3 calories par unité, ces friandises sont formulées avec du DHA et des vitamines C et E pour contribuer au bon fonctionnement cérébral des chiots jusqu’aux chiens matures.\r\n\r\nVeillez à respecter le tableau de rationnement figurant sur l’emballage et à ne pas donner à votre chien plus que le nombre recommandé d’unités par jour.\r\n\r\nLorsque vous offrez des friandises à votre animal de compagnie, il est conseillé d’ajuster sa ration journalière pour l’aider à maintenir un poids idéal.\r\n\r\nPour toute question ou préoccupation concernant la santé de votre chien, veuillez consulter votre vétérinaire.\r\n\r\nQue vous enseigniez à votre chien des instructions de base ou des exercices plus complexes, les friandises ROYAL CANIN® TRAINING TREATS offrent un équilibre parfait entre saveur et nutrition.\r\n', 'chien', 'friandises', 'images/produits/1747947891_ed9c93af84746b9f29f5.png', '3.49', 400, 0, 'adulte', 'Poulet', 0, 'Royal Canin', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(7, 'Animalis - Jouet Ecureuil en Laine Recyclée pour Chiens - 35cm ', 'Jouet pour chien en laine recyclée et polyfibres recyclées, sans rembourrage et avec sifflet (pouic-pouic). ', 'chien', 'jouets', 'images/produits/1747948178_7d83d074c13bd3299ac9.png', '5.99', 136, 1, NULL, NULL, 0, 'Animalis', '2025-05-23 00:13:53', '2025-05-28 13:57:33'),
(8, 'Leeby - Couverture Mouton pour Chiens - Gris ', 'Couverture douce réversible pour le confort de votre chiot. Grâce à son revêtement doux au toucher, votre chiot pourra s\'installer et se reposer confortablement sur cette couverture. Elle est réversible et offre deux surfaces différentes, ce qui lui permet de s\'adapter aux préférences de votre chiot et à chaque saison.\r\n\r\nCARACTERISTIQUES :\r\n\r\nMatière : Polyester\r\nDimensions : 75x100cm\r\nCouverture réversible', 'chien', 'paniers-coussins', 'images/produits/1747948483_a0bf713f622e520e9e81.png', '14.99', 240, 0, NULL, NULL, 0, 'Leeby', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(9, 'Leeby - Coussin Volutes Beige pour Chiens - S', 'Coussin extra doux multi-usage pour le confort de votre animal. Idéal à utiliser dans une corbeille en plastique, ce coussin fera le bonheur de votre chien. Grâce à son rembourrage douillet, ce coussin est épais et moelleux, mais également très doux au toucher, ce qui permettra à votre chien de dormir et/ou de voyager confortablement.\r\n\r\nCARACTERISTIQUES :\r\n\r\nMatière : Polyester\r\nDimensions : 10x70x40cm\r\nCoussin déhoussable', 'chien', 'paniers-coussins', 'images/produits/1747948651_7b80011920ab10e6ea44.png', '16.99', 60, 0, 'junior', NULL, 0, 'Leeby', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(10, 'Ferplast - Niche en Bois Baita - 100 ', ' Offrez à votre chien un lieu pour lui empreint de confort où il prendra plaisir à se réfugier.\r\nCette niche Baita 100 deviendra le lieu de refuge préféré de votre compagnon de toujours. Cette niche en bois, au design et à la couleur élégante, accueillera votre chien et le protégera des intempéries. Montée sur pieds, cette niche bénéficiera d\'une meilleure isolation au sol. Son toit traité avec un vernis spécial offrira une résistance optimale aux écarts thermiques. Adaptée aux chiens de grande taille, cette niche sera un abri de qualité pour votre canidé et un élément décoratif pour votre extérieur.\r\n', 'chien', 'niches-chenils', 'images/produits/1747948805_b09380be4d12238bdb8e.jpg', '199.99', 200, 0, NULL, NULL, 0, 'Ferplast', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(11, 'Animalis - Lotion en Spray Anti Démangeaisons pour Chiens et Chats - 125ml', 'La lotion en spray Animalis anti-démangeaisons à l\'eau florale et huiles essentielles, a une action calmante et désodorisante pour procurer une bonne hygiène de la peau de votre chien ', 'chien', 'hygiene-soins', 'images/produits/1747948924_c591b80930471457c490.jpg', '8.95', 170, 0, NULL, NULL, 0, 'Animalis', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(12, 'Beaphar - Pipettes Antiparasitaires VETOpure Eucalyptus pour Petits Chiens - 3x1ml', 'Les pipettes VETOpure pour petit chien ont été spécialement conçues pour repousser les parasites externes, tels que les puces, tiques et moustiques. À base d’huile d’Eucalyptus, arbre reconnu pour ses propriétés répulsives contre les insectes, elles repoussent les parasites externes pendant 3 mois. Elles peuvent être utilisées sur les chiens à partir de 6 mois.\r\n\r\nConseils d’utilisation : La quantité à utiliser est de 1 pipette de 1 ml, à renouveler toutes les 4 semaines. Ouvrir la pipette en rompant son extrémité et appliquer son contenu sur le cou du petit chien, derrière les oreilles. Sur les chiens blancs, le produit peut provoquer une coloration temporaire du pelage à l’endroit du dépôt. L’action optimale des pipettes nécessite quelques jours.\r\n\r\nUtilisez les biocides avec précaution. Avant toute utilisation, lisez l’étiquette et les informations concernant le produit.\r\n\r\nClassification biocide : Répulsif TP19', 'chien', 'antiparasitaires', 'images/produits/1747949082_a7e8b45e9230e291be7e.jpg', '8.09', 219, 0, NULL, NULL, 0, 'Beaphar', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(13, 'Paradisio - Lotion Nettoyante sans Rinçage Senteur Chèvrefeuille pour Chien - 250ml ', 'Entretenez le pelage de votre chien avec des produits de qualité comme cette lotion nettoyante sans rinçage à l\'extrait de capucine. Cette lotion nettoyante nettoie en douceur le poil de votre chien. Formulée sans paraben ni colorant, elle contient des extraits de capucine qui aident à adoucir les poils. (Quantité : 250 ml) ', 'chien', 'entretien-poil', 'images/produits/1747949288_9131e26c65f26d223bf3.jpg', '8.50', 450, 0, NULL, NULL, 0, 'Paradisio', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(14, 'Animalis - Sachet Nomade de Sacs Propreté pour Chien - 15 sacs ', ' Sachet nomade de 15 sacs pour chien\r\n\r\nLes sacs ramasse-crotte Animalis sont indispensables pour ramasser les excréments de votre chien, tout particulièrement lors des balades en ville où cela est obligatoire.\r\n\r\nCaractéristiques :\r\n\r\n100% biodégradable\r\nSac résistant\r\nDimensions : 30,5x23 centimètres\r\n\r\nVendu en sachet nomade de 15 sacs pour pouvoir être mis dans une poche de pantalon et facilité ainsi son utilisation ', 'chien', 'sacs-proprete', 'images/produits/1747949444_6d42ca6232ab9b94b8fb.jpg', '0.95', 199, 0, NULL, NULL, 0, 'Animalis', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(15, 'Animalis - Sac à Dos pour Chats - Gris - 32X26X42CM', ' Sac à dos pour chat avec ouverture panoramique et hublot pour emmener votre compagnon dans tous vos déplacements.\r\n\r\nAvec son ouverture panoramique et son hublot, ce sac à dos deviendra le poste d\'observation favori de votre compagnon ! Bien ventilé et isolé, il sera idéal pour emmener votre chat partout avec vous et lui faire découvrir de nouveaux environnements en toute sécurité.\r\n\r\nCaractéristiques :\r\nSac à dos en nylon et PC\r\n32 x 26 x 42 cm\r\nPoids maximum recommandé : 8kg', 'chien', 'sac-transport', 'images/produits/1747949538_6f8862f025b79b1292a2.png', '25.99', 71, 1, NULL, NULL, 0, 'Animalis', '2025-05-23 00:13:53', '2025-05-30 10:31:56'),
(16, 'Bobby - Sac de Transport PARISIEN pour Chien et Chat ', '\r\n\r\nCe sac de transport rigide sera idéal pour emmener votre compagnon en voiture ou en train. Les filets de ventilation et l\'entrée des deux côtés offriront une aération optimale.\r\n\r\nDimensions : 47x30x28 centimètres.\r\n', 'chien', 'sac-transport', 'images/produits/1747949689_8925bb25467e90b54cf4.jpg', '75.19', 89, 0, NULL, NULL, 0, 'Bobby', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(17, 'Trixie - Box de Transport Journey Noir/Gris - M/L : 100 x 65 x 60 cm ', ' Box de transport journey pour utilisation optimale du volume de coffre de la voiture grâce aux côtés inclinés\r\n\r\n    utilisation optimale du volume de coffre de la voiture grâce aux côtés inclinés\r\n    porte en métal, ouverture pliante\r\n    accessoires disponibles séparément : tapis drainant (art. 39412 taille S–M, art. 39414 taille M, art. 39416 taille M–L) et séparation en taille M–L (art. 39418)\r\n    en plastique\r\n    couleur : noir/gris\r\n\r\nPlacez le box dans le coffre de la voiture appuyé contre les sièges arrières et assurez-vous que le box soit bien calé.\r\n', 'chien', 'caisses-transport', 'images/produits/1747949862_426a27d96cde91fe616a.jpg', '91.53', 56, 0, NULL, NULL, 0, 'Trixie', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(18, 'Kurgo - Gourde 2 en 1 Bol Intégré pour Chien - Vert ', 'Cette gourde 2 en 1 est idéale pour gagner de la place dans un sac à dos. Une écuelle est intégrée à la bouteille, elle épouse les formes de la gourde et permet de contenir jusqu’à 250 ml d’eau. Pendant ce temps, le maître peut boire directement à la gourde d’une seule main, grâce à son ouverture facile par glissement. Plus besoin de dévisser une bouteille d’eau, s’hydrater et hydrater son chien devient un jeu d’enfant. La gourde a une contenance de 750 ml, elle ne contient ni PVC, ni BPA et peut être lavée au lave-vaisselle.\r\n\r\nGain de place : le bol épouse les formes de la gourde\r\nOuverture facile pour boire d’une seule main\r\nSans BPA ni PVC', 'chien', 'accessoires-voyage', 'images/produits/1747950029_8bceeb0c6fe8f546843c.jpg', '13.41', 83, 0, NULL, NULL, 0, 'Turgo', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(19, 'Animalis - Laisse Basic pour Chien Noi', ' Laisse pour chien de la gamme Basic par Animalis\r\n\r\nLaisse Basic 12 millimètres d\'une longueur de 120 centimètres. Existe en plusieurs coloris et plusieurs tailles pour s\'adapter a tous les chiens. Nylon souple et resistant.\r\n', 'chien', 'laisses', 'images/produits/1747950187_f658d0dd5c5d4ba35129.jpg', '4.50', 74, 0, NULL, NULL, 0, 'Animalis', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(20, 'Flexi - Laisse Classic avec Cordon Rouge pour Chien ', 'Laisse à enrouleur Flexi avec nouveau système de freinage et nouvelle forme ergonomique. M 8M', 'chien', 'laisses-enrouleur', 'images/produits/1747950934_dbc3b15ac21d8a8ce303.webp', '17.99', 58, 0, NULL, NULL, 0, 'Flexi', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(21, 'Gotoo - Collier Montagne pour Chien XL', 'Les chiens sont des compagnons de vie exceptionnels, apportant amour et bonheur à nos journées. Que ce soit lors de balades tranquilles en ville ou d’aventures en pleine nature, chaque moment partagé avec eux est précieux.\r\n\r\nLe COLLIER MONTAGNE GOTOO allie robustesse et élégance.\r\n\r\nAvec son design inspiré de la nature, il affiche un motif de montagne saisissant qui fera ressortir la personnalité de votre compagnon. Ce collier est à la fois léger et durable, parfait pour les chiens actifs qui aiment explorer leur environnement.', 'chien', 'colliers', 'images/produits/1747951056_cbf2ccba188d8501ac24.jpg', '16.99', 48, 0, 'adulte', NULL, 0, 'Gotoo', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(22, 'Gotoo - Harnais Essentials Rouge pour Chien L', ' Allie confort, sécurité et robustesse pour chiens.\r\n\r\nLes chiens sont des explorateurs naturels, toujours prêts à découvrir de nouveaux horizons et à profiter de chaque sortie pour satisfaire leur curiosité.\r\n\r\nPour ces moments essentiels de découverte et d\'activité, équipez votre chien avec les accessoires fonctionnels de GOTOO, garantissant à la fois confort et sécurité.\r\n\r\nLe harnais rouge Essential de GOTOO est un accessoire indispensable pour tous les propriétaires de chiens soucieux du bien-être de leur compagnon.\r\n\r\nConçu avec une attention minutieuse aux détails, ce harnais allie robustesse et ergonomie pour offrir à votre animal une expérience de promenade agréable et sécurisée.\r\n\r\nCARACTÉRISTIQUES :\r\nMatériaux résistants\r\nConfort ergonomique\r\nSangles réglables\r\nFermeture rapide\r\n\r\nL : 70-95 cm', 'chien', 'harnais', 'images/produits/1747951136_339181fe1905f33f4061.jpg', '17.99', 17, 0, 'adulte', NULL, 0, 'Gotoo', '2025-05-23 00:13:53', '2025-05-27 12:02:53'),
(23, 'Trixie - Muselière Muzzle Flex en Noir pour Chien - Taille L', 'La muselière ergonomique pour se balader en toute sérénité !\r\nLa muselière Muzzle Flex de Trixie est solide et résistante tout en offrant du confort à votre chien avec ses attaches en néoprène matelassé au niveau du visage et du cou. Le maintien en place de la muselière est garanti grâce aux attaches triples.\r\n\r\nL/XL : muselière max. 30 centimètres, circonférence intérieure de 36 centimètres\r\n\r\nCaractéristiques de la muselière Muzzle Flex :\r\nSilicone\r\nEmpêche de mordre\r\nAucun problème pour haleter, boire et manger des friandises\r\nTrès confortable à porter grâce à sa forme ergonomique, silicone souple indéformable et attaches en néoprène matelassé au niveau du visage et du cou\r\nMaintien sûr grâce aux attaches triples\r\nAttaches du front et du nez entièrement réglable en continu ainsi que la sangle du cou\r\nBandes réfléchissantes\r\nCouleur : Noir\r\n\r\nTaille de ce harnais : L. ', 'chien', 'muselieres', 'images/produits/1747951291_fa529879341fb81f3985.png', '14.99', 45, 0, 'adulte', NULL, 0, 'Trixie', '2025-05-23 00:13:53', '2025-05-27 12:02:53'),
(24, 'Bobby - Gamelle rose \"Delicious\" pour Chiens Taille M', 'Gamelle en mélamine comportant un bol amovible en inox adapté au lave-vaisselle. Son motif ‘Delicious’ mettra votre animal en appétit, et trouvera sa place dans la cuisine…\r\n\r\nJoint antidérapant\r\nBol amovible inox', 'chien', 'gamelles', 'images/produits/1747951427_2b127edd14886aad560f.jpg', '19.95', 117, 0, NULL, NULL, 0, 'Bobby', '2025-05-23 00:13:53', '2025-05-30 10:09:52'),
(25, 'Nath Veterinary Diet - Croquettes Diabetic Sans Céréales pour Chat - 4Kg', 'Aliment complet diététique pour chats, régulation de l\'apport en glucose (Diabète sucré)convient aux chats souffrant de diabète sucré. Convient également pour un maintien optimal du poids. Contient des fibres ajoutées pour la satiété. ', 'chat', 'alimentation-sans-cereales', 'images/produits/1747951978_b536bc34b6775d45af65.png', '8.50', 58, 0, 'adulte', 'Poulet', 0, 'Nath Veterinary Diet', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(26, 'Yarrah - Croquettes Bio Poulet et Poisson pour Chat Adultes 6KG', ' Croquettes biologiques au poulet et poisson certifié pêche durable pour chat adulte.\r\n\r\nDélicieuses croquettes au hareng MSC et au poulet avec des pois et du lupin, pour tout type de chat adulte.\r\n\r\nCes croquettes appétissantes constituent un repas nutritionnellement complet pour votre chat.\r\n', 'chat', 'alimentation-bio', 'images/produits/1747951991_818004213b999c836bc0.png', '43.19', 250, 0, 'adulte', NULL, 0, 'Yarrah', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(27, 'CatXtreme - Croquettes Adult Sterilised au Saumon Frais pour Chat kg', '\r\n\r\nAliment complet pour chat adulte stérilisé spécialement adapté à ses besoins pour une bonne vitalité. Contient de la viande fraiche, gage de protéines de qualité et d\'une plus grand appétence pour votre chat\r\n\r\nCatxtreme Sterilized est l\'aliment pour chats adultes stérilisés , il a été spécialement conçu pour couvrir leurs besoins alimentaires et énergétiques particuliers, en prévenant le risque d\'obésité.\r\n\r\nLa nourriture pour chat stérilisé Catxtreme incorpore la délicieuse saveur du saumon frais, l\'un des poissons à haute teneur en oméga 3 , qui fait partie des acides gras essentiels pour une bonne santé cardiovasculaire, du pelage et des articulations. Catxtreme Sterilized intègre également des fibres végétales et des minéraux tels que le calcium et le fer qui contribuent aux performances optimales de votre félin, fournissant l\'énergie nécessaire pour mener à bien toutes ses activités avec force et vitalité.\r\n\r\n \r\n\r\n    Aliment spécial pour chats adultes stérilisés avec des protéines et des graisses saines\r\n    Aide à contrôler le poids et prévient l\'obésité\r\n    Il contient des fibres et des minéraux comme le fer pour prévenir l\'anémie et générer de l\'énergie\r\n    Riche en vitamines et antioxydants pour prévenir les maladies graves\r\n    Il comprend de la biotine pour un pelage fort et brillant, ainsi que de la taurine pour une bonne vision et une bonne fonction cardiaque\r\n    Aide à contrôler le poids après la stérilisation\r\n\r\n \r\n\r\nStocker le produit dans un endroit frais et sec.\r\n', 'chat', 'croquettes-sterilise', 'images/produits/1747952238_dddc0a39b70b30d1bad7.jpg', '35.99', 236, 1, 'adulte', 'Saumon', 0, 'CATXTREME', '2025-05-23 00:13:53', '2025-05-30 10:26:20'),
(28, '  True Origins Wild True Origins Wild - Croquettes Poulet &Dinde pour Chatons - 2Kg ', ' Aliment sec riche en viande et sans céréales pour chatons.\r\n\r\nLes croquettes TRUE ORIGINS WILD Chicken Turkey Chaton offrent à votre chaton une alimentation qui répond à ses besoins naturels, grâce à une recette riche en viande et en fruits et légumes de haute qualité.\r\n\r\nCes savoureuses croquettes, sans céréales et riches en protéines, contribueront à maintenir votre chaton en pleine forme grâce à leur haute teneur en viande de qualité. Le poulet est riche en protéines animales, qui favorisent le développement et la bonne santé musculaire, tout au long de sa croissance. Il se distingue, entre autres, par sa teneur élevée en vitamine B2, qui contribue à la bonne santé de la peau et du système immunitaire. La viande de dinde, quant à elle, fournit de nombreux nutriments et produits chimiques, comme la taurine, que le corps du chaton ne produit pas naturellement.\r\n\r\nCette formule complète et équilibrée, comprend également des prébiotiques qui stimulent la microflore intestinale et facilitent la digestion. Les fruits et légumes sont une excellente source de minéraux et de vitamines, agissant comme des antioxydants naturels et permettant au système immunitaire de votre chaton de fonctionner pleinement.\r\n', 'chat', 'croquettes', 'images/produits/1747952424_ac4d0aabad5b5ed04003.jpg', '9.99', 140, 0, 'junior', 'Poulet', 0, 'True Origins Wild', '2025-05-23 00:13:53', '2025-05-23 09:23:31'),
(29, 'CatXtreme - Pâtée Adult Sterilised aux Sardines pour Chats - 170g ', '\r\nDescription\r\nLa boîte de nourriture humide Catxtreme est une nourriture très complète et nutritive qui aide à contrôler le poids de votre chat après la stérilisation. Fabriqué avec des ingrédients naturels et sans céréales, facilitant ainsi la digestion de votre chat et aidant son transit intestinal. Le bac à pâté de sardines aide votre félin à se sentir fort et plein d’énergie tous les jours, et maintient également son poids idéal. Grâce à la viande et au poisson, il fournit une valeur protéique élevée (22% poulet, 14% thon). Cet aliment humide est riche en acides gras qui aident à minimiser les maladies cardiovasculaires. La nourriture Catxtreme est formulée avec des ingrédients sains et naturels afin que votre chat profite d’un repas très nutritif. ', 'chat', 'boites-sachets', 'images/produits/1747952512_4e9bbb9963e9364c7ebe.jpg', '1.90', 219, 0, 'adulte', 'Saumon', 0, 'CATXTREME', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(30, 'Animalis - Herbe à Chat Catnip 100% Naturelle pour Chat - 30g ', '\r\n\r\nL\'herbe à chat Animalis 100% naturelle est naturellement attractive pour tous les chats. À utiliser sur les arbres à chats, les griffoirs ou à l\'intérieur de certains jouets pour l\'éducation de votre chat. Elle l\'incitera à utiliser les objets souhaités et détournera leur attention des meubles de la maison.\r\n\r\nCaractéristiques :\r\n\r\nCanalise l\'énergie du chat\r\nÉvite les griffures sur le mobilier\r\n\r\nFabriqué en France.\r\n', 'chat', 'boites-sachets', 'images/produits/1747952603_d5701fce1c63d3c85784.jpg', '5.99', 356, 1, NULL, NULL, 0, 'Animalis', '2025-05-23 00:13:53', '2025-05-28 10:34:17'),
(31, 'Ferplast - Chatière Swing SB1 en Plastique ', ' SWING 5 T BLANC - CHATIERE 4 VOIES TUNNEL\r\n\r\nGrà¢ce à la gamme Swing de Ferplast, vous pourrez installer une porte pour animaux, consacrée exclusivement à  votre ami à  quatre pattes, dans n\'importe quelle porte en bois, en métal ou en verre et murs en briques. Pour les chats et chiots, nous vous recommandons la Swing 1, 3 ou 5. Pour chiens moyens et grands, ainsi que grands félins, les Swing 11 ou 15 particulièrement adaptés. Le modèle Swing 7, équipé d\'un système magnétique, est parfait pour les chats. Ces chatières sont équipées de système innovant \"wind stopper\", système de protection contre les courants d\'air (à  l\'exception de la Swing 1 et 3 modèles qui ne l\'ont pas). Une autre caractéristique importante est le système de fermeture à  4 positionse (non présent dans le modèle de Swing 1) qui vous permet re régler le type d\'ouverture selon vos besoins : entrée uniquement, sortie uniquement, entrée et sortie, ou fermé. Enfin, un indicateur de passage (fourni avec Swing 5 et 7) vous aidera à  savoir si votre animal est à  l\'intérieur ou à  l\'extérieur, il représente une petite languette, placée au bas de la porte qui se placera dans la direction prise par votre petit animal. Les grands modèles disposent d\'un tunnel permettant ainsi de s\'adapter à  toute structure et pouvant être coupé. Pour les modèles 1, 3 et 5, livrés tunnels partiels, une extension modulable est disponible en option, elle mesure 5 cm de profondeur (les vis ne sont pas inclues). Important : avant d\'installer la chatière sur une structure en verre, nous vous conseillons de consulter un vitrier, car il n\'est pas possible de percer des trous dans le verre de sécurité trempé ou double vitrage sauf si ils ont été créées précédemment lors de la fabrication.»\r\n', 'chat', 'chatieres', 'images/produits/1747952688_9e53d5c8fe90fd4a6603.jpg', '11.19', 0, 0, NULL, NULL, 0, 'Ferplast', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(32, 'Weenect - Traceur GPS pour Chats ', 'Le plus petit traceur GPS pour chat du marché. Weenect Cats est un collier GPS pour chat qui permet aux maîtres de suivre sa position depuis leur téléphone. La localisation se fait en temps réel et en illimité, vous savez donc à tout moment où se trouve votre chat\r\n\r\nCaractéristiques principales :\r\n\r\n    Suivi en temps réel par GPS\r\n    Pas de limite de distance\r\n    Waterproof\r\n    Léger\r\n    Rechargeable', 'chat', 'sellerie', 'images/produits/1747952937_f61c19f015b20d626751.png', '49.99', 255, 1, NULL, NULL, 0, 'Weenect', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(33, 'Trixie - Sac Confort Blanc pour Radiateurs - 45×13x33cm ', 'Sac de confort blanc pour radiateurs, avec couverture en peluche (polyester) poils courts\r\n\r\ncoussin réversible avec rembourrage en fibres de polyester\r\ncadre en métal résistant\r\navec support réglable (9–12 cm)\r\nconvient à tous les types de radiateur\r\npeut supporter un poids jusqu\'à 5 kg', 'chat', 'hamac', 'images/produits/1747953047_235eac300a91f51480c7.jpg', '22.12', 74, 0, NULL, NULL, 0, 'Trixie', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(34, 'Bobby - Dôme Cachette Bulle Poilu Taupe pour Chat - S ', '\r\n\r\nDôme en fourrure, beau et ultra confortable, fabriqué à partir de fourrure synthétique longue et ultra douce. Design moderne et luxueux qui s’adapte facilement à votre intérieur.\r\n\r\nBulle en fourrure toute douce avec tube ammovible pour structurer la forme.\r\n', 'chat', 'niche-cabane', 'images/produits/1747953134_1bcae78959fd05ea2041.jpg', '44.95', 149, 0, NULL, NULL, 0, 'Bobby', '2025-05-23 00:13:53', '2025-05-28 10:34:17'),
(35, 'Leeby - Donut My Perfect Place pour Chats - Rose ', 'Donut moelleux pour le confort de votre animal. Grâce à ses rebords et à son coussin moelleux, votre chat sera confortablement installé pour se reposer ! Ce donut dispose d\'une surface anti-dérapante au verso qui l\'empêchera de glisser sur le sol.\r\n\r\nCARACTERISTIQUES :\r\n\r\nMatière : Coton avec dessous anti-dérapant\r\nDimensions : 15x50x50cm', 'chat', 'panier-coussin', 'images/produits/1747953230_eae0ec7591e83a61c2bc.jpg', '20.99', 53, 1, NULL, NULL, 0, 'Leeby', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(36, 'Animalis - Spray Insectifuge pour Habitat - 500ml ', '\r\n\r\nDiffuseur Insectifuge de la marque Animalis pour l\'habitat contre les puces et tiques. Ce produit a une action répulsive sur les parasites, réduit les risques d\'allergie tout en ayant un parfum agréable de citron qui neutralise également les mauvaises odeurs.\r\n\r\nCaractéristiques :\r\n\r\nAction répulsive sur les parasites\r\nRéduit les risques d\'allergie\r\nNeutralise les mauvaises odeurs\r\n\r\nProduit fabriqué en France\r\n', 'chat', 'antiparasitaires', 'images/produits/1747953374_6e1d40774ec6f70f91c3.jpg', '10.99', 38, 0, NULL, NULL, 0, 'Animalis', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(37, 'Paradisio - Litière Minérale pour Chat - 10Kg ', '\r\n\r\nCette litière pour chats, en sac de 10 kilos, vous assurera une cohabitation parfaite avec votre félin.\r\n\r\nComposée à base d\'argile 100% naturelle, elle constitue un gage de confort pour les chats comme pour votre intérieur, mais aussi un geste écologique pour l\'environnement.\r\n', 'chat', 'litieres', 'images/produits/1747953533_3430f9a5d724ff5e3849.jpg', '5.95', 78, 0, NULL, NULL, 0, 'Paradisio', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(38, 'Ferplast - Maison de Toilette Prima en Plastique ', ' Accessoire indispensable du chat, cette maison de toilette offrira à votre compagnon un coin tranquille pour faire ses besoins tout en préservant la propreté de votre pièce.\r\n\r\nCette maison de toilette traditionnelle pour chat s\'avèrera des plus pratiques pour offrir à votre compagnon un coin tranquille, idéal pour faire ses besoins à l\'abri des regards indiscrets. Fabriquée en plastique, cette maison de toilette aux coloris gris et rose, vous fera part de ses nombreux atouts en préservant notamment votre intérieur contre les mauvaises odeurs et les résidus de litière égarés.\r\nColoris aléatoires.\r\n', 'chat', 'bacs-litiere', 'images/produits/1747953613_beac97e7065799aeb1bc.jpg', '15.96', 45, 0, NULL, NULL, 0, 'Ferplast', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(39, 'Animalis - Filtres à Charbon pour Maison de Toilette Rotin - x2 ', '\r\n\r\nFiltres anti-odeurs au charbon actif pour les maisons de toilette Animalis style « Rotin » (référence 832966).\r\n\r\nLot de 2 filtres.\r\n', 'chat', 'accessoires-litieres', 'images/produits/1747953686_b8d90e51472603010c8d.jpg', '2.99', 200, 0, NULL, NULL, 0, 'Animalis', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(40, 'Trixie - Maison De Toilette Autonettoyante pour Chats ', 'La maison de toilette autonettoyante pour chats vous facilite la vie, à vous et à votre chat. Une fois que votre chat a fait ses besoins, le tambour tourne automatiquement et nettoie la zone.\r\n\r\nPour une propreté durable le tambour tourne automatiquement après utilisation, le processus de nettoyage s\'arrête automatiquement à l\'approche du chat, les particules solides tombent dans la poubelle.\r\n\r\nBac de récupération utilisable en option avec un sac poubelle du commerce\r\nPeut être utilisé avec de la litière agglomérante (max. 4 litres)\r\nTambour facile à utiliser et à nettoyer\r\nIdéal pour les foyers avec plus d\'un chat\r\nPour les chats à partir de 1,5 kg/4 mois\r\nEn plastique\r\nDimensions: 53 × 55,5 × 52 cm', 'chat', 'maison-toilette', 'images/produits/1747953831_76c32a9be536c2d928af.jpg', '277.56', 100, 0, NULL, NULL, 0, 'Trixie', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(41, 'Beaphar - Spray Shampoing Sec parfumé pour Chat - 200ml ', 'Spécialement conçu par nos vétérinaires pour les chats, ce shampoing à base d’eau de rose et d’extraits de bambou hydrate et purifie la peau des chats. Avec ses propriétés astringentes et purifiantes, l’eau de rose permet de limiter l’excès de sébum. Elle est apaisante et améliore l’état des peaux sèches. Son action stimule également la croissance du pelage et permet de limiter sa chute. En outre, le bambou possède des propriétés revitalisantes et hydratantes pour la peau. ', 'chat', 'entretien-poil', 'images/produits/1747953919_8e3c100644e719ae6e80.png', '9.49', 240, 0, NULL, NULL, 0, '', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(42, 'Trixie - Sac pour le transport et le séjour Valery noir/gris - 29 x 31 x 49 cm ', ' Sac pour le transport et le séjour avec un abri protégé\r\nAbri protégé avec fonction transport\r\n\r\n    particulièrement adapté aux chats\r\n    développé avec un vétérinaire spécialiste du comportement animal\r\n    avec matelas à ressorts de forme stable (en peluche)\r\n    ouverture frontale, latérale et par le haut\r\n    avec 4 poignées et bandoulière\r\n    la sangle de transport peut être rangée lorsqu\'elle n\'est pas utilisée\r\n    avec poches extérieures\r\n    en EVA forme stable avec polyester\r\n\r\nSac de transport et de séjour Valery\r\n\r\n\' Un foyer loin de son foyer \' - Notre nouveau sac de voyage et de transport Valery (art. #28901) offre une multitude d\'avantages aux animaux et à leurs maîtres. Le sac peut être utilisé comme abri douillet à la maison. Ainsi, l\'animal s\'habitue au sac dans un environnement familier et s\'y sent en sécurité lorsque vous partez en voyage. L\'insert du lit douillet peut être retiré au niveau du sol, ce qui facilite, par exemple, les visites chez le vétérinaire. Valery offre aux animaux et aux maîtres un moyen de transport confortable, doté d\'un coin repos protégé pour votre animal lorsque vous êtes en déplacement, en particulier pour les chats. Développé avec un vétérinaire spécialiste des chats.\r\n', 'chat', 'sac-transport', 'images/produits/1747954017_344509b753e36b7e83a9.jpg', '35.62', 35, 1, NULL, NULL, 0, 'Trixie', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(43, 'Animalis - Caisse de Transport Panzer Rose pour Chat - 50cm ', '\r\n\r\nPanier de transport pour chat ou petit chien maximum 8 kilos, avec ouverture de porte transparente et verticale. La porte verticale permet d’utiliser 2 mains pour mettre l’animal à l’intérieur.\r\n\r\nL’entrée est bien large pour simplifier l\'entrée de votre animal.\r\n\r\nDimensions : 50x33x31cm\r\n', 'chat', 'caisse-transport', 'images/produits/1747954101_dd1d345d26180cf4e1d6.jpg', '14.95', 345, 0, NULL, NULL, 0, 'Animalis', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(44, 'Ferplast - Support en Plastique Duo Feed avec Écuelles Inox - 400ml ', ' Offrez à votre chien tout le confort souhaité pour ses repas avec ce duo écuelles en inox et support en plastique anti-dérapant.\r\nCet ensemble d\'écuelles et leur support vous permettra de disposer la nourriture de votre chien dans un contenant design et chic. Ces deux écuelles en inox, d\'une contenance de 0,4 L , agrémentées de leur support en plastique gris, permettront à Médor de se restaurer en toute praticité du fait des propriétés anti-dérapantes de ce produit. Se restaurer deviendra un vrai plaisir, il n\'aura plus besoin de courir après une gamelle qui glisse', 'chat', 'gamelles', 'images/produits/1747954276_3abe0d6c527e56e4fa19.jpg', '14.99', 256, 0, NULL, NULL, 0, 'Ferplast', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(45, 'Animalis - Arbre à Chat XL Karla - 165 cm', ' Grand arbre à chat couleur crème qui s\'intègrera parfaitement dans votre intérieur pour le plus grand bonheur de votre chat.\r\n\r\nDécouvrez l\'Arbre à Chat XL Karla Animalis, l\'addition parfaite à votre intérieur que votre chat adoptera sans tarder.\r\n\r\nCOUCHAGE ET OBSERVATION\r\n\r\nAvec son sofa haut perché à plus 1,60m du sol, il offrira à votre chat un poste d\'observation idéal pour surveiller tout ce qu\'il se passe dans la maison, en toute sécurité. Votre chat pourra également choisir un autre lieu de repos, le hamac à structure métallique pouvant accueillir de gros chats, ou la niche douillette au pied de l\'arbre.\r\n\r\nGRIFFOIRS\r\n\r\nSes nombreux poteaux en sisal naturel sans colorants apportent au Karla une excellente stabilité tout permettant à votre chat de faire ses griffes. Son grand panneau griffoir vertical vient s\'ajouter aux poteaux en sisal pour être sûr que votre chat préfèrera son arbre Karla à votre canapé pour faire ses griffes.\r\n\r\nDIVERTISSEMENT ET ESCALADE\r\n\r\nIl dispose également de nombreuses tablettes sur lesquelles votre chat pourra grimper à sa guise. Une corde suspendue à la tablette supérieure du Karla lui permettra également de s\'amuser.\r\n\r\nCARACTERISTIQUES\r\n\r\n \r\n\r\n    Taille : 165x50x60 cm\r\n    Diamètre des poteaux : 7 cm\r\n    Poids : 22,9 kg\r\n    Couleur : Ecru\r\n    Matière : Peluche et sisal naturel', 'chat', 'arbres-griffoirs', 'images/produits/1747954385_84f2cfe50d0912f6b46f.jpg', '149.99', 58, 0, NULL, NULL, 0, 'Animalis', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(46, 'Animalis - Jouet Papillon Iris Gris pour Chat - 16cm ', 'Jouet pour chat en peluche, stimule votre chat et réveille son instinct naturel. Garder votre animal sous surveillance et retirer le jouet lorsqu\'il est abimé.\r\n\r\nDimensions : 16x12x1,3cm\r\nEn polyester', 'chat', 'jouets', 'images/produits/1747954471_1f2e330baec19f34a0f7.jpg', '3.95', 199, 0, 'junior', NULL, 0, 'Animalis', '2025-05-23 00:13:53', '2025-05-28 10:34:17'),
(47, 'Bobby - Jouet Boule Rose pour Chats - 10cm ', 'Collection de jouets en corde de papier recyclé aux couleurs pastels.\r\n\r\nCes jouets ludiques allient l\'utile à l\'agréable : ils permettent au chat de s\'amuser tout en faisant ses griffes. Leurs petits formats pratiques vous permettront de les emporter partout !\r\n\r\nCorde de papier recyclé\r\nStimule l’instinct de chasseur du chat\r\nPetit format pratique à emporter partout\r\nPlumes naturelles', 'chat', 'jouets', 'images/produits/1747954602_75c59f20f31f1590cd42.jpg', '5.00', 300, 0, NULL, NULL, 0, 'Bobby', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(48, 'Purina One - Croquettes Stérilisé Bifensis au Poulet pour Chat - 7,5Kg ', ' PURINA ONE BIFENSIS est une formule nutritionnelle unique contenant des bactéries fonctionnelles bénéfiques, les Lactobacillus. Scientifiquement prouvée, leur action renforce le système immunitaire de votre chat de l\'intérieur et contribue ainsi à protéger son microbiome intestinal.\r\n\r\nPURINA ONE Spécial Chat Stérilisé est spécifiquement formulé avec un profil nutritionnel adapté aux besoins des chats stérilisés. Avoir un microbiome intestinal équilibré est essentiel pour la bonne santé de votre chat, car il a un impact direct sur son système immunitaire.\r\n\r\nLe microbiome est un écosystème contenant des trillions de micro-organismes qui vivent dans l\'intestin et sont uniques à chaque chat. L\'équilibre des micro-organismes est important pour soutenir la bonne santé digestive, le système immunitaire et le bien-être général de votre chat.\r\n\r\nPURINA ONE BIFENSIS est une formule nutritionnelle unique contenant des bactéries fonctionnelles bénéfiques, les Lactobacillus. Scientifiquement prouvée, leur action renforce le système immunitaire de votre chat de l\'intérieur et contribue ainsi à protéger son microbiome intestinal.\r\n\r\nPURINA ONE BIFENSIS contient des ingrédients de haute qualité, dont un prébiotique : la chicorée. Celle-ci nourrit les bonnes bactéries de l\'intestin, afin d\'améliorer le microbiome intestinal de votre chat pour le maintenir en bonne santé. Une digestion saine, un système immunitaire fort et un pelage soyeux, constatez des résultats visibles sur la santé de votre chat aujourd\'hui et demain.\r\n\r\nCaractéristqiues :\r\n\r\nAliment complet pour chats adultes stérilisés\r\nFormulé pour aider à maintenir un métabolisme sain après la stérilisation/castration\r\nContrôle du poids grâce à un ratio protéines/matières grasses plus élevé* (*+15% par rapport à la recette Adulte)\r\nScientifiquement prouvé pour renforcer le système immunitaire de votre chat grâce aux Lactobacillus, des bactéries fonctionnelles bénéfiques\r\nAméliore l\'équilibre du microbiome intestinal grâce à la chicorée, un prébiotique\r\nPoulet : ingrédient N°1 - une bonne source de protéines et d\'acides aminés pour aider à construire et à maintenir des muscles forts\r\nAide à maintenir une peau saine et un pelage soyeux grâce aux acides gras Oméga 3 & 6, et aux vitamines et minéraux essentiels', 'chat', 'croquettes', 'images/produits/1747955751_20e7bda6d7c4d80bf342.png', '32.84', 499, 1, 'adulte', 'Poulet', 0, 'Purina', '2025-05-23 00:13:53', '2025-05-28 10:34:17'),
(49, 'Sheba - Filets au Poulet et au Thon pour Chat Adulte - 60g ', 'Aliment complémentaire pour chats adultes. Nourriture pour chat avec des ingrédients de haute qualité, simples et soigneusement sélectionnés. Un pur délice en sauce pour surprendre le palais des vrais amateurs de poulet et de thon issu de la pêche durable. Un nouveau moment de plaisir à partager avec vos fins gourmets en complément des repas principaux.\r\n\r\nLes Filets Sheba sont préparés avec des ingrédients de haute qualité, simples et soigneusement sélectionnés, sans colorants artificiels, ni conservateurs. Ces recettes exquises vous permettent d\'offrir de véritables moments d\'exception pour tous les félins, même les plus fins! Un choix raffiné et gourmand pour partager un instant unique avec votre chat. 100% de nos poissons sont issus de la pêche durable.\r\n\r\nThon issu de la pêche durable selon le référentiel MSC\r\nDe vrais filets préparés dans une sauce onctueuse pour une recette savoureuse qui ravira les palais des chats les plus raffinés\r\nUn véritable moment d\'exception pour tous les félins, même les plus fins!', 'chat', 'friandises', 'images/produits/1747956353_efd8631aa6d7622a0835.webp', '1.20', 250, 0, NULL, 'Poulet', 0, 'Sheba', '2025-05-23 00:13:53', '2025-05-23 00:13:53'),
(81, 'Animalis - Sachets Fraicheur pour Chats Stérilisés à la Viande - 12x100g ', '\r\n\r\nAliment complet.\r\nLes sachets fraicheur Animalis offrent à votre chat adulte stérilisé une alimentation complète sans colorant ni arôme artificiel, sous forme de petites bouchées en gelée au poulet au veau ou à la Dinde. Cette alimentation de haute qualité contribue à maintenir le poids de forme de votre chat stérilisé et préserve le bon fonctionnement de son système urinaire.\r\n', 'chat', 'boites-sachets', 'images/produits/1748000858_c111589e116fd30b4088.jpg', '7.95', 234, 0, 'adulte', 'Poulet', 1, 'Animalis', '2025-05-23 09:47:38', '2025-05-23 09:47:38');

-- --------------------------------------------------------

--
-- Structure de la table `publicites`
--

CREATE TABLE `publicites` (
  `id` int NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `publicites`
--

INSERT INTO `publicites` (`id`, `titre`, `description`, `image`, `alt_text`) VALUES
(1, 'Accessoires de voyage pour chiens', 'Découvrez notre gamme d\'accessoires de voyage', 'pub1.png', 'Publicité promo friandises'),
(2, 'Antiparasitaires pour chiens', 'Protégez votre chien contre les parasites', 'pub2.png', 'Publicité jouets pour chats'),
(3, 'Friandises pour chats', 'Gâtez votre chat avec nos délicieuses friandises', 'pub3.png', 'Publicité promo croquettes sheba'),
(4, 'Couchage pour chiens', 'Offrez le meilleur confort à votre chien', 'pub4.png', 'Publicité panier');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nomcompte` varchar(255) NOT NULL,
  `prenomcompte` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','client','visiteur') NOT NULL DEFAULT 'visiteur',
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `complement` varchar(255) DEFAULT NULL,
  `code_postal` varchar(20) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `departement` varchar(100) DEFAULT NULL,
  `pays` varchar(100) DEFAULT NULL,
  `telephone` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nomcompte`, `prenomcompte`, `email`, `password`, `role`, `nom`, `prenom`, `adresse`, `complement`, `code_postal`, `ville`, `departement`, `pays`, `telephone`, `created_at`, `updated_at`) VALUES
(12, 'Webber', 'Marion', 'admin@outlook.fr', '$2y$10$Lo19Mqcj4tsMcSqlqZC28ervQlX8i0gGqXOk7GedbM7DFevvAqnMC', 'admin', '', '', '10 rue chaulan', NULL, '13400', 'Aubagne', 'Bouches-du-Rhône', 'France', '0762069989', '2025-05-23 00:13:53', '2025-05-30 12:27:56'),
(14, 'cli', 'ent', 'client@outlook.fr', '$2y$10$UPlhM4HOB3MIhps4HbMPj.iU0JpeXHjgd2nRvifz1I.a9TNO67AN2', 'client', 'cli', 'ent', '76', '', '13400', 'Aubagne', 'Vienne', 'France', '0987654', '2025-05-23 14:51:55', '2025-05-23 14:51:55'),
(15, 'clie', 'nt', 'clientmaison@outlook.fr', '$2y$10$dkGS1NKLnePjhbWW5C3UD.ErEcvwituTpDHNUoDcqQLspJ90U3KGO', 'client', 'clie', 'nt', '54', '', '13400', 'aubagne', 'Pouilles', 'Italie', '2154854', '2025-05-23 20:22:06', '2025-05-23 20:22:06'),
(17, 'dupont', 'marie', 'marie.dupont@email.fr', '$2y$10$Lo19Mqcj4tsMcSqlqZC28ervQlX8i0gGqXOk7GedbM7DFevvAqnMC', 'client', 'Dupont', 'Marie', '15 rue des Lilas', 'Apt 3B', '75011', 'Paris', 'Paris', 'France', '0612345678', '2025-05-26 13:07:29', '2025-05-26 13:07:29'),
(18, 'martin', 'thomas', 'thomas.martin@email.fr', '$2y$10$Lo19Mqcj4tsMcSqlqZC28ervQlX8i0gGqXOk7GedbM7DFevvAqnMC', 'client', 'Martin', 'Thomas', '28 avenue Victor Hugo', '', '69003', 'Lyon', 'Rhône', 'France', '0723456789', '2025-05-26 13:07:29', '2025-05-26 13:07:29'),
(19, 'petit', 'sophie', 'sophie.petit@email.fr', '$2y$10$Lo19Mqcj4tsMcSqlqZC28ervQlX8i0gGqXOk7GedbM7DFevvAqnMC', 'client', 'Petit', 'Sophie', '7 boulevard de la Mer', 'Résidence Les Pins', '13008', 'Marseille', 'Bouches-du-Rhône', 'France', '0634567890', '2025-05-26 13:07:29', '2025-05-26 13:07:29'),
(20, 'bernard', 'lucas', 'lucas.bernard@email.fr', '$2y$10$Lo19Mqcj4tsMcSqlqZC28ervQlX8i0gGqXOk7GedbM7DFevvAqnMC', 'client', 'Bernard', 'Lucas', '42 rue du Commerce', '', '44000', 'Nantes', 'Loire-Atlantique', 'France', '0745678901', '2025-05-26 13:07:29', '2025-05-26 13:07:29'),
(21, 'robert', 'emma', 'emma.robert@email.fr', '$2y$10$Lo19Mqcj4tsMcSqlqZC28ervQlX8i0gGqXOk7GedbM7DFevvAqnMC', 'client', 'Robert', 'Emma', '12 place de la République', '4ème étage', '31000', 'Toulouse', 'Haute-Garonne', 'France', '0656789012', '2025-05-26 13:07:29', '2025-05-26 13:07:29'),
(22, 'moreau', 'louis', 'louis.moreau@email.fr', '$2y$10$Lo19Mqcj4tsMcSqlqZC28ervQlX8i0gGqXOk7GedbM7DFevvAqnMC', 'client', 'Moreau', 'Louis', '3 rue des Fleurs', '', '67000', 'Strasbourg', 'Bas-Rhin', 'France', '0767890123', '2025-05-26 13:07:29', '2025-05-26 13:07:29'),
(23, 'laurent', 'julie', 'julie.laurent@email.fr', '$2y$10$Lo19Mqcj4tsMcSqlqZC28ervQlX8i0gGqXOk7GedbM7DFevvAqnMC', 'client', 'Laurent', 'Julie', '56 avenue des Champs', 'Bât A', '59000', 'Lille', 'Nord', 'France', '0678901234', '2025-05-26 13:07:29', '2025-05-26 13:07:29'),
(24, 'garcia', 'antoine', 'antoine.garcia@email.fr', '$2y$10$Lo19Mqcj4tsMcSqlqZC28ervQlX8i0gGqXOk7GedbM7DFevvAqnMC', 'client', 'Garcia', 'Antoine', '18 rue de la Paix', '', '33000', 'Bordeaux', 'Gironde', 'France', '0689012345', '2025-05-26 13:07:29', '2025-05-26 13:07:29'),
(25, 'roux', 'chloe', 'chloe.roux@email.fr', '$2y$10$Lo19Mqcj4tsMcSqlqZC28ervQlX8i0gGqXOk7GedbM7DFevvAqnMC', 'client', 'Roux', 'Chloé', '9 avenue Jean Jaurès', 'Résidence du Parc', '06000', 'Nice', 'Alpes-Maritimes', 'France', '0690123456', '2025-05-26 13:07:29', '2025-05-26 13:07:29'),
(26, 'leroy', 'paul', 'paul.leroy@email.fr', '$2y$10$Lo19Mqcj4tsMcSqlqZC28ervQlX8i0gGqXOk7GedbM7DFevvAqnMC', 'client', 'Leroy', 'Paul', '25 rue des Roses', '', '35000', 'Rennes', 'Ille-et-Vilaine', 'France', '0701234567', '2025-05-26 13:07:29', '2025-05-26 13:07:29'),
(27, 'test1', 'test', 'test@gmail.com', '$2y$10$52q/6VKTUmx.s6EpKxWhTevEPxCd9L9jZ14sy/rRMcYs9BikQS6yW', 'client', 'test', 'test', '987', '', '8755', 'nimes', 'Luxembourg', 'Luxembourg', '0988', '2025-05-30 11:47:57', '2025-05-30 11:48:28');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adresses`
--
ALTER TABLE `adresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_commande` (`numero_commande`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `adresse_livraison_id` (`adresse_livraison_id`);

--
-- Index pour la table `commande_produits`
--
ALTER TABLE `commande_produits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Index pour la table `paniers`
--
ALTER TABLE `paniers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `panier_produits`
--
ALTER TABLE `panier_produits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `panier_id` (`panier_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `publicites`
--
ALTER TABLE `publicites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adresses`
--
ALTER TABLE `adresses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `commande_produits`
--
ALTER TABLE `commande_produits`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `paniers`
--
ALTER TABLE `paniers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `panier_produits`
--
ALTER TABLE `panier_produits`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT pour la table `publicites`
--
ALTER TABLE `publicites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adresses`
--
ALTER TABLE `adresses`
  ADD CONSTRAINT `adresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commandes_ibfk_2` FOREIGN KEY (`adresse_livraison_id`) REFERENCES `adresses` (`id`);

--
-- Contraintes pour la table `commande_produits`
--
ALTER TABLE `commande_produits`
  ADD CONSTRAINT `commande_produits_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commande_produits_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`);

--
-- Contraintes pour la table `panier_produits`
--
ALTER TABLE `panier_produits`
  ADD CONSTRAINT `panier_produits_ibfk_1` FOREIGN KEY (`panier_id`) REFERENCES `paniers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `panier_produits_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
