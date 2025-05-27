<?php

use CodeIgniter\Router\RouteCollection;

/**
* @var RouteCollection $routes
*/
$routes->get('/', 'Accueil::index');

$routes->get('produits/chiens', 'Produits::chiens');
$routes->get('produits/chats', 'Produits::chats');
$routes->get('produits/detail/(:num)', 'Produits::detail/$1');
$routes->get('produits/categorie/(:any)/(:any)', 'Produits::categorie/$1/$2');
$routes->get('recherche', 'Produits::recherche');
$routes->get('panier', 'Panier::index');
$routes->post('panier/ajouter', 'Panier::ajouter');
$routes->post('panier/supprimer/(:num)', 'Panier::supprimer/$1');
$routes->post('panier/modifier/(:num)', 'Panier::modifier/$1');
$routes->get('panier/vider', 'Panier::vider');

// Routes pour les commandes
$routes->get('commande', 'Commande::index');
$routes->get('commande/historique', 'Commande::historique');
$routes->get('commande/checkout', 'Commande::checkout');
$routes->post('commande/creer', 'Commande::creerCommande');
$routes->get('commande/paypal/success', 'Commande::paypalSuccess');
$routes->get('commande/paypal/cancel', 'Commande::paypalCancel');
$routes->get('commande/confirmation/(:num)', 'Commande::confirmation/$1');

// Routes d'administration
$routes->get('admin', 'Admin::index');
$routes->get('admin/produits', 'Admin::produits');
$routes->get('admin/produit/ajouter', 'Admin::ajouterProduit');
$routes->post('admin/produit/ajouter', 'Admin::saveProduit');
$routes->get('admin/produit/modifier/(:num)', 'Admin::modifierProduit/$1');
$routes->post('admin/produit/modifier/(:num)', 'Admin::updateProduit/$1');
$routes->get('admin/produit/supprimer/(:num)', 'Admin::supprimerProduit/$1');

// Routes pour la gestion des clients dans l'admin
$routes->get('admin/clients', 'Admin::clients');
$routes->get('admin/modifier-client/(:num)', 'Admin::modifierClient/$1');
$routes->post('admin/update-client/(:num)', 'Admin::updateClient/$1');
$routes->get('admin/supprimer-client/(:num)', 'Admin::supprimerClient/$1');

// Routes pour la gestion des commandes dans l'admin
$routes->get('admin/commandes', 'Admin::commandes');
$routes->get('admin/commande/(:num)', 'Admin::voirCommande/$1');
$routes->post('admin/commande/statut/(:num)', 'Admin::updateStatutCommande/$1');

//Route de connexion et inscription et traitement de formulaire 
$routes->get('/connexion', 'AuthController::connexion');
$routes->post('/connexion', 'AuthController::traitementConnexion'); 
$routes->get('/inscription', 'AuthController::inscription');
$routes->post('/inscription', 'AuthController::traitementInscription');//permet l'enregistrement dans la base de données
$routes->get('/deconnexion', 'AuthController::deconnexion');

//Accès profil utilisateur client et admin
$routes->get('/profil', 'AuthController::profil');
$routes->post('/profil', 'AuthController::updateProfil');
$routes->get('profil/supprimer', 'AuthController::supprimerCompte');
$routes->post('/profil/modifier-adresse-principale', 'AuthController::modifierAdressePrincipale');
$routes->get('/profil/modifier-adresse-principale', 'AuthController::afficherFormulaireAdressePrincipale');
$routes->get('/profil/modifier-infos', 'AuthController::afficherFormulaireInfos');
$routes->post('/profil/modifier-infos', 'AuthController::modifierInfos');

//Gerer les adresses postale dans profil
$routes->get('/adresse/ajouter', 'AuthController::ajouterAdresse');
$routes->post('/adresse/ajouter', 'AuthController::saveAdresse');
$routes->get('/adresse/modifier/(:num)', 'AuthController::modifierAdresse/$1');
$routes->post('/adresse/modifier/(:num)', 'AuthController::updateAdresse/$1');
$routes->get('/adresse/supprimer/(:num)', 'AuthController::supprimerAdresse/$1');
$routes->get('adresse/defaut/(:num)', 'AuthController::definirAdresseDefaut/$1');
$routes->get('adresse/defaut/principale', 'AuthController::definirPrincipaleDefaut');

$routes->get('/changer-mot-de-passe', 'AuthController::changerMotDePasse');
$routes->post('/changer-mot-de-passe', 'AuthController::traiterChangementMotDePasse');

