-- Script SQL pour créer les tables de commandes
-- À exécuter dans phpMyAdmin dans votre base de données 'trufficat'

-- Table des commandes
CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `numero_commande` varchar(50) NOT NULL UNIQUE,
  `statut` enum('en_attente','payee','expediee','livree','annulee') NOT NULL DEFAULT 'en_attente',
  `total` decimal(10,2) NOT NULL,
  `adresse_livraison` text NOT NULL,
  `paypal_payment_id` varchar(255) DEFAULT NULL,
  `paypal_payer_id` varchar(255) DEFAULT NULL,
  `date_commande` datetime DEFAULT NULL,
  `date_paiement` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `commandes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table de liaison commande-produits
CREATE TABLE IF NOT EXISTS `commande_produits` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `commande_id` int(11) UNSIGNED NOT NULL,
  `produit_id` int(11) UNSIGNED NOT NULL,
  `quantite` int(11) UNSIGNED NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL,
  `total_ligne` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commande_id` (`commande_id`),
  KEY `produit_id` (`produit_id`),
  CONSTRAINT `commande_produits_commande_id_foreign` FOREIGN KEY (`commande_id`) REFERENCES `commandes`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `commande_produits_produit_id_foreign` FOREIGN KEY (`produit_id`) REFERENCES `produits`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 