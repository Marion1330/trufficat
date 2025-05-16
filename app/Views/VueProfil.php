<?= $this->include('layouts/header') ?>

<main class="form-container">
    <h1>Mon compte</h1>
    <p><strong>Nom :</strong> <?= esc($user['nom']) ?></p>
    <p><strong>Prénom :</strong> <?= esc($user['prenom']) ?></p>
    <p><strong>Email :</strong> <?= esc($user['email']) ?></p>
    <p><strong>Téléphone :</strong> <?= esc($user['telephone']) ?></p>
    <div class="profil-btns">
        <a href="<?= base_url('changer-mot-de-passe') ?>" class="btn btn-secondary btn-sm">Changer le mot de passe</a>
        <a href="<?= base_url('profil/modifier-infos') ?>" class="btn btn-primary btn-sm">Modifier mes informations</a>
    </div>

    <hr>

    <h3>Mon adresse de livraison 
        <?php if ($adressePrincipaleDefaut): ?>
            <span style="color:red;font-weight:bold;">défaut</span>
        <?php endif; ?>
    </h3>
    <div class="adresse-bloc" style="border:1px solid #ccc; padding:1em; border-radius:8px;">
        <p><strong>Nom :</strong> <?= esc($user['nom']) ?></p>
        <p><strong>Prénom :</strong> <?= esc($user['prenom']) ?></p>
        <p><strong>Téléphone :</strong> <?= esc($user['telephone']) ?></p>
        <p><strong>Adresse :</strong> <?= esc($user['adresse']) ?></p>
        <p><strong>Complément :</strong> <?= esc($user['complement']) ?></p>
        <p><strong>Ville :</strong> <?= esc($user['ville']) ?></p>
        <p><strong>Code postal :</strong> <?= esc($user['code_postal']) ?></p>
        <p><strong>Département :</strong> <?= esc($user['departement'] ?? '') ?></p>
        <p><strong>Pays :</strong> <?= esc($user['pays']) ?></p>
        <a href="<?= base_url('profil/modifier-adresse-principale') ?>" class="btn btn-primary btn-sm">Modifier l'adresse</a>
        <?php if (!$adressePrincipaleDefaut): ?>
            <a href="<?= base_url('adresse/defaut/principale') ?>" class="btn btn-danger btn-sm">Définir comme défaut</a>
        <?php endif; ?>
    </div>

    <hr>

    <h3>Mes adresses supplémentaires</h3>
    <?php if ($adresses): ?>
        <?php foreach ($adresses as $adresse): ?>
            <div class="adresse-bloc" style="border:1px solid #ccc; padding:1em; border-radius:8px; margin-bottom:1em;">
                <?php if ($adresse['is_principale']): ?>
                    <span style="color:red;font-weight:bold;">défaut</span>
                <?php endif; ?>
                <p><strong>Titre :</strong> <?= esc($adresse['titre']) ?></p>
                <p><strong>Nom :</strong> <?= esc($user['nom']) ?></p>
                <p><strong>Prénom :</strong> <?= esc($user['prenom']) ?></p>
                <p><strong>Téléphone :</strong> <?= esc($adresse['telephone']) ?></p>
                <p><strong>Adresse :</strong> <?= esc($adresse['adresse']) ?></p>
                <p><strong>Complément :</strong> <?= esc($adresse['complement']) ?></p>
                <p><strong>Ville :</strong> <?= esc($adresse['ville']) ?></p>
                <p><strong>Code postal :</strong> <?= esc($adresse['code_postal']) ?></p>
                <p><strong>Département :</strong> <?= esc($adresse['departement']) ?></p>
                <p><strong>Pays :</strong> <?= esc($adresse['pays']) ?></p>
                <div class="adresse-btns">
                    <a href="<?= base_url('adresse/modifier/'.$adresse['id']) ?>" class="btn btn-primary btn-sm">Modifier</a>
                    <?php if (!$adresse['is_principale']): ?>
                        <a href="<?= base_url('adresse/defaut/'.$adresse['id']) ?>" class="btn btn-danger btn-sm">Définir comme défaut</a>
                        <a href="<?= base_url('adresse/supprimer/'.$adresse['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette adresse ?');">Supprimer</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune adresse supplémentaire enregistrée.</p>
    <?php endif; ?>
    <a href="<?= base_url('adresse/ajouter') ?>" class="btn btn-primary btn-sm">Ajouter une adresse supplémentaire</a>
</main>

<?= $this->include('layouts/footer') ?>
