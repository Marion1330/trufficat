-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 21 mai 2025 à 13:57
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
  `is_principale` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `marque` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `animal`, `categorie`, `image`, `prix`, `stock`, `is_vedette`, `age`, `saveur`, `sterilise`, `marque`) VALUES
(1, 'Os en caoutchouc', 'Un jouet solide pour chien.', 'chien', 'jouets', 'chien1.jpg', '9.99', 0, 1, NULL, NULL, NULL, 'Purina'),
(2, 'Griffoir design', 'Un griffoir stylé pour votre matou.', 'chat', 'arbres-griffoirs', 'chat1.jpg', '24.99', 0, 1, NULL, NULL, NULL, 'Whiskas'),
(3, 'Croquettes premium', 'Aliment complet pour chien actif.', 'chien', 'croquettes', 'chien2.jpg', '34.99', 0, 1, 'adulte', 'Poulet', NULL, 'Royal Canin'),
(4, 'Jouet plume', 'Jouet interactif pour chat joueur.', 'chat', 'jouets', 'chat2.jpg', '6.99', 0, 1, NULL, NULL, NULL, 'Sheba'),
(5, 'Os en caoutchouc', 'Un jouet solide pour chien.', 'chien', 'jouets', 'chien1.jpg', '9.99', 0, 1, NULL, NULL, NULL, 'Purina'),
(6, 'Griffoir design', 'Un griffoir stylé pour votre matou.', 'chat', 'arbres-griffoirs', 'chat1.jpg', '24.99', 0, 1, NULL, NULL, NULL, 'Whiskas'),
(7, 'Croquettes premium', 'Aliment complet pour chien actif.', 'chien', 'croquettes', 'chien2.jpg', '34.99', 0, 1, 'adulte', 'Poulet', NULL, 'Royal Canin'),
(8, 'Jouet plume', 'Jouet interactif pour chat joueur.', 'chat', 'jouets', 'chat2.jpg', '6.99', 0, 1, NULL, NULL, NULL, 'Sheba'),
(9, 'Croquettes Premium pour Chat Stérilisé', 'Croquettes spécialement formulées pour les chats stérilisés, aidant à maintenir un poids idéal tout en apportant les nutriments essentiels.', 'chat', 'croquettes-sterilise', 'royal-canin-sterilised.jpg', '39.99', 0, 0, 'adulte', 'Poulet', 1, 'Royal Canin'),
(10, 'Croquettes Chat Adulte Sans Céréales', 'Alimentation sans céréales de qualité supérieure pour votre chat adulte, riche en protéines animales.', 'chat', 'sans-cereales', 'carnilove-chat.jpg', '44.99', 0, 0, 'adulte', 'Saumon', 0, 'Carnilove'),
(11, 'Croquettes Chaton', 'Spécialement conçues pour les chatons en pleine croissance, ces croquettes sont riches en protéines et calcium.', 'chat', 'croquettes', 'chaton-whiskas.jpg', '29.99', 0, 0, 'junior', 'Poulet', 0, 'Whiskas'),
(12, 'Croquettes Senior Chat', 'Croquettes adaptées aux besoins des chats seniors, riches en antioxydants et nutriments essentiels.', 'chat', 'croquettes', 'hills-senior-chat.jpg', '34.99', 0, 0, 'senior', 'Poulet', 0, 'Hill\'s Science Plan'),
(13, 'Pack de 12 Sachets Fraîcheur', 'Assortiment de 12 savoureux sachets fraîcheur pour chat adulte.', 'chat', 'boites-sachets', 'sheba-sachets.jpg', '12.99', 0, 0, 'adulte', 'Boeuf', 0, 'Sheba'),
(14, 'Boîtes pour Chat Stérilisé', 'Alimentation humide adaptée aux besoins des chats stérilisés.', 'chat', 'boites-sachets', 'perfect-fit-sterilise.jpg', '15.99', 0, 0, 'adulte', 'Saumon', 1, 'Perfect Fit'),
(15, 'Litière Agglomérante', 'Litière agglomérante de qualité supérieure pour un contrôle optimal des odeurs.', 'chat', 'litieres', 'catsan-litiere.jpg', '14.99', 0, 0, NULL, NULL, NULL, 'Purina'),
(16, 'Litière Végétale Biodégradable', 'Litière 100% naturelle et biodégradable, idéale pour les chats et l\'environnement.', 'chat', 'litieres', 'catsan-vegetale.jpg', '19.99', 0, 0, NULL, NULL, NULL, 'Purina'),
(17, 'Arbre à Chat Luxe', 'Un arbre à chat robuste et stable avec plusieurs plateformes et jouets suspendus.', 'chat', 'arbres-griffoirs', 'arbre-chat-luxe.jpg', '89.99', 0, 0, NULL, NULL, NULL, 'Ultima'),
(18, 'Griffoir en Sisal', 'Griffoir vertical en sisal naturel, idéal pour préserver vos meubles.', 'chat', 'arbres-griffoirs', 'griffoir-sisal.jpg', '24.99', 0, 0, NULL, NULL, NULL, 'Almo Nature'),
(19, 'Panier Cocon Douillet', 'Panier doux et confortable en forme de cocon pour que votre chat puisse se blottir.', 'chat', 'panier-coussin', 'panier-chat.jpg', '29.99', 0, 0, NULL, NULL, NULL, 'Edgard & Cooper'),
(20, 'Croquettes Premium Chien Adulte', 'Croquettes complètes et équilibrées pour chiens adultes de toutes races.', 'chien', 'croquettes', 'royal-canin-adulte.jpg', '42.99', 0, 0, 'adulte', 'Poulet', 0, 'Royal Canin'),
(21, 'Croquettes Chiot Grande Race', 'Spécialement conçues pour les chiots de grande race en pleine croissance.', 'chien', 'croquettes', 'eukanuba-chiot.jpg', '39.99', 0, 0, 'junior', 'Poulet', 0, 'Eukanuba'),
(22, 'Croquettes Sans Céréales Chien', 'Alimentation premium sans céréales, riche en protéines animales.', 'chien', 'sans-cereales', 'acana-sans-cereales.jpg', '54.99', 0, 0, 'adulte', 'Boeuf', 0, 'Acana'),
(23, 'Croquettes Chien Stérilisé', 'Formule adaptée aux besoins des chiens stérilisés pour maintenir un poids idéal.', 'chien', 'croquettes-sterilise', 'pedigree-sterilise.jpg', '36.99', 0, 0, 'adulte', 'Poulet', 1, 'Pedigree'),
(24, 'Croquettes Senior Petite Race', 'Croquettes spéciales pour chiens seniors de petite race avec articulations fragiles.', 'chien', 'croquettes', 'hills-senior.jpg', '44.99', 0, 0, 'senior', 'Poulet', 0, 'Hill\'s Science Plan'),
(25, 'Friandises Dentastix', 'Bâtonnets à mâcher pour l\'hygiène dentaire de votre chien.', 'chien', 'friandises', 'dentastix.jpg', '7.99', 0, 0, 'adulte', NULL, 0, 'Pedigree'),
(26, 'Os à Mâcher Naturel', 'Os à mâcher 100% naturel pour le plaisir de votre chien.', 'chien', 'friandises', 'os-naturel.jpg', '9.99', 0, 0, 'adulte', 'Boeuf', 0, 'Carnilove'),
(27, 'Laisse Réglable', 'Laisse robuste et ajustable pour chiens de toutes tailles.', 'chien', 'laisses', 'laisse-reglable.jpg', '19.99', 0, 0, NULL, NULL, NULL, 'Frolic'),
(28, 'Collier en Nylon', 'Collier résistant à l\'eau avec boucle sécurisée.', 'chien', 'colliers', 'collier-nylon.jpg', '14.99', 0, 0, NULL, NULL, NULL, 'Frolic'),
(29, 'Harnais Anti-Traction', 'Harnais confortable et sécurisé limitant les tractions pour une promenade agréable.', 'chien', 'harnais', 'harnais-anti-traction.jpg', '29.99', 0, 0, NULL, NULL, NULL, 'Orijen'),
(30, 'Panier Orthopédique', 'Panier à mémoire de forme offrant un soutien optimal pour les articulations.', 'chien', 'paniers-coussins', 'panier-orthopedique.jpg', '59.99', 0, 0, NULL, NULL, NULL, 'Edgard & Cooper'),
(31, 'Jouet à Mordiller Résistant', 'Jouet ultra-résistant pour les chiens qui aiment mordiller.', 'chien', 'jouets', 'jouet-resistant.jpg', '12.99', 0, 0, NULL, NULL, NULL, 'Purina');

