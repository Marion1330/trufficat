<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/commandes.css') ?>">

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

<?= $this->include('layouts/footer') ?> 