<?php include(APPPATH . 'Views/layouts/header.php'); ?>

<h1 class="titre-accueil">Bienvenue sur Trufficat</h1>
<p class="intro">Votre boutique dédiée aux chiens et chats, tout en douceur.</p>

<div class="cta-container">
    <a href="/produits/chiens" class="btn">Produits pour Chiens</a>
    <a href="/produits/chats" class="btn">Produits pour Chats</a>
</div>

<h2 class="titre-accueil">Publicités</h2>
<div class="carrousel-wrapper pub-carousel">
    <button class="carrousel-btn left">&#10094;</button>
    <div class="carrousel">
        <?php if (!empty($publicites)): ?>
            <?php foreach ($publicites as $pub): ?>
                <div class="carte pub">
                    <a href="<?= esc($pub['url'] ?? '#') ?>" target="_blank">
                    <img src="/trufficat/public/images/pubs/<?= esc($pub['image']) ?>" 
     alt="<?= esc($pub['alt_text'] ?? 'Publicité') ?>" 
     class="produit-img">
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune publicité disponible pour le moment.</p>
        <?php endif; ?>
    </div>
    <button class="carrousel-btn right">&#10095;</button>
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

<!-- JavaScript pour les carrousels -->
<script>
    // Carrousel général (produits et pub)
    document.addEventListener('DOMContentLoaded', () => {
        const carrousels = document.querySelectorAll('.carrousel');
        const scrollAmount = 270;

        carrousels.forEach(carrousel => {
            const btnLeft = carrousel.closest('.carrousel-wrapper').querySelector('.carrousel-btn.left');
            const btnRight = carrousel.closest('.carrousel-wrapper').querySelector('.carrousel-btn.right');

            btnLeft.addEventListener('click', () => {
                carrousel.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            });

            btnRight.addEventListener('click', () => {
                carrousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });

            let isMouseDown = false;
            let startX, scrollLeft;

            carrousel.addEventListener('mousedown', (e) => {
                isMouseDown = true;
                startX = e.pageX - carrousel.offsetLeft;
                scrollLeft = carrousel.scrollLeft;
            });

            carrousel.addEventListener('mouseup', () => {
                isMouseDown = false;
            });

            carrousel.addEventListener('mousemove', (e) => {
                if (!isMouseDown) return;
                e.preventDefault();
                const x = e.pageX - carrousel.offsetLeft;
                const walk = (x - startX) * 3;
                carrousel.scrollLeft = scrollLeft - walk;
            });
        });
    });
</script>
<script src="/trufficat/public/js/carrousel.js"></script>

</body>
</html>
