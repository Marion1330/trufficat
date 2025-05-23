<?= $this->include('layouts/header') ?>

<div class="produits-container">
    <div class="filters-container">
        <h3>Filtrer les produits</h3>
        
        <form action="" method="get" id="filter-form">
            <!-- Tri des produits -->
            <div class="filter-group">
                <label for="tri">Trier par :</label>
                <select name="tri" id="tri" class="form-control" onchange="this.form.submit()">
                    <option value="">Trier par</option>
                    <option value="prix_asc" <?= $filtre_tri == 'prix_asc' ? 'selected' : '' ?>>Prix croissant</option>
                    <option value="prix_desc" <?= $filtre_tri == 'prix_desc' ? 'selected' : '' ?>>Prix décroissant</option>
                    <option value="nom_asc" <?= $filtre_tri == 'nom_asc' ? 'selected' : '' ?>>Nom (A-Z)</option>
                </select>
            </div>
            
            <!-- Filtre par marque -->
            <div class="filter-group">
                <h4><?= $animal == 'chat' ? '🐱 Marques pour chats' : '🐶 Marques pour chiens' ?></h4>
                <div class="filter-options">
                    <div class="filter-option">
                        <input type="radio" id="marque_all" name="marque" value="" <?= empty($filtre_marque) ? 'checked' : '' ?> onchange="this.form.submit()">
                        <label for="marque_all">Toutes les marques</label>
                    </div>
                    
                    <?php 
                    // Marques spécifiques pour chaque animal
                    $marques_chats = ['Purina', 'Sheba', 'Royal Canin', 'Hill\'s Science Plan', 'Almo Nature', 'Edgard & Cooper', 'Carnilove', 'Ultima', 'Perfect Fit'];
                    $marques_chiens = ['Purina', 'Royal Canin', 'Pedigree', 'Hill\'s Science Plan', 'Eukanuba', 'Edgard & Cooper', 'Frolic', 'Carnilove', 'Orijen', 'Acana'];
                    
                    // Sélection des marques selon l'animal
                    $marques_affichees = ($animal == 'chat') ? $marques_chats : $marques_chiens;
                    
                    foreach ($marques_affichees as $marque): 
                    ?>
                        <div class="filter-option">
                            <input type="radio" id="marque_<?= esc($marque) ?>" name="marque" value="<?= esc($marque) ?>" <?= $filtre_marque == $marque ? 'checked' : '' ?> onchange="this.form.submit()">
                            <label for="marque_<?= esc($marque) ?>"><?= esc($marque) ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Filtre par âge -->
            <div class="filter-group">
                <h4>Âge</h4>
                <div class="filter-options">
                    <div class="filter-option">
                        <input type="radio" id="age_all" name="age" value="" <?= empty($filtre_age) ? 'checked' : '' ?> onchange="this.form.submit()">
                        <label for="age_all">Tout âge</label>
                    </div>
                    
                    <?php
                    // Options d'âge selon l'animal
                    if ($animal == 'chat'): ?>
                        <div class="filter-option">
                            <input type="radio" id="age_junior" name="age" value="junior" <?= $filtre_age == 'junior' ? 'checked' : '' ?> onchange="this.form.submit()">
                            <label for="age_junior">Chaton</label>
                        </div>
                        <div class="filter-option">
                            <input type="radio" id="age_adulte" name="age" value="adulte" <?= $filtre_age == 'adulte' ? 'checked' : '' ?> onchange="this.form.submit()">
                            <label for="age_adulte">Adulte</label>
                        </div>
                        <div class="filter-option">
                            <input type="radio" id="age_senior" name="age" value="senior" <?= $filtre_age == 'senior' ? 'checked' : '' ?> onchange="this.form.submit()">
                            <label for="age_senior">Senior</label>
                        </div>
                    <?php else: ?>
                        <div class="filter-option">
                            <input type="radio" id="age_junior" name="age" value="junior" <?= $filtre_age == 'junior' ? 'checked' : '' ?> onchange="this.form.submit()">
                            <label for="age_junior">Chiot</label>
                        </div>
                        <div class="filter-option">
                            <input type="radio" id="age_adulte" name="age" value="adulte" <?= $filtre_age == 'adulte' ? 'checked' : '' ?> onchange="this.form.submit()">
                            <label for="age_adulte">Adulte</label>
                        </div>
                        <div class="filter-option">
                            <input type="radio" id="age_senior" name="age" value="senior" <?= $filtre_age == 'senior' ? 'checked' : '' ?> onchange="this.form.submit()">
                            <label for="age_senior">Senior</label>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Filtre par saveur -->
            <div class="filter-group">
                <h4>Saveur</h4>
                <div class="filter-options">
                    <div class="filter-option">
                        <input type="radio" id="saveur_all" name="saveur" value="" <?= empty($filtre_saveur) ? 'checked' : '' ?> onchange="this.form.submit()">
                        <label for="saveur_all">Toutes les saveurs</label>
                    </div>
                    
                    <?php
                    // Saveurs principales
                    $saveurs = ['Poulet', 'Boeuf', 'Saumon'];
                    
                    foreach ($saveurs as $saveur): 
                    ?>
                        <div class="filter-option">
                            <input type="radio" id="saveur_<?= esc($saveur) ?>" name="saveur" value="<?= esc($saveur) ?>" <?= $filtre_saveur == $saveur ? 'checked' : '' ?> onchange="this.form.submit()">
                            <label for="saveur_<?= esc($saveur) ?>"><?= esc($saveur) ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Filtre pour animal stérilisé -->
            <div class="filter-group">
                <h4>Besoins spécifiques</h4>
                <div class="filter-options">
                    <div class="filter-option">
                        <input type="checkbox" id="sterilise" name="sterilise" value="1" <?= $filtre_sterilise ? 'checked' : '' ?> onchange="this.form.submit()">
                        <label for="sterilise"><?= $animal == 'chat' ? 'Chat' : 'Chien' ?> stérilisé</label>
                    </div>
                    
                    <div class="filter-option">
                        <input type="checkbox" id="sans_cereales" name="sans_cereales" value="1" <?= $filtre_sans_cereales ? 'checked' : '' ?> onchange="this.form.submit()">
                        <label for="sans_cereales">Sans céréales</label>
                    </div>
                </div>
            </div>
            
            <!-- Filtre par prix avec slider -->
            <div class="filter-group">
                <h4>Prix</h4>
                <div class="price-filter">
                    <div class="price-slider-container">
                        <div class="price-values">
                            <span id="price-min-display">0 €</span>
                            <span id="price-max-display">100 €</span>
                        </div>
                        <div class="range-slider">
                            <input type="range" id="price-min-slider" min="0" max="100" step="1" value="<?= $filtre_prix_min ?: 0 ?>">
                            <input type="range" id="price-max-slider" min="0" max="100" step="1" value="<?= $filtre_prix_max ?: 100 ?>">
                        </div>
                    </div>
                    <input type="hidden" name="prix_min" id="prix_min" value="<?= $filtre_prix_min ?>">
                    <input type="hidden" name="prix_max" id="prix_max" value="<?= $filtre_prix_max ?>">
                    <button type="submit" class="btn-filter">Appliquer les filtres</button>
                </div>
            </div>
            
            <!-- Bouton pour réinitialiser les filtres -->
            <div class="filter-actions">
                <a href="<?= current_url() ?>" class="btn-reset-filter">Réinitialiser les filtres</a>
            </div>
        </form>
    </div>
    
    <div class="products-list">
        <h1>
            <?php if (!empty($categorie)): ?>
                <?= ucfirst($categorie) ?> pour <?= $animal == 'chat' ? 'chats' : 'chiens' ?>
            <?php else: ?>
                Produits pour <?= $animal == 'chat' ? 'chats' : 'chiens' ?>
            <?php endif; ?>
        </h1>
        
        <div class="product-count">
            <?= $pagination['total_produits'] ?> produit(s) trouvé(s)
        </div>
        
        <?php if (empty($produits)): ?>
            <div class="no-products">
                <p>Aucun produit ne correspond à vos critères.</p>
            </div>
        <?php else: ?>
            <div class="products-grid">
                <?php foreach ($produits as $produit): ?>
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
            </div>
            
            <!-- Pagination -->
            <?php if ($pagination['total_pages'] > 1): ?>
                <div class="pagination">
                    <?php
                    // Construire la requête de base pour les liens
                    $baseQuery = '';
                    foreach ($pagination['query_params'] as $key => $value) {
                        $baseQuery .= "&{$key}=" . urlencode($value);
                    }
                    ?>
                    
                    <?php if ($pagination['has_previous']): ?>
                        <a href="?page=<?= $pagination['page'] - 1 . $baseQuery ?>" class="pagination-arrow">
                            <i class="fas fa-chevron-left"></i> Précédent
                        </a>
                    <?php else: ?>
                        <span class="pagination-arrow disabled">
                            <i class="fas fa-chevron-left"></i> Précédent
                        </span>
                    <?php endif; ?>
                    
                    <div class="pagination-numbers">
                        <?php 
                        // Déterminer la plage de pages à afficher
                        $startPage = max(1, $pagination['page'] - 2);
                        $endPage = min($pagination['total_pages'], $pagination['page'] + 2);
                        
                        // Afficher toujours la première page
                        if ($startPage > 1) {
                            echo '<a href="?page=1' . $baseQuery . '" class="pagination-number">1</a>';
                            if ($startPage > 2) {
                                echo '<span class="pagination-ellipsis">...</span>';
                            }
                        }
                        
                        // Afficher les pages centrales
                        for ($i = $startPage; $i <= $endPage; $i++) {
                            if ($i == $pagination['page']) {
                                echo '<span class="pagination-number active">' . $i . '</span>';
                            } else {
                                echo '<a href="?page=' . $i . $baseQuery . '" class="pagination-number">' . $i . '</a>';
                            }
                        }
                        
                        // Afficher toujours la dernière page
                        if ($endPage < $pagination['total_pages']) {
                            if ($endPage < $pagination['total_pages'] - 1) {
                                echo '<span class="pagination-ellipsis">...</span>';
                            }
                            echo '<a href="?page=' . $pagination['total_pages'] . $baseQuery . '" class="pagination-number">' . $pagination['total_pages'] . '</a>';
                        }
                        ?>
                    </div>
                    
                    <?php if ($pagination['has_next']): ?>
                        <a href="?page=<?= $pagination['page'] + 1 . $baseQuery ?>" class="pagination-arrow">
                            Suivant <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php else: ?>
                        <span class="pagination-arrow disabled">
                            Suivant <i class="fas fa-chevron-right"></i>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

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
    
    // Gestion du slider de prix
    const minSlider = document.getElementById('price-min-slider');
    const maxSlider = document.getElementById('price-max-slider');
    const minDisplay = document.getElementById('price-min-display');
    const maxDisplay = document.getElementById('price-max-display');
    const minInput = document.getElementById('prix_min');
    const maxInput = document.getElementById('prix_max');
    
    // Initialiser l'affichage du prix
    minDisplay.textContent = minSlider.value + ' €';
    maxDisplay.textContent = maxSlider.value + ' €';
    
    // Fonction pour mettre à jour les valeurs
    function updateValues() {
        // Assurer que min ne dépasse pas max
        if (parseInt(minSlider.value) > parseInt(maxSlider.value)) {
            minSlider.value = maxSlider.value;
        }
        
        // Mettre à jour l'affichage et les inputs cachés
        minDisplay.textContent = minSlider.value + ' €';
        maxDisplay.textContent = maxSlider.value + ' €';
        minInput.value = minSlider.value;
        maxInput.value = maxSlider.value;
    }
    
    // Événements pour les sliders
    minSlider.addEventListener('input', updateValues);
    maxSlider.addEventListener('input', updateValues);
});
</script>

