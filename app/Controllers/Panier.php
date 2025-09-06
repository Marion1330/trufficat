<?php

namespace App\Controllers;

use App\Models\PanierModel;
use App\Models\PanierProduitModel;
use App\Models\ProduitModel;

/**
 * Controleur Panier pour la gestion complete du panier d'achat
 * - Gere l'ajout, modification et suppression de produits
 * - Calcule automatiquement les totaux du panier
 * - Protege contre les requetes multiples et les doublons
 * - Assure la securite des operations via authentification
 * - Gere les interactions AJAX pour une experience utilisateur fluide
 */
class Panier extends BaseController
{
    /**
     * Proprietes pour les modeles de donnees et la session
     * - Instanciation des modeles necessaires pour la gestion du panier
     * - Acces a la session pour la securite et les donnees utilisateur
     */
    protected $panierModel;
    protected $panierProduitModel;
    protected $produitModel;
    protected $session;

    /**
     * Constructeur du controleur Panier
     * - Initialise tous les modeles necessaires
     * - Prepare l'acces a la session utilisateur
     * - Assure la disponibilite des modeles dans toutes les methodes
     */
    public function __construct()
    {
        $this->panierModel = new PanierModel();
        $this->panierProduitModel = new PanierProduitModel();
        $this->produitModel = new ProduitModel();
        $this->session = session();
    }

    /**
     * Affichage de la page principale du panier
     * - Verifie l'authentification utilisateur obligatoire
     * - Recupere le panier actif de l'utilisateur
     * - Calcule le total des produits dans le panier
     * - Affiche la liste des produits avec leurs details
     * - Gere le cas d'un panier vide avec message approprié
     */
    public function index()
    {
        // Verification de l'authentification utilisateur
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/connexion')->with('error', 'Veuillez vous connecter pour accéder à votre panier');
        }

        // Recuperation de l'ID utilisateur et du panier actif
        $userId = $this->session->get('user_id');
        $panier = $this->panierModel->getPanierActif($userId);
        
        // Gestion du cas d'un panier inexistant
        if (!$panier) {
            return view('panier/index', [
                'produits' => []
            ]);
        }

        // Recuperation des produits du panier et calcul du total
        $produits = $this->panierProduitModel->getProduitsPanier($panier['id']);
        $total = array_reduce($produits, function($carry, $item) {
            return $carry + ($item['prix_unitaire'] * $item['quantite']);
        }, 0);

