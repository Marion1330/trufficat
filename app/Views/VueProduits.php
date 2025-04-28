
<?php include('layouts/header.php'); ?>

<h1>Produits pour <?= ucfirst($produits[0]['animal']) ?>s</h1>

<div class="produits">
<?php foreach ($produits as $produit): ?>
<div class="carte <?= $produit['animal'] ?>">
<?php if (!empty($produit['image'])): ?>
<img src="/images/<?= esc($produit['image']) ?>" alt="<?= esc($produit['nom']) ?>" class="produit-img">
<?php endif; ?>
<h2><?= esc($produit['nom']) ?></h2>
<p><?= esc($produit['description']) ?></p>
</div>
<?php endforeach; ?>
</div>

<?php include('layouts/footer.php'); ?>

