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
                    $tva = $total * 0.20; // TVA à 20%
                    $totalTTC = $total + 4.99 + $tva;
                ?>
                <div class="resume-ligne">
                    <span>TVA (20%)</span>
                    <span><?= number_format($tva, 2) ?> €</span>
                </div>
                <div class="resume-ligne total">
                    <span>Total TTC</span>
                    <span><?= number_format($totalTTC, 2) ?> €</span>
                </div>
                <div class="panier-actions">
                    <a href="<?= base_url('commande') ?>" class="btn btn-primary">Commander</a>
                    <a href="<?= base_url('panier/vider') ?>" class="btn btn-danger">Vider le panier</a>
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
            updateQuantite(this.closest('.panier-item').dataset.id, value);
        });
    });
    
    // Gestion de la suppression
    document.querySelectorAll('.btn-supprimer').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Voulez-vous vraiment supprimer ce produit du panier ?')) {
                supprimerProduit(this.dataset.id);
            }
        });
    });
});

function updateQuantite(produitId, quantite) {
    fetch(`/panier/modifier/${produitId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `quantite=${quantite}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function supprimerProduit(produitId) {
    fetch(`/panier/supprimer/${produitId}`, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>

<?= $this->include('layouts/footer') ?>