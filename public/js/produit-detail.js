// Product detail functionality
window.TrufficatProduitDetail = {
    config: {},
    isAdding: false,
    
    init: function(config) {
        this.config = config;
        this.setupEventListeners();
    },
    
    setupEventListeners: function() {
        document.addEventListener('DOMContentLoaded', () => {
            this.setupQuantityControls();
            this.setupAddToCartButton();
        });
    },
    
    setupQuantityControls: function() {
        // Gestion de la quantité
        const quantiteInput = document.getElementById('quantite');
        const quantityBtns = document.querySelectorAll('.quantity-btn');
        
        if (!quantiteInput) return;
        
        quantityBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const action = btn.getAttribute('data-action');
                const currentValue = parseInt(quantiteInput.value);
                const maxValue = parseInt(quantiteInput.getAttribute('max'));
                
                if (action === 'increase' && currentValue < maxValue) {
                    quantiteInput.value = currentValue + 1;
                } else if (action === 'decrease' && currentValue > 1) {
                    quantiteInput.value = currentValue - 1;
                }
            });
        });
        
        // Validation de la saisie manuelle
        quantiteInput.addEventListener('input', function() {
            const value = parseInt(this.value);
            const max = parseInt(this.getAttribute('max'));
            const min = parseInt(this.getAttribute('min'));
            
            if (value > max) {
                this.value = max;
            } else if (value < min || isNaN(value)) {
                this.value = min;
            }
        });
    },
    
    setupAddToCartButton: function() {
        // Gestion de l'ajout au panier
        const addToCartBtn = document.querySelector('.btn-add-to-cart:not(.disabled)');
        if (!addToCartBtn) return;
        
        addToCartBtn.addEventListener('click', (e) => {
            e.preventDefault(); // Empêcher le comportement par défaut
            
            // Si déjà en cours d'ajout, ignorer le clic
            if (this.isAdding) {
                return;
            }
            
            this.isAdding = true;
            addToCartBtn.disabled = true;
            addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Ajout en cours...';
            
            const productId = addToCartBtn.dataset.productId;
            const quantite = parseInt(document.getElementById('quantite').value);
            
            // Vérification de la quantité
            if (!quantite || quantite < 1) {
                // Redirection vers le panier même si quantité invalide
                window.location.href = this.config.panierUrl;
                return;
            }
            
            fetch(this.config.addToCartUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `produit_id=${productId}&quantite=${quantite}`
            })
            .then(response => response.json())
            .then(data => {
                // Redirection vers le panier dans tous les cas
                window.location.href = this.config.panierUrl;
            })
            .catch(error => {
                console.error('Erreur:', error);
                // Redirection vers le panier même en cas d'erreur
                window.location.href = this.config.panierUrl;
            });
        });
    }
}; 