<?= $this->include('layouts/header') ?>

<main class="form-container">
    <h2>Modifier mes informations</h2>
    <form action="<?= base_url('profil/modifier-infos') ?>" method="post">
        <?= csrf_field() ?>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" value="<?= esc($user['nomcompte']) ?>" required><br>
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" value="<?= esc($user['prenomcompte']) ?>" required><br>
        <label for="email">Email :</label>
        <input type="email" name="email" value="<?= esc($user['email']) ?>" required><br>
        <label for="telephone">Téléphone* :</label>
        <input type="text" name="telephone" value="<?= esc($user['telephone']) ?>" required><br>
        <div class="form-btns">
            <button type="button" class="btn btn-secondary btn-sm btn-annuler" onclick="window.location.href='<?= base_url('profil') ?>'">Annuler</button>
            <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
        </div>
    </form>
</main>

<?= $this->include('layouts/footer') ?>