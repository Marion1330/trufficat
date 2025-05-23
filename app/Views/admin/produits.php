<?= $this->include('layouts/header') ?>

<div class="admin-container">
    <div class="admin-sidebar">
        <div class="admin-profile">
            <img src="<?= base_url('images/admin_avatar.png') ?>" alt="Admin" class="admin-avatar" onerror="this.src='<?= base_url('images/placeholder.png') ?>'">
            <h3>Administrateur</h3>
            <p><?= session('email') ?? 'admin@trufficat.com' ?></p>
        </div>
        
        <nav class="admin-nav">
            <ul>
                <li><a href="<?= base_url('admin') ?>"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a></li>
                <li class="active"><a href="<?= base_url('admin/produits') ?>"><i class="fas fa-box-open"></i> Produits</a></li>
                <li><a href="<?= base_url('admin/clients') ?>"><i class="fas fa-users"></i> Clients</a></li>
                <li><a href="<?= base_url('admin/commandes') ?>"><i class="fas fa-shopping-cart"></i> Commandes</a></li>
                <li><a href="<?= base_url('admin/categories') ?>"><i class="fas fa-tags"></i> Catégories</a></li>
                <li><a href="<?= base_url('admin/parametres') ?>"><i class="fas fa-cog"></i> Paramètres</a></li>
            </ul>
        </nav>
    </div>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1><i class="fas fa-box-open"></i> Gestion des produits</h1>
            <div class="admin-actions">
                <form action="" method="get" class="search-form" onsubmit="return false;">
                    <input type="text" placeholder="Rechercher un produit..." name="search" id="searchInput">
                    <button type="button"><i class="fas fa-search"></i></button>
                </form>
                <a href="<?= base_url('admin/produit/ajouter') ?>" class="admin-btn"><i class="fas fa-plus-circle"></i> Ajouter un produit</a>
            </div>
        </div>
        
        <div class="admin-filters">
            <div class="filter-group">
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">Tous</button>
                    <button class="filter-btn" data-filter="chien">Chiens</button>
                    <button class="filter-btn" data-filter="chat">Chats</button>
                </div>
                <div class="scroll-indicator">
                    <div class="scroll-track">
                        <div class="scroll-thumb"></div>
                    </div>
                </div>
            </div>
            
            <select class="sort-select">
                <option value="">Trier par</option>
                <option value="name_asc">Nom (A-Z)</option>
                <option value="name_desc">Nom (Z-A)</option>
                <option value="price_asc">Prix (croissant)</option>
                <option value="price_desc">Prix (décroissant)</option>
                <option value="stock_asc">Stock (croissant)</option>
                <option value="stock_desc">Stock (décroissant)</option>
                <option value="category_asc">Catégorie (A-Z)</option>
                <option value="category_desc">Catégorie (Z-A)</option>
                <option value="brand_asc">Marque (A-Z)</option>
                <option value="brand_desc">Marque (Z-A)</option>
                <option value="age_asc">Âge (croissant)</option>
                <option value="age_desc">Âge (décroissant)</option>
                <option value="flavor_asc">Saveur (A-Z)</option>
                <option value="flavor_desc">Saveur (Z-A)</option>
                <option value="featured_asc">Vedette (Non → Oui)</option>
                <option value="featured_desc">Vedette (Oui → Non)</option>
            </select>
        </div>

        <?php if (empty($produits)): ?>
            <div class="no-products">
                <i class="fas fa-box-open"></i>
                <p>Aucun produit n'a été trouvé.</p>
                <a href="<?= base_url('admin/produit/ajouter') ?>" class="admin-btn">Ajouter un produit</a>
            </div>
        <?php else: ?>
            <div class="table-scroll-hint">
                <i class="fas fa-arrows-alt-h"></i> Faites défiler horizontalement pour voir toutes les colonnes
            </div>
            <div class="products-table-wrapper">
                <table class="products-table">
                    <thead>
                        <tr>
                            <th class="th-image">Image</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th class="th-price">Prix</th>
                            <th class="th-stock">Stock</th>
                            <th class="th-animal">Animal</th>
                            <th class="th-category">Catégorie</th>
                            <th class="th-brand">Marque</th>
                            <th class="th-age">Âge</th>
                            <th class="th-flavor">Saveur</th>
                            <th class="th-featured">Vedette</th>
                            <th class="th-dates">Dates</th>
                            <th class="th-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produits as $produit): ?>
                            <tr class="product-row <?= esc($produit['animal']) ?>">
                                <td class="td-image">
                                    <?php if (!empty($produit['image'])): ?>
                                        <img src="<?= base_url(esc($produit['image'])) ?>" alt="<?= esc($produit['nom']) ?>" class="product-thumbnail">
                                    <?php else: ?>
                                        <div class="no-image"><i class="fas fa-image"></i></div>
                                    <?php endif; ?>
                                </td>
                                <td class="td-name"><?= esc($produit['nom']) ?></td>
                                <td class="td-description"><?= substr(esc($produit['description']), 0, 100) . (strlen($produit['description']) > 100 ? '...' : '') ?></td>
                                <td class="td-price"><?= isset($produit['prix']) ? number_format($produit['prix'], 2, ',', ' ') . ' €' : 'N/A' ?></td>
                                <td class="td-stock">
                                    <span class="stock-badge <?= $produit['stock'] <= 0 ? 'rupture' : 'disponible' ?>">
                                        <?= $produit['stock'] <= 0 ? 'Rupture' : $produit['stock'] ?>
                                    </span>
                                </td>
                                <td class="td-animal">
                                    <span class="animal-badge <?= esc($produit['animal']) ?>">
                                        <?= $produit['animal'] == 'chien' ? '<i class="fas fa-dog"></i> Chien' : '<i class="fas fa-cat"></i> Chat' ?>
                                    </span>
                                </td>
                                <td class="td-category">
                                    <?= !empty($produit['categorie']) ? esc($produit['categorie']) : '-' ?>
                                </td>
                                <td class="td-brand">
                                    <?= !empty($produit['marque']) ? esc($produit['marque']) : '-' ?>
                                </td>
                                <td class="td-age">
                                    <?php if (!empty($produit['age'])): ?>
                                        <?php 
                                            $age_labels = [
                                                'junior' => 'Junior',
                                                'adulte' => 'Adulte',
                                                'senior' => 'Sénior'
                                            ];
                                            echo isset($age_labels[$produit['age']]) ? $age_labels[$produit['age']] : $produit['age'];
                                        ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td class="td-flavor">
                                    <?= !empty($produit['saveur']) ? esc($produit['saveur']) : '-' ?>
                                </td>
                                <td class="td-featured">
                                    <?php if (isset($produit['is_vedette']) && $produit['is_vedette']): ?>
                                        <span class="vedette-badge"><i class="fas fa-star"></i></span>
                                    <?php else: ?>
                                        <span class="non-vedette-badge"><i class="far fa-star"></i></span>
                                    <?php endif; ?>
                                </td>
                                <td class="td-dates">
                                    <div class="dates-info">
                                        <div class="date-created" title="Date de création">
                                            <i class="fas fa-plus-circle"></i> <?= date('d/m/Y H:i', strtotime($produit['created_at'])) ?>
                                        </div>
                                        <div class="date-updated" title="Dernière modification">
                                            <i class="fas fa-edit"></i> <?= date('d/m/Y H:i', strtotime($produit['updated_at'])) ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="td-actions">
                                    <div class="action-buttons">
                                        <a href="<?= base_url('admin/produit/modifier/' . esc($produit['id'])) ?>" class="action-btn edit-btn" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('produits/detail/' . esc($produit['id'])) ?>" class="action-btn view-btn" title="Voir" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/produit/supprimer/' . esc($produit['id'])) ?>" class="action-btn delete-btn" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="admin-pagination">
                <button class="pagination-btn"><i class="fas fa-chevron-left"></i></button>
                <div class="pagination-numbers">
                    <a href="#" class="pagination-number active">1</a>
                    <a href="#" class="pagination-number">2</a>
                    <a href="#" class="pagination-number">3</a>
                </div>
                <button class="pagination-btn"><i class="fas fa-chevron-right"></i></button>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
