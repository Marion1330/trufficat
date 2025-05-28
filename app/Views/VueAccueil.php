<?= $this->include('layouts/header') ?>

<h1 class="titre-accueil">Bienvenue sur Trufficat</h1>
<p class="intro">Votre boutique dédiée aux chiens et chats, tout en douceur.</p>

<!-- 🟧 Nouveau carrousel PUB plein écran -->
<div class="pub-carousel-container">
    <div class="pub-carousel">
        <?php foreach ($publicites as $pub): ?>
            <div class="pub-slide">
                <a href="<?= esc($pub['url'] ?? '#') ?>">
                    <img src="<?= base_url('images/pubs/' . esc($pub['image'])) ?>" alt="<?= esc($pub['alt_text'] ?? 'Publicité') ?>">
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="pub-prev">&#10094;</button>
    <button class="pub-next">&#10095;</button>
</div>

<h2 class="titre-accueil">Produits Vedettes</h2>
<div class="carrousel-container">
    <button class="carrousel-btn left">&#10094;</button>
    <div class="carrousel">
        <?php if (!empty($produitsVedettes)): ?>
            <?php foreach ($produitsVedettes as $produit): ?>
                <div class="product-card <?= esc($produit['animal']) ?>">
                    <a href="<?= base_url('produits/detail/' . $produit['id']) ?>" class="product-link">
                        <div class="product-image">
                            <?php if (!empty($produit['image'])): ?>
                                <img src="<?= base_url(esc($produit['image'])) ?>" alt="<?= esc($produit['nom']) ?>">
                            <?php else: ?>
                                <img src="<?= base_url('images/placeholder.png') ?>" alt="Image non disponible">
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-info">
                            <h2 class="product-title"><?= esc($produit['nom']) ?></h2>
                            
                            <?php if (!empty($produit['marque'])): ?>
                                <p class="product-brand"><?= esc($produit['marque']) ?></p>
                            <?php endif; ?>
                            
                            <p class="product-price">
                                <strong><?= number_format($produit['prix'], 2, ',', ' ') ?> €</strong>
                            </p>
                            <?php if ($produit['stock'] <= 0): ?>
                                <p class="rupture-stock">Rupture de stock</p>
                            <?php else: ?>
                                <p class="stock">En stock</p>
                            <?php endif; ?>
                        </div>
                    </a>
                    
                    <div class="product-actions">
                        <button class="btn-add-to-cart" data-product-id="<?= $produit['id'] ?>" <?= $produit['stock'] <= 0 ? 'disabled' : '' ?>>
                            <?= $produit['stock'] <= 0 ? 'Indisponible' : 'Ajouter au panier' ?>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun produit vedette disponible pour le moment.</p>
        <?php endif; ?>
    </div>
    <button class="carrousel-btn right">&#10095;</button>
</div>

<!-- Section À propos avec image -->
<div class="presentation-section">
    <div class="presentation-content">
        <div class="presentation-image">
            <img src="<?= base_url('images/propos.jpg') ?>" alt="Trufficat - À propos de nous">
        </div>
        <div class="presentation-text">
            <h2>Trufficat, l'essentiel pour chiens et chats en un clic</h2>
            <p>Trufficat vous propose une sélection rigoureuse de produits de qualité pour le bien-être de vos chiens et chats : alimentation, hygiène, accessoires, couchages, jouets, et bien plus encore.</p>
            <p>Notre objectif : vous offrir, en ligne, tout le nécessaire pour prendre soin de vos compagnons au quotidien, avec des articles fiables, adaptés et livrés rapidement.</p>
            <p>Portée par une équipe passionnée, Trufficat s'engage également aux côtés d'acteurs responsables pour le bien-être animal.</p>
            <p>Découvrez notre univers et faites confiance à Trufficat pour combler vos animaux.</p>
        </div>
    </div>
</div>

<script>
// Gestion de l'ajout au panier
document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            
            // Ajouter au panier via AJAX
            fetch('<?= base_url('panier/ajouter') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `produit_id=${productId}&quantite=1`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Rediriger vers le panier après ajout
                    window.location.href = '<?= base_url('panier') ?>';
                } else {
                    console.error('Erreur lors de l\'ajout au panier:', data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    });
});

// Carrousel de publicités
let currentSlide = 0;
const slides = document.querySelectorAll('.pub-slide');
const totalSlides = slides.length;

function showSlide(index) {
    const carousel = document.querySelector('.pub-carousel');
    carousel.style.transform = `translateX(-${index * 100}%)`;
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    showSlide(currentSlide);
}

// Auto-play
setInterval(nextSlide, 5000);

// Boutons de navigation
document.querySelector('.pub-next').addEventListener('click', nextSlide);
document.querySelector('.pub-prev').addEventListener('click', prevSlide);

// Carrousel de produits vedettes
const carrousel = document.querySelector('.carrousel');
const leftBtn = document.querySelector('.carrousel-btn.left');
const rightBtn = document.querySelector('.carrousel-btn.right');

if (carrousel && leftBtn && rightBtn) {
    leftBtn.addEventListener('click', () => {
        carrousel.scrollBy({ left: -300, behavior: 'smooth' });
    });

    rightBtn.addEventListener('click', () => {
        carrousel.scrollBy({ left: 300, behavior: 'smooth' });
    });
}
</script>

<?= $this->include('layouts/footer') ?>

<!-- JavaScript centralisé -->
<script src="<?= base_url('js/carrousel.js') ?>"></script>
</body>
</html>
