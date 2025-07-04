<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modele PanierProduitModel pour la gestion des produits dans le panier
 * - Gere l'ajout, modification et suppression de produits dans le panier
 * - Joint les donnees produits pour affichage complet
 * - Controle les quantites et prix unitaires
 * - Permet le vidage complet du panier
 */
class PanierProduitModel extends Model
{
    protected $table = 'panier_produits';
    protected $primaryKey = 'id';
    protected $allowedFields = ['panier_id', 'produit_id', 'quantite', 'prix_unitaire'];
    protected $useTimestamps = false;
    protected $createdField = 'date_ajout';
    
    /**
     * Recupere tous les produits d'un panier avec leurs informations
     * - Joint la table produits pour obtenir nom et image
     * - Retourne les donnees completees pour affichage
     */
    public function getProduitsPanier($panierId)
    {
        return $this->select('panier_produits.*, produits.nom, produits.image')
                    ->join('produits', 'produits.id = panier_produits.produit_id')
                    ->where('panier_id', $panierId)
                    ->findAll();
    }
    
    /**
     * Recupere les produits avec details complets incluant marque
     * - Utilise pour les operations de commande et facturation
     * - Inclut tous les champs necessaires pour le traitement
     */
    public function getProduitsAvecDetails($panierId)
    {
        return $this->select('panier_produits.*, produits.nom, produits.image, produits.marque, panier_produits.prix_unitaire as prix')
                    ->join('produits', 'produits.id = panier_produits.produit_id')
                    ->where('panier_id', $panierId)
                    ->findAll();
    }
    
    /**
     * Ajoute un produit au panier ou met a jour la quantite
     * - Verifie si le produit existe deja dans le panier
     * - Additionne les quantites si produit deja present
     * - Cree une nouvelle entree si produit inexistant
     * - Controle la validite des quantites (minimum 1)
     */
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
    
    /**
     * Modifie la quantite d'un produit dans le panier
     * - Met a jour uniquement la quantite sans toucher au prix
     * - Utilise pour les controles de quantite dans l'interface
     */
    public function modifierQuantite($panierId, $produitId, $quantite)
    {
        return $this->where([
            'panier_id' => $panierId,
            'produit_id' => $produitId
        ])->set(['quantite' => $quantite])->update();
    }
    
    /**
     * Supprime un produit specifique du panier
     * - Supprime l'entree correspondante dans panier_produits
     * - Utilise pour la suppression individuelle de produits
     * - Retourne le nombre de lignes supprimees
     */
    public function supprimerProduit($panierId, $produitId)
    {
        return $this->where([
            'panier_id' => $panierId,
            'produit_id' => $produitId
        ])->delete();
    }
    
    /**
     * Vide completement un panier
     * - Supprime tous les produits d'un panier donne
     * - Utilise pour le vidage manuel ou apres commande
     * - Retourne le nombre de lignes supprimees
     */
    public function viderPanier($panierId)
    {
        return $this->where('panier_id', $panierId)->delete();
    }
}
