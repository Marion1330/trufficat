<?php

namespace App\Models;

use CodeIgniter\Model;

class PubModel extends Model
{
    // Nom de la table dans la base de données
    protected $table = 'publicites';
    
    // Les champs de la table
    protected $primaryKey = 'id';
    protected $allowedFields = ['titre', 'description', 'image', 'alt_text'];

    // Récupérer toutes les publicités avec leurs URLs générées
    public function getPublicites()
    {
        $publicites = $this->findAll();
        
        // Ajouter l'URL générée pour chaque publicité
        foreach ($publicites as &$pub) {
            $pub['url'] = $this->generateUrlFromImage($pub['image']);
        }
        
        return $publicites;
    }
    
    // Générer l'URL basée sur le nom de l'image
    private function generateUrlFromImage($imageName)
    {
        $baseUrl = base_url();
        
        switch ($imageName) {
            case 'pub1.png':
                return $baseUrl . 'produits/categorie/chien/accessoires-voyage';
            case 'pub2.png':
                return $baseUrl . 'produits/categorie/chien/antiparasitaires';
            case 'pub3.png':
                return $baseUrl . 'produits/categorie/chat/friandises';
            case 'pub4.png':
                return $baseUrl . 'produits/categorie/chien/couchage';
            default:
                return '#'; // URL par défaut si l'image n'est pas reconnue
        }
    }
}