/* Styles pour le tableau de bord administrateur */
.admin-container {
    display: flex;
    min-height: calc(100vh - 180px);
    background-color: #f7f9fc;
    max-width: 100%;
    overflow-x: hidden;
}

.admin-sidebar {
    width: 280px;
    background-color: #F2C078;
    color: #4A3A2D;
    box-shadow: 2px 0 5px rgba(0,0,0,0.05);
    flex-shrink: 0;
}

.admin-profile {
    padding: 25px 20px;
    text-align: center;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

.admin-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    background-color: #fff;
    padding: 3px;
    border: 2px solid #D97B29;
    margin-bottom: 10px;
}

.admin-profile h3 {
    margin: 0 0 5px;
    font-size: 18px;
    color: #4A3A2D;
}

.admin-profile p {
    margin: 0;
    font-size: 14px;
    color: #6B3F1D;
    opacity: 0.8;
}

.admin-nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.admin-nav li {
    margin-bottom: 2px;
}

.admin-nav a {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    color: #4A3A2D;
    text-decoration: none;
    transition: all 0.3s;
    font-weight: 500;
}

.admin-nav a i {
    margin-right: 10px;
    width: 20px;
    text-align: center;
}

.admin-nav li.active a,
.admin-nav a:hover {
    background-color: #D97B29;
    color: white;
}

