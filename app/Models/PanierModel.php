<?php

namespace App\Models;

use CodeIgniter\Model;

class PanierModel extends Model
{
    protected $table = 'paniers';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function getPanierActif($userId)
    {
        return $this->where([
            'user_id' => $userId,
            'status' => 'actif'
        ])->first();
    }
    
    public function creerPanier($userId)
    {
        $data = [
            'user_id' => $userId,
            'status' => 'actif'
        ];
        
        $this->insert($data);
        return $this->insertID;
    }
}
