<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/style.css') ?>" />

<main class="form-container">
  <h1>Connexion</h1>
  <form action="<?= base_url('connexion') ?>" method="POST">
    <label for="email">Adresse e-mail</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Mot de passe</label>
    <input type="password" id="password" name="password" required>

    <button type="submit" class="btn">Se connecter</button>
  </form>

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
</main>

<?= $this->include('layouts/footer') ?>
