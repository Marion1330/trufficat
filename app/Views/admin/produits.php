<?= $this->include('layouts/header') ?>

<div class="admin-container">
    <div class="admin-sidebar">
        <div class="admin-profile">
            <h3>Administrateur</h3>
        </div>
        
        <nav class="admin-nav">
            <ul>
                <li><a href="<?= base_url('admin') ?>"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a></li>
                <li class="active"><a href="<?= base_url('admin/produits') ?>"><i class="fas fa-box-open"></i> Produits</a></li>
                <li><a href="<?= base_url('admin/clients') ?>"><i class="fas fa-users"></i> Clients</a></li>
                <li><a href="<?= base_url('admin/commandes') ?>"><i class="fas fa-shopping-cart"></i> Commandes</a></li>
            </ul>
        </nav>
    </div>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1><i class="fas fa-box-open"></i> Gestion des produits</h1>
            <div class="admin-actions">
                <form action="<?= base_url('admin/produits') ?>" method="get" class="search-form">
                    <input type="hidden" name="animal" value="<?= esc($currentAnimal) ?>">
                    <input type="text" placeholder="Rechercher un produit..." name="search" id="searchInput" value="<?= esc($currentSearch ?? '') ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                    <?php if (!empty($currentSearch)): ?>
                        <a href="<?= base_url('admin/produits?animal=' . $currentAnimal) ?>" class="clear-search" title="Effacer la recherche">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>
                </form>
                <a href="<?= base_url('admin/produit/ajouter') ?>" class="admin-btn"><i class="fas fa-plus-circle"></i> Ajouter un produit</a>
            </div>
        </div>
        
        <?php if (!empty($currentSearch)): ?>
            <div class="search-info">
                <i class="fas fa-search"></i> Résultats pour : "<strong><?= esc($currentSearch) ?></strong>" 
                (<?= $total ?> produit<?= $total > 1 ? 's' : '' ?> trouvé<?= $total > 1 ? 's' : '' ?>)
            </div>
        <?php endif; ?>
        
        <div class="admin-filters">
            <div class="filter-group">
                <div class="filter-buttons">
                    <?php $searchParam = !empty($currentSearch) ? '&search=' . urlencode($currentSearch) : ''; ?>
                    <a href="<?= base_url('admin/produits?animal=all' . $searchParam) ?>" class="filter-btn <?= $currentAnimal === 'all' ? 'active' : '' ?>">Tous</a>
                    <a href="<?= base_url('admin/produits?animal=chien' . $searchParam) ?>" class="filter-btn <?= $currentAnimal === 'chien' ? 'active' : '' ?>">Chiens</a>
                    <a href="<?= base_url('admin/produits?animal=chat' . $searchParam) ?>" class="filter-btn <?= $currentAnimal === 'chat' ? 'active' : '' ?>">Chats</a>
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
                <option value="created_desc">Date de création (Plus récent)</option>
                <option value="created_asc">Date de création (Plus ancien)</option>
                <option value="updated_desc">Dernière modification (Plus récent)</option>
                <option value="updated_asc">Dernière modification (Plus ancien)</option>
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
                <?php 
                $searchParam = !empty($currentSearch) ? '&search=' . urlencode($currentSearch) : '';
                ?>
                <?php if ($currentPage > 1): ?>
                    <a href="<?= base_url('admin/produits?animal=' . $currentAnimal . '&page=' . ($currentPage - 1) . $searchParam) ?>" class="pagination-btn prev" title="Page précédente">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                <?php else: ?>
                    <button class="pagination-btn prev" disabled title="Page précédente"><i class="fas fa-chevron-left"></i></button>
                <?php endif; ?>

                <div class="pagination-numbers">
                    <?php
                    $totalPages = ceil($total / $perPage);
                    for ($i = 1; $i <= $totalPages; $i++):
                    ?>
                        <a href="<?= base_url('admin/produits?animal=' . $currentAnimal . '&page=' . $i . $searchParam) ?>" 
                           class="pagination-number <?= $i == $currentPage ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>

                <?php if ($currentPage < ceil($total / $perPage)): ?>
                    <a href="<?= base_url('admin/produits?animal=' . $currentAnimal . '&page=' . ($currentPage + 1) . $searchParam) ?>" class="pagination-btn next" title="Page suivante">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                <?php else: ?>
                    <button class="pagination-btn next" disabled title="Page suivante"><i class="fas fa-chevron-right"></i></button>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
