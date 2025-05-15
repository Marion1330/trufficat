<?= $this->include('layouts/header') ?>

<h1>Produits pour <?= ucfirst($produits[0]['animal']) ?>s</h1>

<div class="produits">
<?php foreach ($produits as $produit): ?>
<div class="carte <?= esc($produit['animal']) ?>">
<?php if (!empty($produit['image'])): ?>
<img src="<?= base_url('images/' . esc($produit['image'])) ?>" alt="<?= esc($produit['nom']) ?>" class="produit-img">
<?php endif; ?>
<h2><?= esc($produit['nom']) ?></h2>
<p><?= esc($produit['description']) ?></p>
</div>
<?php endforeach; ?>
</div>

<?= $this->include('layouts/footer') ?>

