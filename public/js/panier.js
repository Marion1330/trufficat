// Panier functionality
window.TrufficatPanier = {
    config: {},
    
    init: function(config) {
        this.config = config;
        this.setupEventListeners();
    },
    
    setupEventListeners: function() {
        document.addEventListener('DOMContentLoaded', () => {
            // Gestion des quantités
            document.querySelectorAll('.btn-quantite').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const input = e.target.parentElement.querySelector('.quantite-input');
                    const action = e.target.dataset.action;
                    let value = parseInt(input.value);
                    
                    if (action === 'increase') {
                        value++;
                    } else if (action === 'decrease' && value > 1) {
                        value--;
                    }
                    
                    input.value = value;
                    const produitId = e.target.closest('.panier-item').dataset.id;
                    this.updateQuantite(produitId, value);
                });
            });
            
            // Gestion de la suppression
            document.querySelectorAll('.btn-supprimer').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Récupérer l'ID depuis le bouton, pas depuis l'élément cliqué
                    const button = e.target.closest('.btn-supprimer');
                    const produitId = button.dataset.id;
                    
                    if (!produitId) {
                        console.error('ID du produit non trouvé');
                        return;
                    }
                    
                    this.supprimerProduit(produitId);
                });
            });
        });
    },

    updateQuantite: function(produitId, quantite) {
        console.log('Mise à jour de la quantité:', { produitId, quantite });
        
        fetch(`${this.config.baseUrl}panier/modifier/${produitId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `quantite=${quantite}`
        })
        .then(response => {
            console.log('Réponse reçue:', response);
            return response.json();
        })
        .then(data => {
            console.log('Données reçues:', data);
            if (data.success) {
                try {
                    // Mise à jour du prix total du produit
                    const item = document.querySelector(`.panier-item[data-id="${produitId}"]`);
                    if (!item) {
                        throw new Error(`Élément panier-item non trouvé pour l'ID ${produitId}`);
                    }

                    const prixElement = item.querySelector('.prix');
                    if (!prixElement) {
                        throw new Error('Élément prix non trouvé');
                    }

                    const prixUnitaire = parseFloat(prixElement.textContent.replace('€', '').trim());
                    if (isNaN(prixUnitaire)) {
                        throw new Error('Prix unitaire invalide');
                    }

                    const totalElement = item.querySelector('.panier-item-total');
                    if (!totalElement) {
                        throw new Error('Élément total non trouvé');
                    }

                    const nouveauTotal = (prixUnitaire * quantite).toFixed(2);
                    totalElement.textContent = nouveauTotal + ' €';

                    // Mise à jour du résumé
                    this.updateResume();
                } catch (error) {
                    console.error('Erreur lors de la mise à jour des éléments:', error);
                }
            } else {
                console.error('Erreur lors de la mise à jour de la quantité:', data);
            }
        })
        .catch(error => {
            console.error('Erreur lors de la mise à jour:', error);
        });
    },

    /**
     * Supprime un produit du panier sans confirmation ni rechargement
     * - Effectue une requete AJAX vers le serveur
     * - Supprime l'element du DOM avec animation fluide
     * - Met a jour le resume du panier en temps reel
     * - Affiche le message de panier vide si necessaire
     * - Gere les erreurs silencieusement pour une UX fluide
     */
    supprimerProduit: function(produitId) {
        console.log('Suppression du produit:', produitId);

        fetch(`${this.config.baseUrl}panier/supprimer/${produitId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erreur HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Réponse de suppression:', data);
            if (data.success) {
                try {
                    // Supprimer l'élément du DOM
                    const item = document.querySelector(`.panier-item[data-id="${produitId}"]`);
                    if (!item) {
                        throw new Error(`Élément panier-item non trouvé pour l'ID ${produitId}`);
                    }
                    
                    // Supprimer l'élément avec une animation fluide
                    item.classList.add('removing');
                    setTimeout(() => {
                        item.remove();
                        
                        // Mettre à jour le résumé
                        this.updateResume();
                        
                        // Si le panier est vide, afficher le message de panier vide
                        const panierItems = document.querySelectorAll('.panier-item');
                        if (panierItems.length === 0) {
                            this.afficherPanierVide();
                        }
                    }, 200);
                    
                } catch (error) {
                    console.error('Erreur lors de la suppression:', error);
                }
            } else {
                throw new Error(data.message || 'La suppression a échoué');
            }
        })
        .catch(error => {
            console.error('Erreur lors de la suppression:', error);
        });
    },

    /**
     * Affiche le message de panier vide sans rechargement
     * - Remplace dynamiquement le contenu du panier
     * - Conserve la structure HTML existante
     * - Permet une transition fluide vers l'etat vide
     */
    afficherPanierVide: function() {
        const panierContainer = document.querySelector('.panier-container');
        const panierContent = document.querySelector('.panier-content');
        
        if (panierContent) {
            panierContent.remove();
        }
        
        const panierVideHTML = `
            <div class="panier-empty">
                <img src="${this.config.baseUrl}images/empty-cart.png" alt="Panier vide" class="img-fluid">
                <h2>Votre panier est vide</h2>
                <p>Découvrez nos produits et commencez vos achats !</p>
                <a href="${this.config.baseUrl}produits/chiens" class="panier-btn">
                    Continuer mes achats
                </a>
            </div>
        `;
        
        panierContainer.innerHTML = panierVideHTML;
    },

    updateResume: function() {
        try {
            // Vérifier s'il reste des produits dans le panier
            const panierItems = document.querySelectorAll('.panier-item');
            
            if (panierItems.length === 0) {
                // Si le panier est vide, ne pas mettre à jour le résumé
                return;
            }
            
            // Calculer le sous-total
            let sousTotal = 0;
            panierItems.forEach(item => {
                const prixUnitaire = parseFloat(item.querySelector('.prix').textContent.replace('€', '').trim());
                const quantite = parseInt(item.querySelector('.quantite-input').value);
                if (!isNaN(prixUnitaire) && !isNaN(quantite)) {
                    const totalProduit = prixUnitaire * quantite;
                    sousTotal += totalProduit;
                    // Mettre à jour le total du produit
                    item.querySelector('.panier-item-total').textContent = totalProduit.toFixed(2) + ' €';
                }
            });

            console.log('Sous-total calculé:', sousTotal);

            // Frais d'expédition fixes
            const fraisExpedition = 4.99;
            
            // Calculer la TVA estimée (20%)
            const tva = (sousTotal + fraisExpedition) * 0.20;
            
            // Calculer le total final
            const totalFinal = sousTotal + fraisExpedition;

            console.log('Montants calculés:', {
                sousTotal: sousTotal.toFixed(2),
                fraisExpedition: fraisExpedition.toFixed(2),
                tva: tva.toFixed(2),
                totalFinal: totalFinal.toFixed(2)
            });

            // Sélectionner tous les éléments du résumé
            const resumeLines = document.querySelectorAll('.resume-ligne span:last-child');
            if (resumeLines.length >= 4) {
                // Mise à jour du sous-total
                resumeLines[0].textContent = sousTotal.toFixed(2) + ' €';
                // La ligne [1] est pour les frais d'expédition (déjà fixe)
                // Mise à jour de la TVA estimée
                resumeLines[2].textContent = tva.toFixed(2) + ' €';
                // Mise à jour du total
                document.querySelector('.resume-ligne.total span:last-child').textContent = totalFinal.toFixed(2) + ' €';
            } else {
                console.error('Structure du résumé incorrecte. Éléments trouvés:', resumeLines.length);
            }
        } catch (error) {
            console.error('Erreur lors de la mise à jour du résumé:', error);
        }
    }
}; 