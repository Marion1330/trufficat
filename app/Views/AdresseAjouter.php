<?= $this->include('layouts/header') ?>

<h2>Ajouter une adresse</h2>

<form action="<?= base_url('adresse/ajouter') ?>" method="post">
    <?= csrf_field() ?>

    <label for="titre">Titre de l’adresse (ex. Domicile, Travail) :</label>
    <input type="text" name="titre" required><br>

    <label for="adresse">Adresse :</label>
    <input type="text" name="adresse" required><br>

    <label for="complement">Complément d’adresse :</label>
    <input type="text" name="complement"><br>

    <label for="code_postal">Code postal :</label>
    <input type="text" name="code_postal" required><br>

    <label for="ville">Ville :</label>
    <input type="text" name="ville" required><br>

    <label for="pays">Pays :</label>
    <input type="text" name="pays" required><br>

    <label for="telephone">Téléphone :</label>
    <input type="text" name="telephone"><br>

    <button type="submit">Ajouter</button>
</form>

<a href="<?= base_url('profil') ?>">← Retour au profil</a>

<?= $this->include('layouts/footer') ?>
