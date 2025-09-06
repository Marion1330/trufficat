<?php

namespace App\Controllers;

use App\Models\CommandeModel;
use App\Models\CommandeDetailModel;
use App\Models\PanierModel;
use App\Models\PanierProduitModel;
use App\Models\ProduitModel;

/**
 * Controleur Commande pour la gestion complete du processus de commande
 * - Gere la creation, validation et suivi des commandes
 * - Integre le systeme de paiement PayPal
 * - Gere l'historique des commandes utilisateur
 * - Controle la gestion des stocks et adresses de livraison
 * - Assure la securite des transactions et l'integrite des donnees
 */
class Commande extends BaseController
{
    /**
     * Proprietes pour les modeles de donnees
     * - Instanciation des modeles necessaires pour la gestion des commandes
     * - Permet l'acces aux donnees de commandes, paniers et produits
     */
    protected $commandeModel;
    protected $commandeDetailModel;
    protected $panierModel;
    protected $panierProduitModel;
    protected $produitModel;

    /**
     * Constructeur du controleur Commande
     * - Initialise tous les modeles necessaires
     * - Prepare l'environnement pour la gestion des commandes
     * - Assure la disponibilite des modeles dans toutes les methodes
     */
    public function __construct()
    {
        $this->commandeModel = new CommandeModel();
        $this->commandeDetailModel = new CommandeDetailModel();
        $this->panierModel = new PanierModel();
        $this->panierProduitModel = new PanierProduitModel();
        $this->produitModel = new ProduitModel();
    }

    /**
     * Page d'accueil des commandes
     * - Redirige automatiquement vers le checkout
     * - Simplifie le parcours utilisateur vers la finalisation
     * - Evite les pages intermediaires inutiles
     */
    public function index()
    {
        // Rediriger directement vers le checkout pour passer commande
        return redirect()->to('/commande/checkout');
    }

    /**
     * Affichage de l'historique des commandes utilisateur
     * - Verifie que l'utilisateur est connecte
     * - Recupere toutes les commandes de l'utilisateur triees par date
     * - Ajoute les details des produits pour chaque commande
     * - Affiche l'historique complet avec statuts et informations
     */
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

    /**
     * Page de finalisation de commande (checkout)
     * - Verifie l'authentification et l'existence du panier
     * - Calcule le total de la commande
     * - Charge la configuration PayPal pour le paiement
     * - Prepare les donnees pour l'interface de paiement
     * - Valide que le panier contient des produits
     */
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

    /**
     * Creation d'une nouvelle commande via AJAX
     * - Valide l'authentification et l'existence du panier
     * - Calcule le total de la commande
     * - Recupere ou cree l'adresse de livraison
     * - Genere un numero de commande unique
     * - Cree la commande et ses details en base
     * - Retourne une reponse JSON pour l'interface
     * - Gere les erreurs avec try-catch et logging
     */
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

    /**
     * Traitement du succes du paiement PayPal
     * - Recupere les parametres de retour PayPal (paymentId, payerId)
     * - Met a jour le statut de la commande en 'validee'
     * - Enregistre les informations de paiement PayPal
     * - Vide le panier de l'utilisateur
     * - Met a jour les stocks des produits
     * - Redirige vers la page de confirmation
     */
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

    /**
     * Traitement de l'annulation du paiement PayPal
     * - Redirige vers le panier avec message d'annulation
     * - Permet a l'utilisateur de reessayer le paiement
     * - Conserve les produits dans le panier
     */
    public function paypalCancel()
    {
        return redirect()->to('/panier')->with('error', 'Paiement annulé');
    }

    /**
     * Page de confirmation de commande
     * - Verifie l'authentification et la propriete de la commande
     * - Recupere les details complets de la commande
     * - Affiche la confirmation avec adresse de livraison
     * - Permet l'acces aux administrateurs pour toutes les commandes
     * - Controle la securite d'acces aux commandes
     */
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

        // Récupérer l'adresse par défaut actuelle de l'utilisateur
        $adresseModel = new \App\Models\AdresseModel();
        $adresseDefaut = $adresseModel->where('user_id', $commande['user_id'])
                                     ->where('is_defaut', 1)
                                     ->first();

        // Extraire les produits pour les passer séparément à la vue
        $produits = $commande['produits'] ?? [];

        return view('commande/confirmation', [
            'commande' => $commande,
            'produits' => $produits,
            'adresseDefaut' => $adresseDefaut
        ]);
    }

    /**
     * Methode privee pour recuperer l'adresse de livraison formattee
     * - Recupere les informations d'adresse de l'utilisateur
     * - Formate l'adresse pour l'affichage
     * - Utilise les informations du profil utilisateur
     * - Retourne une chaine formatee pour la livraison
     */
    private function getAdresseLivraison()
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find(session('user_id'));
        
        return $user['adresse'] . ', ' . $user['code_postal'] . ' ' . $user['ville'];
    }

    /**
     * Methode privee pour recuperer ou creer l'adresse de livraison
     * - Cherche d'abord l'adresse par defaut de l'utilisateur
     * - Si aucune adresse par defaut, utilise la premiere adresse disponible
     * - Si aucune adresse, cree une adresse par defaut depuis les infos utilisateur
     * - Assure qu'une adresse de livraison est toujours disponible
     * - Retourne l'ID de l'adresse de livraison
     */
    private function getOrCreateAdresseLivraison()
    {
        $adresseModel = new \App\Models\AdresseModel();
        $userModel = new \App\Models\UserModel();
        
        // Chercher l'adresse par défaut de l'utilisateur
        $adresseDefaut = $adresseModel->where('user_id', session('user_id'))
                                     ->where('is_defaut', 1)
                                         ->first();
        
        if ($adresseDefaut) {
            return $adresseDefaut['id'];
        }
        
        // Si pas d'adresse par défaut, chercher la première adresse de l'utilisateur
        $premiereAdresse = $adresseModel->where('user_id', session('user_id'))->first();
        
        if ($premiereAdresse) {
            // Définir cette adresse comme par défaut
            $adresseModel->update($premiereAdresse['id'], ['is_defaut' => 1]);
            return $premiereAdresse['id'];
        }
        
        // Si aucune adresse, créer une adresse par défaut basée sur les infos utilisateur
        $user = $userModel->find(session('user_id'));
        
        if ($user && !empty($user['adresse']) && !empty($user['code_postal']) && !empty($user['ville'])) {
            $nouvelleAdresse = [
                'user_id' => session('user_id'),
                'nom' => $user['nom'] ?: $user['nomcompte'],
                'prenom' => $user['prenom'] ?: $user['prenomcompte'],
                'titre' => 'Adresse par défaut',
                'adresse' => $user['adresse'],
                'complement' => $user['complement'],
                'code_postal' => $user['code_postal'],
                'ville' => $user['ville'],
                'departement' => $user['departement'],
                'pays' => $user['pays'] ?: 'France',
                'telephone' => $user['telephone'],
                'is_defaut' => 1
            ];
            
            $adresseId = $adresseModel->insert($nouvelleAdresse);
            return $adresseId;
        }
        
        return null;
    }

    /**
     * Methode privee pour mettre a jour les stocks apres validation de commande
     * - Recupere tous les produits de la commande
     * - Calcule le nouveau stock pour chaque produit
     * - Met a jour les stocks en base de donnees
     * - Assure que le stock ne descend jamais en dessous de 0
     * - Gere la logique metier de gestion des stocks
     */
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