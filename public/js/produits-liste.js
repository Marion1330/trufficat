document.addEventListener('DOMContentLoaded', function() {
    // Gestion des boutons "Ajouter au panier"
    document.querySelectorAll('.btn-add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            
            fetch(baseUrl + 'index.php/panier/ajouter', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `produit_id=${productId}&quantite=1`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Produit ajouté silencieusement au panier
                    console.log('Produit ajouté au panier');
                } else {
                    console.error('Erreur lors de l\'ajout au panier:', data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    });
    
    // Gestion du slider de prix
    const minSlider = document.getElementById('price-min-slider');
    const maxSlider = document.getElementById('price-max-slider');
    const minDisplay = document.getElementById('price-min-display');
    const maxDisplay = document.getElementById('price-max-display');
    const minInput = document.getElementById('prix_min');
    const maxInput = document.getElementById('prix_max');
    
    if (minSlider && maxSlider) {
    // Initialiser l'affichage du prix
    minDisplay.textContent = minSlider.value + ' €';
    maxDisplay.textContent = maxSlider.value + ' €';
    
    // Fonction pour mettre à jour les valeurs
    function updateValues() {
        // Assurer que min ne dépasse pas max
        if (parseInt(minSlider.value) > parseInt(maxSlider.value)) {
            minSlider.value = maxSlider.value;
        }
        
        // Mettre à jour l'affichage et les inputs cachés
        minDisplay.textContent = minSlider.value + ' €';
        maxDisplay.textContent = maxSlider.value + ' €';
        minInput.value = minSlider.value;
        maxInput.value = maxSlider.value;
    }
    
    // Événements pour les sliders
    minSlider.addEventListener('input', updateValues);
    maxSlider.addEventListener('input', updateValues);
    }
}); 