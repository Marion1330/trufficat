<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/admin-dashboard.css') ?>">

<div class="admin-container">
    <div class="admin-sidebar">
        <div class="admin-profile">
            <h3>Administrateur</h3>
            <p><?= session('email') ?? 'admin@trufficat.com' ?></p>
        </div>
        
        <nav class="admin-nav">
            <ul>
                <li class="active"><a href="<?= base_url('admin') ?>"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a></li>
                <li><a href="<?= base_url('admin/produits') ?>"><i class="fas fa-box-open"></i> Produits</a></li>
                <li><a href="<?= base_url('admin/clients') ?>"><i class="fas fa-users"></i> Clients</a></li>
                <li><a href="<?= base_url('admin/commandes') ?>"><i class="fas fa-shopping-cart"></i> Commandes</a></li>
            </ul>
        </nav>
    </div>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1><i class="fas fa-tachometer-alt"></i> Tableau de bord</h1>
            <div class="admin-actions">
                <span class="date-display"><?= date('d/m/Y') ?></span>
                <a href="<?= base_url('deconnexion') ?>" class="admin-logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
            </div>
        </div>
        
        <div class="admin-stats">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-box-open"></i></div>
                <div class="stat-info">
                    <h3>Produits</h3>
                    <p class="stat-number"><?= $total_produits ?></p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-info">
                    <h3>Clients</h3>
                    <p class="stat-number">48</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
                <div class="stat-info">
                    <h3>Commandes</h3>
                    <p class="stat-number">32</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-euro-sign"></i></div>
                <div class="stat-info">
                    <h3>Revenus</h3>
                    <p class="stat-number">4 520 €</p>
                </div>
            </div>
        </div>
        
        <div class="admin-quick-links">
            <h2>Accès rapides</h2>
            <div class="quick-links-grid">
                <a href="<?= base_url('admin/produit/ajouter') ?>" class="quick-link">
                    <i class="fas fa-plus-circle"></i>
                    <span>Ajouter un produit</span>
                </a>
                <a href="<?= base_url('admin/commandes/recentes') ?>" class="quick-link">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Commandes récentes</span>
                </a>
                <a href="<?= base_url('admin/messages') ?>" class="quick-link">
                    <i class="fas fa-envelope"></i>
                    <span>Messages</span>
                </a>
                <a href="<?= base_url('admin/statistiques') ?>" class="quick-link">
                    <i class="fas fa-chart-bar"></i>
                    <span>Statistiques</span>
                </a>
            </div>
        </div>
        
        <div class="admin-recent-activities">
            <h2>Activités récentes</h2>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon"><i class="fas fa-shopping-cart"></i></div>
                    <div class="activity-details">
                        <h4>Nouvelle commande #1234</h4>
                        <p>Client: Jean Dupont</p>
                        <span class="activity-time">Il y a 2 heures</span>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon"><i class="fas fa-user-plus"></i></div>
                    <div class="activity-details">
                        <h4>Nouveau client inscrit</h4>
                        <p>Marie Martin a créé un compte</p>
                        <span class="activity-time">Il y a 4 heures</span>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon"><i class="fas fa-box"></i></div>
                    <div class="activity-details">
                        <h4>Produit mis à jour</h4>
                        <p>Croquettes Premium pour Chat a été modifié</p>
                        <span class="activity-time">Il y a 1 jour</span>
                    </div>
                </div>
            </div>
        </div>
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
}

.date-display {
    margin-right: 20px;
    font-size: 14px;
    color: #6B3F1D;
}

.admin-logout {
    padding: 8px 15px;
    background-color: #F2C078;
    color: #4A3A2D;
    border-radius: 4px;
    text-decoration: none;
    font-size: 14px;
    transition: background-color 0.3s;
}

.admin-logout:hover {
    background-color: #D97B29;
    color: white;
}

/* Stats Cards */
.admin-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background-color: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 60px;
    height: 60px;
    background-color: #FFF8F0;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #D97B29;
    margin-right: 15px;
}

.stat-info h3 {
    margin: 0 0 5px;
    font-size: 16px;
    color: #6B3F1D;
}

.stat-number {
    font-size: 24px;
    font-weight: bold;
    color: #D97B29;
    margin: 0;
}

/* Quick Links */
.admin-quick-links,
.admin-recent-activities {
    background-color: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.admin-quick-links h2,
.admin-recent-activities h2 {
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 18px;
    color: #4A3A2D;
    padding-bottom: 10px;
    border-bottom: 1px solid #e0e0e0;
}

.quick-links-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 15px;
}

.quick-link {
    background-color: #FFF8F0;
    border-radius: 8px;
    padding: 15px;
    text-decoration: none;
    text-align: center;
    color: #6B3F1D;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.quick-link i {
    font-size: 24px;
    margin-bottom: 10px;
    color: #D97B29;
}

.quick-link span {
    font-size: 14px;
    font-weight: 500;
}

.quick-link:hover {
    background-color: #D97B29;
    color: white;
}

.quick-link:hover i {
    color: white;
}

/* Activity List */
.activity-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.activity-item {
    display: flex;
    align-items: center;
    padding: 12px;
    border-radius: 8px;
    background-color: #FFF8F0;
    transition: background-color 0.3s ease;
}

.activity-item:hover {
    background-color: #FFE8C6;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background-color: #D97B29;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
}

.activity-details h4 {
    margin: 0 0 5px;
    font-size: 16px;
    color: #4A3A2D;
}

.activity-details p {
    margin: 0 0 5px;
    font-size: 14px;
    color: #6B3F1D;
}

.activity-time {
    font-size: 12px;
    color: #888;
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
    
    .admin-stats {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .quick-links-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .admin-stats {
        grid-template-columns: 1fr;
    }
    
    .quick-links-grid {
        grid-template-columns: 1fr;
    }
    
    .admin-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .admin-actions {
        margin-top: 15px;
    }
}
</style>

<?= $this->include('layouts/footer') ?>
