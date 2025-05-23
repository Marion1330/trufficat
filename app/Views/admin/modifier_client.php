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
                <li><a href="<?= base_url('admin/produits') ?>"><i class="fas fa-box-open"></i> Produits</a></li>
                <li class="active"><a href="<?= base_url('admin/clients') ?>"><i class="fas fa-users"></i> Clients</a></li>
                <li><a href="<?= base_url('admin/commandes') ?>"><i class="fas fa-shopping-cart"></i> Commandes</a></li>
                <li><a href="<?= base_url('admin/categories') ?>"><i class="fas fa-tags"></i> Catégories</a></li>
                <li><a href="<?= base_url('admin/parametres') ?>"><i class="fas fa-cog"></i> Paramètres</a></li>
            </ul>
        </nav>
    </div>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1><i class="fas fa-user-edit"></i> Modifier un client</h1>
            <div class="admin-actions">
                <a href="<?= base_url('admin/clients') ?>" class="admin-btn secondary"><i class="fas fa-arrow-left"></i> Retour à la liste</a>
            </div>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="edit-form-container">
            <form action="<?= base_url('admin/update-client/' . $client['id']) ?>" method="post" class="admin-form">
                <div class="form-section">
                    <h3>Informations de connexion</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?= esc($client['email']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Nouveau mot de passe (laisser vide si inchangé)</label>
                            <input type="password" id="password" name="password">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Informations du compte</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nomcompte">Nom du compte</label>
                            <input type="text" id="nomcompte" name="nomcompte" value="<?= esc($client['nomcompte']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="prenomcompte">Prénom du compte</label>
                            <input type="text" id="prenomcompte" name="prenomcompte" value="<?= esc($client['prenomcompte']) ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Informations personnelles</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="text" id="nom" name="nom" value="<?= esc($client['nom']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom</label>
                            <input type="text" id="prenom" name="prenom" value="<?= esc($client['prenom']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="telephone">Téléphone</label>
                            <input type="tel" id="telephone" name="telephone" value="<?= esc($client['telephone']) ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Adresse</h3>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="adresse">Adresse</label>
                            <input type="text" id="adresse" name="adresse" value="<?= esc($client['adresse']) ?>" required>
                        </div>
                        <div class="form-group full-width">
                            <label for="complement">Complément d'adresse</label>
                            <input type="text" id="complement" name="complement" value="<?= esc($client['complement']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="code_postal">Code Postal</label>
                            <input type="text" id="code_postal" name="code_postal" value="<?= esc($client['code_postal']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="ville">Ville</label>
                            <input type="text" id="ville" name="ville" value="<?= esc($client['ville']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="departement">Département</label>
                            <input type="text" id="departement" name="departement" value="<?= esc($client['departement']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="pays">Pays</label>
                            <input type="text" id="pays" name="pays" value="<?= esc($client['pays']) ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="admin-btn primary"><i class="fas fa-save"></i> Enregistrer les modifications</button>
                    <a href="<?= base_url('admin/clients') ?>" class="admin-btn secondary">Annuler</a>
                </div>
            </form>
        </div>
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

.admin-btn {
    padding: 8px 15px;
    border-radius: 4px;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    border: none;
    transition: all 0.3s ease;
}

.admin-btn.primary {
    background-color: #D97B29;
    color: white;
}

.admin-btn.secondary {
    background-color: #F2C078;
    color: #4A3A2D;
}

.admin-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.admin-btn.primary:hover {
    background-color: #C16A24;
}

.admin-btn.secondary:hover {
    background-color: #E5B06E;
}

.edit-form-container {
    background: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.form-section {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}

.form-section:last-child {
    border-bottom: none;
}

.form-section h3 {
    color: #4A3A2D;
    margin-bottom: 20px;
    font-size: 18px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #666;
    font-weight: 500;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-group input:focus {
    outline: none;
    border-color: #D97B29;
    box-shadow: 0 0 5px rgba(217, 123, 41, 0.2);
}

.form-actions {
    margin-top: 30px;
    display: flex;
    justify-content: flex-end;
    gap: 15px;
}

.alert {
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.alert-danger {
    background-color: #F2DEDE;
    color: #A94442;
    border: 1px solid #EBCCD1;
}
</style>

<?= $this->include('layouts/footer') ?> 