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
            log_message('error', 'Tentative d\'ajout au panier sans connexion');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Veuillez vous connecter pour ajouter des produits au panier'
            ]);
        }

        $userId = $this->session->get('user_id');
        $produitId = $this->request->getPost('produit_id');
        $quantite = $this->request->getPost('quantite') ?? 1;
        
        log_message('debug', "Tentative d'ajout au panier - User ID: {$userId}, Produit ID: {$produitId}, Quantité: {$quantite}");
        
        if (!$produitId) {
            log_message('error', 'Tentative d\'ajout au panier sans ID produit');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID du produit manquant'
            ]);
        }
        
        $produit = $this->produitModel->find($produitId);
        if (!$produit) {
            log_message('error', "Produit non trouvé - ID: {$produitId}");
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Produit non trouvé'
            ]);
        }

        log_message('debug', "Produit trouvé - Prix: {$produit['prix']}");

        $panier = $this->panierModel->getPanierActif($userId);
        if (!$panier) {
            log_message('debug', "Création d'un nouveau panier pour l'utilisateur {$userId}");
            $panierId = $this->panierModel->creerPanier($userId);
            $panier = ['id' => $panierId];
        }

        log_message('debug', "Panier ID: {$panier['id']}");

        try {
            $result = $this->panierProduitModel->ajouterProduit(
                $panier['id'],
                $produitId,
                $quantite,
                $produit['prix']
            );
            
            log_message('debug', "Résultat de l'ajout: " . json_encode($result));
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Produit ajouté au panier'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Erreur lors de l\'ajout au panier: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            log_message('error', 'User ID: ' . $userId . ', Produit ID: ' . $produitId . ', Panier ID: ' . $panier['id']);
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'ajout au panier. Veuillez réessayer.'
            ]);
        }
    }

    public function modifier($id)
    {
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false]);
        }

        $userId = $this->session->get('user_id');
        $quantite = $this->request->getPost('quantite');
        
        $panier = $this->panierModel->getPanierActif($userId);
        if (!$panier) {
            return $this->response->setJSON(['success' => false]);
        }

        $this->panierProduitModel->modifierQuantite($panier['id'], $id, $quantite);
        return $this->response->setJSON(['success' => true]);
    }

    public function supprimer($id)
    {
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false]);
        }

        $userId = $this->session->get('user_id');
        $panier = $this->panierModel->getPanierActif($userId);
        
        if (!$panier) {
            return $this->response->setJSON(['success' => false]);
        }

        $this->panierProduitModel->supprimerProduit($panier['id'], $id);
        return $this->response->setJSON(['success' => true]);
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