<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trufficat</title>
  <link rel="stylesheet" href="/trufficat/public/css/style.css">
</head>
<body>

<header>
  <!-- Barre de navigation principale -->
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
          <li><a href="/login">Connexion</a></li>
          <li><a href="/register">Inscription</a></li>
          <li><a href="/logout">Déconnexion</a></li>
        </ul>
      </li>
      <li><a href="/panier">Panier</a></li>
    </ul>
  </nav>
  <!-- Barre de navigation secondaire -->
<nav class="navbar-secondary">
  <ul class="nav-links-secondary">
    <li class="dropdown">
      <a href="#">Produits pour chiens</a>
      <div class="dropdown-menu">
        <div class="dropdown-row">
          <div class="dropdown-column">
            <strong>Alimentation</strong>
            <a href="#">Alimentation sans céréales</a>
            <a href="#">Alimentation Bio</a>
            <a href="#">Croquettes</a>
            <a href="#">Croquettes pour chiens stérilisé</a>
            <a href="#">Boites et sachets</a>
            <a href="#">Friandises</a>
          </div>
          <div class="dropdown-column">
            <strong>Jouets</strong>
            <strong>Niche et couchage</strong>
            <a href="#">Paniers et coussins</a>
            <a href="#">Niches et chenils</a>
          </div>
          <div class="dropdown-column">
            <strong>Hygiène et soins</strong>
            <a href="#">Produits antiparasitaires</a>
            <a href="#">Entretien du poil</a>
            <a href="#">Sacs de propreté</a>
            <strong>Paniers et transports</strong>
            <a href="#">Caisses et sacs de transport</a>
            <a href="#">Accessoires de voyage</a>
          </div>
          <div class="dropdown-column">
            <strong>Sellerie</strong>
            <a href="#">Laisses</a>
            <a href="#">Laisses à enrouleur</a>
            <a href="#">Colliers</a>
            <a href="#">Harnais</a>
            <a href="#">Muselières</a>
            <strong>Accessoires</strong>
            <a href="#">Gamelles et accessoires</a>
          </div>
        </div>
      </div>
    </li>

    <li class="dropdown">
      <a href="#">Produits pour chats</a>
      <div class="dropdown-menu">
        <div class="dropdown-row">
          <div class="dropdown-column">
            <strong>Alimentation</strong>
            <a href="#">Alimentation sans céréales</a>
            <a href="#">Alimentation Bio</a>
            <a href="#">Croquettes</a>
            <a href="#">Croquettes pour chat stérilisé</a>
            <a href="#">Boites et sachets</a>
            <a href="#">Friandises</a>
          </div>
          <div class="dropdown-column">
            <strong>Chatières</strong>
            <strong>Sellerie</strong>
            <strong>Couchage</strong>
            <a href="#">Hamac</a>
            <a href="#">Maison</a>
            <a href="#">Niche et cabane</a>
            <a href="#">Panier et coussin</a>
          </div>
          <div class="dropdown-column">
            <strong>Hygiène et soins</strong>
            <a href="#">Produits antiparasitaires</a>
            <a href="#">Litières</a>
            <a href="#">Bacs à litière</a>
            <a href="#">Accessoires de litières</a>
            <a href="#">Maison de toilette</a>
            <a href="#">Entretien du poil</a>
          </div>
          <div class="dropdown-column">
            <strong>Paniers et transports</strong>
            <a href="#">Sac de transport</a>
            <a href="#">Caisse de transport</a>
            <strong>Jouets</strong>
            <strong>Arbres à chat et griffoirs</strong>
            <strong>Gamelles et accessoires</strong>
          </div>
        </div>
      </div>
    </li>
  </ul>
</nav>

</header>
</body>
</html>
