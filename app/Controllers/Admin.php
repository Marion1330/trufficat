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

    public function supprimerProduit($id)
    {
        $model = new ProduitModel();
        $model->delete($id);
        return redirect()->to('/admin/produits');
    }
}
