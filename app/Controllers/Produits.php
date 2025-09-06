<?php

namespace App\Controllers;

use App\Models\ProduitModel;

/**
 * Controleur Produits pour la gestion complete du catalogue produits
 * - Gere l'affichage des produits par animal (chiens/chats)
 * - Implemente un systeme de filtres avances (marque, age, saveur, prix)
 * - Gere la pagination pour optimiser les performances
 * - Permet la recherche textuelle dans tous les champs produits
 * - Affiche les details complets d'un produit specifique
 * - Optimise les requetes SQL avec Query Builder
 */
class Produits extends BaseController
{
    /**
     * Propriete pour le modele de donnees produits
     * - Instanciation du modele ProduitModel pour l'acces aux donnees
     * - Permet l'acces aux methodes de requetage et de filtrage
     */
    protected $produitModel;
    
    /**
     * Constructeur du controleur Produits
     * - Initialise le modele ProduitModel
     * - Prepare l'environnement pour la gestion des produits
     */
    public function __construct()
    {
        $this->produitModel = new ProduitModel();
    }
    
    /**
     * Affichage des produits pour chiens
     * - Redirige vers la methode generique afficherProduits
     * - Passe le parametre 'chien' pour filtrer les produits
     * - Permet l'affichage de tous les produits pour chiens
     */
    public function chiens()
    {
        return $this->afficherProduits('chien');
    }

    /**
     * Affichage des produits pour chats
     * - Redirige vers la methode generique afficherProduits
     * - Passe le parametre 'chat' pour filtrer les produits
     * - Permet l'affichage de tous les produits pour chats
     */
    public function chats()
    {
        return $this->afficherProduits('chat');
    }
    
