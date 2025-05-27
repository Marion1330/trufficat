<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/panier.css') ?>">

<div class="container">
    <h1>Finaliser votre commande</h1>
    
    <div class="checkout-container">
        <div class="order-summary">
            <h2>Récapitulatif de votre commande</h2>
            
            <div class="products-list">
                <?php foreach ($produits as $produit): ?>
                    <div class="product-item">
                        <div class="product-info">
                            <img src="<?= base_url($produit['image'] ?: 'images/placeholder.png') ?>" alt="<?= esc($produit['nom']) ?>">
                            <div class="product-details">
                                <h3><?= esc($produit['nom']) ?></h3>
                                <p class="brand"><?= esc($produit['marque']) ?></p>
                                <p class="quantity">Quantité: <?= $produit['quantite'] ?></p>
                            </div>
                        </div>
                        <div class="product-price">
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
<script>
let commandeId = null;

paypal.Buttons({
    createOrder: function(data, actions) {
        // Créer la commande côté serveur d'abord
        return fetch('<?= base_url('commande/creer') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                commandeId = data.commande_id;
                // Créer le paiement PayPal
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?= number_format($total, 2, '.', '') ?>',
                            currency_code: 'EUR'
                        },
                        description: 'Commande Trufficat #' + data.commande_id
                    }]
                });
            } else {
                throw new Error(data.message || 'Erreur lors de la création de la commande');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la création de la commande: ' + error.message);
        });
    },
    
    onApprove: function(data, actions) {
        document.getElementById('loading').style.display = 'block';
        
        return actions.order.capture().then(function(details) {
            // Rediriger vers la page de succès avec les bonnes informations
            window.location.href = '<?= base_url('commande/paypal/success') ?>?paymentId=' + 
                                   data.orderID + '&PayerID=' + data.payerID + '&commande_id=' + commandeId;
        });
    },
    
    onCancel: function(data) {
        window.location.href = '<?= base_url('commande/paypal/cancel') ?>';
    },
    
    onError: function(err) {
        console.error('Erreur PayPal:', err);
        alert('Une erreur est survenue lors du paiement. Veuillez réessayer.');
        document.getElementById('loading').style.display = 'none';
    }
}).render('#paypal-button-container');
</script>

<style>
.checkout-container {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
    margin-top: 20px;
}

.order-summary, .payment-section {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.product-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.product-info {
    display: flex;
    align-items: center;
}

.product-info img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
    margin-right: 15px;
}

.product-details h3 {
    margin: 0 0 5px;
    font-size: 16px;
    color: #333;
}

.product-details .brand {
    color: #D97B29;
    font-size: 14px;
    margin: 0 0 5px;
}

.product-details .quantity {
    color: #666;
    font-size: 14px;
    margin: 0;
}

.product-price {
    font-weight: bold;
    color: #D97B29;
}

.total-section {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #D97B29;
}

.total-line {
    font-size: 18px;
    text-align: right;
    color: #D97B29;
}

#paypal-button-container {
    margin-top: 20px;
}

#loading {
    text-align: center;
    padding: 20px;
    color: #D97B29;
}

@media (max-width: 768px) {
    .checkout-container {
        grid-template-columns: 1fr;
    }
}
</style>

<?= $this->include('layouts/footer') ?> 