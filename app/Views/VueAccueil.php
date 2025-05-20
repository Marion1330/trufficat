<?= $this->include('layouts/header') ?>

<h1 class="titre-accueil">Bienvenue sur Trufficat</h1>
<p class="intro">Votre boutique dédiée aux chiens et chats, tout en douceur.</p>

<!-- 🟧 Nouveau carrousel PUB plein écran -->
<div class="pub-carousel-container">
    <div class="pub-carousel">
        <?php foreach ($publicites as $pub): ?>
            <div class="pub-slide">
                <a href="<?= esc($pub['url'] ?? '#') ?>" target="_blank">
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
                                <img src="<?= base_url('images/' . esc($produit['image'])) ?>" alt="<?= esc($produit['nom']) ?>">
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
                        </div>
                    </a>
                    
                    <div class="product-actions">
                        <button class="btn-add-to-cart" data-product-id="<?= $produit['id'] ?>">
                            Ajouter au panier
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

<style>
/* Styles pour le carrousel de produits vedettes */
.carrousel-container {
    position: relative;
    width: 100%;
    max-width: 1200px;
    margin: 30px auto;
    padding: 0 20px;
}

.carrousel {
    display: flex;
    padding: 20px 10px;
    gap: 15px;
    overflow-x: auto;
    scroll-behavior: smooth;
    scrollbar-width: none;
    -webkit-overflow-scrolling: touch;
}

.carrousel::-webkit-scrollbar {
    display: none;
}

.carrousel .product-card {
    flex: 0 0 auto;
    width: 250px;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background-color: white;
}

.carrousel .chien {
    background-color: #FFE8C6;
}

.carrousel .chat {
    background-color: #FDD4B0;
}

.carrousel .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.carrousel .product-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.carrousel .product-image {
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

/* Fond spécifique pour chaque type d'animal dans l'image */
.carrousel .chien .product-image {
    background-color: #FFE8C6;
}

.carrousel .chat .product-image {
    background-color: #FDD4B0;
}

.carrousel .product-image img {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
}

.carrousel .product-info {
    padding: 15px;
}

.carrousel .product-title {
    font-size: 16px;
    margin: 0 0 5px;
    color: #333;
    height: 40px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.carrousel .product-brand {
    font-size: 14px;
    color: #777;
    margin-bottom: 10px;
}

.carrousel .product-price {
    color: #A44D25;
    font-size: 18px;
    margin: 0;
}

.carrousel .product-actions {
    padding: 0 15px 15px;
}

.carrousel .btn-add-to-cart {
    width: 100%;
    padding: 8px 15px;
    background-color: #D97B29;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
}

.carrousel .btn-add-to-cart:hover {
    background-color: #B45B19;
}

/* Styles pour les boutons du carrousel */
.carrousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(242, 192, 120, 0.8);
    color: #4A3A2D;
    border: none;
    padding: 10px 14px;
    cursor: pointer;
    z-index: 10;
    font-size: 22px;
    border-radius: 50%;
    transition: background 0.3s;
}

.carrousel-btn:hover {
    background: rgba(167, 123, 41, 0.9);
}

.carrousel-btn.left {
    left: 10px;
}

.carrousel-btn.right {
    right: 10px;
}

@media (max-width: 768px) {
    .carrousel {
        gap: 10px;
    }
    
    .carrousel .product-card {
        width: 220px;
    }
    
    .carrousel .product-image {
        height: 180px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de l'ajout au panier
    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            
            // Ajouter au panier via AJAX (à implémenter)
            alert('Produit ajouté au panier !');
        });
    });
    
    // Scroll horizontal du carrousel avec les boutons
    const carrousel = document.querySelector('.carrousel');
    const leftBtn = document.querySelector('.carrousel-btn.left');
    const rightBtn = document.querySelector('.carrousel-btn.right');
    
    leftBtn.addEventListener('click', () => {
        carrousel.scrollBy({
            left: -300,
            behavior: 'smooth'
        });
    });
    
    rightBtn.addEventListener('click', () => {
        carrousel.scrollBy({
            left: 300,
            behavior: 'smooth'
        });
    });
});
</script>

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

<!-- JavaScript centralisé -->
<script src="<?= base_url('js/carrousel.js') ?>"></script>
</body>
</html>
