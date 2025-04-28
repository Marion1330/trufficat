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
}
