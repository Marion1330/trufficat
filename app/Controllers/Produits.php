<?php

namespace App\Controllers;

use App\Models\ProduitModel;

class Produits extends BaseController
{
    protected $produitModel;
    
    public function __construct()
    {
        $this->produitModel = new ProduitModel();
    }
    
    public function chiens()
    {
        return $this->afficherProduits('chien');
    }

    public function chats()
    {
        return $this->afficherProduits('chat');
    }
    
    private function afficherProduits($animal, $categorie = null)
    {
        // Récupération des filtres depuis l'URL
        $marque = $this->request->getGet('marque');
        $age = $this->request->getGet('age');
        $saveur = $this->request->getGet('saveur');
        $sterilise = $this->request->getGet('sterilise');
        $sans_cereales = $this->request->getGet('sans_cereales');
        $prix_min = $this->request->getGet('prix_min');
        $prix_max = $this->request->getGet('prix_max');
        $page = $this->request->getGet('page') ? (int)$this->request->getGet('page') : 1;
        
        // Construction de la requête avec les filtres
        $db = \Config\Database::connect();
        $builder = $db->table('produits');
        $builder->where('animal', $animal);
        
        if ($categorie) {
            if ($categorie === 'alimentation') {
                $builder->groupStart()
                    ->where('categorie', 'alimentation')
                    ->orWhere('categorie', 'alimentation-sans-cereales')
                    ->orWhere('categorie', 'alimentation-bio')
                    ->orWhere('categorie', 'croquettes')
                    ->orWhere('categorie', 'croquettes-sterilise')
                    ->orWhere('categorie', 'boites-sachets')
                    ->orWhere('categorie', 'friandises')
                    ->groupEnd();
            } elseif ($categorie === 'hygiene-soins') {
                if ($animal === 'chien') {
                    $builder->groupStart()
                        ->where('categorie', 'hygiene-soins')
                        ->orWhere('categorie', 'antiparasitaires')
                        ->orWhere('categorie', 'entretien-poil')
                        ->orWhere('categorie', 'sacs-proprete')
                        ->groupEnd();
                } else { // chat
                    $builder->groupStart()
                        ->where('categorie', 'hygiene-soins')
                        ->orWhere('categorie', 'antiparasitaires')
                        ->orWhere('categorie', 'litieres')
                        ->orWhere('categorie', 'bacs-litiere')
                        ->orWhere('categorie', 'accessoires-litieres')
                        ->orWhere('categorie', 'maison-toilette')
                        ->orWhere('categorie', 'entretien-poil')
                        ->groupEnd();
                }
            } elseif ($categorie === 'accessoires') {
                if ($animal === 'chien') {
                    $builder->groupStart()
                        ->where('categorie', 'gamelles')
                        ->groupEnd();
                } else { // chat
                    $builder->groupStart()
                        ->where('categorie', 'gamelles')
                        ->orWhere('categorie', 'litieres')
                        ->orWhere('categorie', 'bacs-litiere')
                        ->orWhere('categorie', 'accessoires-litieres')
                        ->orWhere('categorie', 'maison-toilette')
                        ->orWhere('categorie', 'sellerie')
                        ->orWhere('categorie', 'chatieres')
                        ->groupEnd();
                }
            } elseif ($categorie === 'couchage') {
                if ($animal === 'chien') {
                    $builder->groupStart()
                        ->where('categorie', 'paniers-coussins')
                        ->orWhere('categorie', 'niches-chenils')
                        ->groupEnd();
                } else { // chat
                    $builder->groupStart()
                        ->where('categorie', 'hamac')
                        ->orWhere('categorie', 'niche-cabane')
                        ->orWhere('categorie', 'panier-coussin')
                        ->groupEnd();
                }
            } elseif ($categorie === 'transports' && $animal === 'chien') {
                $builder->groupStart()
                    ->where('categorie', 'caisses-transport')
                    ->orWhere('categorie', 'accessoires-voyage')
                    ->groupEnd();
            } elseif ($categorie === 'transport' && $animal === 'chat') {
                $builder->groupStart()
                    ->where('categorie', 'sac-transport')
                    ->orWhere('categorie', 'caisse-transport')
                    ->groupEnd();
            } elseif ($categorie === 'sellerie' && $animal === 'chien') {
                $builder->groupStart()
                    ->where('categorie', 'laisses')
                    ->orWhere('categorie', 'laisses-enrouleur')
                    ->orWhere('categorie', 'colliers')
                    ->orWhere('categorie', 'harnais')
                    ->orWhere('categorie', 'muselieres')
                    ->groupEnd();
            } else {
                $builder->where('categorie', $categorie);
            }
        }
        
        if ($marque) {
            $builder->where('marque', $marque);
        }
        
        if ($age) {
            $builder->where('age', $age);
        }
        
        if ($saveur) {
            $builder->where('saveur', $saveur);
        }
        
        if ($sterilise) {
            $builder->where('sterilise', 1);
        }
        
        if ($sans_cereales) {
            $builder->where('sans_cereales', 1);
        }
        
        if ($prix_min) {
            $builder->where('prix >=', $prix_min);
        }
        
        if ($prix_max) {
            $builder->where('prix <=', $prix_max);
        }
        
        // Tri des résultats
        $tri = $this->request->getGet('tri');
        if ($tri) {
            switch ($tri) {
                case 'prix_asc':
                    $builder->orderBy('prix', 'ASC');
                    break;
                case 'prix_desc':
                    $builder->orderBy('prix', 'DESC');
                    break;
                case 'nom_asc':
                    $builder->orderBy('nom', 'ASC');
                    break;
                default:
                    $builder->orderBy('id', 'DESC');
            }
        } else {
            $builder->orderBy('id', 'DESC');
        }
        
        // Compter le nombre total de produits (pour la pagination)
        $totalProduits = $builder->countAllResults(false);
        
        // Produits par page
        $produitsParPage = 9;
        
        // Calculer l'offset
        $offset = ($page - 1) * $produitsParPage;
        
        // Récupérer les produits pour la page actuelle
        $produits = $builder->limit($produitsParPage, $offset)->get()->getResultArray();
        
        // Créer un objet pager maison
        $totalPages = ceil($totalProduits / $produitsParPage);
        $hasPrevious = $page > 1;
        $hasNext = $page < $totalPages;
        
        // Préparer les paramètres de requête pour les liens
        $queryParams = [];
        if ($marque) $queryParams['marque'] = $marque;
        if ($age) $queryParams['age'] = $age;
        if ($saveur) $queryParams['saveur'] = $saveur;
        if ($sterilise) $queryParams['sterilise'] = $sterilise;
        if ($sans_cereales) $queryParams['sans_cereales'] = $sans_cereales;
        if ($prix_min) $queryParams['prix_min'] = $prix_min;
        if ($prix_max) $queryParams['prix_max'] = $prix_max;
        if ($tri) $queryParams['tri'] = $tri;
        
        // Préparation des données pour la vue
        $data['produits'] = $produits;
        $data['animal'] = $animal;
        $data['categorie'] = $categorie;
        
        // Informations de pagination pour la vue
        $data['pagination'] = [
            'page' => $page,
            'total_pages' => $totalPages,
            'has_previous' => $hasPrevious,
            'has_next' => $hasNext,
            'query_params' => $queryParams,
            'total_produits' => $totalProduits
        ];
        
        // Récupération des marques, âges et saveurs pour les filtres
        $data['marques'] = $this->produitModel->getMarques($animal);
        $data['ages'] = $this->produitModel->getAges($animal);
        $data['saveurs'] = $this->produitModel->getSaveurs($animal);
        
        // Valeurs actuelles des filtres
        $data['filtre_marque'] = $marque;
        $data['filtre_age'] = $age;
        $data['filtre_saveur'] = $saveur;
        $data['filtre_sterilise'] = $sterilise;
        $data['filtre_sans_cereales'] = $sans_cereales;
        $data['filtre_prix_min'] = $prix_min;
        $data['filtre_prix_max'] = $prix_max;
        $data['filtre_tri'] = $tri;
        
        return view('produits/liste', $data);
    }
    
    public function categorie($animal, $categorie)
    {
        return $this->afficherProduits($animal, $categorie);
    }
    
    public function detail($id)
    {
        $produit = $this->produitModel->getProduit($id);
        
        if (!$produit) {
            return redirect()->to('/');
        }
        
        $data['produit'] = $produit;
        return view('produits/detail', $data);
    }
}
