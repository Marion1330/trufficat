<?php

namespace App\Models;

use CodeIgniter\Model;

class ProduitModel extends Model
{
    protected $table = 'produits';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'description', 'image', 'animal', 'is_vedette'];

    // Récupère les produits vedettes
    public function getProduitsVedettes()
    {
        return $this->where('is_vedette', 1) // Filtre les produits vedettes
                    ->findAll();
    }

    // Récupère tous les produits
    public function getProduits()
    {
        return $this->findAll();
    }
}
