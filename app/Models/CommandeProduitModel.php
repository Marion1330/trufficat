<?php

namespace App\Models;

use CodeIgniter\Model;

class CommandeProduitModel extends Model
{
    protected $table = 'commande_produits';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'commande_id',
        'produit_id',
        'quantite',
        'prix_unitaire',
        'total_ligne'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getProduitsCommande($commandeId)
    {
        return $this->select('commande_produits.*, produits.nom, produits.image, produits.marque')
                    ->join('produits', 'produits.id = commande_produits.produit_id')
                    ->where('commande_id', $commandeId)
                    ->findAll();
    }
} 