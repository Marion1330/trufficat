<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'email', 'password', 'role', 'nom', 'prenom',
        'adresse', 'complement', 'code_postal', 'ville',
        'departement', // ← ajoute cette ligne
        'pays', 'telephone'
    ];

    protected $useTimestamps = false;

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    // Fonction pour hacher le mot de passe avant insertion
    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }

        // Ne re-hache que si ce n'est pas déjà un hash bcrypt
        if (strlen($data['data']['password']) < 60 || !preg_match('/^\$2y\$/', $data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }

}
