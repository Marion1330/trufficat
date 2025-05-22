<?= $this->include('layouts/header') ?>

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

<style>
.carte {
    padding: 20px;
    margin: 15px;
    border-radius: 8px;
    text-align: center;
    transition: transform 0.3s ease;
}

.carte:hover {
    transform: translateY(-5px);
}

.produit-img {
    width: 200px;
    height: 200px;
    object-fit: contain;
    margin-bottom: 15px;
}

.carte h2 {
    font-size: 1.2em;
    margin: 10px 0;
    color: #4A3A2D;
}

.description {
    color: #666;
    margin-bottom: 15px;
    font-size: 0.9em;
}

.prix {
    font-size: 1.3em;
    font-weight: bold;
    color: #D97B29;
    margin: 10px 0;
}

.rupture-stock {
    color: #ff0000;
    font-weight: bold;
    margin: 5px 0;
    font-size: 0.9em;
    background-color: rgba(255, 0, 0, 0.1);
    padding: 5px 10px;
    border-radius: 4px;
    display: inline-block;
}

.stock {
    color: #28a745;
    font-weight: bold;
    margin: 5px 0;
    font-size: 0.9em;
    background-color: rgba(40, 167, 69, 0.1);
    padding: 5px 10px;
    border-radius: 4px;
    display: inline-block;
}

.product-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 15px;
}

.btn-details {
    background-color: #4A7A8C;
    color: white;
    padding: 8px 15px;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.3s;
}

.btn-details:hover {
    background-color: #3d6a78;
}

.btn-add-to-cart {
    background-color: #D97B29;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-add-to-cart:hover {
    background-color: #B45B19;
}

.btn-add-to-cart:disabled {
    background-color: #cccccc;
    cursor: not-allowed;
}

.produits {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    padding: 20px;
}
</style>

<?= $this->include('layouts/footer') ?>

