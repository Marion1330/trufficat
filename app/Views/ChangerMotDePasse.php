<?= $this->include('layouts/header') ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<form action="<?= base_url('changer-mot-de-passe') ?>" method="post" class="form-container">
    <?= csrf_field() ?>
    <h2>Changer de mot de passe</h2>
    <label for="ancien">Ancien mot de passe :</label>
    <input type="password" name="ancien" id="ancien" required><br>

    <label for="nouveau">Nouveau mot de passe :</label>
    <input type="password" name="nouveau" id="nouveau" minlength="9" required>
    <small id="nouveau-help" class="form-text">Le mot de passe doit contenir au minimum 9 caractères.</small><br>

    <label for="confirmer">Confirmer le nouveau mot de passe :</label>
    <input type="password" name="confirmer" id="confirmer" minlength="9" required>
    <small id="confirmer-help" class="form-text"></small><br>

    <div class="form-btns">
        <button type="button" class="btn btn-secondary btn-sm btn-annuler" onclick="window.location.href='<?= base_url('profil') ?>'">Annuler</button>
        <button type="submit" class="btn btn-primary btn-sm">Changer</button>
    </div>
</form>

<!-- Script de validation des mots de passe -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nouveau = document.getElementById('nouveau');
    const confirmer = document.getElementById('confirmer');
    const nouveauHelp = document.getElementById('nouveau-help');
    const confirmerHelp = document.getElementById('confirmer-help');
    const form = document.querySelector('form');

    // Validation du nouveau mot de passe
    nouveau.addEventListener('input', function() {
        const value = this.value;
        if (value.length === 0) {
            nouveauHelp.textContent = 'Le mot de passe doit contenir au minimum 9 caractères.';
            nouveauHelp.style.color = '#666';
        } else if (value.length < 9) {
            nouveauHelp.textContent = `Il manque ${9 - value.length} caractère${9 - value.length > 1 ? 's' : ''}.`;
            nouveauHelp.style.color = '#dc3545';
        } else {
            nouveauHelp.textContent = 'Mot de passe valide ✓';
            nouveauHelp.style.color = '#28a745';
        }
        validateConfirmPassword();
    });

    // Validation de la confirmation
    confirmer.addEventListener('input', validateConfirmPassword);

    function validateConfirmPassword() {
        const value = confirmer.value;
        const nouveauValue = nouveau.value;
        
        if (value.length === 0) {
            confirmerHelp.textContent = '';
        } else if (value !== nouveauValue) {
            confirmerHelp.textContent = 'Les mots de passe ne correspondent pas.';
            confirmerHelp.style.color = '#dc3545';
        } else if (nouveauValue.length >= 9) {
            confirmerHelp.textContent = 'Confirmation valide ✓';
            confirmerHelp.style.color = '#28a745';
        }
    }

    // Validation du formulaire avant soumission
    form.addEventListener('submit', function(e) {
        const nouveauValue = nouveau.value;
        const confirmerValue = confirmer.value;

        if (nouveauValue.length < 9) {
            e.preventDefault();
            alert('Le nouveau mot de passe doit contenir au minimum 9 caractères.');
            nouveau.focus();
            return false;
        }

        if (nouveauValue !== confirmerValue) {
            e.preventDefault();
            alert('Les mots de passe ne correspondent pas.');
            confirmer.focus();
            return false;
        }
    });
});
</script>

<?= $this->include('layouts/footer') ?>