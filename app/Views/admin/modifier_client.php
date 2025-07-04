<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/modifier_client.css') ?>">

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
            <h1><i class="fas fa-user-edit"></i> Modifier un utilisateur</h1>
            <div class="admin-actions">
        <a href="<?= base_url('admin/clients') ?>" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
            </div>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

        <div class="form-container">
    <form action="<?= base_url('admin/update-client/' . $client['id']) ?>" method="post" class="edit-form">
        <div class="form-grid">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= esc($client['email']) ?>" required>
            </div>

            <div class="form-group">
                <label for="role">Rôle</label>
                <select id="role" name="role" required>
                    <option value="admin" <?= $client['role'] === 'admin' ? 'selected' : '' ?>>Administrateur</option>
                    <option value="client" <?= $client['role'] === 'client' ? 'selected' : '' ?>>Client</option>
                </select>
            </div>

            <div class="form-group">
                <label for="nomcompte">Nom du compte</label>
                <input type="text" id="nomcompte" name="nomcompte" value="<?= esc($client['nomcompte']) ?>" required>
            </div>

            <div class="form-group">
                <label for="prenomcompte">Prénom du compte</label>
                <input type="text" id="prenomcompte" name="prenomcompte" value="<?= esc($client['prenomcompte']) ?>" required>
            </div>

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

            <div class="form-group full-width">
                <label for="password">Nouveau mot de passe (optionnel)</label>
                <input type="password" id="password" name="password" placeholder="Laisser vide pour ne pas changer">
                <small>Minimum 9 caractères</small>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="save-btn">
                <i class="fas fa-save"></i> Enregistrer
            </button>
        </div>
    </form>
        </div>
    </div>
</div>

<?= $this->include('layouts/footer') ?> 