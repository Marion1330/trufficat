<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/style.css') ?>" />

<main class="form-container">
  <h1>Inscription</h1>

  <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger">
      <?= session()->getFlashdata('error') ?>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
      <?= session()->getFlashdata('success') ?>
    </div>
  <?php endif; ?>

  <form action="<?= base_url('inscription') ?>" method="POST">
    <label for="nom">Nom</label>
    <input type="text" id="nom" name="nom" required>

    <label for="prenom">Prénom</label>
    <input type="text" id="prenom" name="prenom" required>

    <label for="email">Adresse e-mail</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Mot de passe</label>
    <input type="password" id="password" name="password" required>

    <label for="confirm-password">Confirmer le mot de passe</label>
    <input type="password" id="confirm-password" name="confirm-password" required>

    <button type="submit" class="btn">Créer un compte</button>
  </form>
</main>

<?= $this->include('layouts/footer') ?>
