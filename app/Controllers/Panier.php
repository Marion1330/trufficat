<?php

namespace App\Controllers;

class Panier extends BaseController
{
    public function index()
    {
        return view('panier/index');
    }

    public function ajouter($id)
    {
        // Logique pour ajouter un produit au panier
        return $this->response->setJSON(['success' => true]);
    }

    public function supprimer($id)
    {
        // Logique pour supprimer un produit du panier
        return $this->response->setJSON(['success' => true]);
    }

    public function modifier($id)
    {
        // Logique pour modifier la quantité d'un produit
        return $this->response->setJSON(['success' => true]);
    }

    public function vider()
    {
        // Logique pour vider le panier
        return redirect()->to('/panier')->with('message', 'Votre panier a été vidé');
    }
} 