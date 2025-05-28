<?php

namespace App\Controllers;

use App\Models\CommandeModel;
use App\Models\CommandeDetailModel;
use App\Models\PanierModel;
use App\Models\PanierProduitModel;
use App\Models\ProduitModel;

class Commande extends BaseController
{
    protected $commandeModel;
    protected $commandeDetailModel;
    protected $panierModel;
    protected $panierProduitModel;
    protected $produitModel;

    public function __construct()
    {
        $this->commandeModel = new CommandeModel();
        $this->commandeDetailModel = new CommandeDetailModel();
        $this->panierModel = new PanierModel();
        $this->panierProduitModel = new PanierProduitModel();
        $this->produitModel = new ProduitModel();
    }

    public function index()
    {
        // Rediriger directement vers le checkout pour passer commande
        return redirect()->to('/commande/checkout');
    }

    public function historique()
    {
        if (!session('user_id')) {
            return redirect()->to('/connexion')->with('error', 'Vous devez être connecté pour voir vos commandes');
        }

        // Récupérer les commandes de l'utilisateur
        $commandes = $this->commandeModel->where('user_id', session('user_id'))
                                        ->orderBy('date_commande', 'DESC')
                                        ->findAll();

        // Ajouter les détails des produits pour chaque commande
        foreach ($commandes as &$commande) {
            $commande['produits'] = $this->commandeDetailModel->getProduitsCommande($commande['id']);
        }

        $data['commandes'] = $commandes;
        return view('commande/historique', $data);
    }

    public function checkout()
    {
        if (!session('user_id')) {
            return redirect()->to('/connexion')->with('error', 'Vous devez être connecté pour passer commande');
        }

        // Récupérer le panier de l'utilisateur
        $panier = $this->panierModel->where('user_id', session('user_id'))->first();
        if (!$panier) {
            return redirect()->to('/panier')->with('error', 'Votre panier est vide');
        }

        $produitsPanier = $this->panierProduitModel->getProduitsAvecDetails($panier['id']);
        if (empty($produitsPanier)) {
            return redirect()->to('/panier')->with('error', 'Votre panier est vide');
        }

        // Calculer le total
        $total = 0;
        foreach ($produitsPanier as $produit) {
            $total += $produit['prix'] * $produit['quantite'];
        }

        // Charger la configuration PayPal
        $paypalConfig = new \App\Config\PayPal();

        $data = [
            'produits' => $produitsPanier,
            'total' => $total,
            'paypal_client_id' => $paypalConfig->clientId
        ];

        return view('commande/checkout', $data);
    }

    public function creerCommande()
    {
        if (!session('user_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non connecté']);
        }

