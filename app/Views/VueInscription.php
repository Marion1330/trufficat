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

    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom" value="<?= esc(set_value('nom')) ?>" required><br>

    <label for="prenom">Prénom :</label>
    <input type="text" name="prenom" id="prenom" value="<?= esc(set_value('prenom')) ?>" required><br>

    <label for="email">Email :</label>
    <input type="email" name="email" id="email" value="<?= esc(set_value('email')) ?>" required><br>

    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" minlength="9" required>
    <small id="password-help" class="form-text">Le mot de passe doit contenir au minimum 9 caractères.</small><br>

    <label for="confirm-password">Confirmer le mot de passe :</label>
    <input type="password" name="confirm-password" id="confirm-password" minlength="9" required>
    <small id="confirm-password-help" class="form-text"></small><br>

    <label for="telephone">Téléphone :</label>
    <input type="text" name="telephone" id="telephone" value="<?= esc(set_value('telephone')) ?>" required><br>

    <hr>
    <h2>Adresse postale</h2>

    <label for="adresse">Adresse :</label>
    <input type="text" name="adresse" id="adresse" value="<?= esc(set_value('adresse')) ?>" required><br>

    <label for="complement">Complément :</label>
    <input type="text" name="complement" id="complement" value="<?= esc(set_value('complement')) ?>"><br>

    <label for="code_postal">Code postal :</label>
    <input type="text" name="code_postal" id="code_postal" value="<?= esc(set_value('code_postal')) ?>" required><br>

    <label for="ville">Ville :</label>
    <input type="text" name="ville" id="ville" value="<?= esc(set_value('ville')) ?>" required><br>

    <label for="pays">Pays :</label>
    <select name="pays" id="pays" data-valeur="<?= esc(set_value('pays')) ?>" required>
      <option value="">Sélectionnez un pays</option>
    </select><br>

    <label for="departement">Département :</label>
    <select name="departement" id="departement" data-valeur="<?= esc(set_value('departement')) ?>" required>
      <option value="">Sélectionnez d'abord un pays</option>
    </select><br>

    <button type="submit" class="btn btn-primary">S'inscrire</button>
  </form>
</main>

<!-- Inclure le script pour les sélecteurs dynamiques -->
<script src="<?= base_url('js/address-manager.js') ?>"></script>

<!-- Script de validation des mots de passe -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm-password');
    const passwordHelp = document.getElementById('password-help');
    const confirmPasswordHelp = document.getElementById('confirm-password-help');
    const form = document.querySelector('form');

    // Validation du mot de passe principal
    password.addEventListener('input', function() {
        const value = this.value;
        if (value.length === 0) {
            passwordHelp.textContent = 'Le mot de passe doit contenir au minimum 9 caractères.';
            passwordHelp.style.color = '#666';
        } else if (value.length < 9) {
            passwordHelp.textContent = `Il manque ${9 - value.length} caractère${9 - value.length > 1 ? 's' : ''}.`;
            passwordHelp.style.color = '#dc3545';
        } else {
            passwordHelp.textContent = 'Mot de passe valide ✓';
            passwordHelp.style.color = '#28a745';
        }
        validateConfirmPassword();
    });

    // Validation de la confirmation
    confirmPassword.addEventListener('input', validateConfirmPassword);

    function validateConfirmPassword() {
        const value = confirmPassword.value;
        const passwordValue = password.value;
        
        if (value.length === 0) {
            confirmPasswordHelp.textContent = '';
        } else if (value !== passwordValue) {
            confirmPasswordHelp.textContent = 'Les mots de passe ne correspondent pas.';
            confirmPasswordHelp.style.color = '#dc3545';
        } else if (passwordValue.length >= 9) {
            confirmPasswordHelp.textContent = 'Confirmation valide ✓';
            confirmPasswordHelp.style.color = '#28a745';
        }
    }

    // Validation du formulaire avant soumission
    form.addEventListener('submit', function(e) {
        const passwordValue = password.value;
        const confirmPasswordValue = confirmPassword.value;

        if (passwordValue.length < 9) {
            e.preventDefault();
            alert('Le mot de passe doit contenir au minimum 9 caractères.');
            password.focus();
            return false;
        }

        if (passwordValue !== confirmPasswordValue) {
            e.preventDefault();
            alert('Les mots de passe ne correspondent pas.');
            confirmPassword.focus();
            return false;
        }
    });
});
</script>

<?= $this->include('layouts/footer') ?>
