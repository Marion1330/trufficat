<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/panier.css') ?>">

<div class="container">
    <div class="confirmation-container">
        <div class="confirmation-header">
            <i class="fas fa-check-circle"></i>
            <h1>Commande confirmée !</h1>
            <p>Merci pour votre achat. Votre commande a été traitée avec succès.</p>
        </div>
        
        <div class="order-details">
            <h2>Détails de votre commande</h2>
            
            <div class="order-info">
                <div class="info-row">
                    <span class="label">Numéro de commande :</span>
                    <span class="value"><?= esc($commande['numero_commande'] ?? 'CMD-' . $commande['id']) ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Date de commande :</span>
                    <span class="value"><?= date('d/m/Y à H:i', strtotime($commande['date_commande'])) ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Statut :</span>
                    <span class="value status-validee">Validée et payée</span>
                </div>
                <?php if (!empty($commande['paypal_payment_id'])): ?>
                <div class="info-row">
                    <span class="label">ID de paiement PayPal :</span>
                    <span class="value"><?= esc($commande['paypal_payment_id']) ?></span>
                </div>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($commande['adresse_livraison'])): ?>
            <div class="delivery-address">
                <h3>Adresse de livraison</h3>
                <div class="address-info">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="address-details">
                        <p class="recipient-name"><strong><?= esc($commande['prenom']) ?> <?= esc($commande['nom']) ?></strong></p>
                        <p class="address-text"><?= nl2br(esc($commande['adresse_livraison'])) ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="products-ordered">
                <h3>Produits commandés</h3>
                <?php if (!empty($commande['produits'])): ?>
                    <?php foreach ($commande['produits'] as $produit): ?>
                        <div class="product-item">
                            <div class="product-info">
                                <img src="<?= base_url($produit['image'] ?: 'images/placeholder.png') ?>" alt="<?= esc($produit['nom']) ?>">
                                <div class="product-details">
                                    <h4><?= esc($produit['nom']) ?></h4>
                                    <p class="brand"><?= esc($produit['marque']) ?></p>
                                    <p class="quantity">Quantité: <?= $produit['quantite'] ?></p>
                                </div>
                            </div>
                            <div class="product-price">
                                <?= number_format($produit['prix_unitaire'] * $produit['quantite'], 2, ',', ' ') ?> €
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <div class="order-total">
                <div class="total-line">
                    <strong>Total payé: <?= number_format($commande['total'], 2, ',', ' ') ?> €</strong>
                </div>
            </div>
        </div>
        
        <div class="next-steps">
            <h3>Prochaines étapes</h3>
            <ul>
                <li>📧 Vous recevrez un email de confirmation</li>
                <li>📦 Votre commande sera préparée sous 24-48h</li>
                <li>🚚 Vous recevrez un email avec le numéro de suivi</li>
            </ul>
        </div>
        
        <div class="action-buttons">
            <?php if (session('role') === 'admin'): ?>
                <a href="<?= base_url('admin/commandes') ?>" class="btn btn-admin">
                    <i class="fas fa-arrow-left"></i> Retour au dashboard admin
                </a>
            <?php else: ?>
                <a href="<?= base_url('commande/historique') ?>" class="btn btn-secondary">
                    <i class="fas fa-history"></i> Voir mes commandes
                </a>
            <?php endif; ?>
            <a href="<?= base_url('/') ?>" class="btn btn-primary">
                <i class="fas fa-home"></i> Retour à l'accueil
            </a>
        </div>
    </div>
</div>

<style>
.confirmation-container {
    max-width: 800px;
    margin: 20px auto;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
}

.confirmation-header {
    background: linear-gradient(135deg, #D97B29, #F2C078);
    color: white;
    text-align: center;
    padding: 40px 20px;
}

.confirmation-header i {
    font-size: 48px;
    margin-bottom: 20px;
}

.confirmation-header h1 {
    margin: 0 0 10px;
    font-size: 28px;
}

.confirmation-header p {
    margin: 0;
    font-size: 16px;
    opacity: 0.9;
}

.order-details {
    padding: 30px;
}

.order-details h2 {
    color: #D97B29;
    margin-bottom: 20px;
    border-bottom: 2px solid #F2C078;
    padding-bottom: 10px;
}

.order-info {
    background: #FFF8F0;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #F2C078;
}

.info-row:last-child {
    border-bottom: none;
}

.info-row .label {
    font-weight: 600;
    color: #6B3F1D;
}

.info-row .value {
    color: #333;
}

.status-validee {
    background: #d4edda;
    color: #155724;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
}

.delivery-address {
    background: #FFF8F0;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
}

.delivery-address h3 {
    color: #D97B29;
    margin-bottom: 20px;
}

.address-info {
    display: flex;
    align-items: flex-start;
}

.address-info i {
    font-size: 24px;
    color: #D97B29;
    margin-right: 15px;
    margin-top: 5px;
}

.address-details {
    flex: 1;
}

.recipient-name {
    margin: 0 0 10px 0;
    color: #D97B29;
    font-size: 16px;
}

.address-text {
    margin: 0;
    color: #6B3F1D;
    line-height: 1.5;
}

.products-ordered h3 {
    color: #D97B29;
    margin-bottom: 20px;
}

.product-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.product-item:last-child {
    border-bottom: none;
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

.product-details h4 {
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

.order-total {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #D97B29;
}

.total-line {
    text-align: right;
    font-size: 18px;
    color: #D97B29;
}

.next-steps {
    background: #FFF8F0;
    padding: 20px;
    border-radius: 8px;
    margin: 30px 0;
}

.next-steps h3 {
    color: #D97B29;
    margin-bottom: 15px;
}

.next-steps ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.next-steps li {
    padding: 8px 0;
    color: #6B3F1D;
}

.action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    padding: 30px;
    background: #FFF8F0;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-primary {
    background: #D97B29;
    color: white;
}

.btn-primary:hover {
    background: #A44D25;
    color: white;
}

.btn-secondary {
    background: #6B3F1D;
    color: white;
}

.btn-secondary:hover {
    background: #4A3A2D;
    color: white;
}

.btn-admin {
    background: #6B3F1D;
    color: white;
}

.btn-admin:hover {
    background: #4A3A2D;
    color: white;
}

@media (max-width: 768px) {
    .confirmation-container {
        margin: 10px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .product-item {
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
    }
    
    .product-info {
        margin-bottom: 10px;
    }
}
</style>

<?= $this->include('layouts/footer') ?> 