-- --------------------------------------------------------

--
-- Structure de la table `publicites`
--

CREATE TABLE `publicites` (
  `id` int NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `publicites`
--

INSERT INTO `publicites` (`id`, `titre`, `description`, `image`, `url`, `alt_text`) VALUES
(1, 'Publicité 1', 'Balade', 'pub1.png', 'https://exemple.com/promo1', 'Publicité promo friandises'),
(2, 'Publicité 2', 'Anti-parasites', 'pub2.png', 'https://exemple.com/promo2', 'Publicité jouets pour chats'),
(3, 'Publicité 3', 'Promo sur les croquettes sheba', 'pub3.png', 'https://exemple.com/promo3', 'Publicité promo croquettes sheba'),
(4, 'Publicité 4', 'Pub panier', 'pub4.png', 'https://exemple.com/promo4', 'Publicité panier');

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
  `telephone` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nomcompte`, `prenomcompte`, `email`, `password`, `role`, `nom`, `prenom`, `adresse`, `complement`, `code_postal`, `ville`, `departement`, `pays`, `telephone`) VALUES
(12, 'ministrateur', 'Ad', 'admin@outlook.fr', '$2y$10$Lo19Mqcj4tsMcSqlqZC28ervQlX8i0gGqXOk7GedbM7DFevvAqnMC', 'admin', 'ministrateur', 'Ad', '87', '', '13400', 'Aubagne', 'Bouches-du-Rhône', 'France', '098765432');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `publicites`
--
ALTER TABLE `publicites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adresses`
--
ALTER TABLE `adresses`
  ADD CONSTRAINT `adresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
