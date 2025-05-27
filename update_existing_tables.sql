-- Script pour adapter les tables existantes au code CodeIgniter
-- À exécuter dans phpMyAdmin

-- 1. Renommer la table commande_details en commande_produits
RENAME TABLE `commande_details` TO `commande_produits`;

-- 2. Ajouter les colonnes manquantes à la table commandes
ALTER TABLE `commandes` 
ADD COLUMN `numero_commande` varchar(50) UNIQUE AFTER `user_id`,
ADD COLUMN `adresse_livraison` text AFTER `numero_commande`,
ADD COLUMN `paypal_payment_id` varchar(255) DEFAULT NULL AFTER `adresse_livraison`,
ADD COLUMN `paypal_payer_id` varchar(255) DEFAULT NULL AFTER `paypal_payment_id`,
ADD COLUMN `date_paiement` datetime DEFAULT NULL AFTER `paypal_payer_id`,
ADD COLUMN `created_at` datetime DEFAULT NULL AFTER `date_paiement`,
ADD COLUMN `updated_at` datetime DEFAULT NULL AFTER `created_at`;

-- 3. Renommer les colonnes pour correspondre au code
ALTER TABLE `commandes` 
CHANGE `montant_total` `total` decimal(10,2) NOT NULL,
CHANGE `status` `statut` enum('en_attente','payee','expediee','livree','annulee') NOT NULL DEFAULT 'en_attente';

-- 4. Ajouter les colonnes manquantes à commande_produits
ALTER TABLE `commande_produits`
ADD COLUMN `total_ligne` decimal(10,2) NOT NULL AFTER `prix_unitaire`,
ADD COLUMN `created_at` datetime DEFAULT NULL AFTER `total_ligne`,
ADD COLUMN `updated_at` datetime DEFAULT NULL AFTER `created_at`;

-- 5. Générer des numéros de commande pour les commandes existantes (si il y en a)
UPDATE `commandes` SET `numero_commande` = CONCAT('CMD-', YEAR(CURDATE()), '-', LPAD(id, 5, '0')) WHERE `numero_commande` IS NULL;

-- 6. Calculer les totaux de ligne pour les détails existants
UPDATE `commande_produits` SET `total_ligne` = `quantite` * `prix_unitaire` WHERE `total_ligne` = 0; 