<?php

namespace App\Controllers;

use App\Models\PanierModel;
use App\Models\PanierProduitModel;
use App\Models\ProduitModel;

class Panier extends BaseController
{
    protected $panierModel;
    protected $panierProduitModel;
    protected $produitModel;
    protected $session;

    public function __construct()
    {
        $this->panierModel = new PanierModel();
        $this->panierProduitModel = new PanierProduitModel();
        $this->produitModel = new ProduitModel();
        $this->session = session();
    }

    public function index()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/connexion')->with('error', 'Veuillez vous connecter pour accéder à votre panier');
        }

        $userId = $this->session->get('user_id');
        $panier = $this->panierModel->getPanierActif($userId);
        
        if (!$panier) {
            return view('panier/index', [
                'produits' => []
            ]);
        }

        $produits = $this->panierProduitModel->getProduitsPanier($panier['id']);
        $total = array_reduce($produits, function($carry, $item) {
            return $carry + ($item['prix_unitaire'] * $item['quantite']);
        }, 0);

        return view('panier/index', [
            'produits' => $produits,
            'total' => $total
        ]);
    }

    public function ajouter()
    {
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Veuillez vous connecter pour ajouter des produits au panier'
            ]);
        }

        $userId = $this->session->get('user_id');
        $produitId = $this->request->getPost('produit_id');
        $quantite = $this->request->getPost('quantite') ?? 1;
        
        // Protection contre les requêtes multiples
        $requestKey = "panier_add_{$userId}_{$produitId}_{$quantite}";
        $lastRequest = $this->session->get($requestKey);
        $currentTime = time();
        
        // Si la même requête a été faite il y a moins de 2 secondes, l'ignorer
        if ($lastRequest && ($currentTime - $lastRequest) < 2) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Produit déjà ajouté au panier'
            ]);
        }
        
        // Enregistrer le timestamp de cette requête
        $this->session->set($requestKey, $currentTime);
        
        if (!$produitId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID du produit manquant'
            ]);
        }
        
        $produit = $this->produitModel->find($produitId);
        if (!$produit) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Produit non trouvé'
            ]);
        }

        $panier = $this->panierModel->getPanierActif($userId);
        if (!$panier) {
            $panierId = $this->panierModel->creerPanier($userId);
            $panier = ['id' => $panierId];
        }

        try {
            $result = $this->panierProduitModel->ajouterProduit(
                $panier['id'],
                $produitId,
                $quantite,
                $produit['prix']
            );
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Produit ajouté au panier'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Erreur lors de l\'ajout au panier: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'ajout au panier. Veuillez réessayer.'
            ]);
        }
    }

    public function modifier($id)
    {
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non connecté']);
        }

        $userId = $this->session->get('user_id');
        $quantite = $this->request->getPost('quantite');
        
        if (!$quantite || $quantite < 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Quantité invalide']);
        }
        
        $panier = $this->panierModel->getPanierActif($userId);
        if (!$panier) {
            return $this->response->setJSON(['success' => false, 'message' => 'Panier non trouvé']);
        }

        try {
            $this->panierProduitModel->modifierQuantite($panier['id'], $id, $quantite);
            
            // Récupérer les nouvelles données du panier
            $produits = $this->panierProduitModel->getProduitsPanier($panier['id']);
            $total = array_reduce($produits, function($carry, $item) {
                return $carry + ($item['prix_unitaire'] * $item['quantite']);
            }, 0);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Quantité mise à jour',
                'total' => $total,
                'produits' => $produits
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Erreur lors de la modification de la quantité: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de la quantité'
            ]);
        }
    }

    public function supprimer($id)
    {
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Non connecté'
            ]);
        }

        $userId = $this->session->get('user_id');
        $panier = $this->panierModel->getPanierActif($userId);
        
        if (!$panier) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Panier non trouvé'
            ]);
        }

        try {
            // Supprimer le produit
            $this->panierProduitModel->supprimerProduit($panier['id'], $id);
            
            // Récupérer les nouvelles données du panier
            $produits = $this->panierProduitModel->getProduitsPanier($panier['id']);
            $total = array_reduce($produits, function($carry, $item) {
                return $carry + ($item['prix_unitaire'] * $item['quantite']);
            }, 0);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Produit supprimé du panier',
                'total' => $total,
                'produits' => $produits
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Erreur lors de la suppression du produit: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la suppression du produit'
            ]);
        }
    }

    public function vider()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/panier');
        }

        $userId = $this->session->get('user_id');
        $panier = $this->panierModel->getPanierActif($userId);
        
        if ($panier) {
            $this->panierProduitModel->viderPanier($panier['id']);
        }

        return redirect()->to('/panier')->with('message', 'Votre panier a été vidé');
    }
} 