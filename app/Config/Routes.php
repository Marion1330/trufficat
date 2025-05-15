<?php

use CodeIgniter\Router\RouteCollection;

/**
* @var RouteCollection $routes
*/
$routes->get('/', 'Accueil::index');
$routes->get('produits/chiens', 'Produits::chiens');
$routes->get('produits/chats', 'Produits::chats');
$routes->get('panier', 'Panier::index');

// Routes d'administration
$routes->get('admin', 'Admin::index');
$routes->get('admin/produits', 'Admin::produits');
$routes->get('admin/produit/ajouter', 'Admin::ajouterProduit');
$routes->get('admin/produit/modifier/(:num)', 'Admin::modifierProduit/$1');
$routes->get('admin/produit/supprimer/(:num)', 'Admin::supprimerProduit/$1');

$routes->get('/connexion', 'AuthController::connexion');
$routes->post('/connexion', 'AuthController::traitementConnexion'); 
$routes->get('/inscription', 'AuthController::inscription');
$routes->post('/inscription', 'AuthController::traitementInscription');//permet l'enregistrement dans la base de données
$routes->get('/deconnexion', 'AuthController::deconnexion');
$routes->get('/mon-compte', 'AuthController::monCompte');