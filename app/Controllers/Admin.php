<?php

namespace App\Controllers;

use App\Models\ProduitModel;

/**
 * Controleur Admin pour la gestion complete de l'interface d'administration
 * - Gere tous les aspects de l'administration : produits, clients, commandes
 * - Verifie les droits administrateur sur toutes les actions
 * - Permet la gestion CRUD complete des produits avec upload d'images
 * - Gere les utilisateurs avec synchronisation adresses par defaut
 * - Controle les commandes et leurs statuts avec validation
 */
class Admin extends BaseController
{
    // Chemin de stockage des images de produits
    protected $uploadPath = 'images/produits/';

    /**
     * Constructeur du controleur Admin
     * - Initialise les helpers necessaires pour la gestion des fichiers
     * - Prepare l'environnement pour les operations d'upload
     */
    public function __construct()
    {
        helper('filesystem');
    }

    /**
     * Tableau de bord principal de l'administration
     * - Verifie les droits administrateur obligatoires
     * - Recupere les statistiques globales : nombre de produits, utilisateurs, commandes
     * - Affiche le tableau de bord avec les donnees synthetiques
     * - Utilise des requetes directes pour optimiser les performances
     */
    public function index()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé');
        }

        $produitModel = new ProduitModel();
        $data['total_produits'] = $produitModel->countAll();
        
        // Récupérer le nombre total d'utilisateurs (admin + clients)
        $db = \Config\Database::connect();
        $data['total_utilisateurs'] = $db->table('users')->countAllResults();
        
        // Récupérer le nombre total de commandes
        $data['total_commandes'] = $db->table('commandes')->countAllResults();

        return view('admin/index', $data);
    }

    /**
     * Gestion de la liste des produits avec filtres et pagination
     * - Verifie les droits administrateur obligatoires
     * - Applique des filtres par type d'animal (chien/chat)
     * - Permet la recherche textuelle sur nom, description, marque, categorie, saveur
     * - Implemente la pagination avec 10 produits par page
     * - Retourne les donnees filtrees avec les informations de pagination
     */
    public function produits()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé');
        }

        $model = new ProduitModel();
        
        // Récupérer les paramètres de filtrage et pagination
        $animal = $this->request->getGet('animal') ?? 'all';
        $page = $this->request->getGet('page') ?? 1;
        $search = $this->request->getGet('search') ?? '';
        $perPage = 10;

        // Appliquer le filtre par type d'animal
        if ($animal !== 'all') {
            $model->where('animal', $animal);
        }

        // Appliquer la recherche si un terme est fourni
        if (!empty($search)) {
            $model->groupStart()
                  ->like('nom', $search)
                  ->orLike('description', $search)
                  ->orLike('marque', $search)
                  ->orLike('categorie', $search)
                  ->orLike('saveur', $search)
                  ->groupEnd();
        }

        // Récupérer le total des produits pour la pagination
        $total = $model->countAllResults(false);

        // Récupérer les produits avec pagination
        $data['produits'] = $model->paginate($perPage);
        $data['pager'] = $model->pager;
        $data['currentAnimal'] = $animal;
        $data['currentSearch'] = $search;
        $data['total'] = $total;
        $data['perPage'] = $perPage;
        $data['currentPage'] = $page;

        return view('admin/produits', $data);
    }

    /**
     * Affichage du formulaire d'ajout de produit
     * - Affiche le formulaire vide pour la creation d'un nouveau produit
     * - Prepare l'interface pour l'upload d'image et la saisie des donnees
     */
    public function ajouterProduit()
    {
        return view('admin/ajouter_produit');
    }

    /**
     * Traitement de l'ajout d'un nouveau produit
     * - Recupere et valide toutes les donnees du formulaire
     * - Gere l'upload d'image avec generation de nom unique
     * - Cree le dossier d'upload si necessaire
     * - Insere le produit en base avec gestion d'erreurs
     * - Redirige avec message de succes ou d'erreur
     */
    public function saveProduit()
    {
        $model = new ProduitModel();

        // Récupérer les données du formulaire
        $data = [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'prix' => (float)$this->request->getPost('prix'),
            'stock' => (int)$this->request->getPost('stock'),
            'animal' => $this->request->getPost('animal'),
            'categorie' => $this->request->getPost('categorie'),
            'marque' => $this->request->getPost('marque'),
            'age' => $this->request->getPost('age') ?: null,
            'saveur' => $this->request->getPost('saveur') ?: null,
            'sterilise' => $this->request->getPost('sterilise') === '1' ? 1 : 0,
            'is_vedette' => $this->request->getPost('is_vedette') === '1' ? 1 : 0
        ];

        // Gestion de l'upload d'image
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            if (!is_dir($this->uploadPath)) {
                mkdir($this->uploadPath, 0777, true);
            }
            $image->move('./' . $this->uploadPath, $newName);
            $data['image'] = $this->uploadPath . $newName;
        }

        // Ajout du produit
        try {
            $result = $model->insert($data);
            if ($result) {
                return redirect()->to('/admin/produits')->with('success', 'Produit ajouté avec succès');
            } else {
                $errors = $model->errors();
                return redirect()->back()->withInput()->with('error', 'Erreur lors de l\'ajout du produit: ' . json_encode($errors));
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de l\'ajout du produit: ' . $e->getMessage());
        }
    }

    /**
     * Affichage du formulaire de modification d'un produit
     * - Recupere le produit existant par son ID
     * - Affiche le formulaire pre-rempli avec les donnees actuelles
     * - Permet la modification de tous les champs du produit
     */
    public function modifierProduit($id)
    {
        $model = new ProduitModel();
        $data['produit'] = $model->find($id);
        return view('admin/modifier_produit', $data);
    }

    /**
     * Traitement de la modification d'un produit existant
     * - Verifie l'existence du produit avant modification
     * - Gere l'upload d'une nouvelle image avec suppression de l'ancienne
     * - Met a jour tous les champs du produit en base
     * - Applique la validation et la gestion d'erreurs
     * - Redirige avec message de succes ou d'erreur
     */
    public function updateProduit($id)
    {
        $model = new ProduitModel();
        $produit = $model->find($id);

        if (!$produit) {
            return redirect()->to('/admin/produits')->with('error', 'Produit non trouvé');
        }

        // Récupérer les données du formulaire
        $data = [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'prix' => (float)$this->request->getPost('prix'),
            'stock' => (int)$this->request->getPost('stock'),
            'animal' => $this->request->getPost('animal'),
            'categorie' => $this->request->getPost('categorie'),
            'marque' => $this->request->getPost('marque'),
            'age' => $this->request->getPost('age') ?: null,
            'saveur' => $this->request->getPost('saveur') ?: null,
            'sterilise' => $this->request->getPost('sterilise') === '1' ? 1 : 0,
            'is_vedette' => $this->request->getPost('is_vedette') === '1' ? 1 : 0
        ];

        // Gestion de l'upload d'image
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Supprimer l'ancienne image si elle existe
            if (!empty($produit['image']) && file_exists('./' . $produit['image'])) {
                unlink('./' . $produit['image']);
            }

            $newName = $image->getRandomName();
            if (!is_dir($this->uploadPath)) {
                mkdir($this->uploadPath, 0777, true);
            }
            $image->move('./' . $this->uploadPath, $newName);
            $data['image'] = $this->uploadPath . $newName;
        }

        // Mise à jour du produit
        try {
            if ($model->update($id, $data)) {
                return redirect()->to('/admin/produits')->with('success', 'Produit modifié avec succès');
            } else {
                $errors = $model->errors();
                return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification du produit: ' . json_encode($errors));
            }
        } catch (\Exception $e) {
            log_message('error', 'Erreur lors de la modification du produit: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification du produit: ' . $e->getMessage());
        }
    }

    /**
     * Suppression d'un produit avec nettoyage des fichiers associes
     * - Verifie l'existence du produit avant suppression
     * - Supprime l'image associee du serveur si elle existe
     * - Supprime l'entree en base de donnees
     * - Redirige avec message de confirmation ou d'erreur
     */
    public function supprimerProduit($id)
    {
        $model = new ProduitModel();
        $produit = $model->find($id);

        if ($produit) {
            // Supprimer l'image associée si elle existe
            if (!empty($produit['image']) && file_exists('./' . $produit['image'])) {
                unlink('./' . $produit['image']);
            }

            $model->delete($id);
            return redirect()->to('/admin/produits')->with('success', 'Produit supprimé avec succès');
        }

        return redirect()->to('/admin/produits')->with('error', 'Produit non trouvé');
    }

    /**
     * Affiche la liste des clients avec leurs adresses par defaut
     * - Verifie les droits administrateur obligatoires
     * - Recupere tous les utilisateurs admin et client
     * - Joint les adresses par defaut avec nom/prenom associes
     * - Ordonne par role puis par nom pour affichage organise
     */
    public function clients()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé');
        }

        $userModel = new \App\Models\UserModel();
        $adresseModel = new \App\Models\AdresseModel();
        
        // Récupérer tous les utilisateurs admin et client
        $users = $userModel->where('role IN ("admin", "client")')
                          ->orderBy('role', 'ASC')
                          ->orderBy('nomcompte', 'ASC')
                          ->findAll();
        
        // Pour chaque utilisateur, récupérer son adresse par défaut
        foreach ($users as &$user) {
            $adresseDefaut = $adresseModel->where('user_id', $user['id'])
                                         ->where('is_defaut', 1)
                                         ->first();
            
            if ($adresseDefaut) {
                // Utiliser les informations de l'adresse par défaut
                $user['nom_affichage'] = $adresseDefaut['nom'];
                $user['prenom_affichage'] = $adresseDefaut['prenom'];
                $user['adresse_affichage'] = $adresseDefaut['adresse'];
                $user['complement_affichage'] = $adresseDefaut['complement'];
                $user['code_postal_affichage'] = $adresseDefaut['code_postal'];
                $user['ville_affichage'] = $adresseDefaut['ville'];
                $user['departement_affichage'] = $adresseDefaut['departement'];
                $user['pays_affichage'] = $adresseDefaut['pays'];
                $user['telephone_affichage'] = $adresseDefaut['telephone'];
            } else {
                // Fallback sur les informations utilisateur si pas d'adresse par défaut
                $user['nom_affichage'] = $user['nom'] ?: $user['nomcompte'];
                $user['prenom_affichage'] = $user['prenom'] ?: $user['prenomcompte'];
                $user['adresse_affichage'] = $user['adresse'] ?: 'Non renseignée';
                $user['complement_affichage'] = $user['complement'];
                $user['code_postal_affichage'] = $user['code_postal'] ?: 'Non renseigné';
                $user['ville_affichage'] = $user['ville'] ?: 'Non renseignée';
                $user['departement_affichage'] = $user['departement'];
                $user['pays_affichage'] = $user['pays'] ?: 'Non renseigné';
                $user['telephone_affichage'] = $user['telephone'] ?: 'Non renseigné';
            }
        }
        
        $data['clients'] = $users;
        return view('admin/clients', $data);
    }

    /**
     * Affiche le formulaire de modification d'un utilisateur
     * - Verifie les droits administrateur obligatoires
     * - Recupere les donnees utilisateur avec tous les champs
     * - Recupere l'adresse par defaut pour les valeurs a jour
     * - Prepare la vue avec les informations les plus recentes
     * - Synchronise les donnees entre table users et adresse par defaut
     */
    public function modifierClient($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé');
        }

        $userModel = new \App\Models\UserModel();
        $adresseModel = new \App\Models\AdresseModel();
        
        $client = $userModel->find($id);
        
        if (!$client) {
            return redirect()->to('/admin/clients')->with('error', 'Utilisateur non trouvé');
        }

        // Recuperer l'adresse par defaut pour avoir les informations a jour
        // Les adresses par defaut contiennent souvent les donnees les plus recentes
        $adresseDefaut = $adresseModel->where('user_id', $id)
                                     ->where('is_defaut', 1)
                                     ->first();
        
        if ($adresseDefaut) {
            // Utiliser les informations de l'adresse par defaut comme valeurs principales
            // Cela garantit que le formulaire affiche les donnees les plus a jour
            $client['nom'] = $adresseDefaut['nom'];
            $client['prenom'] = $adresseDefaut['prenom'];
            $client['adresse'] = $adresseDefaut['adresse'];
            $client['complement'] = $adresseDefaut['complement'];
            $client['code_postal'] = $adresseDefaut['code_postal'];
            $client['ville'] = $adresseDefaut['ville'];
            $client['departement'] = $adresseDefaut['departement'];
            $client['pays'] = $adresseDefaut['pays'];
            $client['telephone'] = $adresseDefaut['telephone'];
        }

        $data['client'] = $client;
        return view('admin/modifier_client', $data);
    }

    /**
     * Met a jour les donnees d'un utilisateur depuis l'interface admin
     * - Verifie les droits administrateur et existence utilisateur
     * - Gere la protection du dernier compte administrateur
     * - Traite les 4 champs distincts : nomcompte/prenomcompte et nom/prenom
     * - Met a jour la table users ET l'adresse par defaut correspondante
     * - Applique le hachage securise pour les nouveaux mots de passe
     */
    public function updateClient($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé');
        }

        $userModel = new \App\Models\UserModel();
        $adresseModel = new \App\Models\AdresseModel();
        
        $client = $userModel->find($id);

        if (!$client) {
            return redirect()->to('/admin/clients')->with('error', 'Utilisateur non trouvé');
        }

        // Empêcher la modification du rôle du dernier administrateur
        $newRole = $this->request->getPost('role');
        if ($client['role'] === 'admin' && $newRole !== 'admin') {
            $adminCount = $userModel->where('role', 'admin')->countAllResults();
            if ($adminCount <= 1) {
                return redirect()->to('/admin/clients')->with('error', 'Impossible de changer le rôle du dernier administrateur');
            }
        }

        // Données pour la table users
        $userData = [
            'email' => $this->request->getPost('email'),
            'nomcompte' => $this->request->getPost('nomcompte'),
            'prenomcompte' => $this->request->getPost('prenomcompte'),
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'adresse' => $this->request->getPost('adresse'),
            'complement' => $this->request->getPost('complement'),
            'code_postal' => $this->request->getPost('code_postal'),
            'ville' => $this->request->getPost('ville'),
            'departement' => $this->request->getPost('departement'),
            'pays' => $this->request->getPost('pays'),
            'telephone' => $this->request->getPost('telephone'),
            'role' => $newRole
        ];

        // Si un nouveau mot de passe est fourni
        if ($password = $this->request->getPost('password')) {
            $userData['password'] = $password; // Le UserModel s'occupera du hachage
        }

        try {
            // Mettre a jour la table users avec les nouvelles donnees
            // Cela inclut les identifiants de connexion et les informations personnelles
            if (!$userModel->update($id, $userData)) {
                return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification de l\'utilisateur');
            }

            // Mettre a jour l'adresse par defaut correspondante pour maintenir la coherence
            // Cela garantit que les donnees affichees dans le tableau de bord restent synchronisees
            $adresseDefaut = $adresseModel->where('user_id', $id)
                                         ->where('is_defaut', 1)
                                         ->first();
            
            if ($adresseDefaut) {
                $adresseData = [
                    'nom' => $this->request->getPost('nom'),
                    'prenom' => $this->request->getPost('prenom'),
                    'adresse' => $this->request->getPost('adresse'),
                    'complement' => $this->request->getPost('complement'),
                    'code_postal' => $this->request->getPost('code_postal'),
                    'ville' => $this->request->getPost('ville'),
                    'departement' => $this->request->getPost('departement'),
                    'pays' => $this->request->getPost('pays'),
                    'telephone' => $this->request->getPost('telephone'),
                ];
                
                $adresseModel->update($adresseDefaut['id'], $adresseData);
            }

            return redirect()->to('/admin/clients')->with('success', 'Utilisateur modifié avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification de l\'utilisateur: ' . $e->getMessage());
        }
    }

    /**
     * Suppression d'un utilisateur avec protection du dernier administrateur
     * - Verifie les droits administrateur obligatoires
     * - Controle l'existence de l'utilisateur avant suppression
     * - Protege le dernier compte administrateur de la suppression
     * - Supprime l'utilisateur en base avec gestion d'erreurs
     * - Redirige avec message de confirmation ou d'erreur
     */
    public function supprimerClient($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé');
        }

        $model = new \App\Models\UserModel();
        $client = $model->find($id);

        if (!$client) {
            return redirect()->to('/admin/clients')->with('error', 'Utilisateur non trouvé');
        }

        // Empêcher la suppression du dernier administrateur
        if ($client['role'] === 'admin') {
            $adminCount = $model->where('role', 'admin')->countAllResults();
            if ($adminCount <= 1) {
                return redirect()->to('/admin/clients')->with('error', 'Impossible de supprimer le dernier administrateur');
            }
        }

        try {
            $model->delete($id);
            return redirect()->to('/admin/clients')->with('success', 'Utilisateur supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()->to('/admin/clients')->with('error', 'Erreur lors de la suppression de l\'utilisateur');
        }
    }

    /**
     * Affichage de la liste des commandes avec informations utilisateur
     * - Verifie les droits administrateur obligatoires
     * - Recupere toutes les commandes avec les donnees utilisateur associees
     * - Utilise le modele CommandeModel pour la jointure automatique
     * - Affiche la liste complete des commandes pour suivi administratif
     */
    public function commandes()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé');
        }

        $commandeModel = new \App\Models\CommandeModel();
        $data['commandes'] = $commandeModel->getCommandesWithUser();
        
        return view('admin/commandes', $data);
    }

    /**
     * Affichage du detail d'une commande specifique
     * - Verifie les droits administrateur obligatoires
     * - Recupere la commande par son ID avec verification d'existence
     * - Redirige vers la page de confirmation existante pour affichage detaille
     * - Permet a l'admin de consulter tous les details de la commande
     */
    public function voirCommande($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé');
        }

        $commandeModel = new \App\Models\CommandeModel();
        $commande = $commandeModel->find($id);
        
        if (!$commande) {
            return redirect()->to('/admin/commandes')->with('error', 'Commande non trouvée');
        }
        
        // Rediriger vers la page de confirmation de commande existante
        return redirect()->to('/commande/confirmation/' . $id);
    }

    /**
     * Mise a jour du statut d'une commande avec validation et logging
     * - Verifie les droits administrateur obligatoires
     * - Valide le statut soumis contre la liste des statuts autorises
     * - Gere automatiquement la date de paiement lors du passage en "validee"
     * - Applique la mise a jour avec verification de reussite
     * - Log toutes les operations pour audit et debugging
     * - Redirige avec message de succes ou d'erreur detaille
     */
    public function updateStatutCommande($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé');
        }

        $statut = $this->request->getPost('statut');
        
        // Debug: afficher le statut reçu
        log_message('debug', "Statut reçu: " . $statut . " pour commande ID: " . $id);
        
        // Validation du statut
        $statutsValides = ['en_attente', 'validee', 'en_preparation', 'expediee', 'livree', 'annulee'];
        if (!in_array($statut, $statutsValides)) {
            log_message('error', "Statut invalide reçu: " . $statut);
            return redirect()->to('/admin/commandes')->with('error', 'Statut invalide');
        }
        
        $commandeModel = new \App\Models\CommandeModel();
        
        // Vérifier que la commande existe
        $commande = $commandeModel->find($id);
        if (!$commande) {
            return redirect()->to('/admin/commandes')->with('error', 'Commande non trouvée');
        }
        
        log_message('debug', "Commande trouvée, statut actuel: " . $commande['statut']);
        
        try {
            $datePaiement = null;
            
            // Si on passe à "validee" et qu'il n'y a pas encore de date de paiement
            if ($statut === 'validee' && empty($commande['date_paiement'])) {
                $datePaiement = date('Y-m-d H:i:s');
            }
            
            log_message('debug', "Mise à jour vers statut: " . $statut . ($datePaiement ? " avec date de paiement: " . $datePaiement : ""));
            
            $result = $commandeModel->updateStatut($id, $statut, $datePaiement);
            log_message('debug', "Résultat de la mise à jour: " . ($result ? 'true' : 'false'));
            
            if ($result) {
                // Vérifier que la mise à jour a bien eu lieu
                $commandeUpdated = $commandeModel->find($id);
                log_message('debug', "Statut après mise à jour: " . $commandeUpdated['statut']);
                
                return redirect()->to('/admin/commandes')->with('success', 'Statut mis à jour avec succès');
            } else {
                $errors = $commandeModel->errors();
                log_message('error', "Erreurs du modèle: " . json_encode($errors));
                return redirect()->to('/admin/commandes')->with('error', 'Erreur lors de la mise à jour du statut');
            }
        } catch (\Exception $e) {
            log_message('error', "Exception lors de la mise à jour du statut de la commande {$id}: " . $e->getMessage());
            return redirect()->to('/admin/commandes')->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }
}
