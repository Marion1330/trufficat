<?php include(APPPATH . 'Views/layouts/header.php'); ?>

<h1 class="titre-accueil">Bienvenue sur Trufficat</h1>
<p class="intro">Votre boutique dédiée aux chiens et chats, tout en douceur.</p>

<div class="cta-container">
    <a href="/produits/chiens" class="btn">Produits pour Chiens</a>
    <a href="/produits/chats" class="btn">Produits pour Chats</a>
</div>

<div class="produits">
    <?php foreach ($produits as $produit): ?>
        <div class="carte <?= esc($produit['animal']) ?>">
            <?php if (!empty($produit['image'])): ?>
                <img src="/trufficat/public/images/<?= esc($produit['image']) ?>" alt="<?= esc($produit['nom']) ?>" class="produit-img">
            <?php endif; ?>
            <h2><?= esc($produit['nom']) ?></h2>
            <p><?= esc($produit['description']) ?></p>
        </div>
    <?php endforeach; ?>
</div>

<h1>Produits pour <?= ucfirst($produits[0]['animal']) ?>s</h1>

<div class="produits">
<?php foreach ($produits as $produit): ?>
<div class="carte <?= $produit['animal'] ?>">
    <?php if (!empty($produit['image'])): ?>
        <img src="/images/<?= esc($produit['image']) ?>" alt="<?= esc($produit['nom']) ?>" class="produit-img">
    <?php endif; ?>
    <h2><?= esc($produit['nom']) ?></h2>
    <p><?= esc($produit['description']) ?></p>
    <p><strong>Prix:</strong> <?= esc($produit['prix']) ?> €</p>
    <a href="/produit/<?= esc($produit['id']) ?>" class="btn">Voir les détails</a>
</div>
<?php endforeach; ?>
</div>



<?php include(APPPATH . 'Views/layouts/footer.php'); ?>