.admin-content {
    flex: 1;
    padding: 25px;
    max-width: 100%;
    overflow-x: hidden;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e0e0e0;
}

.admin-header h1 {
    margin: 0;
    font-size: 24px;
    color: #D97B29;
    display: flex;
    align-items: center;
}

.admin-header h1 i {
    margin-right: 10px;
}

.admin-actions {
    display: flex;
    align-items: center;
    gap: 15px;
}

.search-form {
    display: flex;
    align-items: center;
    position: relative;
}

.search-form input {
    padding: 10px 15px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    font-size: 14px;
    width: 250px;
}

.search-form button {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6B3F1D;
    cursor: pointer;
}

.admin-btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 15px;
    background-color: #D97B29;
    color: white;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.admin-btn i {
    margin-right: 8px;
}

.admin-btn:hover {
    background-color: #B45B19;
}

/* Filtres */
.admin-filters {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
    gap: 15px;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.filter-buttons {
    display: flex;
    gap: 10px;
}

.filter-btn {
    padding: 8px 15px;
    background-color: #f2f2f2;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s;
}

.filter-btn.active,
.filter-btn:hover {
    background-color: #D97B29;
    color: white;
}

.sort-select {
    padding: 6px 12px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    font-size: 13px;
    background-color: white;
    max-width: 120px;
}

.sort-select option {
    font-size: 13px;
}

/* Style de la barre de défilement */
.scroll-indicator {
    width: 100%;
    padding: 0 2px;
    cursor: pointer;
    user-select: none;
}

.scroll-track {
    height: 4px;
    background-color: #f0f0f0;
    border-radius: 2px;
    position: relative;
    margin: 8px 0;
}

.scroll-thumb {
    position: absolute;
    height: 16px; /* Plus grand pour une meilleure prise */
    width: 60px;
    background-color: #D97B29;
    border-radius: 8px;
    top: -6px;
    left: 0;
    cursor: grab;
    transition: background-color 0.2s ease;
    touch-action: none;
}

.scroll-thumb:hover {
    background-color: #B45B19;
}

.scroll-thumb.dragging {
    cursor: grabbing;
    background-color: #B45B19;
}

/* Tableau des produits */
.products-table-wrapper {
    overflow-x: auto;
    margin-bottom: 30px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    width: 100%;
    max-width: calc(100vw - 330px); /* 280px sidebar + 50px padding */
    position: relative;
}

.products-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 1200px; /* Assure une largeur minimale pour le tableau */
}

