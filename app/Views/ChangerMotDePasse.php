<?= $this->include('layouts/header') ?>

<h2>Changer de mot de passe</h2>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<form action="<?= base_url('changer-mot-de-passe') ?>" method="post">
    <?= csrf_field() ?>
    <label for="ancien">Ancien mot de passe :</label>
    <input type="password" name="ancien" id="ancien" required><br>

    <label for="nouveau">Nouveau mot de passe :</label>
    <input type="password" name="nouveau" id="nouveau" required><br>

    <label for="confirmer">Confirmer le nouveau mot de passe :</label>
    <input type="password" name="confirmer" id="confirmer" required><br>

    <button type="submit" class="btn btn-primary btn-sm">Changer</button>
    <a href="<?= base_url('profil') ?>" class="btn btn-secondary btn-sm">Retour au profil</a>
</form>

<?= $this->include('layouts/footer') ?>