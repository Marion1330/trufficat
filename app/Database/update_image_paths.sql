UPDATE produits 
SET image = CONCAT('images/produits/', image)
WHERE image IS NOT NULL 
AND image != ''
AND image NOT LIKE 'images/produits/%'; 