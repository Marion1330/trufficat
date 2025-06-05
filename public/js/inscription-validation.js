// Validation du formulaire d'inscription
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