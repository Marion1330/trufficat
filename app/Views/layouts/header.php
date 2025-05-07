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
          <li><a href="/register">S'inscrire</a></li>
        </ul>
      </li>
      <li><a href="/panier">Panier</a></li>
    </ul>
  </nav>
</header>

<nav class="produits-navbar">
  <ul class="produits-menu">
    <!-- Menu Produits pour chats -->
    <li class="produits-item">
      <a href="#">Produits pour chats</a>
      <ul class="produits-dropdown">
        <li><strong>Alimentation</strong>
          <ul>
            <li><a href="#">Alimentation sans céréales</a></li>
            <li><a href="#">Alimentation Bio</a></li>
            <li><a href="#">Croquettes</a></li>
            <li><a href="#">Croquettes pour chat stérilisé</a></li>
            <li><a href="#">Boites et sachets</a></li>
            <li><a href="#">Friandises</a></li>
          </ul>
        </li>
        <li><strong>Chatières</strong></li>
        <li><strong>Sellerie</strong></li>
        <li><strong>Couchage</strong>
          <ul>
            <li><a href="#">Hamac</a></li>
            <li><a href="#">Maison</a></li>
            <li><a href="#">Niche et cabane</a></li>
            <li><a href="#">Panier et coussin</a></li>
          </ul>
        </li>
        <li><strong>Hygiène et soins</strong>
          <ul>
            <li><a href="#">Produits antiparasitaires</a></li>
            <li><a href="#">Litières</a></li>
            <li><a href="#">Bacs à litière</a></li>
            <li><a href="#">Accessoires de litières</a></li>
            <li><a href="#">Maison de toilette</a></li>
            <li><a href="#">Entretien du poil</a></li>
          </ul>
        </li>
        <li><strong>Paniers et transports</strong>
          <ul>
            <li><a href="#">Sac de transport</a></li>
            <li><a href="#">Caisse de transport</a></li>
          </ul>
        </li>
        <li><strong>Jouets</strong></li>
        <li><strong>Arbres à chat et griffoirs</strong></li>
        <li><strong>Gamelles et accessoires</strong></li>
      </ul>
    </li>

    <!-- Menu Produits pour chiens -->
    <li class="produits-item">
      <a href="#">Produits pour chiens</a>
      <ul class="produits-dropdown">
        <li><strong>Alimentation</strong>
          <ul>
            <li><a href="#">Alimentation sans céréales</a></li>
            <li><a href="#">Alimentation Bio</a></li>
            <li><a href="#">Croquettes</a></li>
            <li><a href="#">Croquettes pour chiens stérilisé</a></li>
            <li><a href="#">Boites et sachets</a></li>
            <li><a href="#">Friandises</a></li>
          </ul>
        </li>
        <li><strong>Jouets</strong></li>
        <li><strong>Niche et couchage</strong>
          <ul>
            <li><a href="#">Paniers et coussins</a></li>
            <li><a href="#">Niches et chenils</a></li>
          </ul>
        </li>
        <li><strong>Hygiène et soins</strong>
          <ul>
            <li><a href="#">Produits antiparasitaires</a></li>
            <li><a href="#">Entretien du poil</a></li>
            <li><a href="#">Sacs de propreté</a></li>
          </ul>
        </li>
        <li><strong>Paniers et transports</strong>
          <ul>
            <li><a href="#">Caisses et sacs de transport</a></li>
            <li><a href="#">Accessoires de voyage</a></li>
          </ul>
        </li>
        <li><strong>Sellerie</strong>
          <ul>
            <li><a href="#">Laisses</a></li>
            <li><a href="#">Laisses à enrouleur</a></li>
            <li><a href="#">Colliers</a></li>
            <li><a href="#">Harnais</a></li>
            <li><a href="#">Muselières</a></li>
          </ul>
        </li>
        <li><strong>Accessoires</strong>
          <ul>
            <li><a href="#">Gamelles et accessoires</a></li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</nav>


</body>
</html>
