<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/style-liste.css') ?>">
<div class="produits-container">
    <div class="filters-container">
        <h3>Filtrer les produits</h3>
        
        <form action="" method="get" id="filter-form">
            <!-- Tri des produits -->
            <div class="filter-group">
                <select name="tri" id="tri" class="form-control" onchange="this.form.submit()">
                    <option value="">Trier par</option>
                    <option value="nom_asc" <?= $filtre_tri == 'nom_asc' ? 'selected' : '' ?>>Nom (A-Z)</option>
                    <option value="nom_desc" <?= $filtre_tri == 'nom_desc' ? 'selected' : '' ?>>Nom (Z-A)</option>
                    <option value="prix_asc" <?= $filtre_tri == 'prix_asc' ? 'selected' : '' ?>>Prix (croissant)</option>
                    <option value="prix_desc" <?= $filtre_tri == 'prix_desc' ? 'selected' : '' ?>>Prix (décroissant)</option>
                    <option value="category_asc" <?= $filtre_tri == 'category_asc' ? 'selected' : '' ?>>Catégorie (A-Z)</option>
                    <option value="category_desc" <?= $filtre_tri == 'category_desc' ? 'selected' : '' ?>>Catégorie (Z-A)</option>
                    <option value="brand_asc" <?= $filtre_tri == 'brand_asc' ? 'selected' : '' ?>>Marque (A-Z)</option>
                    <option value="brand_desc" <?= $filtre_tri == 'brand_desc' ? 'selected' : '' ?>>Marque (Z-A)</option>
                    <option value="age_asc" <?= $filtre_tri == 'age_asc' ? 'selected' : '' ?>>Âge (croissant)</option>
                    <option value="age_desc" <?= $filtre_tri == 'age_desc' ? 'selected' : '' ?>>Âge (décroissant)</option>
                    <option value="flavor_asc" <?= $filtre_tri == 'flavor_asc' ? 'selected' : '' ?>>Saveur (A-Z)</option>
                    <option value="flavor_desc" <?= $filtre_tri == 'flavor_desc' ? 'selected' : '' ?>>Saveur (Z-A)</option>
                </select>
            </div>
            
            <!-- Filtre par marque -->
            <div class="filter-group">
                <h4><?= $animal == 'chat' ? 'Marques' : ' Marques' ?></h4>
                <div class="filter-options">
                    <div class="filter-option">
                        <input type="radio" id="marque_all" name="marque" value="" <?= empty($filtre_marque) ? 'checked' : '' ?> onchange="this.form.submit()">
                        <label for="marque_all">Toutes les marques</label>
                    </div>
                    
                    <?php 
                    // Marques spécifiques pour chaque animal
                    $marques_chats = [
                        'Royal Canin',
                        'Purina',
                        'True Origins Wild',
                        'Sheba',
                        'CATXTREME',
                        'Nutriva Nature Plus',
                        'Edgard & Cooper',
                        'Animalis',
                        'Leeby',
                        'Ferplast',
                        'Beaphar',
                        'Paradisio',
                        'Bobby',
                        'Trixie',
                        'Turgo',
                        'Flexi',
                        'Gotoo',
                        'Nath Veterinary Diet',
                        'Yarrah',
                        'Weenect'
                    ];
                    
                    $marques_chiens = [
                        'Royal Canin',
                        'Purina',
                        'True Origins Wild',
                        'Nutriva Nature Plus',
                        'Edgard & Cooper',
                        'Animalis',
                        'Leeby',
                        'Ferplast',
                        'Beaphar',
                        'Paradisio',
                        'Bobby',
                        'Trixie',
                        'Turgo',
                        'Flexi',
                        'Gotoo',
                        'Nath Veterinary Diet',
                        'Yarrah',
                        'Weenect'
                    ];
                    
                    // Sélection des marques selon l'animal
                    $marques_affichees = ($animal == 'chat') ? $marques_chats : $marques_chiens;
                    
                    foreach ($marques_affichees as $marque): 
                    ?>
                        <div class="filter-option">
                            <input type="radio" id="marque_<?= esc(str_replace(' ', '_', $marque)) ?>" name="marque" value="<?= esc($marque) ?>" <?= $filtre_marque == $marque ? 'checked' : '' ?> onchange="this.form.submit()">
                            <label for="marque_<?= esc(str_replace(' ', '_', $marque)) ?>"><?= esc($marque) ?></label>
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
            
            <!-- Filtre pour besoins spécifiques -->
            <div class="filter-group">
                <h4>Besoins spécifiques</h4>
                <div class="filter-options">
                    <div class="filter-option">
                        <input type="radio" id="besoin_sterilise" name="besoin" value="sterilise" <?= $filtre_besoin == 'sterilise' ? 'checked' : '' ?> onchange="this.form.submit()">
                        <label for="besoin_sterilise"><?= $animal == 'chat' ? 'Chat stérilisé' : 'Chien stérilisé' ?></label>
                    </div>
                    
                    <div class="filter-option">
                        <input type="radio" id="besoin_sans_cereales" name="besoin" value="sans_cereales" <?= $filtre_besoin == 'sans_cereales' ? 'checked' : '' ?> onchange="this.form.submit()">
                        <label for="besoin_sans_cereales">Alimentation sans céréales</label>
                    </div>

                    <div class="filter-option">
                        <input type="radio" id="besoin_bio" name="besoin" value="bio" <?= $filtre_besoin == 'bio' ? 'checked' : '' ?> onchange="this.form.submit()">
                        <label for="besoin_bio">Alimentation bio</label>
                    </div>

                    <div class="filter-option">
                        <input type="radio" id="besoin_aucun" name="besoin" value="" <?= empty($filtre_besoin) ? 'checked' : '' ?> onchange="this.form.submit()">
                        <label for="besoin_aucun">Aucun filtre</label>
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
                            <span id="price-max-display"><?= $max_price ?> €</span>
                        </div>
                        <div class="range-slider">
                            <input type="range" id="price-min-slider" min="0" max="<?= $max_price ?>" step="1" value="<?= $filtre_prix_min ?: 0 ?>">
                            <input type="range" id="price-max-slider" min="0" max="<?= $max_price ?>" step="1" value="<?= $filtre_prix_max ?: $max_price ?>">
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

<script src="<?= base_url('js/produits-liste.js') ?>"></script>
<?= $this->include('layouts/footer') ?> 