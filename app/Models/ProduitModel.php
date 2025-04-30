<?php

namespace App\Models;

use CodeIgniter\Model;

class ProduitModel extends Model
{
    protected $table = 'produits';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'description', 'animal', 'image'];

    public function getByAnimal($type)
    {
        return $this->where('animal', $type)->findAll();
    }

    // Ajouter un produit
public function ajouter($data)
{
    return $this->insert($data);
}

// Modifier un produit
public function modifier($id, $data)
{
    return $this->update($id, $data);
}

// Supprimer un produit
public function supprimer($id)
{
    return $this->delete($id);
}

}