<style>
.produits-container {
    display: flex;
    gap: 30px;
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.filters-container {
    width: 280px;
    flex-shrink: 0;
    padding: 20px;
    background-color: #f8f8f8;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.products-list {
    flex-grow: 1;
}

.filter-group {
    margin-bottom: 20px;
    border-bottom: 1px solid #e5e5e5;
    padding-bottom: 15px;
}

.filter-group h4 {
    margin-bottom: 10px;
    font-size: 16px;
    color: #333;
}

.filter-options {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.filter-option {
    display: flex;
    align-items: center;
    gap: 8px;
}

.filter-option label {
    cursor: pointer;
    font-size: 14px;
}

.price-filter {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Styles pour le slider de prix */
.price-slider-container {
    width: 100%;
    margin-bottom: 15px;
}

.price-values {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 14px;
    color: #555;
}

.range-slider {
    position: relative;
    height: 5px;
    background: #ddd;
    border-radius: 5px;
    margin: 15px 0;
}

.range-slider input[type="range"] {
    position: absolute;
    width: 100%;
    height: 5px;
    top: 0;
    background: none;
    pointer-events: none;
    -webkit-appearance: none;
    margin: 0;
}

.range-slider input[type="range"]::-webkit-slider-thumb {
    height: 18px;
    width: 18px;
    border-radius: 50%;
    background: #4a7a8c;
    cursor: pointer;
    pointer-events: auto;
    -webkit-appearance: none;
}

.range-slider input[type="range"]::-moz-range-thumb {
    height: 18px;
    width: 18px;
    border-radius: 50%;
    background: #4a7a8c;
    cursor: pointer;
    pointer-events: auto;
    border: none;
}

.btn-filter {
    padding: 8px 15px;
    background-color: #4a7a8c;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    width: 100%;
}

.btn-reset-filter {
    display: inline-block;
    font-size: 14px;
    color: #4a7a8c;
    text-decoration: none;
    margin-top: 10px;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.product-card {
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background-color: white;
}

/* Styles spécifiques selon le type d'animal */
.product-card.chien {
    background-color: #FFE8C6;
}

.product-card.chat {
    background-color: #FDD4B0;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.product-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.product-image {
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

/* Fond spécifique pour chaque type d'animal dans l'image */
.chien .product-image {
    background-color: #FFE8C6;
}

.chat .product-image {
    background-color: #FDD4B0;
}

.product-image img {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
}

.product-info {
    padding: 15px;
}

.product-title {
    font-size: 16px;
    margin: 0 0 5px;
    color: #333;
    height: 40px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.product-brand {
    font-size: 14px;
    color: #777;
    margin-bottom: 10px;
}

.product-price {
    color: #A44D25;
    font-size: 18px;
    margin: 0;
}

.product-actions {
    padding: 0 15px 15px;
}

.btn-add-to-cart {
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

.btn-add-to-cart:hover {
    background-color: #B45B19;
}

.no-products {
    padding: 20px;
    text-align: center;
    background-color: #f8f8f8;
    border-radius: 8px;
    margin-top: 20px;
}

@media (max-width: 768px) {
    .produits-container {
        flex-direction: column;
    }
    
    .filters-container {
        width: 100%;
    }
}

/* Styles pour la pagination */
.product-count {
    margin: 10px 0 20px;
    font-size: 14px;
    color: #666;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 30px;
    padding: 15px 0;
    border-top: 1px solid #e5e5e5;
}

.pagination-arrow {
    padding: 8px 15px;
    background-color: #f8f8f8;
    border: 1px solid #ddd;
    border-radius: 4px;
    color: #4a7a8c;
    text-decoration: none;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: background-color 0.3s;
}

.pagination-arrow:hover {
    background-color: #e8e8e8;
}

.pagination-arrow.disabled {
    color: #aaa;
    background-color: #f5f5f5;
    cursor: not-allowed;
}

.pagination-numbers {
    display: flex;
    align-items: center;
    margin: 0 15px;
}

.pagination-number {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 5px;
    border-radius: 4px;
    text-decoration: none;
    color: #333;
    background-color: #f8f8f8;
    border: 1px solid #ddd;
    transition: all 0.3s;
}

.pagination-number:hover {
    background-color: #e8e8e8;
}

.pagination-number.active {
    background-color: #4a7a8c;
    color: white;
    border-color: #4a7a8c;
}

.pagination-ellipsis {
    margin: 0 5px;
    color: #666;
}
</style>

<?= $this->include('layouts/footer') ?> 