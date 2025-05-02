<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Trufficat</title>
<link rel="stylesheet" href="/trufficat/public/css/style.css">
</head>
<body>
<header>
<nav class="navbar">
<div class="logo">
<a href="/"><img src="/trufficat/public/images/logo.png" alt="Trufficat" class="logo-img"></a>
</div>
<form action="/recherche" method="get" class="search-bar">
<input type="text" name="q" placeholder="Rechercher un produit...">
</form>

<ul class="nav-links">
<li><a href="/">Accueil</a></li>
<li class="dropdown">
<a href="#">Compte</a>
<ul class="dropdown-menu">
<li><a href="/login">Se connecter</a></li>
<li><a href="/register">S'inscrire</a></li>
</ul>
</li>
<li><a href="/panier">Panier</a></li>
</ul>
</nav>
</header>

<main>
