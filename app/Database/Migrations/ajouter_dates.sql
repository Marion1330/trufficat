-- Ajouter les colonnes à la table produits
ALTER TABLE produits
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Ajouter les colonnes à la table users
ALTER TABLE users
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Mettre à jour les dates existantes
UPDATE produits SET created_at = NOW(), updated_at = NOW();
UPDATE users SET created_at = NOW(), updated_at = NOW(); 