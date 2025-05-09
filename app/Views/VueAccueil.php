<?php include(APPPATH . 'Views/layouts/header.php'); ?>

<h1 class="titre-accueil">Bienvenue sur Trufficat</h1>
<p class="intro">Votre boutique dédiée aux chiens et chats, tout en douceur.</p>

<!-- 🟧 Nouveau carrousel PUB plein écran -->
<div class="pub-carousel-container">
    <div class="pub-carousel">
        <?php foreach ($publicites as $pub): ?>
            <div class="pub-slide">
                <a href="<?= esc($pub['url'] ?? '#') ?>" target="_blank">
                    <img src="/trufficat/public/images/pubs/<?= esc($pub['image']) ?>" alt="<?= esc($pub['alt_text'] ?? 'Publicité') ?>">
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="pub-prev">&#10094;</button>
    <button class="pub-next">&#10095;</button>
</div>

<h2 class="titre-accueil">Produits Vedettes</h2>
<div class="carrousel-wrapper">
    <button class="carrousel-btn left">&#10094;</button>
    <div class="carrousel">
        <?php if (!empty($produitsVedettes)): ?>
            <?php foreach ($produitsVedettes as $produit): ?>
                <div class="carte <?= esc($produit['animal']) ?>">
                    <?php if (!empty($produit['image'])): ?>
                        <img src="/trufficat/public/images/<?= esc($produit['image']) ?>" alt="<?= esc($produit['nom']) ?>" class="produit-img">
                    <?php endif; ?>
                    <h2><?= esc($produit['nom']) ?></h2>
                    <p><?= esc($produit['description']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun produit vedette disponible pour le moment.</p>
        <?php endif; ?>
    </div>
    <button class="carrousel-btn right">&#10095;</button>
</div>

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

<?php include(APPPATH . 'Views/layouts/footer.php'); ?>

<!-- JavaScript centralisé -->
<script src="/trufficat/public/js/carrousel.js"></script>
</body>
</html>
