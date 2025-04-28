<?php

use CodeIgniter\Router\RouteCollection;

/**
* @var RouteCollection $routes
*/
$routes->get('/', 'Accueil::index');
$routes->get('produits/chiens', 'Produits::chiens');
$routes->get('produits/chats', 'Produits::chats');
$routes->get('login', 'Compte::login');
$routes->get('register', 'Compte::register');
$routes->get('panier', 'Panier::index');
