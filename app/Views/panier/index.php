<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/panier.css') ?>">

<div class="panier-container">
    <h1 class="panier-title">Mon Panier</h1>
    
    <?php if (empty($produits)): ?>
        <div class="panier-empty">
            <img src="<?= base_url('images/empty-cart.png') ?>" alt="Panier vide" class="img-fluid">
            <h2>Votre panier est vide</h2>
            <p>Découvrez nos produits et commencez vos achats !</p>
            <a href="<?= base_url('produits/chiens') ?>" class="panier-btn">
                Continuer mes achats
            </a>
        </div>
    <?php else: ?>
        <div class="panier-content">
            <div class="panier-items">
                <?php foreach ($produits as $produit): ?>
                    <div class="panier-item" data-id="<?= $produit['produit_id'] ?>">
                        <img src="<?= base_url($produit['image']) ?>" alt="<?= $produit['nom'] ?>" class="panier-item-image">
                        <div class="panier-item-details">
                            <h3><?= $produit['nom'] ?></h3>
                            <p class="prix"><?= number_format($produit['prix_unitaire'], 2) ?> €</p>
                            <div class="quantite-controls">
                                <button class="btn-quantite" data-action="decrease">-</button>
                                <input type="number" value="<?= $produit['quantite'] ?>" min="1" class="quantite-input" readonly>
                                <button class="btn-quantite" data-action="increase">+</button>
                                <button class="btn-supprimer" data-id="<?= $produit['produit_id'] ?>" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="panier-item-total">
                            <?= number_format($produit['prix_unitaire'] * $produit['quantite'], 2) ?> €
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="panier-resume">
                <h2>Résumé de la commande</h2>
                <div class="resume-ligne">
                    <span>Sous-total</span>
                    <span><?= number_format($total, 2) ?> €</span>
                </div>
                <div class="resume-ligne">
                    <span>Frais d'expédition estimés</span>
                    <span>4,99 €</span>
                </div>
                <?php 
                    $totalFinal = $total + 4.99;
                    $tva = ($total + 4.99) * 0.20; // TVA à titre indicatif (20%)
                ?>
                <div class="resume-ligne">
                    <span>TVA estimée (20%)</span>
                    <span><?= number_format($tva, 2) ?> €</span>
                </div>
                <div class="resume-ligne total">
                    <span>Total</span>
                    <span><?= number_format($totalFinal, 2) ?> €</span>
                </div>
                <div class="panier-actions">
                    <a href="<?= base_url('commande/checkout') ?>" class="btn-commander">Commander</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="<?= base_url('js/panier.js') ?>"></script>
<script>
// Initialiser le panier avec la configuration
window.TrufficatPanier.init({
    baseUrl: '<?= base_url() ?>'
});
</script>
</style>

<?= $this->include('layouts/footer') ?>