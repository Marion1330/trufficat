<?php

namespace App\Controllers;

use App\Models\ProduitModel;

class Accueil extends BaseController
{
    protected $produitModel;

    // Le constructeur pour initialiser le modèle
    public function __construct()
    {
        $this->produitModel = new ProduitModel(); // Initialisation du modèle
    }

    public function index()
    {
        // Récupère les produits vedettes et tous les produits
        $produitsVedettes = $this->produitModel->getProduitsVedettes(); 
        $produits = $this->produitModel->getProduits(); 

        // Passe les produits à la vue
        return view('VueAccueil', [
            'produitsVedettes' => $produitsVedettes,
            'produits' => $produits 
        ]);
    }
}
