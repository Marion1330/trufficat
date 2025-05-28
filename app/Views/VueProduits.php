<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/VueProduits.css') ?>">

<h1>Produits pour <?= ucfirst($produits[0]['animal']) ?>s</h1>

<div class="produits">
<?php foreach ($produits as $produit): ?>
    <div class="carte <?= esc($produit['animal']) ?>">
        <?php if (!empty($produit['image'])): ?>
            <img src="<?= base_url(esc($produit['image'])) ?>" alt="<?= esc($produit['nom']) ?>" class="produit-img">
        <?php endif; ?>
        <h2><?= esc($produit['nom']) ?></h2>
        <p class="description"><?= esc($produit['description']) ?></p>
        <p class="prix"><?= number_format($produit['prix'], 2, ',', ' ') ?> €</p>
        <?php if ($produit['stock'] <= 0): ?>
            <p class="rupture-stock">Rupture de stock</p>
        <?php else: ?>
            <p class="stock">En stock</p>
        <?php endif; ?>
        <div class="product-actions">
            <a href="<?= base_url('produits/detail/' . $produit['id']) ?>" class="btn-details">Voir détails</a>
            <button class="btn-add-to-cart" data-product-id="<?= $produit['id'] ?>" <?= $produit['stock'] <= 0 ? 'disabled' : '' ?>>
                <?= $produit['stock'] <= 0 ? 'Indisponible' : 'Ajouter au panier' ?>
            </button>
        </div>
    </div>
<?php endforeach; ?>
</div>

<?= $this->include('layouts/footer') ?>

