<?= $this->include('layouts/header') ?>

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
                    <label for="quantity">Quantité:</label>
                    <div class="quantity-controls">
                        <button type="button" class="quantity-btn" data-action="decrease">-</button>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?= $produit['stock'] ?>">
                        <button type="button" class="quantity-btn" data-action="increase">+</button>
                    </div>
                </div>
                
                <button class="add-to-cart-btn" data-product-id="<?= $produit['id'] ?>">
                    Ajouter au panier
                </button>
                <?php else: ?>
                <button class="add-to-cart-btn disabled" disabled>
                    Produit indisponible
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="product-description">
        <h2>Description</h2>
        <?php if (!empty($produit['description'])): ?>
            <p><?= esc($produit['description']) ?></p>
        <?php else: ?>
            <p>Aucune description disponible pour ce produit.</p>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de la quantité
    const quantityInput = document.getElementById('quantity');
    const quantityBtns = document.querySelectorAll('.quantity-btn');
    
    quantityBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const action = btn.getAttribute('data-action');
            const currentValue = parseInt(quantityInput.value);
            
            if (action === 'increase') {
                if (currentValue < parseInt(quantityInput.getAttribute('max'))) {
                    quantityInput.value = currentValue + 1;
                }
            } else if (action === 'decrease') {
                if (currentValue > parseInt(quantityInput.getAttribute('min'))) {
                    quantityInput.value = currentValue - 1;
                }
            }
        });
    });
    
    // Gestion de l'ajout au panier
    const addToCartBtn = document.querySelector('.add-to-cart-btn');
    
    addToCartBtn.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        const quantity = quantityInput.value;
        
        // Ajouter au panier via AJAX (à implémenter)
        alert(`${quantity} produit(s) ajouté(s) au panier !`);
    });
});
</script>

<style>
.product-detail-container {
    max-width: 1200px;
    margin: 30px auto;
    padding: 0 20px;
}

.product-detail {
    display: flex;
    gap: 40px;
    margin-bottom: 40px;
}

.product-images {
    width: 45%;
}

.main-image {
    background-color: #f8f8f8;
    border-radius: 8px;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 400px;
}

.main-image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.product-info {
    width: 55%;
}

.product-title {
    font-size: 24px;
    margin: 0 0 15px;
    color: #333;
}

.product-brand,
.product-age,
.product-flavor {
    margin: 10px 0;
    font-size: 16px;
    color: #555;
}

.product-price-container {
    display: flex;
    align-items: center;
    margin: 20px 0;
}

.product-price {
    font-size: 24px;
    font-weight: bold;
    color: #d9534f;
    margin: 0;
    margin-right: 15px;
}

.rupture-stock {
    color: #ff0000;
    font-weight: bold;
    padding: 5px 10px;
    border-radius: 4px;
    background-color: rgba(255, 0, 0, 0.1);
}

.stock {
    color: #28a745;
    font-weight: bold;
    padding: 5px 10px;
    border-radius: 4px;
    background-color: rgba(40, 167, 69, 0.1);
}

.product-feature {
    display: inline-block;
    background-color: #f0f0f0;
    padding: 5px 10px;
    border-radius: 4px;
    margin-right: 10px;
    font-size: 14px;
    color: #555;
}

.product-buy {
    margin-top: 30px;
}

.quantity-selector {
    margin-bottom: 15px;
}

.quantity-selector label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
}

.quantity-controls {
    display: flex;
    align-items: center;
    width: fit-content;
}

.quantity-btn {
    background-color: #f0f0f0;
    border: 1px solid #ddd;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
}

.quantity-btn:first-child {
    border-radius: 4px 0 0 4px;
}

.quantity-btn:last-child {
    border-radius: 0 4px 4px 0;
}

.quantity-controls input {
    width: 50px;
    height: 30px;
    border: 1px solid #ddd;
    text-align: center;
    font-size: 16px;
    border-left: none;
    border-right: none;
}

.add-to-cart-btn {
    background-color: #4a7a8c;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 12px 25px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
    width: 100%;
    max-width: 300px;
}

.add-to-cart-btn:hover {
    background-color: #3d6a78;
}

.add-to-cart-btn.disabled {
    background-color: #cccccc;
    cursor: not-allowed;
}

.product-description {
    margin-top: 40px;
    padding-top: 30px;
    border-top: 1px solid #e5e5e5;
}

.product-description h2 {
    font-size: 20px;
    margin-bottom: 15px;
    color: #333;
}

.product-description p {
    line-height: 1.6;
    color: #555;
}

@media (max-width: 768px) {
    .product-detail {
        flex-direction: column;
    }
    
    .product-images,
    .product-info {
        width: 100%;
    }
    
    .main-image {
        height: 300px;
    }
}
</style>

<?= $this->include('layouts/footer') ?> 