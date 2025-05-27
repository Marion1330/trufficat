<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/panier.css') ?>">

<div class="container">
    <h1>Historique de mes commandes</h1>
    
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (empty($commandes)): ?>
        <div class="no-commandes">
            <i class="fas fa-shopping-cart"></i>
            <p>Vous n'avez encore passé aucune commande.</p>
            <a href="<?= base_url('panier') ?>" class="btn btn-primary">Voir mon panier</a>
        </div>
    <?php else: ?>
        <div class="commandes-list">
            <?php foreach ($commandes as $commande): ?>
                <div class="commande-card">
                    <div class="commande-header">
                        <div class="commande-info">
                            <h3>Commande <?= esc($commande['numero_commande'] ?? 'CMD-' . $commande['id']) ?></h3>
                            <p class="commande-date">Passée le <?= date('d/m/Y à H:i', strtotime($commande['date_commande'])) ?></p>
                        </div>
                        <div class="commande-statut">
                            <span class="statut-badge statut-<?= $commande['statut'] ?>">
                                <?php
                                $statuts = [
                                    'en_attente' => 'En attente',
                                    'validee' => 'Validée',
                                    'en_preparation' => 'En préparation',
                                    'expediee' => 'Expédiée',
                                    'livree' => 'Livrée',
                                    'annulee' => 'Annulée'
                                ];
                                echo $statuts[$commande['statut']] ?? $commande['statut'];
                                ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="commande-produits">
                        <?php if (!empty($commande['produits'])): ?>
                            <?php foreach ($commande['produits'] as $produit): ?>
                                <div class="produit-commande">
                                    <img src="<?= base_url($produit['image'] ?: 'images/placeholder.png') ?>" alt="<?= esc($produit['nom']) ?>">
                                    <div class="produit-details">
                                        <h4><?= esc($produit['nom']) ?></h4>
                                        <p class="marque"><?= esc($produit['marque']) ?></p>
                                        <p class="quantite">Quantité: <?= $produit['quantite'] ?></p>
                                    </div>
                                    <div class="produit-prix">
                                        <?= number_format($produit['prix_unitaire'] * $produit['quantite'], 2, ',', ' ') ?> €
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="commande-footer">
                        <div class="commande-total">
                            <strong>Total: <?= number_format($commande['total'], 2, ',', ' ') ?> €</strong>
                        </div>
                        <?php if ($commande['statut'] === 'validee' && !empty($commande['date_paiement'])): ?>
                            <p class="paiement-info">
                                <i class="fas fa-check-circle"></i>
                                Payée le <?= date('d/m/Y à H:i', strtotime($commande['date_paiement'])) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.no-commandes {
    text-align: center;
    padding: 60px 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    margin-top: 20px;
}

.no-commandes i {
    font-size: 48px;
    color: #D97B29;
    margin-bottom: 20px;
}

.no-commandes p {
    font-size: 18px;
    color: #6B3F1D;
    margin-bottom: 20px;
}

.btn {
    display: inline-block;
    padding: 12px 24px;
    background-color: #D97B29;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color: #A44D25;
    color: white;
}

.commandes-list {
    margin-top: 20px;
}

.commande-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    overflow: hidden;
}

.commande-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background-color: #FFF8F0;
    border-bottom: 1px solid #F2C078;
}

.commande-info h3 {
    margin: 0 0 5px;
    color: #D97B29;
    font-size: 18px;
}

.commande-date {
    margin: 0;
    color: #6B3F1D;
    font-size: 14px;
}

.statut-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.statut-en_attente {
    background-color: #fff3cd;
    color: #856404;
}

.statut-validee {
    background-color: #d4edda;
    color: #155724;
}

.statut-en_preparation {
    background-color: #cce5ff;
    color: #004085;
}

.statut-expediee {
    background-color: #cce5ff;
    color: #004085;
}

.statut-livree {
    background-color: #d1ecf1;
    color: #0c5460;
}

.statut-annulee {
    background-color: #f8d7da;
    color: #721c24;
}

.commande-produits {
    padding: 20px;
}

.produit-commande {
    display: flex;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
}

.produit-commande:last-child {
    border-bottom: none;
}

.produit-commande img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
    margin-right: 15px;
}

.produit-details {
    flex: 1;
}

.produit-details h4 {
    margin: 0 0 5px;
    font-size: 16px;
    color: #333;
}

.produit-details .marque {
    color: #D97B29;
    font-size: 14px;
    margin: 0 0 5px;
}

.produit-details .quantite {
    color: #666;
    font-size: 14px;
    margin: 0;
}

.produit-prix {
    font-weight: bold;
    color: #D97B29;
}

.commande-footer {
    padding: 20px;
    background-color: #FFF8F0;
    border-top: 1px solid #F2C078;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.commande-total {
    font-size: 18px;
    color: #D97B29;
}

.paiement-info {
    color: #155724;
    margin: 0;
    font-size: 14px;
}

.paiement-info i {
    margin-right: 5px;
}

.alert {
    padding: 12px 20px;
    margin-bottom: 20px;
    border-radius: 4px;
    font-size: 14px;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

@media (max-width: 768px) {
    .commande-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .commande-footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .produit-commande {
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
    }
    
    .produit-commande img {
        margin-bottom: 10px;
    }
}
</style>

<?= $this->include('layouts/footer') ?> 