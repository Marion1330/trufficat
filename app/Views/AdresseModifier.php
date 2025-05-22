<?= $this->include('layouts/header') ?>

<main class="form-container">
    <h2>Modifier l'adresse</h2>

    <form action="<?= isset($isPrincipale) && $isPrincipale ? base_url('profil/modifier-adresse-principale') : base_url('adresse/modifier/'.$adresse['id']) ?>" method="post">
        <?= csrf_field() ?>
        
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="<?= esc(set_value('nom', $adresse['nom'] ?? '')) ?>" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" value="<?= esc(set_value('prenom', $adresse['prenom'] ?? '')) ?>" required><br>
        
        <label for="adresse">Adresse :</label>
        <input type="text" name="adresse" value="<?= esc(set_value('adresse', $adresse['adresse'] ?? '')) ?>" required><br>

        <label for="complement">Complément :</label>
        <input type="text" name="complement" value="<?= esc(set_value('complement', $adresse['complement'] ?? '')) ?>"><br>

        <label for="code_postal">Code postal :</label>
        <input type="text" name="code_postal" value="<?= esc(set_value('code_postal', $adresse['code_postal'] ?? '')) ?>" required><br>

        <label for="ville">Ville :</label>
        <input type="text" name="ville" value="<?= esc(set_value('ville', $adresse['ville'] ?? '')) ?>" required><br>

        <label for="pays">Pays :</label>
        <select name="pays" id="pays" data-valeur="<?= esc(set_value('pays', $adresse['pays'] ?? '')) ?>" required>
            <option value="">Sélectionnez un pays</option>
        </select><br>

        <label for="departement">Département :</label>
        <select name="departement" id="departement" data-valeur="<?= esc(set_value('departement', $adresse['departement'] ?? '')) ?>" required>
            <option value="">Sélectionnez d'abord un pays</option>
        </select><br>

        <label for="telephone">Téléphone :</label>
        <input type="text" name="telephone" value="<?= esc(set_value('telephone', $adresse['telephone'] ?? '')) ?>"><br>

        <label>
            <input type="checkbox" name="is_principale" value="1"
                <?= set_value('is_principale', $adresse['is_principale'] ?? false) ? 'checked' : '' ?>>
            Définir comme adresse principale
        </label><br>

        <div class="form-btns">
            <button type="button" class="btn btn-secondary btn-sm btn-annuler" onclick="window.location.href='<?= base_url('profil') ?>'">Annuler</button>
            <button type="submit" class="btn btn-primary btn-sm">Enregistrer les modifications</button>
        </div>
    </form>
</main>

<!-- Inclure le script pour les sélecteurs dynamiques -->
<script src="<?= base_url('js/address-manager.js') ?>"></script>

<?= $this->include('layouts/footer') ?>

