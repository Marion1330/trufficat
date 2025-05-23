<?= $this->include('layouts/header') ?>

<div class="panier-container">
    <h1 class="panier-title">Mon Panier</h1>
    
    <div class="panier-empty">
        <img src="<?= base_url('images/empty-cart.png') ?>" alt="Panier vide" class="img-fluid">
        <h2>Votre panier est vide</h2>
        <p>Découvrez nos produits et commencez vos achats !</p>
        <a href="<?= base_url('produits/chiens') ?>" class="panier-btn">
            Continuer mes achats
        </a>
    </div>
</div>

<?= $this->include('layouts/footer') ?> 