<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trufficat - Votre animalerie en ligne</title>
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('css/carousel.css') ?>" />
  <link rel="icon" type="image/png" href="<?= base_url('images/logo.png') ?>" sizes="32x32">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<header>
  <!-- Barre de navigation principale -->
  <nav class="navbar">
    <div class="logo">
      <a href="<?= base_url() ?>"><img src="<?= base_url('images/logo.png') ?>" alt="Trufficat" class="logo-img" /></a>
    </div>
    <form action="<?= base_url('recherche') ?>" method="get" class="search-bar">
      <input type="text" name="q" placeholder="Rechercher un produit..." />
      <button type="submit"><i class="fas fa-search"></i></button>
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
            <li><a href="<?= base_url('commande/historique') ?>">Commandes</a></li>
            <li><a href="<?= base_url('deconnexion') ?>">Déconnexion</a></li>
          <?php endif; ?>
        </ul>
      </li>
      <li><a href="<?= base_url('panier') ?>">Panier</a></li>
    </ul>
  </nav>

  <!-- Barre de navigation secondaire -->
  <nav class="navbar-secondary">
    <ul class="nav-links-secondary">

      <!-- Produits pour chiens -->
      <li class="dropdown dropdown-chiens">
        <a href="<?= base_url('produits/chiens') ?>">Produits pour chiens</a>
        <div class="dropdown-menu dropdown-menu-chiens">
          <div class="dropdown-row">
            <div class="dropdown-column">
              <a href="<?= base_url('produits/categorie/chien/alimentation') ?>"><strong>Alimentation</strong></a>
              <a href="<?= base_url('produits/categorie/chien/alimentation-sans-cereales') ?>">Alimentation sans céréales</a>
              <a href="<?= base_url('produits/categorie/chien/alimentation-bio') ?>">Alimentation Bio</a>
              <a href="<?= base_url('produits/categorie/chien/croquettes') ?>">Croquettes</a>
              <a href="<?= base_url('produits/categorie/chien/croquettes-sterilise') ?>">Croquettes pour chiens stérilisé</a>
              <a href="<?= base_url('produits/categorie/chien/boites-sachets') ?>">Boites et sachets</a>
              <a href="<?= base_url('produits/categorie/chien/friandises') ?>">Friandises</a>
            </div>
            <div class="dropdown-column">
              <a href="<?= base_url('produits/categorie/chien/hygiene-soins') ?>"><strong>Hygiène et soins</strong></a>
              <a href="<?= base_url('produits/categorie/chien/antiparasitaires') ?>">Produits antiparasitaires</a>
              <a href="<?= base_url('produits/categorie/chien/entretien-poil') ?>">Entretien du poil</a>
              <a href="<?= base_url('produits/categorie/chien/sacs-proprete') ?>">Sacs de propreté</a>
              <a href="<?= base_url('produits/categorie/chien/accessoires') ?>"><strong>Accessoires</strong></a>
              <a href="<?= base_url('produits/categorie/chien/gamelles') ?>">Gamelles</a>
            </div>
            <div class="dropdown-column">
            <a href="<?= base_url('produits/categorie/chien/couchage') ?>"><strong>Niche et couchage</strong></a>
              <a href="<?= base_url('produits/categorie/chien/paniers-coussins') ?>">Paniers et coussins</a>
              <a href="<?= base_url('produits/categorie/chien/niches-chenils') ?>">Niches et chenils</a>
              <a href="<?= base_url('produits/categorie/chien/transports') ?>"><strong>Transports</strong></a>
              <a href="<?= base_url('produits/categorie/chien/caisses-transport') ?>">Caisses et sacs de transport</a>
              <a href="<?= base_url('produits/categorie/chien/accessoires-voyage') ?>">Accessoires de voyage</a>
            </div>
            <div class="dropdown-column">
              <a href="<?= base_url('produits/categorie/chien/sellerie') ?>"><strong>Sellerie</strong></a>
              <a href="<?= base_url('produits/categorie/chien/laisses') ?>">Laisses</a>
              <a href="<?= base_url('produits/categorie/chien/laisses-enrouleur') ?>">Laisses à enrouleur</a>
              <a href="<?= base_url('produits/categorie/chien/colliers') ?>">Colliers</a>
              <a href="<?= base_url('produits/categorie/chien/harnais') ?>">Harnais</a>
              <a href="<?= base_url('produits/categorie/chien/muselieres') ?>">Muselières</a>
            </div>
            <div class="dropdown-column">
              <a href="<?= base_url('produits/categorie/chien/jouets') ?>"><strong>Jouets</strong></a>
            </div>
          </div>
        </div>
      </li>

      <!-- Produits pour chats -->
      <li class="dropdown dropdown-chats">
        <a href="<?= base_url('produits/chats') ?>">Produits pour chats</a>
        <div class="dropdown-menu dropdown-menu-chats">
          <div class="dropdown-row">
            <div class="dropdown-column">
              <a href="<?= base_url('produits/categorie/chat/alimentation') ?>"><strong>Alimentation</strong></a>
              <a href="<?= base_url('produits/categorie/chat/alimentation-sans-cereales') ?>">Alimentation sans céréales</a>
              <a href="<?= base_url('produits/categorie/chat/alimentation-bio') ?>">Alimentation Bio</a>
              <a href="<?= base_url('produits/categorie/chat/croquettes') ?>">Croquettes</a>
              <a href="<?= base_url('produits/categorie/chat/croquettes-sterilise') ?>">Croquettes pour chat stérilisé</a>
              <a href="<?= base_url('produits/categorie/chat/boites-sachets') ?>">Boites et sachets</a>
              <a href="<?= base_url('produits/categorie/chat/friandises') ?>">Friandises</a>
            </div>
            <div class="dropdown-column">
              <a href="<?= base_url('produits/categorie/chat/hygiene-soins') ?>"><strong>Hygiène et soins</strong></a>
              <a href="<?= base_url('produits/categorie/chat/antiparasitaires') ?>">Produits antiparasitaires</a>
              <a href="<?= base_url('produits/categorie/chat/litieres') ?>">Litières</a>
              <a href="<?= base_url('produits/categorie/chat/bacs-litiere') ?>">Bacs à litière</a>
              <a href="<?= base_url('produits/categorie/chat/accessoires-litieres') ?>">Accessoires de litières</a>
              <a href="<?= base_url('produits/categorie/chat/maison-toilette') ?>">Maison de toilette</a>
              <a href="<?= base_url('produits/categorie/chat/entretien-poil') ?>">Entretien du poil</a>
            </div>
            <div class="dropdown-column">
            <a href="<?= base_url('produits/categorie/chat/couchage') ?>"><strong>Couchage</strong></a>
              <a href="<?= base_url('produits/categorie/chat/hamac') ?>">Hamac</a>
              <a href="<?= base_url('produits/categorie/chat/niche-cabane') ?>">Niche et cabane</a>
              <a href="<?= base_url('produits/categorie/chat/panier-coussin') ?>">Panier et coussin</a>
              <a href="<?= base_url('produits/categorie/chat/transport') ?>"><strong>Paniers et transports</strong></a>
              <a href="<?= base_url('produits/categorie/chat/sac-transport') ?>">Sac de transport</a>
              <a href="<?= base_url('produits/categorie/chat/caisse-transport') ?>">Caisse de transport</a>
            </div>
            
            <div class="dropdown-column">
            <a href="<?= base_url('produits/categorie/chat/accessoires') ?>"><strong>Accessoires</strong></a>
            <a href="<?= base_url('produits/categorie/chat/gamelles') ?>">Gamelles</a>
            <a href="<?= base_url('produits/categorie/chat/litieres') ?>">Litières</a>
            <a href="<?= base_url('produits/categorie/chat/bacs-litiere') ?>">Bacs à litière</a>
            <a href="<?= base_url('produits/categorie/chat/accessoires-litieres') ?>">Accessoires de litières</a>
            <a href="<?= base_url('produits/categorie/chat/maison-toilette') ?>">Maison de toilette</a>
            <a href="<?= base_url('produits/categorie/chat/sellerie') ?>">Sellerie</a>
            <a href="<?= base_url('produits/categorie/chat/chatieres') ?>">Chatières</a>
            </div>
            <div class="dropdown-column">
             <a href="<?= base_url('produits/categorie/chat/jouets') ?>"><strong>Jouets</strong></a>
             <a href="<?= base_url('produits/categorie/chat/arbres-griffoirs') ?>"><strong>Arbres à chat & griffoirs</strong></a>
          </div>
        </div>
      </li>

    </ul>
  </nav>
</header>

<main>

</main>

</body>
</html>
