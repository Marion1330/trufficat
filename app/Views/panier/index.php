<?= $this->include('layouts/header') ?>

<div class="panier-container">
    <h1 class="panier-title">Mon Panier</h1>
    
    <?php if (empty($produits)): ?>
        <div class="panier-empty">
            <img src="<?= base_url('images/empty-cart.png') ?>" alt="Panier vide" class="img-fluid">
            <h2>Votre panier est vide</h2>
            <p>Découvrez nos produits et commencez vos achats !</p>
            <a href="<?= base_url('produits/chiens') ?>" class="panier-btn">
                Continuer mes achats
            </a>
        </div>
    <?php else: ?>
        <div class="panier-content">
            <div class="panier-items">
                <?php foreach ($produits as $produit): ?>
                    <div class="panier-item" data-id="<?= $produit['produit_id'] ?>">
                        <img src="<?= base_url($produit['image']) ?>" alt="<?= $produit['nom'] ?>" class="panier-item-image">
                        <div class="panier-item-details">
                            <h3><?= $produit['nom'] ?></h3>
                            <p class="prix"><?= number_format($produit['prix_unitaire'], 2) ?> €</p>
                            <div class="quantite-controls">
                                <button class="btn-quantite" data-action="decrease">-</button>
                                <input type="number" value="<?= $produit['quantite'] ?>" min="1" class="quantite-input" readonly>
                                <button class="btn-quantite" data-action="increase">+</button>
                                <button class="btn-supprimer" data-id="<?= $produit['produit_id'] ?>" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="panier-item-total">
                            <?= number_format($produit['prix_unitaire'] * $produit['quantite'], 2) ?> €
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="panier-resume">
                <h2>Résumé de la commande</h2>
                <div class="resume-ligne">
                    <span>Sous-total</span>
                    <span><?= number_format($total, 2) ?> €</span>
                </div>
                <div class="resume-ligne">
                    <span>Frais d'expédition estimés</span>
                    <span>4,99 €</span>
                </div>
                <?php 
                    $totalFinal = $total + 4.99;
                    $tva = ($total + 4.99) * 0.20; // TVA à titre indicatif (20%)
                ?>
                <div class="resume-ligne">
                    <span>TVA estimée (20%)</span>
                    <span><?= number_format($tva, 2) ?> €</span>
                </div>
                <div class="resume-ligne total">
                    <span>Total</span>
                    <span><?= number_format($totalFinal, 2) ?> €</span>
                </div>
                <div class="panier-actions">
                    <a href="<?= base_url('commande/checkout') ?>" class="btn-commander">Commander</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des quantités
    document.querySelectorAll('.btn-quantite').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantite-input');
            const action = this.dataset.action;
            let value = parseInt(input.value);
            
            if (action === 'increase') {
                value++;
            } else if (action === 'decrease' && value > 1) {
                value--;
            }
            
            input.value = value;
            const produitId = this.closest('.panier-item').dataset.id;
            updateQuantite(produitId, value);
        });
    });
    
    // Gestion de la suppression
    document.querySelectorAll('.btn-supprimer').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const produitId = this.dataset.id;
            supprimerProduit(produitId);
        });
    });
});

function updateQuantite(produitId, quantite) {
    const baseUrl = '<?= base_url() ?>';
    console.log('Mise à jour de la quantité:', { produitId, quantite });
    
    fetch(`${baseUrl}panier/modifier/${produitId}`, {
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
                updateResume();
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
}

function supprimerProduit(produitId) {
    const baseUrl = '<?= base_url() ?>';
    console.log('Suppression du produit:', produitId);

    fetch(`${baseUrl}panier/supprimer/${produitId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Réponse de suppression:', data);
        if (data.success) {
            try {
                // Supprimer l'élément du DOM
                const item = document.querySelector(`.panier-item[data-id="${produitId}"]`);
                if (!item) {
                    throw new Error(`Élément panier-item non trouvé pour l'ID ${produitId}`);
                }
                
                // Supprimer l'élément
                item.remove();
                
                // Mettre à jour le résumé
                updateResume();
                
                // Si le panier est vide, recharger la page
                const panierItems = document.querySelectorAll('.panier-item');
                if (panierItems.length === 0) {
                    window.location.reload();
                }
            } catch (error) {
                console.error('Erreur lors de la suppression:', error);
            }
        } else {
            throw new Error('La suppression a échoué');
        }
    })
    .catch(error => {
        console.error('Erreur lors de la suppression:', error);
        alert('Une erreur est survenue lors de la suppression du produit');
    });
}

function updateResume() {
    try {
        // Calculer le sous-total
        let sousTotal = 0;
        document.querySelectorAll('.panier-item').forEach(item => {
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
</script>

<style>
.panier-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.panier-title {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

.panier-content {
    display: flex;
    gap: 30px;
}

.panier-items {
    flex: 1;
}

.panier-resume {
    width: 350px;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    position: sticky;
    top: 20px;
    align-self: flex-start;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.panier-resume h2 {
    font-size: 18px;
    color: #333;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #ddd;
}

.resume-ligne {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    font-size: 14px;
    color: #666;
}

.resume-ligne.total {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 2px solid #ddd;
    font-size: 18px;
    font-weight: bold;
    color: #333;
}

.btn-commander {
    display: block;
    width: 100%;
    padding: 15px;
    background-color: #D97B29;
    color: white;
    text-align: center;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    margin-top: 20px;
    transition: background-color 0.3s ease;
}

.btn-commander:hover {
    background-color: #B45B19;
    text-decoration: none;
    color: white;
}

.panier-item {
    display: flex;
    align-items: center;
    padding: 20px;
    margin-bottom: 15px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.panier-item-image {
    width: 100px;
    height: 100px;
    object-fit: contain;
    margin-right: 20px;
}

.panier-item-details {
    flex: 1;
}

.panier-item-details h3 {
    margin: 0 0 10px;
    font-size: 16px;
    color: #333;
}

.prix {
    font-size: 16px;
    color: #D97B29;
    font-weight: bold;
    margin: 5px 0;
}

.quantite-controls {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
}

.btn-quantite {
    width: 30px;
    height: 30px;
    border: 1px solid #ddd;
    background-color: white;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    transition: all 0.2s;
}

.btn-quantite:hover {
    background-color: #f0f0f0;
}

.quantite-input {
    width: 40px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
}

.btn-supprimer {
    background: none;
    border: none;
    color: #ff4444;
    cursor: pointer;
    padding: 5px;
    transition: color 0.2s;
}

.btn-supprimer:hover {
    color: #cc0000;
}

.panier-item-total {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-left: 20px;
    min-width: 80px;
    text-align: right;
}

@media (max-width: 768px) {
    .panier-content {
        flex-direction: column;
    }

    .panier-resume {
        width: 100%;
        position: static;
    }

    .panier-item {
        flex-direction: column;
        text-align: center;
    }

    .panier-item-image {
        margin-right: 0;
        margin-bottom: 15px;
    }

    .panier-item-total {
        margin-left: 0;
        margin-top: 15px;
        text-align: center;
    }

    .quantite-controls {
        justify-content: center;
    }
}
</style>

<?= $this->include('layouts/footer') ?>