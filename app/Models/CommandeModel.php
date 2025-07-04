<?php

namespace App\Models;

use CodeIgniter\Model;

class CommandeModel extends Model
{
    protected $table = 'commandes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id',
        'adresse_livraison_id',
        'total',
        'statut',
        'numero_commande',
        'adresse_livraison',
        'paypal_payment_id',
        'paypal_payer_id',
        'date_paiement'
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'date_commande';
    protected $updatedField = 'date_modification';

    public function getCommandesWithUser()
    {
        return $this->select('commandes.*, users.email, users.nom, users.prenom')
                    ->join('users', 'users.id = commandes.user_id')
                    ->orderBy('commandes.date_commande', 'DESC')
                    ->findAll();
    }

    public function getCommandeWithDetails($id)
    {
        $commande = $this->select('commandes.*, users.email, users.nom, users.prenom, users.adresse, users.code_postal, users.ville, users.departement, users.pays')
                         ->join('users', 'users.id = commandes.user_id')
                         ->find($id);

        if ($commande) {
            $commandeDetailModel = new \App\Models\CommandeDetailModel();
            $commande['produits'] = $commandeDetailModel->getProduitsCommande($id);
        }

        return $commande;
    }

    public function genererNumeroCommande()
    {
        return 'CMD-' . date('Y') . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    public function updateStatut($id, $statut, $datePaiement = null)
    {
        $data = ['statut' => $statut];
        
        if ($datePaiement) {
            $data['date_paiement'] = $datePaiement;
        }
        
        // Mettre à jour manuellement la date de modification
        $data['date_modification'] = date('Y-m-d H:i:s');
        
        return $this->update($id, $data);
    }
} 