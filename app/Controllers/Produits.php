<?php

namespace App\Controllers;

use App\Models\ProduitModel;

class Produits extends BaseController
{
    public function chiens()
    {
        $model = new ProduitModel();
        $data['produits'] = $model->where('animal', 'chien')->findAll(); // Filtre par "chien"
        return view('VueProduits', $data);
    }

    public function chats()
    {
        $model = new ProduitModel();
        $data['produits'] = $model->where('animal', 'chat')->findAll(); // Filtre par "chat"
        return view('VueProduits', $data);
    }
}
