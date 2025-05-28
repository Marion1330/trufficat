<?php

namespace App\Controllers;

use App\Models\ProduitModel;
use App\Models\PubModel;

class Accueil extends BaseController
{
    protected $produitModel;
    protected $pubModel;

    // Le constructeur pour initialiser les modèles
    public function __construct()
    {
        $this->produitModel = new ProduitModel();
        $this->pubModel = new PubModel();
    }

    public function index()
    {
        // Récupère les produits vedettes
        $produitsVedettes = $this->produitModel->getProduitsVedettes();

        // Récupérer les publicités avec leurs URLs générées
        $publicites = $this->pubModel->getPublicites();

        // Calcul du prix formaté
        foreach ($produitsVedettes as &$produit) {
            if (!isset($produit['prix']) || $produit['prix'] == 0) {
                // Attribuer un prix par défaut si manquant
                $produit['prix'] = 19.99;
            }
        }

        // Envoie les données à la vue
        $data = [
            'produitsVedettes' => $produitsVedettes,
            'publicites' => $publicites
        ];
        
        return view('VueAccueil', $data);
    }
}

