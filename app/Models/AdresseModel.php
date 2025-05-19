<?php

namespace App\Models;

use CodeIgniter\Model;

class AdresseModel extends Model
{
    protected $table = 'adresses';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'nom', 'prenom', 'titre', 'adresse', 'complement', 'code_postal',
        'ville', 'departement', 'pays', 'telephone', 'is_principale'
    ];
}
