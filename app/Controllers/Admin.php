<?php

namespace App\Controllers;

use App\Models\ProduitModel;

class Admin extends BaseController
{
    protected $uploadPath = 'images/produits/';

    public function __construct()
    {
        helper('filesystem');
    }

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

    public function ajouterProduit()
    {
        return view('admin/ajouter_produit');
    }

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

    public function modifierProduit($id)
    {
        $model = new ProduitModel();
        $data['produit'] = $model->find($id);
        return view('admin/modifier_produit', $data);
    }

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

    public function clients()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé');
        }

        $model = new \App\Models\UserModel();
        $data['clients'] = $model->where('role IN ("admin", "client")')
                                ->orderBy('role', 'ASC')  // ASC mettra 'admin' avant 'client'
                                ->orderBy('nom', 'ASC')
                                ->findAll();
        return view('admin/clients', $data);
    }

    public function modifierClient($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé');
        }

        $model = new \App\Models\UserModel();
        $data['client'] = $model->find($id);
        
        if (!$data['client']) {
            return redirect()->to('/admin/clients')->with('error', 'Utilisateur non trouvé');
        }

        return view('admin/modifier_client', $data);
    }

    public function updateClient($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé');
        }

        $model = new \App\Models\UserModel();
        $client = $model->find($id);

        if (!$client) {
            return redirect()->to('/admin/clients')->with('error', 'Utilisateur non trouvé');
        }

        // Empêcher la modification du rôle du dernier administrateur
        $newRole = $this->request->getPost('role');
        if ($client['role'] === 'admin' && $newRole !== 'admin') {
            $adminCount = $model->where('role', 'admin')->countAllResults();
            if ($adminCount <= 1) {
                return redirect()->to('/admin/clients')->with('error', 'Impossible de changer le rôle du dernier administrateur');
            }
        }

        $data = [
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
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        try {
            if ($model->update($id, $data)) {
                return redirect()->to('/admin/clients')->with('success', 'Utilisateur modifié avec succès');
            } else {
                return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification de l\'utilisateur');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification de l\'utilisateur: ' . $e->getMessage());
        }
    }

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

    public function commandes()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé');
        }

        $commandeModel = new \App\Models\CommandeModel();
        $data['commandes'] = $commandeModel->getCommandesWithUser();
        
        return view('admin/commandes', $data);
    }

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
