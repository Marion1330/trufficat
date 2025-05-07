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
  <!-- Barre de navigation secondaire -->
<nav class="navbar-secondary">
  <ul class="nav-links-secondary">
    <li class="dropdown">
      <a href="#">Produits pour chiens</a>
      <div class="dropdown-menu">
        <div class="dropdown-columns">
          <div class="dropdown-column">
            <strong>Alimentation</strong>
            <a href="#">Sans céréales</a>
            <a href="#">Bio</a>
            <a href="#">Croquettes</a>
            <a href="#">Croquettes stérilisé</a>
            <a href="#">Boites et sachets</a>
            <a href="#">Friandises</a>
          </div>
          <div class="dropdown-column">
            <strong>Jouets</strong>
            <br><br>
            <strong>Niche et couchage</strong>
            <a href="#">Paniers et coussins</a>
            <a href="#">Niches et chenils</a>
            <strong>Hygiène et soins</strong>
            <a href="#">Antiparasitaires</a>
            <a href="#">Entretien du poil</a>
            <a href="#">Sacs de propreté</a>
          </div>
          <div class="dropdown-column">
            <strong>Transport</strong>
            <a href="#">Caisses et sacs</a>
            <a href="#">Accessoires voyage</a>
            <strong>Sellerie</strong>
            <a href="#">Laisses</a>
            <a href="#">Colliers</a>
            <a href="#">Harnais</a>
            <a href="#">Muselières</a>
            <strong>Accessoires</strong>
            <a href="#">Gamelles</a>
          </div>
        </div>
      </div>
    </li>

    <li class="dropdown">
      <a href="#">Produits pour chats</a>
      <div class="dropdown-menu">
        <div class="dropdown-columns">
          <div class="dropdown-column">
            <strong>Alimentation</strong>
            <a href="#">Sans céréales</a>
            <a href="#">Bio</a>
            <a href="#">Croquettes</a>
            <a href="#">Croquettes stérilisé</a>
            <a href="#">Boites et sachets</a>
            <a href="#">Friandises</a>
          </div>
          <div class="dropdown-column">
            <strong>Couchage</strong>
            <a href="#">Hamac</a>
            <a href="#">Maison</a>
            <a href="#">Cabane</a>
            <a href="#">Panier</a>
            <strong>Hygiène</strong>
            <a href="#">Antiparasitaires</a>
            <a href="#">Litières</a>
            <a href="#">Bacs</a>
            <a href="#">Accessoires</a>
          </div>
          <div class="dropdown-column">
            <strong>Transport</strong>
            <a href="#">Sacs</a>
            <a href="#">Caisses</a>
            <strong>Jouets</strong>
            <br><br>
            <strong>Griffoirs</strong>
            <br><br>
            <strong>Sellerie</strong>
            <br><br>
            <strong>Gamelles</strong>
          </div>
        </div>
      </div>
    </li>
  </ul>
</nav>

</header>
</body>
</html>
