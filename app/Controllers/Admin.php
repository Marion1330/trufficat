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

        $model = new ProduitModel();
        $data['total_produits'] = $model->countAll();

        return view('admin/index', $data);
    }

    public function produits()
    {
        $model = new ProduitModel();
        $data['produits'] = $model->findAll();
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
        $data['clients'] = $model->where('role', 'client')->findAll();
        return view('admin/clients', $data);
    }

    public function modifierClient($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé');
        }

        $model = new \App\Models\UserModel();
        $data['client'] = $model->find($id);
        
        if (!$data['client'] || $data['client']['role'] !== 'client') {
            return redirect()->to('/admin/clients')->with('error', 'Client non trouvé');
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

        if (!$client || $client['role'] !== 'client') {
            return redirect()->to('/admin/clients')->with('error', 'Client non trouvé');
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
            'telephone' => $this->request->getPost('telephone')
        ];

        // Si un nouveau mot de passe est fourni
        if ($password = $this->request->getPost('password')) {
            $data['password'] = $password;
        }

        try {
            if ($model->update($id, $data)) {
                return redirect()->to('/admin/clients')->with('success', 'Client modifié avec succès');
            } else {
                return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification du client');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification du client: ' . $e->getMessage());
        }
    }

    public function supprimerClient($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé');
        }

        $model = new \App\Models\UserModel();
        $client = $model->find($id);

        if (!$client || $client['role'] !== 'client') {
            return redirect()->to('/admin/clients')->with('error', 'Client non trouvé');
        }

        try {
            $model->delete($id);
            return redirect()->to('/admin/clients')->with('success', 'Client supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()->to('/admin/clients')->with('error', 'Erreur lors de la suppression du client');
        }
    }
}
