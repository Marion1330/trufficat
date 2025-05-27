<?= $this->include('layouts/header') ?>

<div class="admin-container">
    <div class="admin-sidebar">
        <div class="admin-profile">
            <h3>Administrateur</h3>
        </div>
        
        <nav class="admin-nav">
            <ul>
                <li><a href="<?= base_url('admin') ?>"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a></li>
                <li><a href="<?= base_url('admin/produits') ?>"><i class="fas fa-box-open"></i> Produits</a></li>
                <li><a href="<?= base_url('admin/clients') ?>"><i class="fas fa-users"></i> Clients</a></li>
                <li class="active"><a href="<?= base_url('admin/commandes') ?>"><i class="fas fa-shopping-cart"></i> Commandes</a></li>
            </ul>
        </nav>
    </div>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1><i class="fas fa-shopping-cart"></i> Gestion des commandes</h1>
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

        <?php if (empty($commandes)): ?>
            <div class="no-commandes">
                <i class="fas fa-shopping-cart"></i>
                <p>Aucune commande n'a été trouvée.</p>
            </div>
        <?php else: ?>
            <div class="commandes-table-wrapper">
                <table class="commandes-table">
                    <thead>
                        <tr>
                            <th>N° Commande</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($commandes as $commande): ?>
                            <tr>
                                <td class="td-numero">
                                    <strong><?= esc($commande['numero_commande']) ?></strong>
                                </td>
                                <td class="td-client">
                                    <div class="client-info">
                                        <strong><?= esc($commande['nom']) ?> <?= esc($commande['prenom']) ?></strong>
                                        <br>
                                        <small><?= esc($commande['email']) ?></small>
                                    </div>
                                </td>
                                <td class="td-date">
                                    <?= date('d/m/Y H:i', strtotime($commande['date_commande'])) ?>
                                </td>
                                <td class="td-total">
                                    <strong><?= number_format($commande['total'], 2, ',', ' ') ?> €</strong>
                                </td>
                                <td class="td-statut">
                                    <span class="statut-badge statut-<?= $commande['statut'] ?>">
                                        <?php
                                        $statuts = [
                                            'en_attente' => 'En attente',
                                            'validee' => 'Validée',
                                            'en_preparation' => 'En préparation',
                                            'expediee' => 'Expédiée',
                                            'livree' => 'Livrée',
                                            'annulee' => 'Annulée'
                                        ];
                                        echo $statuts[$commande['statut']] ?? $commande['statut'];
                                        ?>
                                    </span>
                                </td>
                                <td class="td-actions">
                                    <div class="action-buttons">
                                        <a href="<?= base_url('admin/commande/' . $commande['id']) ?>" 
                                           class="btn-action btn-view" title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <form method="post" action="<?= base_url('admin/commande/statut/' . $commande['id']) ?>" 
                                              style="display: inline-block;">
                                            <?= csrf_field() ?>
                                            <select name="statut" onchange="this.form.submit()" class="statut-select">
                                                <option value="en_attente" <?= $commande['statut'] == 'en_attente' ? 'selected' : '' ?>>En attente</option>
                                                <option value="validee" <?= $commande['statut'] == 'validee' ? 'selected' : '' ?>>Validée</option>
                                                <option value="en_preparation" <?= $commande['statut'] == 'en_preparation' ? 'selected' : '' ?>>En préparation</option>
                                                <option value="expediee" <?= $commande['statut'] == 'expediee' ? 'selected' : '' ?>>Expédiée</option>
                                                <option value="livree" <?= $commande['statut'] == 'livree' ? 'selected' : '' ?>>Livrée</option>
                                                <option value="annulee" <?= $commande['statut'] == 'annulee' ? 'selected' : '' ?>>Annulée</option>
                                            </select>
                                        </form>
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

<style>
/* Styles pour la gestion des commandes */
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

.alert {
    padding: 12px 20px;
    margin-bottom: 20px;
    border-radius: 4px;
    font-size: 14px;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.no-commandes {
    text-align: center;
    padding: 60px 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.no-commandes i {
    font-size: 48px;
    color: #D97B29;
    margin-bottom: 20px;
}

.no-commandes p {
    font-size: 18px;
    color: #6B3F1D;
    margin: 0;
}

.commandes-table-wrapper {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    overflow-x: auto;
}

.commandes-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.commandes-table th {
    background-color: #F2C078;
    color: #4A3A2D;
    padding: 15px 12px;
    text-align: left;
    font-weight: 600;
    border-bottom: 2px solid #D97B29;
}

.commandes-table td {
    padding: 15px 12px;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: top;
}

.commandes-table tr:hover {
    background-color: #FFF8F0;
}

.td-numero strong {
    color: #D97B29;
}

.client-info strong {
    color: #4A3A2D;
}

.client-info small {
    color: #6B3F1D;
}

.td-total strong {
    color: #D97B29;
}

.statut-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.statut-en_attente {
    background-color: #fff3cd;
    color: #856404;
}

.statut-payee {
    background-color: #d4edda;
    color: #155724;
}

.statut-expediee {
    background-color: #cce5ff;
    color: #004085;
}

.statut-livree {
    background-color: #d1ecf1;
    color: #0c5460;
}

.statut-annulee {
    background-color: #f8d7da;
    color: #721c24;
}

.action-buttons {
    display: flex;
    gap: 8px;
    align-items: center;
}

.btn-action {
    padding: 6px 10px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 12px;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-view {
    background-color: #D97B29;
    color: white;
}

.btn-view:hover {
    background-color: #A44D25;
    color: white;
}

.statut-select {
    padding: 4px 8px;
    border: 1px solid #D97B29;
    border-radius: 4px;
    font-size: 12px;
    background-color: white;
    color: #4A3A2D;
}

.statut-select:focus {
    outline: none;
    border-color: #A44D25;
}

@media (max-width: 992px) {
    .admin-container {
        flex-direction: column;
    }
    
    .admin-sidebar {
        width: 100%;
    }
    
    .commandes-table-wrapper {
        overflow-x: scroll;
    }
    
    .commandes-table {
        min-width: 800px;
    }
}
</style>

<?= $this->include('layouts/footer') ?> 