        try {
            // Récupérer le panier
            $panier = $this->panierModel->where('user_id', session('user_id'))->first();
            if (!$panier) {
                return $this->response->setJSON(['success' => false, 'message' => 'Panier vide']);
            }

            $produitsPanier = $this->panierProduitModel->getProduitsAvecDetails($panier['id']);
            if (empty($produitsPanier)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Panier vide']);
            }

            // Calculer le total
            $total = 0;
            foreach ($produitsPanier as $produit) {
                $total += $produit['prix'] * $produit['quantite'];
            }

            // Récupérer ou créer l'adresse de livraison
            $adresseLivraisonId = $this->getOrCreateAdresseLivraison();
            
            if (!$adresseLivraisonId) {
                return $this->response->setJSON(['success' => false, 'message' => 'Impossible de créer l\'adresse de livraison']);
            }

            // Créer la commande avec la structure existante
            $numeroCommande = $this->commandeModel->genererNumeroCommande();
            
            $commandeData = [
                'user_id' => session('user_id'),
                'numero_commande' => $numeroCommande,
                'statut' => 'en_attente',
                'total' => $total,
                'adresse_livraison' => $this->getAdresseLivraison(),
                'adresse_livraison_id' => $adresseLivraisonId
            ];

            $commandeId = $this->commandeModel->insert($commandeData);

            if ($commandeId) {
                // Ajouter les produits à la commande
                foreach ($produitsPanier as $produit) {
                    $this->commandeDetailModel->insert([
                        'commande_id' => $commandeId,
                        'produit_id' => $produit['produit_id'],
                        'quantite' => $produit['quantite'],
                        'prix_unitaire' => $produit['prix'],
                        'total_ligne' => $produit['prix'] * $produit['quantite']
                    ]);
                }

                return $this->response->setJSON([
                    'success' => true,
                    'commande_id' => $commandeId,
                    'total' => $total
                ]);
            }

            return $this->response->setJSON(['success' => false, 'message' => 'Erreur lors de la création de la commande']);
            
        } catch (\Exception $e) {
            log_message('error', 'Erreur lors de la création de la commande: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Erreur lors de la création de la commande: ' . $e->getMessage()]);
        }
    }

    public function paypalSuccess()
    {
        $paymentId = $this->request->getGet('paymentId');
        $payerId = $this->request->getGet('PayerID');
        $commandeId = $this->request->getGet('commande_id');

        if ($paymentId && $payerId && $commandeId) {
            // Mettre à jour la commande avec les informations PayPal
            $this->commandeModel->update($commandeId, [
                'statut' => 'validee',
                'paypal_payment_id' => $paymentId,
                'paypal_payer_id' => $payerId,
                'date_paiement' => date('Y-m-d H:i:s')
            ]);

            // Vider le panier
            $panier = $this->panierModel->where('user_id', session('user_id'))->first();
            if ($panier) {
                $this->panierProduitModel->where('panier_id', $panier['id'])->delete();
            }

            // Mettre à jour les stocks
            $this->updateStocks($commandeId);

            return redirect()->to('/commande/confirmation/' . $commandeId)
                           ->with('success', 'Paiement effectué avec succès !');
        }

        return redirect()->to('/panier')->with('error', 'Erreur lors du paiement');
    }

    public function paypalCancel()
    {
        return redirect()->to('/panier')->with('error', 'Paiement annulé');
    }

    public function confirmation($commandeId)
    {
        if (!session('user_id')) {
            return redirect()->to('/connexion');
        }

        $commande = $this->commandeModel->getCommandeWithDetails($commandeId);
        
        if (!$commande) {
            return redirect()->to('/')->with('error', 'Commande non trouvée');
        }
        
        // Vérifier que l'utilisateur est propriétaire de la commande OU est administrateur
        if ($commande['user_id'] != session('user_id') && session('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé');
        }

        // Extraire les produits pour les passer séparément à la vue
        $produits = $commande['produits'] ?? [];

        return view('commande/confirmation', [
            'commande' => $commande,
            'produits' => $produits
        ]);
    }

    private function getAdresseLivraison()
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find(session('user_id'));
        
        return $user['adresse'] . ', ' . $user['code_postal'] . ' ' . $user['ville'];
    }

    private function getOrCreateAdresseLivraison()
    {
        $adresseModel = new \App\Models\AdresseModel();
        $userModel = new \App\Models\UserModel();
        
        // Chercher l'adresse principale de l'utilisateur
        $adressePrincipale = $adresseModel->where('user_id', session('user_id'))
                                         ->where('is_principale', 1)
                                         ->first();
        
        if ($adressePrincipale) {
            return $adressePrincipale['id'];
        }
        
        // Si pas d'adresse principale, chercher la première adresse de l'utilisateur
        $premiereAdresse = $adresseModel->where('user_id', session('user_id'))->first();
        
        if ($premiereAdresse) {
            return $premiereAdresse['id'];
        }
        
        // Si aucune adresse, créer une adresse par défaut basée sur les infos utilisateur
        $user = $userModel->find(session('user_id'));
        
        if ($user && !empty($user['adresse']) && !empty($user['code_postal']) && !empty($user['ville'])) {
            $nouvelleAdresse = [
                'user_id' => session('user_id'),
                'nom' => $user['nom'] ?: $user['nomcompte'],
                'prenom' => $user['prenom'] ?: $user['prenomcompte'],
                'titre' => 'Adresse principale',
                'adresse' => $user['adresse'],
                'complement' => $user['complement'],
                'code_postal' => $user['code_postal'],
                'ville' => $user['ville'],
                'departement' => $user['departement'],
                'pays' => $user['pays'] ?: 'France',
                'telephone' => $user['telephone'],
                'is_principale' => 1
            ];
            
            $adresseId = $adresseModel->insert($nouvelleAdresse);
            return $adresseId;
        }
        
        return null;
    }

    private function updateStocks($commandeId)
    {
        $produits = $this->commandeDetailModel->where('commande_id', $commandeId)->findAll();
        
        foreach ($produits as $produit) {
            $produitActuel = $this->produitModel->find($produit['produit_id']);
            if ($produitActuel) {
                $nouveauStock = $produitActuel['stock'] - $produit['quantite'];
                $this->produitModel->update($produit['produit_id'], ['stock' => max(0, $nouveauStock)]);
            }
        }
    }
} 