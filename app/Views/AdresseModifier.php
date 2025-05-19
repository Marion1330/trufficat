<?= $this->include('layouts/header') ?>

<main class="form-container">
    <h2>Modifier l’adresse</h2>

    <form action="<?= isset($isPrincipale) && $isPrincipale ? base_url('profil/modifier-adresse-principale') : base_url('adresse/modifier/'.$adresse['id']) ?>" method="post">
        <?= csrf_field() ?>

        <label for="titre">Titre :</label>
        <input type="text" name="titre" value="<?= esc($adresse['titre']) ?>" required><br>

        <label for="adresse">Adresse :</label>
        <input type="text" name="adresse" value="<?= esc($adresse['adresse']) ?>" required><br>

        <label for="complement">Complément :</label>
        <input type="text" name="complement" value="<?= esc($adresse['complement']) ?>"><br>

        <label for="code_postal">Code postal :</label>
        <input type="text" name="code_postal" value="<?= esc($adresse['code_postal']) ?>" required><br>

        <label for="ville">Ville :</label>
        <input type="text" name="ville" value="<?= esc($adresse['ville']) ?>" required><br>

        <label for="departement">Département :</label>
        <input type="text" name="departement" value="<?= esc($adresse['departement']) ?>"><br>

        <label for="pays">Pays :</label>
        <input type="text" name="pays" value="<?= esc($adresse['pays']) ?>" required><br>

        <label for="telephone">Téléphone :</label>
        <input type="text" name="telephone" value="<?= esc($adresse['telephone']) ?>"><br>

        <label>
            <input type="checkbox" name="is_principale" value="1" <?= $adresse['is_principale'] ? 'checked' : '' ?>>
            Définir comme adresse principale
        </label><br>

        <div class="form-btns">
            <button type="button" class="btn btn-secondary btn-sm btn-annuler" onclick="window.location.href='<?= base_url('profil') ?>'">Annuler</button>
            <button type="submit" class="btn btn-primary btn-sm">Enregistrer les modifications</button>
        </div>
    </form>
</main>

<?= $this->include('layouts/footer') ?>

