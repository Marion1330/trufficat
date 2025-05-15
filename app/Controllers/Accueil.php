<?php

namespace App\Controllers;

use App\Models\ProduitModel;
use App\Models\PubModel; // Assure-toi que le modèle PubModel est bien importé

class Accueil extends BaseController
{
    protected $produitModel;
    protected $pubModel;

    // Le constructeur pour initialiser les modèles
    public function __construct()
    {
        $this->produitModel = new ProduitModel(); // Initialisation du modèle Produit
        $this->pubModel = new PubModel(); // Initialisation du modèle Pub
    }

    public function index()
    {
        // Récupère les produits vedettes, tous les produits et les publicités
        $produitsVedettes = $this->produitModel->getProduitsVedettes();
        $produits = $this->produitModel->getProduits();
        $publicites = $this->pubModel->getPublicites();  // Récupère les publicités
    
        // Passe les produits et publicités à la vue
        return view('VueAccueil', [
            'produitsVedettes' => $produitsVedettes,
            'produits' => $produits,
            'publicites' => $publicites  // Ajout des publicités à la vue
        ]);
    }
}