    /**
     * Methode privee principale pour l'affichage des produits
     * - Gere tous les filtres possibles (marque, age, saveur, prix, recherche)
     * - Implemente la pagination pour optimiser les performances
     * - Construit des requetes SQL dynamiques avec Query Builder
     * - Gere le tri des resultats selon plusieurs criteres
     * - Prepare toutes les donnees necessaires pour la vue
     * - Optimise les requetes avec des jointures et des conditions complexes
     */
    private function afficherProduits($animal, $categorie = null)
    {
        // Recuperation des filtres depuis l'URL
        // Ces parametres permettent un filtrage avance des produits
        $marque = $this->request->getGet('marque');
        $age = $this->request->getGet('age');
        $saveur = $this->request->getGet('saveur');
        $besoin = $this->request->getGet('besoin');
        $prix_min = $this->request->getGet('prix_min');
        $prix_max = $this->request->getGet('prix_max');
        $recherche = $this->request->getGet('recherche');
        $page = $this->request->getGet('page') ? (int)$this->request->getGet('page') : 1;
        
        // Construction de la requete avec les filtres
        // Utilisation du Query Builder pour des requetes optimisees
        $db = \Config\Database::connect();
        $builder = $db->table('produits');
        $builder->where('animal', $animal);
        
        // Filtre de recherche textuelle
        // Recherche dans tous les champs pertinents du produit
        if ($recherche) {
            $builder->groupStart()
                ->like('nom', $recherche)
                ->orLike('marque', $recherche)
                ->orLike('description', $recherche)
                ->orLike('categorie', $recherche)
                ->orLike('saveur', $recherche)
                ->orLike('age', $recherche)
            ->groupEnd();
        }
        
        // Filtre par categorie avec logique complexe
        // Gestion des categories speciales selon l'animal
        if ($categorie) {
            if ($categorie === 'alimentation') {
                // Regroupement de toutes les categories d'alimentation
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
                // Categories d'hygiene differentes selon l'animal
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
                // Accessoires specifiques selon l'animal
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
                // Couchage adapte selon l'animal
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
                // Transport specifique aux chiens
                $builder->groupStart()
                    ->where('categorie', 'caisses-transport')
                    ->orWhere('categorie', 'accessoires-voyage')
                    ->groupEnd();
            } elseif ($categorie === 'transport' && $animal === 'chat') {
                // Transport specifique aux chats
                $builder->groupStart()
                    ->where('categorie', 'sac-transport')
                    ->orWhere('categorie', 'caisse-transport')
                    ->groupEnd();
            } elseif ($categorie === 'sellerie' && $animal === 'chien') {
                // Sellerie specifique aux chiens
                $builder->groupStart()
                    ->where('categorie', 'laisses')
                    ->orWhere('categorie', 'laisses-enrouleur')
                    ->orWhere('categorie', 'colliers')
                    ->orWhere('categorie', 'harnais')
                    ->orWhere('categorie', 'muselieres')
                    ->groupEnd();
            } else {
                // Categorie simple sans logique speciale
                $builder->where('categorie', $categorie);
            }
        }
        
        // Application des filtres simples
        // Ces filtres s'appliquent directement sur les colonnes
        if ($marque) {
            $builder->where('marque', $marque);
        }
        
        if ($age) {
            $builder->where('age', $age);
        }
        
        if ($saveur) {
            $builder->where('saveur', $saveur);
        }
        
        // Filtre par besoin special avec logique complexe
        // Gestion des besoins nutritionnels et specifiques
        if ($besoin) {
            switch ($besoin) {
                case 'sterilise':
                    // Produits pour animaux sterilises
                    $builder->groupStart()
                        ->where('sterilise', 1)
                        ->orWhere('categorie', 'croquettes-sterilise')
                    ->groupEnd();
                    break;
                case 'sans_cereales':
                    // Produits sans cereales
                    $builder->like('categorie', 'sans-cereales');
                    break;
                case 'bio':
                    // Produits biologiques
                    $builder->like('categorie', 'bio');
                    break;
            }
        }
        
        // Filtres de prix avec validation
        // Permet de definir une fourchette de prix
        if ($prix_min) {
            $builder->where('prix >=', $prix_min);
        }
        
        if ($prix_max) {
            $builder->where('prix <=', $prix_max);
        }
        
        // Tri des resultats selon plusieurs criteres
        // Permet un tri flexible selon les besoins utilisateur
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
                case 'nom_desc':
                    $builder->orderBy('nom', 'DESC');
                    break;
                case 'category_asc':
                    $builder->orderBy('categorie', 'ASC');
                    break;
                case 'category_desc':
                    $builder->orderBy('categorie', 'DESC');
                    break;
                case 'brand_asc':
                    $builder->orderBy('marque', 'ASC');
                    break;
                case 'brand_desc':
                    $builder->orderBy('marque', 'DESC');
                    break;
                case 'age_asc':
                    $builder->orderBy('age', 'ASC');
                    break;
                case 'age_desc':
                    $builder->orderBy('age', 'DESC');
                    break;
                case 'flavor_asc':
                    $builder->orderBy('saveur', 'ASC');
                    break;
                case 'flavor_desc':
                    $builder->orderBy('saveur', 'DESC');
                    break;
                default:
                    // Tri par defaut par ID decroissant
                    $builder->orderBy('id', 'DESC');
            }
        } else {
            // Tri par defaut si aucun tri specifie
            $builder->orderBy('id', 'DESC');
        }
        
        // Recuperation du prix maximum pour l'animal specifique
        // Utilise pour l'affichage du slider de prix
        $maxPrice = $db->table('produits')
            ->where('animal', $animal)
            ->selectMax('prix')
            ->get()
            ->getRow()
            ->prix;
        
        // Compter le nombre total de produits (pour la pagination)
        // Cette requete est optimisee pour le comptage
        $totalProduits = $builder->countAllResults(false);
        
        // Configuration de la pagination
        // Limite le nombre de produits par page pour les performances
        $produitsParPage = 9;
        
        // Calculer l'offset pour la pagination
        // Permet de recuperer la bonne page de resultats
        $offset = ($page - 1) * $produitsParPage;
        
        // Recuperer les produits pour la page actuelle
        // Application de la limite et de l'offset
        $produits = $builder->limit($produitsParPage, $offset)->get()->getResultArray();
        
        // Creation d'un objet pager maison
        // Calculs pour la navigation entre les pages
        $totalPages = ceil($totalProduits / $produitsParPage);
        $hasPrevious = $page > 1;
        $hasNext = $page < $totalPages;
        
        // Preparation des parametres de requete pour les liens
        // Conservation des filtres lors de la navigation
        $queryParams = [];
        if ($marque) $queryParams['marque'] = $marque;
        if ($age) $queryParams['age'] = $age;
        if ($saveur) $queryParams['saveur'] = $saveur;
        if ($besoin) $queryParams['besoin'] = $besoin;
        if ($prix_min) $queryParams['prix_min'] = $prix_min;
        if ($prix_max) $queryParams['prix_max'] = $prix_max;
        if ($recherche) $queryParams['recherche'] = $recherche;
        if ($tri) $queryParams['tri'] = $tri;
        
        // Preparation des donnees pour la vue
        // Toutes les informations necessaires pour l'affichage
        $data['produits'] = $produits;
        $data['animal'] = $animal;
        $data['categorie'] = $categorie;
        $data['max_price'] = ceil($maxPrice); // Arrondir au nombre entier superieur
        
        // Informations de pagination pour la vue
        // Donnees pour la navigation entre les pages
        $data['pagination'] = [
            'page' => $page,
            'total_pages' => $totalPages,
            'has_previous' => $hasPrevious,
            'has_next' => $hasNext,
            'query_params' => $queryParams,
            'total_produits' => $totalProduits
        ];
        
        // Recuperation des marques, ages et saveurs pour les filtres
        // Donnees pour peupler les menus deroulants
        $data['marques'] = $this->produitModel->getMarques($animal);
        $data['ages'] = $this->produitModel->getAges($animal);
        $data['saveurs'] = $this->produitModel->getSaveurs($animal);
        
        // Valeurs actuelles des filtres
        // Conservation de l'etat des filtres pour l'interface
        $data['filtre_marque'] = $marque;
        $data['filtre_age'] = $age;
        $data['filtre_saveur'] = $saveur;
        $data['filtre_besoin'] = $besoin;
        $data['filtre_prix_min'] = $prix_min;
        $data['filtre_prix_max'] = $prix_max;
        $data['filtre_recherche'] = $recherche;
        $data['filtre_tri'] = $tri;
        
        // Affichage de la vue avec toutes les donnees
        return view('produits/liste', $data);
    }
    
    /**
     * Affichage des produits par categorie
     * - Redirige vers la methode generique afficherProduits
     * - Passe les parametres animal et categorie
     * - Permet l'affichage filtre par categorie
     */
    public function categorie($animal, $categorie)
    {
        return $this->afficherProduits($animal, $categorie);
    }
    
    /**
     * Affichage des details d'un produit specifique
     * - Recupere les informations completes du produit
     * - Verifie l'existence du produit en base
     * - Redirige vers l'accueil si le produit n'existe pas
     * - Affiche la page de detail avec toutes les informations
     */
    public function detail($id)
    {
        // Recuperation des details complets du produit
        $produit = $this->produitModel->getProduit($id);
        
        // Verification de l'existence du produit
        if (!$produit) {
            return redirect()->to('/');
        }
        
        // Preparation des donnees pour la vue
        $data['produit'] = $produit;
        return view('produits/detail', $data);
    }
    
    /**
     * Fonction de recherche globale
     * - Recupere le terme de recherche depuis l'URL
     * - Compte les resultats pour chiens et chats separement
     * - Determine automatiquement vers quelle page rediriger
     * - Redirige vers la page appropriee avec le filtre de recherche
     * - Optimise l'experience utilisateur en choisissant la page la plus pertinente
     */
    public function recherche()
    {
        // Recuperation du terme de recherche
        $terme = $this->request->getGet('q');
        
        // Redirection si aucun terme de recherche
        if (!$terme) {
            return redirect()->to('/');
        }
        
        // Connexion a la base de donnees
        $db = \Config\Database::connect();
        
        // Compter les produits pour chiens correspondant au terme de recherche
        // Recherche dans tous les champs pertinents
        $builderChiens = $db->table('produits');
        $builderChiens->where('animal', 'chien');
        $builderChiens->groupStart()
            ->like('nom', $terme)
            ->orLike('marque', $terme)
            ->orLike('description', $terme)
            ->orLike('categorie', $terme)
            ->orLike('saveur', $terme)
            ->orLike('age', $terme)
        ->groupEnd();
        $countChiens = $builderChiens->countAllResults();
        
        // Compter les produits pour chats correspondant au terme de recherche
        // Meme logique de recherche pour les chats
        $builderChats = $db->table('produits');
        $builderChats->where('animal', 'chat');
        $builderChats->groupStart()
            ->like('nom', $terme)
            ->orLike('marque', $terme)
            ->orLike('description', $terme)
            ->orLike('categorie', $terme)
            ->orLike('saveur', $terme)
            ->orLike('age', $terme)
        ->groupEnd();
        $countChats = $builderChats->countAllResults();
        
        // Determination de la page de destination
        // Logique : si egalite ou plus de chats, on va vers chats
        // Sinon on va vers chiens (priorite aux chiens en cas d'egalite)
        if ($countChats >= $countChiens) {
            $animal = 'chats';
        } else {
            $animal = 'chiens';
        }
        
        // Redirection vers la page appropriee avec le terme de recherche
        // Le terme est encode pour la securite URL
        return redirect()->to("/produits/$animal?recherche=" . urlencode($terme));
    }
}
