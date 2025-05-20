<?= $this->include('layouts/header') ?>

<main class="form-container">
    <h2>Ajouter une adresse</h2>
    <form action="<?= base_url('adresse/ajouter') ?>" method="post">
        <?= csrf_field() ?>

        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" required><br>
        <label for="adresse">Adresse :</label>
        <input type="text" name="adresse" id="adresse" required><br>

        <label for="complement">Complément d'adresse :</label>
        <input type="text" name="complement" id="complement"><br>

        <label for="code_postal">Code postal :</label>
        <input type="text" name="code_postal" id="code_postal" required><br>

        <label for="ville">Ville :</label>
        <input type="text" name="ville" id="ville" required><br>

        <label for="pays">Pays :</label>
        <select name="pays" id="pays" required>
            <option value="">Sélectionnez un pays</option>
        </select><br>

        <label for="departement">Département :</label>
        <select name="departement" id="departement" required disabled>
            <option value="">Sélectionnez d'abord un pays</option>
        </select><br>

        <label for="telephone">Téléphone :</label>
        <input type="text" name="telephone" id="telephone"><br>

        <div class="form-btns">
            <button type="button" class="btn btn-secondary btn-sm btn-annuler" onclick="window.location.href='<?= base_url('profil') ?>'">Annuler</button>
            <button type="submit" class="btn btn-primary btn-sm">Ajouter</button>
        </div>
    </form>
</main>

<!-- Inclure le script pour les sélecteurs dynamiques -->
<script src="<?= base_url('js/address-manager.js') ?>"></script>

<?= $this->include('layouts/footer') ?>
