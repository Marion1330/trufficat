<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="form-container">
    <div class="form-header">
        <h1>Modifier un utilisateur</h1>
        <a href="<?= base_url('admin/clients') ?>" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

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
                <label for="telephone">Téléphone</label>
                <input type="tel" id="telephone" name="telephone" value="<?= esc($client['telephone']) ?>" required>
            </div>

            <div class="form-group full-width">
                <label for="adresse">Adresse</label>
                <input type="text" id="adresse" name="adresse" value="<?= esc($client['adresse']) ?>" required>
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

        <div class="form-actions">
            <button type="submit" class="save-btn">
                <i class="fas fa-save"></i> Enregistrer
            </button>
        </div>
    </form>
</div>

<style>
.form-container {
    background: white;
    padding: 3rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-width: 1200px;
    margin: 0 auto;
}

.form-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 3rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #F2C078;
}

.form-header h1 {
    color: #D97B29;
    font-size: 2rem;
    margin: 0;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.2rem;
    background-color: #F2C078;
    color: #4A3A2D;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.back-btn:hover {
    background-color: #D97B29;
    color: #fff;
    transform: translateY(-2px);
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem 4rem;
    margin-bottom: 2rem;
    padding: 0 2rem;
}

.form-group {
    margin-bottom: 1.8rem;
    position: relative;
}

.form-group.full-width {
    grid-column: 1 / -1;
    max-width: 100%;
    padding: 0;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 0.9rem 1rem;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background-color: #fff;
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #F2C078;
    box-shadow: 0 0 0 3px rgba(242, 192, 120, 0.2);
}

.form-group label {
    display: block;
    margin-bottom: 0.8rem;
    color: #4A3A2D;
    font-weight: 500;
    font-size: 1rem;
    letter-spacing: 0.3px;
}

.form-actions {
    margin-top: 2rem;
    text-align: right;
    padding: 0 2rem;
}

.save-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.9rem 2rem;
    background-color: #D97B29;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 180px;
}

.save-btn:hover {
    background-color: #C16A24;
    transform: translateY(-2px);
}

.alert {
    padding: 1rem;
    margin-bottom: 1.5rem;
    border-radius: 8px;
    font-size: 0.95rem;
}

.alert-danger {
    background-color: #FEE2E2;
    color: #991B1B;
    border: 1px solid #FCA5A5;
}

@media (max-width: 1024px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .form-container {
        padding: 1.5rem;
    }

    .form-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .back-btn {
        width: 100%;
        justify-content: center;
    }

    .save-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
<?= $this->endSection() ?> 