document.addEventListener('DOMContentLoaded', function() {
    // Gestion de l'ajout au panier
    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            
            // Ajouter au panier via AJAX (à implémenter)
            alert('Produit ajouté au panier !');
        });
    });
    
    // Gestion du slider de prix
    const minSlider = document.getElementById('price-min-slider');
    const maxSlider = document.getElementById('price-max-slider');
    const minDisplay = document.getElementById('price-min-display');
    const maxDisplay = document.getElementById('price-max-display');
    const minInput = document.getElementById('prix_min');
    const maxInput = document.getElementById('prix_max');
    
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
}); 