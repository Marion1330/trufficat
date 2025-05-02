<?php include(APPPATH . 'Views/layouts/header.php'); ?>

<h1 class="titre-accueil">Bienvenue sur Trufficat</h1>
<p class="intro">Votre boutique dédiée aux chiens et chats, tout en douceur.</p>

<div class="cta-container">
    <a href="/produits/chiens" class="btn">Produits pour Chiens</a>
    <a href="/produits/chats" class="btn">Produits pour Chats</a>
</div>
<!-- Carrousel des produits vedettes -->
<h2 class="titre-accueil">Produits Vedettes</h2>

<div class="carrousel-wrapper">
    <button class="carrousel-btn left" id="prevBtn">&#8592;</button>

    <div class="carrousel" id="carrousel">
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

    <button class="carrousel-btn right" id="nextBtn">&#8594;</button>
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

<!-- JavaScript pour le carrousel -->
<script>
    const carrousel = document.querySelector('.carrousel');
    let isMouseDown = false;
    let startX, scrollLeft;

    carrousel.addEventListener('mousedown', (e) => {
        isMouseDown = true;
        startX = e.pageX - carrousel.offsetLeft;
        scrollLeft = carrousel.scrollLeft;
    });

    carrousel.addEventListener('mouseleave', () => {
        isMouseDown = false;
    });

    carrousel.addEventListener('mouseup', () => {
        isMouseDown = false;
    });

    carrousel.addEventListener('mousemove', (e) => {
        if (!isMouseDown) return;
        e.preventDefault();
        const x = e.pageX - carrousel.offsetLeft;
        const walk = (x - startX) * 3; // Ajuste la vitesse du défilement horizontal
        carrousel.scrollLeft = scrollLeft - walk;
    });
</script>
<script src="/trufficat/public/js/carrousel.js"></script>

</body>
</html>
