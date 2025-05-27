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
    
    public function getProduitsAvecDetails($panierId)
    {
        return $this->select('panier_produits.*, produits.nom, produits.image, produits.marque, panier_produits.prix_unitaire as prix')
                    ->join('produits', 'produits.id = panier_produits.produit_id')
                    ->where('panier_id', $panierId)
                    ->findAll();
    }
    
    public function ajouterProduit($panierId, $produitId, $quantite = 1, $prix)
    {
        // Conversion simple en entier
        $quantite = intval($quantite);
        if ($quantite < 1) {
            $quantite = 1;
        }

        $existant = $this->where([
            'panier_id' => $panierId,
            'produit_id' => $produitId
        ])->first();
        
        if ($existant) {
            // Additionner la nouvelle quantité à l'existante
            $nouvelleQuantite = $existant['quantite'] + $quantite;
            return $this->update($existant['id'], [
                'quantite' => $nouvelleQuantite
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
