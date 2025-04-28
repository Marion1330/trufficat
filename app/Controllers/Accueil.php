<?php

namespace App\Controllers;

use App\Models\ProduitModel;

class Accueil extends BaseController
{
    public function index()
    {
        $model = new ProduitModel();
        $data['produits'] = $model->findAll();
        $data['title'] = 'Page d\'accueil';

        return view('VueAccueil', $data);
    }
}
