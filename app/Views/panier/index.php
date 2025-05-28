<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/panier.css') ?>">

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
</style>

<?= $this->include('layouts/footer') ?>