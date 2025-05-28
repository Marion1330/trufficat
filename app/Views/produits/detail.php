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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de la quantité
    const quantiteInput = document.getElementById('quantite');
    const quantityBtns = document.querySelectorAll('.quantity-btn');
    
    quantityBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const action = btn.getAttribute('data-action');
            const currentValue = parseInt(quantiteInput.value);
            const maxValue = parseInt(quantiteInput.getAttribute('max'));
            
            if (action === 'increase' && currentValue < maxValue) {
                quantiteInput.value = currentValue + 1;
            } else if (action === 'decrease' && currentValue > 1) {
                quantiteInput.value = currentValue - 1;
            }
        });
    });
    
    // Validation de la saisie manuelle
    quantiteInput.addEventListener('input', function() {
        const value = parseInt(this.value);
        const max = parseInt(this.getAttribute('max'));
        const min = parseInt(this.getAttribute('min'));
        
        if (value > max) {
            this.value = max;
        } else if (value < min || isNaN(value)) {
            this.value = min;
        }
    });
    
    // Gestion de l'ajout au panier
    const addToCartBtn = document.querySelector('.btn-add-to-cart:not(.disabled)');
    if (addToCartBtn) {
        let isAdding = false; // Variable pour empêcher les clics multiples
        
        addToCartBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Empêcher le comportement par défaut
            
            // Si déjà en cours d'ajout, ignorer le clic
            if (isAdding) {
                return;
            }
            
            isAdding = true;
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Ajout en cours...';
            
            const productId = this.dataset.productId;
            const quantite = parseInt(document.getElementById('quantite').value);
            
            // Vérification de la quantité
            if (!quantite || quantite < 1) {
                // Redirection vers le panier même si quantité invalide
                window.location.href = '<?= base_url('index.php/panier') ?>';
                return;
            }
            
            fetch('<?= base_url('index.php/panier/ajouter') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `produit_id=${productId}&quantite=${quantite}`
            })
            .then(response => response.json())
            .then(data => {
                // Redirection vers le panier dans tous les cas
                window.location.href = '<?= base_url('index.php/panier') ?>';
            })
            .catch(error => {
                console.error('Erreur:', error);
                // Redirection vers le panier même en cas d'erreur
                window.location.href = '<?= base_url('index.php/panier') ?>';
            });
        });
    }
});
</script>

<?= $this->include('layouts/footer') ?> 