/* Styles pour le tableau de bord administrateur */
.admin-container {
    display: flex;
    min-height: calc(100vh - 180px);
    background-color: #FFF8F0;
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
    border-bottom: 1px solid #F2C078;
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
    margin-right: 15px;
}

.search-form input {
    padding: 8px 12px;
    border: 1px solid #F2C078;
    border-radius: 4px;
    font-size: 14px;
    width: 250px;
    transition: all 0.3s ease;
}

.search-form input:focus {
    outline: none;
    border-color: #D97B29;
    box-shadow: 0 0 5px rgba(217, 123, 41, 0.2);
}

.search-form button {
    background: none;
    border: none;
    color: #D97B29;
    cursor: pointer;
    padding: 8px;
    margin-left: -35px;
}

.clear-search {
    background: none;
    border: none;
    color: #dc3545;
    cursor: pointer;
    padding: 8px;
    margin-left: 5px;
    text-decoration: none;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.clear-search:hover {
    background-color: #dc3545;
    color: white;
}

.admin-btn {
    padding: 8px 15px;
    background-color: #D97B29;
    color: white;
    border-radius: 4px;
    text-decoration: none;
    font-size: 14px;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
}

.admin-btn i {
    margin-right: 8px;
}

.admin-btn:hover {
    background-color: #A44D25;
    transform: translateY(-2px);
}

/* Filtres */
.admin-filters {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    gap: 20px;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.filter-buttons {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    padding-bottom: 5px;
}

.filter-btn {
    padding: 10px 15px;
    background-color: #fff;
    border: 1px solid #D97B29;
    border-radius: 6px;
    color: #333;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
    min-width: 100px;
}

.filter-btn:hover {
    border-color: #A44D25;
    box-shadow: 0 0 8px rgba(217, 123, 41, 0.2);
}

.filter-btn.active {
    background-color: #FFE8C6;
    color: #A44D25;
    border-color: #D97B29;
}

.sort-select {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #D97B29;
    border-radius: 6px;
    background-color: #fff;
    color: #333;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23D97B29' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: calc(100% - 12px) center;
    padding-right: 35px;
    width: 200px;
}

.sort-select:hover {
    border-color: #A44D25;
    box-shadow: 0 0 8px rgba(217, 123, 41, 0.2);
}

.sort-select:focus {
    outline: none;
    border-color: #A44D25;
    box-shadow: 0 0 8px rgba(217, 123, 41, 0.3);
}

.sort-select option {
    padding: 10px;
    background-color: #fff;
    color: #333;
}

.sort-select option:checked {
    background-color: #FFE8C6;
    color: #A44D25;
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

.products-table td {
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
    font-size: 14px;
}

.products-table th {
    background-color: #D97B29;
    color: white;
    font-weight: 600;
    text-align: left;
    padding: 12px 15px;
    font-size: 13px;
    border-bottom: 2px solid #B45B19;
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
    color: #4A1F0E;
    font-weight: 600;
    background-color: #FFF8F0;
    border-radius: 4px;
}

.td-description {
    color: #4A1F0E;
    max-width: 200px;
    font-size: 13px;
    background-color: #FFF1E6;
    border-radius: 4px;
}

.td-price {
    color: #4A1F0E;
    font-weight: 600;
    background-color: #FFF1E6;
    border-radius: 4px;
}

.td-stock {
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
    background-color: #FFE8C6;
    color: #D97B29;
}

.stock-badge.rupture {
    background-color: #fff8e1;
    color: #ff8f00;;
    color: #c62828;
}

.td-animal {
    width: 100px;
    text-align: center;
}

.animal-badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 3px;
    font-size: 13px;
    font-weight: 500;
    background-color: #FFE8C6;
    color: #D97B29;
}

.animal-badge i {
    margin-right: 5px;
}

.animal-badge.chien {
    background-color: #fff8e1;
    color: #ff8f00;
}

.animal-badge.chat {
    background-color: #fff8e1;
    color: #ff8f00;
}

.td-category {
    color: #4A1F0E;
    font-weight: 600;
    background-color: #FFE8C6;
    border-radius: 4px;
}

.td-brand {
    color: #4A1F0E;
    font-weight: 600;
    background-color: #FFE8C6;
    border-radius: 4px;
}

.td-age, .td-flavor {
    color: #4A1F0E;
    background-color: #FFF8F0;
    border-radius: 4px;
}

.td-featured {
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

.td-dates {
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
    margin-top: 2rem;
    gap: 1rem;
}

.pagination-numbers {
    display: flex;
    gap: 0.5rem;
}

.pagination-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 2rem;
    height: 2rem;
    padding: 0.5rem;
    border-radius: 4px;
    background-color: #fff;
    color: #D97B29;
    text-decoration: none;
    transition: all 0.3s ease;
}

.pagination-number:hover {
    background-color: #FFE8C6;
}

.pagination-number.active {
    background-color: #D97B29;
    color: #fff;
}

.pagination-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    border-radius: 4px;
    background-color: #fff;
    color: #D97B29;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
}

.pagination-btn:hover:not(:disabled) {
    background-color: #FFE8C6;
}

.pagination-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.filter-btn {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border: 1px solid #D97B29;
    background-color: #fff;
    color: #D97B29;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
}

.filter-btn:hover {
    background-color: #FFE8C6;
}

.filter-btn.active {
    background-color: #D97B29;
    color: #fff;
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

.product-row.chat td {
    background-color: #FDD4B0;
    color: #4A3A2D;
}

.product-row.chat .td-name {
    color: #A44D25;
    font-weight: 600;
    background-color: #FDD4B0;
}

.product-row.chat .td-description {
    color: #6B3F1D;
    background-color: #FDD4B0;
}

.product-row.chat .td-brand,
.product-row.chat .td-category {
    color: #D97B29;
    font-weight: 600;
    background-color: #FDD4B0;
}

.product-row.chat .td-price {
    color: #A44D25;
    font-weight: 600;
    background-color: #FDD4B0;
    
}

.product-row.chien td {
    background-color: #FFE8C6;
    color: #4A3A2D;
}

.product-row.chien .td-name {
    color: #A44D25;
    font-weight: 600;
    background-color: #FFE8C6;
}

.product-row.chien .td-description {
    color: #6B3F1D;
    background-color: #FFE8C6;
}

.product-row.chien .td-brand,
.product-row.chien .td-category {
    color: #D97B29;
    font-weight: 600;
    background-color: #FFE8C6;
}

.product-row.chien .td-price {
    color: #A44D25;
    font-weight: 600;
    background-color: #FFE8C6;
}

.product-row.chien .stock-badge.disponible {
    background-color:#FDD4B0;
    color: #D97B29;
}

.products-table tr:hover td {
    opacity: 0.9;
}

.pagination-ellipsis {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    color: #6B3F1D;
}

.pagination-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background-color: #f5f5f5;
}

.pagination-btn:disabled:hover {
    background-color: #f5f5f5;
    transform: none;
}

.search-info {
    background-color: #FFF8E1;
    border: 1px solid #FFE8C6;
    border-radius: 4px;
    padding: 10px 15px;
    margin-bottom: 20px;
    color: #D97B29;
    font-size: 14px;
}

.search-info i {
    margin-right: 8px;
    color: #D97B29;
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
            },
            created: (a, b) => {
                const getCreatedDate = (el) => {
                    const dateText = el.querySelector('.date-created').textContent;
                    const [day, month, year, hours, minutes] = dateText.match(/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})/).slice(1);
                    return new Date(year, month - 1, day, hours, minutes);
                };
                return getCreatedDate(a) - getCreatedDate(b);
            },
            updated: (a, b) => {
                const getUpdatedDate = (el) => {
                    const dateText = el.querySelector('.date-updated').textContent;
                    const [day, month, year, hours, minutes] = dateText.match(/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})/).slice(1);
                    return new Date(year, month - 1, day, hours, minutes);
                };
                return getUpdatedDate(a) - getUpdatedDate(b);
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

    // Pagination
    const itemsPerPage = 10;
    let currentPage = 1;

    function updatePagination() {
        const visibleRows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.style.display !== 'none');
        const totalPages = Math.ceil(visibleRows.length / itemsPerPage);
        
        // Mettre à jour les numéros de page
        const paginationNumbers = document.querySelector('.pagination-numbers');
        paginationNumbers.innerHTML = '';
        
        // Calculer la plage de pages à afficher
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, startPage + 4);
        
        // Ajuster si on est près de la fin
        if (endPage - startPage < 4) {
            startPage = Math.max(1, endPage - 4);
        }
        
        // Ajouter la première page si nécessaire
        if (startPage > 1) {
            const firstPageLink = document.createElement('a');
            firstPageLink.href = '#';
            firstPageLink.className = 'pagination-number';
            firstPageLink.textContent = '1';
            firstPageLink.addEventListener('click', (e) => {
                e.preventDefault();
                goToPage(1);
            });
            paginationNumbers.appendChild(firstPageLink);
            
            if (startPage > 2) {
                const ellipsis = document.createElement('span');
                ellipsis.className = 'pagination-ellipsis';
                ellipsis.textContent = '...';
                paginationNumbers.appendChild(ellipsis);
            }
        }
        
        // Ajouter les pages
        for (let i = startPage; i <= endPage; i++) {
            const pageLink = document.createElement('a');
            pageLink.href = '#';
            pageLink.className = `pagination-number${i === currentPage ? ' active' : ''}`;
            pageLink.textContent = i;
            pageLink.addEventListener('click', (e) => {
                e.preventDefault();
                goToPage(i);
            });
            paginationNumbers.appendChild(pageLink);
        }
        
        // Ajouter la dernière page si nécessaire
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                const ellipsis = document.createElement('span');
                ellipsis.className = 'pagination-ellipsis';
                ellipsis.textContent = '...';
                paginationNumbers.appendChild(ellipsis);
            }
            
            const lastPageLink = document.createElement('a');
            lastPageLink.href = '#';
            lastPageLink.className = 'pagination-number';
            lastPageLink.textContent = totalPages;
            lastPageLink.addEventListener('click', (e) => {
                e.preventDefault();
                goToPage(totalPages);
            });
            paginationNumbers.appendChild(lastPageLink);
        }
        
        // Mettre à jour les boutons précédent/suivant
        const prevButton = document.querySelector('.pagination-btn.prev');
        const nextButton = document.querySelector('.pagination-btn.next');
        
        prevButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === totalPages;
        
        // Afficher les produits de la page courante
        visibleRows.forEach((row, index) => {
            const shouldShow = index >= (currentPage - 1) * itemsPerPage && index < currentPage * itemsPerPage;
            row.style.display = shouldShow ? '' : 'none';
        });
    }

    function goToPage(page) {
        currentPage = page;
        updatePagination();
        // Scroll en haut du tableau
        tableWrapper.scrollIntoView({ behavior: 'smooth' });
    }

    // Ajouter les écouteurs d'événements pour les boutons de pagination
    document.querySelector('.pagination-btn.prev').addEventListener('click', () => {
        if (currentPage > 1) {
            goToPage(currentPage - 1);
        }
    });

    document.querySelector('.pagination-btn.next').addEventListener('click', () => {
        const visibleRows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.style.display !== 'none');
        const totalPages = Math.ceil(visibleRows.length / itemsPerPage);
        if (currentPage < totalPages) {
            goToPage(currentPage + 1);
        }
    });

    // Mettre à jour la pagination après chaque recherche ou tri
    const updateTableAndPagination = () => {
        currentPage = 1; // Retour à la première page
        updatePagination();
    };

    // Modifier les fonctions existantes pour appeler updateTableAndPagination
    sortSelect.addEventListener('change', function() {
        const [sortBy, direction] = this.value.split('_');
        if (!sortBy) return;
        
        sortTable(sortBy, direction);
        updateTableAndPagination();
    });

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        searchTimeout = setTimeout(() => {
            searchProducts(query);
            updateTableAndPagination();
        }, 300);
    });

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
            
            updateTableAndPagination();
        });
    });

    // Initialiser la pagination au chargement
    updateTableAndPagination();
});
</script>

<?= $this->include('layouts/footer') ?>
