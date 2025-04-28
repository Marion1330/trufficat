<?php

namespace App\Controllers;
use App\Models\ProduitModel;

class Produits extends BaseController
{
public function chiens()
{
$model = new ProduitModel();
$data['produits'] = $model->getByAnimal('chien');
return view('VueProduits', $data);
}

public function chats()
{
$model = new ProduitModel();
$data['produits'] = $model->getByAnimal('chat');
return view('VueProduits', $data);
}
}