        // Affichage de la page du panier avec les donnees
        return view('panier/index', [
            'produits' => $produits,
            'total' => $total
        ]);
    }

    /**
     * Ajout d'un produit au panier via requete AJAX
     * - Verifie l'authentification utilisateur obligatoire
     * - Protege contre les requetes multiples (anti-doublon)
     * - Valide l'existence du produit en base
     * - Cree automatiquement un panier si necessaire
     * - Ajoute le produit avec la quantite specifiee
     * - Retourne une reponse JSON pour l'interface
     * - Gere les erreurs avec logging et messages explicites
     */
    public function ajouter()
    {
        // Verification de l'authentification utilisateur
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Veuillez vous connecter pour ajouter des produits au panier'
            ]);
        }

        // Recuperation des donnees de la requete
        $userId = $this->session->get('user_id');
        $produitId = $this->request->getPost('produit_id');
        $quantite = $this->request->getPost('quantite') ?? 1;
        
        // Protection contre les requêtes multiples
        // Cree une cle unique pour cette requete specifique
        $requestKey = "panier_add_{$userId}_{$produitId}_{$quantite}";
        $lastRequest = $this->session->get($requestKey);
        $currentTime = time();
        
        // Si la même requête a été faite il y a moins de 2 secondes, l'ignorer
        // Cette protection evite les doublons lors de clics multiples
        if ($lastRequest && ($currentTime - $lastRequest) < 2) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Produit déjà ajouté au panier'
            ]);
        }
        
        // Enregistrer le timestamp de cette requête pour la protection anti-doublon
        $this->session->set($requestKey, $currentTime);
        
        // Validation de l'ID du produit
        if (!$produitId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID du produit manquant'
            ]);
        }
        
        // Verification de l'existence du produit en base
        $produit = $this->produitModel->find($produitId);
        if (!$produit) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Produit non trouvé'
            ]);
        }

        // Recuperation ou creation du panier actif
        $panier = $this->panierModel->getPanierActif($userId);
        if (!$panier) {
            // Creation automatique d'un nouveau panier si necessaire
            $panierId = $this->panierModel->creerPanier($userId);
            $panier = ['id' => $panierId];
        }

        // Ajout du produit au panier avec gestion d'erreurs
        try {
            $result = $this->panierProduitModel->ajouterProduit(
                $panier['id'],
                $produitId,
                $quantite,
                $produit['prix']
            );
            
            // Retour de la reponse de succes
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Produit ajouté au panier'
            ]);
        } catch (\Exception $e) {
            // Logging de l'erreur pour le debugging
            log_message('error', 'Erreur lors de l\'ajout au panier: ' . $e->getMessage());
            
            // Retour de la reponse d'erreur
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'ajout au panier. Veuillez réessayer.'
            ]);
        }
    }

    /**
     * Modification de la quantite d'un produit dans le panier
     * - Verifie l'authentification utilisateur obligatoire
     * - Valide la quantite (doit etre superieure a 0)
     * - Met a jour la quantite du produit specifique
     * - Recalcule le total du panier apres modification
     * - Retourne les nouvelles donnees du panier en JSON
     * - Gere les erreurs avec messages explicites
     */
    public function modifier($id)
    {
        // Verification de l'authentification utilisateur
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non connecté']);
        }

        // Recuperation des donnees de la requete
        $userId = $this->session->get('user_id');
        $quantite = $this->request->getPost('quantite');
        
        // Validation de la quantite (doit etre positive)
        if (!$quantite || $quantite < 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Quantité invalide']);
        }
        
        // Recuperation du panier actif
        $panier = $this->panierModel->getPanierActif($userId);
        if (!$panier) {
            return $this->response->setJSON(['success' => false, 'message' => 'Panier non trouvé']);
        }

        // Modification de la quantite avec gestion d'erreurs
        try {
            // Mise a jour de la quantite du produit
            $this->panierProduitModel->modifierQuantite($panier['id'], $id, $quantite);
            
            // Récupération des nouvelles données du panier pour mise a jour de l'interface
            $produits = $this->panierProduitModel->getProduitsPanier($panier['id']);
            $total = array_reduce($produits, function($carry, $item) {
                return $carry + ($item['prix_unitaire'] * $item['quantite']);
            }, 0);

            // Retour des nouvelles donnees du panier
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Quantité mise à jour',
                'total' => $total,
                'produits' => $produits
            ]);
        } catch (\Exception $e) {
            // Logging de l'erreur pour le debugging
            log_message('error', 'Erreur lors de la modification de la quantité: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de la quantité'
            ]);
        }
    }

    /**
     * Supprime un produit du panier via requete AJAX
     * - Verifie l'authentification utilisateur obligatoire
     * - Recupere le panier actif de l'utilisateur
     * - Supprime le produit specifique du panier
     * - Recalcule le total du panier apres suppression
     * - Retourne les nouvelles donnees du panier en JSON
     * - Gere les erreurs avec messages explicites
     */
    public function supprimer($id)
    {
        // Verification de l'authentification utilisateur
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Non connecté'
            ]);
        }

        // Recuperation du panier actif
        $userId = $this->session->get('user_id');
        $panier = $this->panierModel->getPanierActif($userId);
        
        // Verification de l'existence du panier
        if (!$panier) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Panier non trouvé'
            ]);
        }

        // Suppression du produit avec gestion d'erreurs
        try {
            // Supprimer le produit du panier
            // Cette operation supprime l'entree correspondante dans panier_produits
            $this->panierProduitModel->supprimerProduit($panier['id'], $id);
            
            // Récupération des nouvelles données du panier après suppression
            // Pour mettre à jour les totaux et verifier l'etat du panier
            $produits = $this->panierProduitModel->getProduitsPanier($panier['id']);
            $total = array_reduce($produits, function($carry, $item) {
                return $carry + ($item['prix_unitaire'] * $item['quantite']);
            }, 0);

            // Retour des nouvelles donnees du panier
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Produit supprimé du panier',
                'total' => $total,
                'produits' => $produits
            ]);
        } catch (\Exception $e) {
            // Logging de l'erreur pour le debugging
            log_message('error', 'Erreur lors de la suppression du produit: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la suppression du produit'
            ]);
        }
    }

    /**
     * Vide completement le panier de l'utilisateur
     * - Verifie l'authentification utilisateur
     * - Supprime tous les produits du panier actif
     * - Redirige vers la page du panier avec message de confirmation
     * - Gere le cas d'un panier deja vide
     */
    public function vider()
    {
        // Verification de l'authentification utilisateur
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/panier');
        }

        // Recuperation et vidage du panier actif
        $userId = $this->session->get('user_id');
        $panier = $this->panierModel->getPanierActif($userId);
        
        // Suppression de tous les produits si le panier existe
        if ($panier) {
            $this->panierProduitModel->viderPanier($panier['id']);
        }

        // Redirection vers la page du panier avec message de confirmation
        return redirect()->to('/panier')->with('message', 'Votre panier a été vidé');
    }
} 