.products-table th,
.products-table td {
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
    font-size: 14px;
}

.products-table th {
    background-color: #f7f7f7;
    font-weight: 600;
    color: #555;
    text-align: left;
    white-space: nowrap;
}

.products-table tr:last-child td {
    border-bottom: none;
}

.products-table tr:hover {
    background-color: #fafafa;
}

.th-image, .td-image {
    width: 80px;
    text-align: center;
}

.product-thumbnail {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #e0e0e0;
}

.no-image {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f0f0f0;
    border-radius: 4px;
    color: #aaa;
}

.td-name {
    font-weight: 500;
}

.td-description {
    color: #666;
    max-width: 300px;
}

.th-price, .td-price {
    width: 100px;
    text-align: right;
    font-weight: 500;
}

.th-stock, .td-stock {
    width: 100px;
    text-align: center;
}

.stock-badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 3px;
    font-size: 13px;
    font-weight: 500;
}

.stock-badge.disponible {
    background-color: #e6f7e9;
    color: #2e7d32;
}

.stock-badge.rupture {
    background-color: #ffebee;
    color: #c62828;
}

.th-animal, .td-animal {
    width: 100px;
    text-align: center;
}

.animal-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 3px 8px;
    border-radius: 3px;
    font-size: 13px;
    font-weight: 500;
}

.animal-badge.chien {
    background-color: #e3f2fd;
    color: #1565c0;
}

.animal-badge.chat {
    background-color: #fff8e1;
    color: #ff8f00;
}

.th-category, .td-category {
    width: 120px;
    text-align: center;
}

.th-brand, .td-brand {
    width: 120px;
    text-align: center;
}

.th-age, .td-age {
    width: 80px;
    text-align: center;
}

.th-flavor, .td-flavor {
    width: 100px;
    text-align: center;
}

.th-featured, .td-featured {
    width: 80px;
    text-align: center;
}

.vedette-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #FFF8E1;
    color: #FFC107;
}

.non-vedette-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #f5f5f5;
    color: #bdbdbd;
}

.th-dates, .td-dates {
    min-width: 200px;
    text-align: left;
    padding: 10px;
}

.dates-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
    font-size: 12px;
}

.date-created, .date-updated {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #666;
}

.date-created i {
    color: #4CAF50;
}

.date-updated i {
    color: #2196F3;
}

.date-created:hover, .date-updated:hover {
    color: #333;
}

.th-actions, .td-actions {
    width: 120px;
    text-align: center;
}

.action-buttons {
    display: flex;
    justify-content: center;
    gap: 8px;
}

.action-btn {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    color: white;
    text-decoration: none;
    transition: opacity 0.3s;
}

.action-btn:hover {
    opacity: 0.8;
}

.edit-btn {
    background-color: #D97B29;
}

.view-btn {
    background-color: #4A7A8C;
}

.delete-btn {
    background-color: #d9534f;
}

/* Quand pas de produits */
.no-products {
    background-color: white;
    border-radius: 8px;
    padding: 50px 20px;
    text-align: center;
    margin-bottom: 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.no-products i {
    font-size: 48px;
    color: #D97B29;
    margin-bottom: 20px;
}

.no-products p {
    font-size: 18px;
    color: #6B3F1D;
    margin-bottom: 20px;
}

/* Pagination */
.admin-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-top: 25px;
}

.pagination-btn {
    width: 36px;
    height: 36px;
    border: 1px solid #e0e0e0;
    background-color: white;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
}

.pagination-btn:hover {
    background-color: #f9f9f9;
}

.pagination-numbers {
    display: flex;
    gap: 5px;
}

.pagination-number {
    width: 36px;
    height: 36px;
    border: 1px solid #e0e0e0;
    background-color: white;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: #6B3F1D;
    transition: all 0.3s;
}

