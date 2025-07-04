<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modele AdresseModel pour la gestion des adresses multiples utilisateur
 * - Permet a chaque utilisateur d'avoir plusieurs adresses
 * - Gere le systeme d'adresse par defaut (is_defaut = 1)
 * - Stocke nom/prenom specifiques pour chaque adresse
 * - Utilise pour livraisons, facturation et gestion des commandes
 */
class AdresseModel extends Model
{
    protected $table = 'adresses';
    protected $primaryKey = 'id';
    
    // Champs autorises pour la gestion complete des adresses
    // Inclut la liaison utilisateur et le marquage adresse par defaut
    protected $allowedFields = [
        'user_id', 'nom', 'prenom', 'titre', 'adresse', 'complement', 'code_postal',
        'ville', 'departement', 'pays', 'telephone', 'is_defaut'
    ];
}
