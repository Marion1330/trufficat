<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/style.css') ?>" />

<main class="form-container">
<h2>Inscription</h2>

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
    <?= csrf_field() ?>

    <label for="nom">Nom* :</label>
    <input type="text" name="nom" id="nom" value="<?= esc(set_value('nom')) ?>" required><br>

    <label for="prenom">Prénom* :</label>
    <input type="text" name="prenom" id="prenom" value="<?= esc(set_value('prenom')) ?>" required><br>

    <label for="email">Email* :</label>
    <input type="email" name="email" id="email" value="<?= esc(set_value('email')) ?>" required><br>

    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" minlength="9" required>
    <small id="password-help" class="form-text">Le mot de passe doit contenir au minimum 9 caractères.</small><br>

    <label for="confirm-password">Confirmer le mot de passe* :</label>
    <input type="password" name="confirm-password" id="confirm-password" minlength="9" required>
    <small id="confirm-password-help" class="form-text"></small><br>

    <label for="telephone">Téléphone* :</label>
    <input type="text" name="telephone" id="telephone" value="<?= esc(set_value('telephone')) ?>" required><br>

    <hr>
    <h2>Adresse postale</h2>

    <label for="adresse">Adresse* :</label>
    <input type="text" name="adresse" id="adresse" value="<?= esc(set_value('adresse')) ?>" required><br>

    <label for="complement">Complément :</label>
    <input type="text" name="complement" id="complement" value="<?= esc(set_value('complement')) ?>"><br>

    <label for="code_postal">Code postal* :</label>
    <input type="text" name="code_postal" id="code_postal" value="<?= esc(set_value('code_postal')) ?>" required><br>

    <label for="ville">Ville* :</label>
    <input type="text" name="ville" id="ville" value="<?= esc(set_value('ville')) ?>" required><br>

    <label for="pays">Pays :</label>
    <select name="pays" id="pays" data-valeur="<?= esc(set_value('pays')) ?>" required>
      <option value="">Sélectionnez un pays</option>
    </select><br>

    <label for="departement">Département* :</label>
    <select name="departement" id="departement" data-valeur="<?= esc(set_value('departement')) ?>" required>
      <option value="">Sélectionnez d'abord un pays</option>
    </select><br>

    <button type="submit" class="btn btn-primary">S'inscrire</button>
  </form>
</main>

<!-- Inclure les scripts JavaScript -->
<script src="<?= base_url('js/address-manager.js') ?>"></script>
<script src="<?= base_url('js/inscription-validation.js') ?>"></script>

<?= $this->include('layouts/footer') ?>
