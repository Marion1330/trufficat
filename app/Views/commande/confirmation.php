<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/confirmation.css') ?>">

<div class="confirmation-container">
    <div class="confirmation-header">
        <h1>Commande confirmée !</h1>
        <i class="fas fa-check-circle"></i>
        <p>Merci pour votre commande. Voici les détails de votre achat.</p>
    </div>

    <div class="order-details">
        <h2><i class="fas fa-receipt"></i> Détails de la commande</h2>
        
        <div class="order-info">
            <div class="info-row">
                <span class="label">Numéro de commande :</span>
                <span class="value">#<?= $commande['id'] ?></span>
            </div>
            <div class="info-row">
                <span class="label">Date de commande :</span>
                <span class="value"><?= date('d/m/Y à H:i', strtotime($commande['date_commande'])) ?></span>
            </div>
            <div class="info-row">
                <span class="label">Statut :</span>
                <span class="value status-validee">Validée</span>
            </div>
            <div class="info-row">
                <span class="label">Total :</span>
                <span class="value"><?= number_format($commande['total'], 2, ',', ' ') ?> €</span>
            </div>
        </div>

        <!-- Adresse de livraison -->
        <div class="delivery-address">
            <h3><i class="fas fa-map-marker-alt"></i> Adresse de livraison</h3>
            <div class="address-info">
                <i class="fas fa-home"></i>
                <div class="address-details">
                    <?php if ($adresseDefaut): ?>
                        <p class="recipient-name"><?= esc($adresseDefaut['prenom']) ?> <?= esc($adresseDefaut['nom']) ?></p>
                        <p class="address-text">
                            <?= esc($adresseDefaut['adresse']) ?><br>
                            <?php if (!empty($adresseDefaut['complement'])): ?>
                                <?= esc($adresseDefaut['complement']) ?><br>
                            <?php endif; ?>
                            <?= esc($adresseDefaut['code_postal']) ?> <?= esc($adresseDefaut['ville']) ?><br>
                            <?= esc($adresseDefaut['departement']) ?><?= !empty($adresseDefaut['pays']) ? ', ' . esc($adresseDefaut['pays']) : '' ?>
                        </p>
                        <?php if (!empty($adresseDefaut['telephone'])): ?>
                            <p class="phone">📞 <?= esc($adresseDefaut['telephone']) ?></p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="recipient-name">Adresse non disponible</p>
                        <p class="address-text">Veuillez définir une adresse par défaut dans votre profil.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Produits commandés -->
        <div class="products-ordered">
            <h3><i class="fas fa-box"></i> Produits commandés</h3>
            
            <?php foreach ($produits as $produit): ?>
                <div class="product-item">
                    <div class="product-info">
                        <img src="<?= base_url(esc($produit['image'])) ?>" alt="<?= esc($produit['nom']) ?>">
                        <div class="product-details">
                            <h4><?= esc($produit['nom']) ?></h4>
                            <p class="brand"><?= esc($produit['marque']) ?></p>
                            <p class="quantity">Quantité : <?= $produit['quantite'] ?></p>
                        </div>
                    </div>
                    <div class="product-price">
                        <?= number_format($produit['prix_unitaire'] * $produit['quantite'], 2, ',', ' ') ?> €
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div class="order-total">
                <div class="total-line">
                    <strong>Total : <?= number_format($commande['total'], 2, ',', ' ') ?> €</strong>
                </div>
            </div>
        </div>

        <!-- Prochaines étapes -->
        <div class="next-steps">
            <h3><i class="fas fa-clock"></i> Prochaines étapes</h3>
            <ul>
                <li>📧 Vous recevrez un email de confirmation sous peu</li>
                <li>📦 Votre commande sera préparée dans les 24h</li>
                <li>🚚 Livraison estimée : 2-3 jours ouvrés</li>
            </ul>
        </div>
    </div>

    <div class="action-buttons">
        <?php if (session()->get('role') === 'admin'): ?>
            <a href="<?= base_url('admin') ?>" class="btn btn-admin">
                <i class="fas fa-tachometer-alt"></i> Retour au dashboard admin
            </a>
        <?php else: ?>
            <a href="<?= base_url('commande/historique') ?>" class="btn btn-primary">
                <i class="fas fa-history"></i> Voir mes commandes
            </a>
        <?php endif; ?>
        
        <a href="<?= base_url('/') ?>" class="btn btn-secondary">
            <i class="fas fa-home"></i> Retour à l'accueil
        </a>
    </div>
</div>

<?= $this->include('layouts/footer') ?> 