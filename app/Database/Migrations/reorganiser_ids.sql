-- Désactiver les contraintes de clé étrangère temporairement
SET FOREIGN_KEY_CHECKS=0;

-- Créer une table temporaire
CREATE TABLE temp_produits LIKE produits;

-- Copier les données dans la table temporaire avec des IDs réorganisés
INSERT INTO temp_produits 
SELECT NULL, nom, description, animal, categorie, image, prix, stock, sans_cereales, age, saveur, sterilise, marque, is_vedette
FROM produits 
ORDER BY id;

-- Supprimer l'ancienne table
DROP TABLE produits;

-- Renommer la table temporaire
RENAME TABLE temp_produits TO produits;

-- Réactiver les contraintes de clé étrangère
SET FOREIGN_KEY_CHECKS=1;

SET @count = 0;
UPDATE produits SET id = @count:= @count + 1 ORDER BY id; 