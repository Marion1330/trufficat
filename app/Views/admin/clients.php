<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/clients.css') ?>">

<div class="admin-container">
    <div class="admin-sidebar">
        <div class="admin-profile">
            <h3>Administrateur</h3>
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

<?= $this->include('layouts/footer') ?> 