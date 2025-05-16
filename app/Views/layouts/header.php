<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trufficat</title>
<link rel="stylesheet" href="<?= base_url('css/style.css') ?>" />
<link rel="icon" type="image/png" href="<?= base_url('images/logo.png') ?>" sizes="32x32">
</head>
<body>

<header>
  <!-- Barre de navigation principale -->
  <nav class="navbar">
    <div class="logo">
      <a href="<?= base_url() ?>"><img src="<?= base_url('images/logo.png') ?>" alt="Trufficat" class="logo-img" /></a>
    </div>
    <form action="/recherche" method="get" class="search-bar">
      <input type="text" name="q" placeholder="Rechercher un produit..." />
    </form>

    <ul class="nav-links">
      <li><a href="<?= base_url() ?>">Accueil</a></li>
      <?php if (session('role') === 'admin'): ?>
        <li><a href="<?= base_url('admin') ?>">Tableau de bord</a></li>
      <?php endif; ?>
      <!-- Menu Compte avec classe spécifique -->
      <li class="dropdown dropdown-compte">
        <a href="#">Compte</a>
        <ul class="dropdown-menu dropdown-menu-compte">
          <?php if (!session('role')): ?>
            <li><a href="<?= base_url('connexion') ?>">Connexion</a></li>
            <li><a href="<?= base_url('inscription') ?>">Inscription</a></li>
          <?php else: ?>
            <li><a href="<?= base_url('profil') ?>">Profil</a></li>
            <li><a href="<?= base_url('deconnexion') ?>">Déconnexion</a></li>
          <?php endif; ?>
        </ul>
      </li>
      <li><a href="/panier">Panier</a></li>
    </ul>
  </nav>

  <!-- Barre de navigation secondaire -->
  <nav class="navbar-secondary">
    <ul class="nav-links-secondary">

      <!-- Produits pour chiens -->
      <li class="dropdown dropdown-chiens">
        <a href="#">Produits pour chiens</a>
        <div class="dropdown-menu dropdown-menu-chiens">
          <div class="dropdown-row">
            <div class="dropdown-column">
              <a href="#"><strong>Alimentation</strong></a>
              <a href="#">Alimentation sans céréales</a>
              <a href="#">Alimentation Bio</a>
              <a href="#">Croquettes</a>
              <a href="#">Croquettes pour chiens stérilisé</a>
              <a href="#">Boites et sachets</a>
              <a href="#">Friandises</a>
            </div>
            <div class="dropdown-column">
              <a href="#"><strong>Hygiène et soins</strong></a>
              <a href="#">Produits antiparasitaires</a>
              <a href="#">Entretien du poil</a>
              <a href="#">Sacs de propreté</a>
              <a href="#"><strong>Accessoires</strong></a>
              <a href="#">Gamelles</a>
            </div>
            <div class="dropdown-column">
            <a href="#"><strong>Niche et couchage</strong></a>
              <a href="#">Paniers et coussins</a>
              <a href="#">Niches et chenils</a>
              <a href="#"><strong>Transports</strong></a>
              <a href="#">Caisses et sacs de transport</a>
              <a href="#">Accessoires de voyage</a>
            </div>
            <div class="dropdown-column">
              <a href="#"><strong>Sellerie</strong></a>
              <a href="#">Laisses</a>
              <a href="#">Laisses à enrouleur</a>
              <a href="#">Colliers</a>
              <a href="#">Harnais</a>
              <a href="#">Muselières</a>
            </div>
            <div class="dropdown-column">
              <a href="#"><strong>Jouets</strong></a>
            </div>
          </div>
        </div>
      </li>

      <!-- Produits pour chats -->
      <li class="dropdown dropdown-chats">
        <a href="#">Produits pour chats</a>
        <div class="dropdown-menu dropdown-menu-chats">
          <div class="dropdown-row">
            <div class="dropdown-column">
              <a href="#"><strong>Alimentation</strong></a>
              <a href="#">Alimentation sans céréales</a>
              <a href="#">Alimentation Bio</a>
              <a href="#">Croquettes</a>
              <a href="#">Croquettes pour chat stérilisé</a>
              <a href="#">Boites et sachets</a>
              <a href="#">Friandises</a>
            </div>
            <div class="dropdown-column">
              <a href="#"><strong>Hygiène et soins</strong></a>
              <a href="#">Produits antiparasitaires</a>
              <a href="#">Litières</a>
              <a href="#">Bacs à litière</a>
              <a href="#">Accessoires de litières</a>
              <a href="#">Maison de toilette</a>
              <a href="#">Entretien du poil</a>
            </div>
            <div class="dropdown-column">
            <a href="#"><strong>Couchage</strong></a>
              <a href="#">Hamac</a>
              <a href="#">Niche et cabane</a>
              <a href="#">Panier et coussin</a>
              <a href="#"><strong>Paniers et transports</strong></a>
              <a href="#">Sac de transport</a>
              <a href="#">Caisse de transport</a>
            </div>
            
            <div class="dropdown-column">
            <a href="#"><strong>Accessoires</strong></a>
            <a href="#">Gamelles</a>
              <a href="#"><strong>Sellerie</strong></a>
              <a href="#"><strong>Chatières</strong></a>
            </div>
            <div class="dropdown-column">
             <a href="#"><strong>Jouets</strong></a>
             <a href="#"><strong>Arbres à chat & griffoirs</strong></a>
          </div>
        </div>
      </li>

    </ul>
  </nav>
</header>

</body>
</html>
