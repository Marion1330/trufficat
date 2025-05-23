<?php

namespace App\Models;

use CodeIgniter\Model;

class ProduitModel extends Model
{
    protected $table = 'produits';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nom', 
        'description', 
        'animal', 
        'categorie', 
        'image', 
        'prix', 
        'stock',
        'is_vedette',
        'age',
        'saveur',
        'sterilise',
        'marque',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Récupère les produits vedettes
    public function getProduitsVedettes()
    {
        return $this->where('is_vedette', 1)
                    ->findAll();
    }

    // Récupère tous les produits
    public function getProduits()
    {
        return $this->findAll();
    }
    
    // Récupère les produits par catégorie
    public function getProduitsByCategorie($animal, $categorie = null)
    {
        $query = $this->where('animal', $animal);
        
        if ($categorie) {
            $query = $query->where('categorie', $categorie);
        }
        
        return $query->findAll();
    }
    
    // Récupère les marques disponibles
    public function getMarques($animal = null)
    {
        $builder = $this->builder();
        $builder->select('marque');
        $builder->distinct();
        
        if ($animal) {
            $builder->where('animal', $animal);
        }
        
        $query = $builder->get();
        return $query->getResultArray();
    }
    
    // Récupère les âges disponibles
    public function getAges($animal = null)
    {
        $builder = $this->builder();
        $builder->select('age');
        $builder->distinct();
        
        if ($animal) {
            $builder->where('animal', $animal);
        }
        
        $query = $builder->get();
        return $query->getResultArray();
    }
    
    // Récupère les saveurs disponibles
    public function getSaveurs($animal = null)
    {
        $builder = $this->builder();
        $builder->select('saveur');
        $builder->distinct();
        
        if ($animal) {
            $builder->where('animal', $animal);
        }
        
        $query = $builder->get();
        return $query->getResultArray();
    }
    
    // Récupère un produit par son ID
    public function getProduit($id)
    {
        return $this->find($id);
    }
}
