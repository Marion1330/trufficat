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
                <form action="" method="get" class="search-form">
                    <input type="text" placeholder="Rechercher un produit..." name="search">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
                <a href="<?= base_url('admin/produit/ajouter') ?>" class="admin-btn"><i class="fas fa-plus-circle"></i> Ajouter un produit</a>
            </div>
        </div>
        
        <div class="admin-filters">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">Tous</button>
                <button class="filter-btn" data-filter="chien">Chiens</button>
                <button class="filter-btn" data-filter="chat">Chats</button>
            </div>
            
            <select class="sort-select">
                <option value="">Trier par</option>
                <option value="name_asc">Nom (A-Z)</option>
                <option value="name_desc">Nom (Z-A)</option>
                <option value="price_asc">Prix (croissant)</option>
                <option value="price_desc">Prix (décroissant)</option>
            </select>
        </div>

        <?php if (empty($produits)): ?>
            <div class="no-products">
                <i class="fas fa-box-open"></i>
                <p>Aucun produit n'a été trouvé.</p>
                <a href="<?= base_url('admin/produit/ajouter') ?>" class="admin-btn">Ajouter un produit</a>
            </div>
        <?php else: ?>
            <div class="products-table-wrapper">
                <table class="products-table">
                    <thead>
                        <tr>
                            <th class="th-image">Image</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th class="th-price">Prix</th>
                            <th class="th-animal">Animal</th>
                            <th class="th-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produits as $produit): ?>
                            <tr class="product-row <?= esc($produit['animal']) ?>">
                                <td class="td-image">
                                    <?php if (!empty($produit['image'])): ?>
                                        <img src="<?= base_url('images/' . esc($produit['image'])) ?>" alt="<?= esc($produit['nom']) ?>" class="product-thumbnail">
                                    <?php else: ?>
                                        <div class="no-image"><i class="fas fa-image"></i></div>
                                    <?php endif; ?>
                                </td>
                                <td class="td-name"><?= esc($produit['nom']) ?></td>
                                <td class="td-description"><?= substr(esc($produit['description']), 0, 100) . (strlen($produit['description']) > 100 ? '...' : '') ?></td>
                                <td class="td-price"><?= isset($produit['prix']) ? number_format($produit['prix'], 2, ',', ' ') . ' €' : 'N/A' ?></td>
                                <td class="td-animal">
                                    <span class="animal-badge <?= esc($produit['animal']) ?>">
                                        <?= $produit['animal'] == 'chien' ? '<i class="fas fa-dog"></i> Chien' : '<i class="fas fa-cat"></i> Chat' ?>
                                    </span>
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
    align-items: center;
    margin-bottom: 20px;
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
    padding: 8px 15px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    font-size: 14px;
    background-color: white;
}

/* Tableau des produits */
.products-table-wrapper {
    overflow-x: auto;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    margin-bottom: 25px;
}

.products-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

.products-table th {
    padding: 15px;
    background-color: #f9f9f9;
    font-weight: 600;
    color: #4A3A2D;
    border-bottom: 1px solid #e0e0e0;
}

.products-table td {
    padding: 15px;
    border-bottom: 1px solid #e0e0e0;
    color: #6B3F1D;
}

.products-table tr:last-child td {
    border-bottom: none;
}

.products-table tr:hover {
    background-color: #FFF8F0;
}

.th-image, .td-image {
    width: 80px;
    text-align: center;
}

.th-price, .td-price {
    width: 120px;
    text-align: right;
}

.th-animal, .td-animal {
    width: 120px;
    text-align: center;
}

.th-actions, .td-actions {
    width: 120px;
    text-align: center;
}

.product-thumbnail {
    width: 60px;
    height: 60px;
    object-fit: contain;
    border-radius: 4px;
    background-color: #f9f9f9;
}

.no-image {
    width: 60px;
    height: 60px;
    background-color: #f2f2f2;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #aaa;
    font-size: 20px;
}

.td-name {
    font-weight: 500;
}

.td-description {
    max-width: 300px;
    font-size: 14px;
    color: #777;
}

.animal-badge {
    display: inline-flex;
    align-items: center;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.animal-badge i {
    margin-right: 5px;
}

.animal-badge.chien {
    background-color: #FFE8C6;
    color: #6B3F1D;
}

.animal-badge.chat {
    background-color: #FDD4B0;
    color: #6B3F1D;
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
}

@media (max-width: 768px) {
    .admin-filters {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .sort-select {
        width: 100%;
    }
    
    .th-description, .td-description {
        display: none;
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
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtrage par type d'animal
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productRows = document.querySelectorAll('.product-row');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Retirer la classe active de tous les boutons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            // Afficher/masquer les lignes selon le filtre
            productRows.forEach(row => {
                if (filter === 'all') {
                    row.style.display = '';
                } else {
                    if (row.classList.contains(filter)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    });
});
</script>

<?= $this->include('layouts/footer') ?>
