<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/detail.css') ?>">

<div class="product-detail-container">
    <div class="product-detail">
        <div class="product-images">
            <div class="main-image">
                <?php if (!empty($produit['image'])): ?>
                    <img src="<?= base_url(esc($produit['image'])) ?>" alt="<?= esc($produit['nom']) ?>">
                <?php else: ?>
                    <img src="<?= base_url('images/placeholder.png') ?>" alt="Image non disponible">
                <?php endif; ?>
            </div>
        </div>
        
        <div class="product-info">
            <h1 class="product-title"><?= esc($produit['nom']) ?></h1>
            
            <?php if (!empty($produit['marque'])): ?>
                <p class="product-brand">Marque : <strong><?= esc($produit['marque']) ?></strong></p>
            <?php endif; ?>
            
            <?php if (!empty($produit['age'])): ?>
                <p class="product-age">
                    Âge : 
                    <strong>
                        <?php 
                        $label = $produit['age'];
                        if ($produit['animal'] == 'chat' && $produit['age'] == 'junior') {
                            $label = 'Chaton';
                        } elseif ($produit['animal'] == 'chat' && $produit['age'] == 'adulte') {
                            $label = 'Chat adulte';
                        } elseif ($produit['animal'] == 'chat' && $produit['age'] == 'senior') {
                            $label = 'Chat senior';
                        } elseif ($produit['animal'] == 'chien' && $produit['age'] == 'junior') {
                            $label = 'Chiot';
                        } elseif ($produit['animal'] == 'chien' && $produit['age'] == 'adulte') {
                            $label = 'Chien adulte';
                        } elseif ($produit['animal'] == 'chien' && $produit['age'] == 'senior') {
                            $label = 'Chien senior';
                        }
                        echo esc($label);
                        ?>
                    </strong>
                </p>
            <?php endif; ?>
            
            <div class="product-price-container">
                <p class="product-price"><?= number_format($produit['prix'], 2, ',', ' ') ?> €</p>
                <?php if ($produit['stock'] <= 0): ?>
                    <p class="rupture-stock">Rupture de stock</p>
                <?php else: ?>
                    <p class="stock">En stock (<?= $produit['stock'] ?> disponibles)</p>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($produit['saveur'])): ?>
                <p class="product-flavor">Saveur : <strong><?= esc($produit['saveur']) ?></strong></p>
            <?php endif; ?>
            
            <?php if (isset($produit['sans_cereales']) && $produit['sans_cereales']): ?>
                <p class="product-feature">Sans céréales</p>
            <?php endif; ?>
            
            <?php if (isset($produit['sterilise']) && $produit['sterilise']): ?>
                <p class="product-feature">Spécial <?= $produit['animal'] == 'chat' ? 'chat' : 'chien' ?> stérilisé</p>
            <?php endif; ?>
            
            <div class="product-buy">
                <?php if ($produit['stock'] > 0): ?>
                <div class="quantity-selector">
                    <label for="quantite">Quantité :</label>
                    <div class="quantity-controls">
                        <button type="button" class="quantity-btn" data-action="decrease">-</button>
                        <input type="number" id="quantite" name="quantite" value="1" min="1" max="<?= $produit['stock'] ?>" class="quantity-input">
                        <button type="button" class="quantity-btn" data-action="increase">+</button>
                    </div>
                </div>
                
                <button class="btn-add-to-cart" data-product-id="<?= $produit['id'] ?>">
                    <i class="fas fa-shopping-cart"></i> Ajouter au panier
                </button>
                <?php else: ?>
                <button class="btn-add-to-cart disabled" disabled>
                    Produit indisponible
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="product-description">
        <h2>Description</h2>
        <?php if (!empty($produit['description'])): ?>
            <p><?= nl2br(esc($produit['description'])) ?></p>
        <?php else: ?>
            <p>Aucune description disponible pour ce produit.</p>
        <?php endif; ?>
    </div>
</div>

<script src="<?= base_url('js/produit-detail.js') ?>"></script>
<script>
// Initialiser le produit detail avec la configuration
window.TrufficatProduitDetail.init({
    addToCartUrl: '<?= base_url('index.php/panier/ajouter') ?>',
    panierUrl: '<?= base_url('index.php/panier') ?>'
});
</script>

<?= $this->include('layouts/footer') ?> 