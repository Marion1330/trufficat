<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/historique.css') ?>">

<div class="container">
    <h1 style="text-align: center;">Historique de mes commandes</h1>
    
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
                        <div class="commande-actions">
                            <?php if ($commande['statut'] === 'validee' && !empty($commande['date_paiement'])): ?>
                                <p class="paiement-info">
                                    <i class="fas fa-check-circle"></i>
                                    Payée le <?= date('d/m/Y à H:i', strtotime($commande['date_paiement'])) ?>
                                </p>
                            <?php endif; ?>
                            <a href="<?= base_url('commande/confirmation/' . $commande['id']) ?>" class="btn btn-confirmation">
                                <i class="fas fa-receipt"></i> Voir la confirmation
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</style>

<?= $this->include('layouts/footer') ?> 