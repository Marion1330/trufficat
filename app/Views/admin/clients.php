<?= $this->include('layouts/header') ?>

<div class="admin-container">
    <div class="admin-sidebar">
        <div class="admin-profile">
            <h3>Administrateur</h3>
            <p><?= session('email') ?? 'admin@trufficat.com' ?></p>
        </div>
        
        <nav class="admin-nav">
            <ul>
                <li><a href="<?= base_url('admin') ?>"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a></li>
                <li><a href="<?= base_url('admin/produits') ?>"><i class="fas fa-box-open"></i> Produits</a></li>
                <li class="active"><a href="<?= base_url('admin/clients') ?>"><i class="fas fa-users"></i> Clients</a></li>
                <li><a href="<?= base_url('admin/commandes') ?>"><i class="fas fa-shopping-cart"></i> Commandes</a></li>
            </ul>
        </nav>
    </div>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1><i class="fas fa-users"></i> Gestion des clients</h1>
            <div class="admin-actions">
                <form action="" method="get" class="search-form" onsubmit="return false;">
                    <input type="text" placeholder="Rechercher un client..." name="search" id="searchInput">
                    <button type="button"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (empty($clients)): ?>
            <div class="no-clients">
                <i class="fas fa-users"></i>
                <p>Aucun client n'a été trouvé.</p>
            </div>
        <?php else: ?>
            <div class="products-table-wrapper">
                <table class="products-table">
                    <thead>
                        <tr>
                            <th class="th-name">Nom</th>
                            <th class="th-name">Prénom</th>
                            <th class="th-email">Email</th>
                            <th class="th-phone">Téléphone</th>
                            <th class="th-address">Adresse</th>
                            <th class="th-postal">Code Postal</th>
                            <th class="th-city">Ville</th>
                            <th class="th-role">Rôle</th>
                            <th class="th-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $client): ?>
                            <tr>
                                <td class="td-name"><?= esc($client['nom']) ?></td>
                                <td class="td-name"><?= esc($client['prenom']) ?></td>
                                <td class="td-email"><?= esc($client['email']) ?></td>
                                <td class="td-phone"><?= esc($client['telephone']) ?></td>
                                <td class="td-address"><?= esc($client['adresse']) ?></td>
                                <td class="td-postal"><?= esc($client['code_postal']) ?></td>
                                <td class="td-city"><?= esc($client['ville']) ?></td>
                                <td class="td-role">
                                    <span class="role-badge <?= strtolower($client['role']) ?>">
                                        <?= ucfirst($client['role']) ?>
                                    </span>
                                </td>
                                <td class="td-actions">
                                    <div class="action-buttons">
                                        <a href="<?= base_url('admin/modifier-client/' . $client['id']) ?>" class="action-btn edit-btn" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="action-btn delete-btn" onclick="confirmerSuppression(<?= $client['id'] ?>)" title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('.products-table tbody tr');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
});

function confirmerSuppression(id) {
    window.location.href = '<?= base_url('admin/supprimer-client/') ?>' + id;
}
</script>

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

.products-table-wrapper {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    overflow-x: auto;
    margin-top: 20px;
}

.products-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

.products-table th,
.products-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.products-table th {
    background-color: #D97B29;
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
}

.products-table tr:hover {
    background-color: #FFF8F0;
}

.products-table td {
    color: #4A3A2D;
    font-size: 14px;
}

.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    transition: all 0.3s ease;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.action-btn.edit-btn {
    background-color: #4A90E2;
}

.action-btn.delete-btn {
    background-color: #E25C5C;
}

.table-scroll-hint {
    color: #666;
    font-size: 14px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.no-clients {
    text-align: center;
    padding: 40px;
    background: white;
    border-radius: 8px;
    margin-top: 20px;
}

.no-clients i {
    font-size: 48px;
    color: #D97B29;
    margin-bottom: 15px;
}

.no-clients p {
    color: #666;
    margin: 0;
}

.alert {
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.alert-success {
    background-color: #DFF0D8;
    color: #3C763D;
    border: 1px solid #D6E9C6;
}

.alert-danger {
    background-color: #F2DEDE;
    color: #A94442;
    border: 1px solid #EBCCD1;
}

/* Style pour la modal de confirmation */
.modal-content {
    border-radius: 8px;
    border: none;
}

.modal-header {
    background-color: #F8F9FA;
    border-bottom: 1px solid #E9ECEF;
    border-radius: 8px 8px 0 0;
}

.modal-title {
    color: #333;
}

.modal-body {
    padding: 20px;
    color: #666;
}

.modal-footer {
    border-top: 1px solid #E9ECEF;
    padding: 15px;
}

.btn {
    padding: 8px 16px;
    border-radius: 4px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-secondary {
    background-color: #6C757D;
    border: none;
    color: white;
}

.btn-danger {
    background-color: #DC3545;
    border: none;
    color: white;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Styles spécifiques pour les colonnes */
.th-name, .td-name {
    color: #D97B29;
    font-weight: 500;
}

.th-email, .td-email {
    color: #4A90E2;
}

.th-phone, .td-phone {
    color: #50B83C;
}

.th-address, .td-address {
    color: #9C6F44;
}

.th-postal, .td-postal {
    color: #7E57C2;
}

.th-city, .td-city {
    color: #F5A623;
}

.th-role, .td-role {
    text-align: center;
}

.role-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
    text-transform: capitalize;
    background-color: #F2C078;
    color: #4A3A2D;
}

.role-badge.admin {
    background-color: #D97B29;
    color: white;
}

.role-badge.client {
    background-color: #F2C078;
    color: #4A3A2D;
}

.role-badge.vendeur {
    background-color: #C16A24;
    color: white;
}
</style>

<?= $this->include('layouts/footer') ?> 