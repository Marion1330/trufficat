<?php

namespace App\Models;

use CodeIgniter\Model;

class PanierProduitModel extends Model
{
    protected $table = 'panier_produits';
    protected $primaryKey = 'id';
    protected $allowedFields = ['panier_id', 'produit_id', 'quantite', 'prix_unitaire'];
    protected $useTimestamps = false;
    protected $createdField = 'date_ajout';
    
    public function getProduitsPanier($panierId)
    {
        return $this->select('panier_produits.*, produits.nom, produits.image')
                    ->join('produits', 'produits.id = panier_produits.produit_id')
                    ->where('panier_id', $panierId)
                    ->findAll();
    }
    
    public function ajouterProduit($panierId, $produitId, $quantite = 1, $prix)
    {
        // S'assurer que la quantité est au moins 1
        $quantite = max(1, intval($quantite));

        $existant = $this->where([
            'panier_id' => $panierId,
            'produit_id' => $produitId
        ])->first();
        
        if ($existant) {
            return $this->update($existant['id'], [
                'quantite' => $quantite
            ]);
        }
        
        return $this->insert([
            'panier_id' => $panierId,
            'produit_id' => $produitId,
            'quantite' => $quantite,
            'prix_unitaire' => $prix
        ]);
    }
    
    public function modifierQuantite($panierId, $produitId, $quantite)
    {
        return $this->where([
            'panier_id' => $panierId,
            'produit_id' => $produitId
        ])->set(['quantite' => $quantite])->update();
    }
    
    public function supprimerProduit($panierId, $produitId)
    {
        return $this->where([
            'panier_id' => $panierId,
            'produit_id' => $produitId
        ])->delete();
    }
    
    public function viderPanier($panierId)
    {
        return $this->where('panier_id', $panierId)->delete();
    }
}
