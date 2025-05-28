<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/produits.css') ?>">

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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fonction de tri
    const sortSelect = document.querySelector('.sort-select');
    const tbody = document.querySelector('.products-table tbody');

    if (!sortSelect || !tbody) return;

    function sortTable(sortBy, direction) {
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        const sortFunctions = {
            name: (a, b) => a.querySelector('.td-name').textContent.localeCompare(b.querySelector('.td-name').textContent),
            price: (a, b) => {
                const priceTextA = a.querySelector('.td-price').textContent.replace(/[€\s]/g, '').replace(',', '.');
                const priceTextB = b.querySelector('.td-price').textContent.replace(/[€\s]/g, '').replace(',', '.');
                const priceA = parseFloat(priceTextA) || 0;
                const priceB = parseFloat(priceTextB) || 0;
                return priceA - priceB;
            },
            stock: (a, b) => {
                const stockTextA = a.querySelector('.td-stock .stock-badge').textContent.trim();
                const stockTextB = b.querySelector('.td-stock .stock-badge').textContent.trim();
                const stockA = stockTextA === 'Rupture' ? 0 : parseInt(stockTextA) || 0;
                const stockB = stockTextB === 'Rupture' ? 0 : parseInt(stockTextB) || 0;
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
                    const match = dateText.match(/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})/);
                    if (!match) return new Date(0);
                    const [, day, month, year, hours, minutes] = match;
                    return new Date(year, month - 1, day, hours, minutes);
                };
                return getCreatedDate(a) - getCreatedDate(b);
            },
            updated: (a, b) => {
                const getUpdatedDate = (el) => {
                    const dateText = el.querySelector('.date-updated').textContent;
                    const match = dateText.match(/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})/);
                    if (!match) return new Date(0);
                    const [, day, month, year, hours, minutes] = match;
                    return new Date(year, month - 1, day, hours, minutes);
                };
                return getUpdatedDate(a) - getUpdatedDate(b);
            }
        };

        if (sortFunctions[sortBy]) {
            rows.sort((a, b) => {
                let result = sortFunctions[sortBy](a, b);
                return direction === 'desc' ? -result : result;
            });

            // Réinsérer les lignes triées
            rows.forEach(row => tbody.appendChild(row));
        }
    }

    // Event listener pour le tri
    sortSelect.addEventListener('change', function() {
        const value = this.value;
        if (!value) return;
        
        const parts = value.split('_');
        const sortBy = parts[0];
        const direction = parts[1] || 'asc';
        
        console.log('Tri par:', sortBy, 'Direction:', direction); // Debug
        sortTable(sortBy, direction);
    });

    // Fonction de recherche simple
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim().toLowerCase();
            
            searchTimeout = setTimeout(() => {
                const rows = tbody.querySelectorAll('tr');
                
                rows.forEach(row => {
                    const searchableText = [
                        row.querySelector('.td-name').textContent,
                        row.querySelector('.td-description').textContent,
                        row.querySelector('.td-category').textContent,
                        row.querySelector('.td-brand').textContent,
                        row.querySelector('.td-age').textContent,
                        row.querySelector('.td-flavor').textContent
                    ].join(' ').toLowerCase();
                    
                    if (query === '' || searchableText.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }, 300);
        });
    }
});
</script>

<?= $this->include('layouts/footer') ?>
