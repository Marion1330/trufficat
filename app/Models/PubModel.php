<?php

namespace App\Models;

use CodeIgniter\Model;

class PubModel extends Model
{
    // Nom de la table dans la base de données
    protected $table = 'publicites';
    
    // Les champs de la table
    protected $primaryKey = 'id';
    protected $allowedFields = ['titre', 'description', 'image', 'lien'];

    // Récupérer toutes les publicités
    public function getPublicites()
    {
        return $this->findAll();
    }
}
