<?php

namespace App\Controllers;

use App\Models\ProduitModel;

class Admin extends BaseController
{
   public function index()
{
    if (session()->get('role') !== 'admin') {
        return redirect()->to('/')->with('error', 'Accès refusé');
    }

    return view('admin/index');
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
            'prix' => $this->request->getPost('prix'),
            'stock' => $this->request->getPost('stock'),
            'animal' => $this->request->getPost('animal'),
            'categorie' => $this->request->getPost('categorie'),
            'marque' => $this->request->getPost('marque'),
            'age' => $this->request->getPost('age'),
            'saveur' => $this->request->getPost('saveur'),
            'sterilise' => $this->request->getPost('sterilise') ? 1 : 0
        ];

        // Gestion de l'upload d'image
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move('./images', $newName);
            $data['image'] = $newName;
        }

        // Mise à jour du produit
        if ($model->update($id, $data)) {
            return redirect()->to('/admin/produits')->with('success', 'Produit modifié avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification du produit');
        }
    }

    public function supprimerProduit($id)
    {
        $model = new ProduitModel();
        $model->delete($id);
        return redirect()->to('/admin/produits');
    }
}
