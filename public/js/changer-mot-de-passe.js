// Validation du formulaire de changement de mot de passe
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