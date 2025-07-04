<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modele UserModel pour la gestion des utilisateurs
 * - Gere tous les types d'utilisateurs : admin, client, visiteur
 * - Applique automatiquement le hachage securise des mots de passe
 * - Traite les 4 champs distincts : nomcompte/prenomcompte et nom/prenom
 * - Integre toutes les informations d'adresse dans le profil utilisateur
 */
class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    // Champs autorises pour les operations CRUD
    // Inclut les identifiants de connexion et informations personnelles
    protected $allowedFields = [
        'email', 'password', 'role', 'nomcompte', 'prenomcompte',
        'nom', 'prenom',
        'adresse', 'complement', 'code_postal', 'ville',
        'departement', 'pays', 'telephone'
    ];

    protected $useTimestamps = false;

    // Declencheurs automatiques pour le hachage securise des mots de passe
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     * Hache automatiquement le mot de passe avant insertion ou mise a jour
     * - Detecte si le mot de passe est deja hache (bcrypt)
     * - Applique le hachage seulement sur les mots de passe en clair
     * - Utilise PASSWORD_DEFAULT pour la securite optimale
     * - Evite le double hachage lors des modifications
     */
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

