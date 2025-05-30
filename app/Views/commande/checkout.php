<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/checkout.css') ?>">

<div class="container">
    <h1 class="page-title">Finaliser votre commande</h1>
    
    <div class="checkout-container">
        <div class="order-summary">
            <h2>Récapitulatif de votre commande</h2>
            
            <div class="products-list">
                <?php foreach ($produits as $produit): ?>
                    <div class="checkout-product-item">
                        <div class="checkout-product-info">
                            <img src="<?= base_url($produit['image'] ?: 'images/placeholder.png') ?>" alt="<?= esc($produit['nom']) ?>">
                            <div class="checkout-product-details">
                                <h3><?= esc($produit['nom']) ?></h3>
                                <p class="brand"><?= esc($produit['marque']) ?></p>
                                <p class="quantity">Quantité: <?= $produit['quantite'] ?></p>
                            </div>
                        </div>
                        <div class="checkout-product-price">
                            <?= number_format($produit['prix'] * $produit['quantite'], 2, ',', ' ') ?> €
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="total-section">
                <div class="total-line">
                    <strong>Total: <?= number_format($total, 2, ',', ' ') ?> €</strong>
                </div>
            </div>
        </div>
        
        <div class="payment-section">
            <h2>Paiement</h2>
            <div id="paypal-button-container"></div>
            <div id="loading" style="display: none;">
                <p>Traitement en cours...</p>
            </div>
        </div>
    </div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id=<?= $paypal_client_id ?>&currency=EUR"></script>
<script src="<?= base_url('js/checkout.js') ?>"></script>
<script>
// Initialiser le checkout avec la configuration
window.TrufficatCheckout.init({
    total: '<?= number_format($total, 2, '.', '') ?>',
    createOrderUrl: '<?= base_url('commande/creer') ?>',
    successUrl: '<?= base_url('commande/paypal/success') ?>',
    cancelUrl: '<?= base_url('commande/paypal/cancel') ?>'
});
</script>

<?= $this->include('layouts/footer') ?> 