.pagination-number:hover {
    background-color: #f9f9f9;
}

.pagination-number.active {
    background-color: #D97B29;
    color: white;
    border-color: #D97B29;
}

/* Indication de défilement */
.table-scroll-hint {
    display: none;
    text-align: center;
    margin-bottom: 10px;
    color: #D97B29;
    font-size: 14px;
    background-color: #FFF8E1;
    padding: 8px;
    border-radius: 4px;
    position: relative;
}

.table-scroll-hint i {
    margin-right: 5px;
    animation: scrollHint 1.5s infinite;
}

@keyframes scrollHint {
    0% { transform: translateX(0); }
    50% { transform: translateX(10px); }
    100% { transform: translateX(0); }
}

/* Ajout d'un indicateur de défilement sur le côté droit du tableau */
.products-table-wrapper::after {
    content: '→';
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    background: linear-gradient(to right, transparent, #fff);
    padding: 10px;
    color: #D97B29;
    font-size: 20px;
    opacity: 0;
    transition: opacity 0.3s;
    pointer-events: none;
}

.products-table-wrapper:hover::after {
    opacity: 1;
}

@media (max-width: 1200px) {
    .table-scroll-hint {
        display: block;
    }
}

/* Responsive */
@media (max-width: 992px) {
    .admin-container {
        flex-direction: column;
    }
    
    .admin-sidebar {
        width: 100%;
    }
    
    .admin-profile {
        padding: 15px;
    }
    
    .admin-avatar {
        width: 60px;
        height: 60px;
    }
    
    .admin-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .admin-actions {
        margin-top: 15px;
        width: 100%;
    }
    
    .search-form {
        width: 100%;
    }
    
    .search-form input {
        width: 100%;
    }
    
    .td-description {
        max-width: 150px;
    }
    
    /* Ajustement pour les tablettes */
    .th-flavor, .td-flavor {
        display: none;
    }
    
    .products-table-wrapper {
        max-width: calc(100vw - 50px); /* Ajustement quand la sidebar passe en haut */
    }
    
    .admin-content {
        padding: 15px;
    }
}

@media (max-width: 768px) {
    .admin-filters {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .sort-select {
        max-width: 100%;
    }
    
    .products-table-wrapper {
        margin-left: -15px;
        margin-right: -15px;
        max-width: calc(100vw);
        border-radius: 0;
    }
    
    .th-description, .td-description,
    .th-age, .td-age,
    .th-brand, .td-brand {
        display: none;
    }
    
    .products-table {
        min-width: 800px; /* Réduit la largeur minimale pour les écrans moyens */
    }
}

@media (max-width: 576px) {
    .admin-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .admin-btn {
        text-align: center;
        justify-content: center;
    }
    
    .admin-content {
        padding: 10px;
    }
    
    .products-table th,
    .products-table td {
        padding: 10px 8px;
        font-size: 13px;
    }
    
    .product-thumbnail {
        width: 40px;
        height: 40px;
    }
    
    /* Cacher certaines colonnes sur mobile pour un meilleur affichage */
    .th-category, .td-category {
        display: none;
    }
    
    .products-table {
        min-width: 600px; /* Encore réduit pour mobile */
    }
    
    .products-table-wrapper {
        margin-left: -10px;
        margin-right: -10px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableWrapper = document.querySelector('.products-table-wrapper');
    const scrollTrack = document.querySelector('.scroll-track');
    const scrollThumb = document.querySelector('.scroll-thumb');
    
    if (!tableWrapper || !scrollTrack || !scrollThumb) return;

    let isDragging = false;
    let startX, startScrollLeft, startThumbPosition;

    function updateThumbPosition(forcePosition = null) {
        const scrollableWidth = tableWrapper.scrollWidth - tableWrapper.clientWidth;
        if (scrollableWidth <= 0) return;

        const trackWidth = scrollTrack.clientWidth;
        const thumbWidth = scrollThumb.clientWidth;
        const maxTransform = trackWidth - thumbWidth;

        if (forcePosition !== null) {
            const transform = Math.max(0, Math.min(forcePosition, maxTransform));
            const percentage = transform / maxTransform;
            tableWrapper.scrollLeft = percentage * scrollableWidth;
        } else {
            const scrollPercentage = tableWrapper.scrollLeft / scrollableWidth;
            const transform = scrollPercentage * maxTransform;
            scrollThumb.style.transform = `translateX(${transform}px)`;
        }
    }

    // Mise à jour initiale
    updateThumbPosition();

    // Gestion du défilement du tableau
    tableWrapper.addEventListener('scroll', () => updateThumbPosition());

    // Gestion du drag & drop
    function onMouseDown(e) {
        isDragging = true;
        scrollThumb.classList.add('dragging');
        
        startX = e.clientX;
        startThumbPosition = scrollThumb.getBoundingClientRect().left - scrollTrack.getBoundingClientRect().left;
        
        document.addEventListener('mousemove', onMouseMove);
        document.addEventListener('mouseup', onMouseUp);
        e.preventDefault(); // Empêche la sélection de texte
    }

    function onMouseMove(e) {
        if (!isDragging) return;

        const deltaX = e.clientX - startX;
        const newPosition = startThumbPosition + deltaX;
        updateThumbPosition(newPosition);
    }

    function onMouseUp() {
        isDragging = false;
        scrollThumb.classList.remove('dragging');
        document.removeEventListener('mousemove', onMouseMove);
        document.removeEventListener('mouseup', onMouseUp);
    }

    // Gestion du clic sur la track
    scrollTrack.addEventListener('click', function(e) {
        if (e.target === scrollThumb) return;
        
        const trackRect = scrollTrack.getBoundingClientRect();
        const clickPosition = e.clientX - trackRect.left;
        const thumbWidth = scrollThumb.clientWidth;
        const trackWidth = scrollTrack.clientWidth;
        
        // Centre le curseur sur le clic
        const newPosition = clickPosition - (thumbWidth / 2);
        updateThumbPosition(newPosition);
    });

    // Ajout des écouteurs d'événements pour le drag & drop
    scrollThumb.addEventListener('mousedown', onMouseDown);

    // Gestion du resize de la fenêtre
    window.addEventListener('resize', () => updateThumbPosition());

    // Filtrage par type d'animal
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productRows = document.querySelectorAll('.product-row');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            productRows.forEach(row => {
                if (filter === 'all') {
                    row.style.display = '';
                } else {
                    row.style.display = row.classList.contains(filter) ? '' : 'none';
                }
            });
        });
    });

    // Fonction de tri
    const sortSelect = document.querySelector('.sort-select');
    const tbody = document.querySelector('.products-table tbody');

    function sortTable(sortBy, direction) {
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        const sortFunctions = {
            name: (a, b) => a.querySelector('.td-name').textContent.localeCompare(b.querySelector('.td-name').textContent),
            price: (a, b) => {
                const priceA = parseFloat(a.querySelector('.td-price').textContent.replace('€', '').replace(',', '.').trim());
                const priceB = parseFloat(b.querySelector('.td-price').textContent.replace('€', '').replace(',', '.').trim());
                return priceA - priceB;
            },
            stock: (a, b) => {
                const stockA = parseInt(a.querySelector('.td-stock .stock-badge').textContent) || 0;
                const stockB = parseInt(b.querySelector('.td-stock .stock-badge').textContent) || 0;
                return stockA - stockB;
            },
            category: (a, b) => a.querySelector('.td-category').textContent.localeCompare(b.querySelector('.td-category').textContent),
            brand: (a, b) => a.querySelector('.td-brand').textContent.localeCompare(b.querySelector('.td-brand').textContent),
            age: (a, b) => {
                const ageOrder = { 'Junior': 1, 'Adulte': 2, 'Sénior': 3, '-': 4 };
                const ageA = ageOrder[a.querySelector('.td-age').textContent.trim()] || 4;
                const ageB = ageOrder[b.querySelector('.td-age').textContent.trim()] || 4;
                return ageA - ageB;
            },
            flavor: (a, b) => a.querySelector('.td-flavor').textContent.localeCompare(b.querySelector('.td-flavor').textContent),
            featured: (a, b) => {
                const featuredA = a.querySelector('.td-featured .vedette-badge') ? 1 : 0;
                const featuredB = b.querySelector('.td-featured .vedette-badge') ? 1 : 0;
                return featuredA - featuredB;
            }
        };

        rows.sort((a, b) => {
            const [field] = sortBy.split('_');
            let result = sortFunctions[field](a, b);
            return direction === 'desc' ? -result : result;
        });

        // Réinsérer les lignes triées
        rows.forEach(row => tbody.appendChild(row));
    }

    sortSelect.addEventListener('change', function() {
        const [sortBy, direction] = this.value.split('_');
        if (!sortBy) return; // Si "Trier par" est sélectionné
        
        sortTable(sortBy, direction);
    });

    // Fonction de recherche
    const searchInput = document.getElementById('searchInput');
    let searchTimeout;

    function normalizeText(text) {
        return text.toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9\s]/g, '');
    }

    function searchProducts(query) {
        const normalizedQuery = normalizeText(query);
        
        productRows.forEach(row => {
            const searchableFields = [
                row.querySelector('.td-name').textContent,
                row.querySelector('.td-description').textContent,
                row.querySelector('.td-category').textContent,
                row.querySelector('.td-brand').textContent,
                row.querySelector('.td-age').textContent,
                row.querySelector('.td-flavor').textContent,
                row.querySelector('.td-price').textContent,
                row.querySelector('.td-stock .stock-badge').textContent,
                row.querySelector('.td-animal').textContent
            ];

            const searchableText = normalizeText(searchableFields.join(' '));
            
            if (normalizedQuery === '' || searchableText.includes(normalizedQuery)) {
                row.style.display = '';
                // Mettre en surbrillance les correspondances
                highlightMatches(row, query);
            } else {
                row.style.display = 'none';
            }
        });

        // Mettre à jour la position du curseur de défilement
        if (typeof updateThumbPosition === 'function') {
            updateThumbPosition();
        }
    }

    function highlightMatches(row, query) {
        if (!query) {
            // Restaurer le texte original s'il n'y a pas de recherche
            row.querySelectorAll('.highlight').forEach(el => {
                el.outerHTML = el.textContent;
            });
            return;
        }

        const fields = row.querySelectorAll('.td-name, .td-description, .td-category, .td-brand, .td-age, .td-flavor');
        const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');

        fields.forEach(field => {
            const originalText = field.textContent;
            if (!field.querySelector('.highlight')) {
                field.innerHTML = originalText.replace(regex, '<span class="highlight">$1</span>');
            }
        });
    }

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        // Délai de 300ms pour éviter trop de recherches pendant la frappe
        searchTimeout = setTimeout(() => {
            searchProducts(query);
        }, 300);
    });

    // Ajouter les styles pour la surbrillance
    const style = document.createElement('style');
    style.textContent = `
        .highlight {
            background-color: #fff3cd;
            padding: 0 2px;
            border-radius: 2px;
            font-weight: bold;
            color: #D97B29;
        }
        
        .search-form {
            position: relative;
        }
        
        .search-form input {
            padding-right: 35px;
            transition: all 0.3s ease;
        }
        
        .search-form input:focus {
            border-color: #D97B29;
            box-shadow: 0 0 0 2px rgba(217, 123, 41, 0.1);
        }
        
        .search-form button {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #D97B29;
            cursor: pointer;
            padding: 5px;
            transition: color 0.3s ease;
        }
        
        .search-form button:hover {
            color: #B45B19;
        }
    `;
    document.head.appendChild(style);
});
</script>

<?= $this->include('layouts/footer') ?>
