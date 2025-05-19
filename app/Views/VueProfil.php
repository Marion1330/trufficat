<?= $this->include('layouts/header') ?>

<main class="form-container">
    <h1>Mon compte</h1>
    <p><strong>Nom :</strong> <?= esc($user['nom']) ?></p>
    <p><strong>Prénom :</strong> <?= esc($user['prenom']) ?></p>
    <p><strong>Email :</strong> <?= esc($user['email']) ?></p>
    <p><strong>Téléphone :</strong> <?= esc($user['telephone']) ?></p>
    <div class="profil-btns">
        <button type="button" class="btn btn-secondary btn-sm" onclick="window.location.href='<?= base_url('changer-mot-de-passe') ?>'">Changer le mot de passe</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?= base_url('profil/modifier-infos') ?>'">Modifier mes informations</button>
    </div>

    <hr>

    <h3>Mon adresse de livraison 
        <?php if ($adressePrincipaleDefaut): ?>
            <span class="badge-defaut">défaut</span>
        <?php endif; ?>
    </h3>
    <div class="adresse-bloc">
        <p><strong>Nom :</strong> <?= esc($user['nom']) ?></p>
        <p><strong>Prénom :</strong> <?= esc($user['prenom']) ?></p>
        <p><strong>Téléphone :</strong> <?= esc($user['telephone']) ?></p>
        <p><strong>Adresse :</strong> <?= esc($user['adresse']) ?></p>
        <p><strong>Complément :</strong> <?= esc($user['complement']) ?></p>
        <p><strong>Ville :</strong> <?= esc($user['ville']) ?></p>
        <p><strong>Code postal :</strong> <?= esc($user['code_postal']) ?></p>
        <p><strong>Département :</strong> <?= esc($user['departement'] ?? '') ?></p>
        <p><strong>Pays :</strong> <?= esc($user['pays']) ?></p>
        <div class="adresse-btns">
            <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?= base_url('profil/modifier-adresse-principale') ?>'">Modifier l'adresse</button>
            <?php if (!$adressePrincipaleDefaut): ?>
                <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='<?= base_url('adresse/defaut/principale') ?>'">Définir comme défaut</button>
            <?php endif; ?>
        </div>
    </div>

    <hr>

    <h3>Mes adresses supplémentaires</h3>
    <?php if ($adresses): ?>
        <?php foreach ($adresses as $adresse): ?>
            <div class="adresse-bloc">
                <?php if ($adresse['is_principale']): ?>
                    <span class="badge-defaut">défaut</span>
                <?php endif; ?>
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
                    <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?= base_url('adresse/modifier/'.$adresse['id']) ?>'">Modifier</button>
                    <?php if (!$adresse['is_principale']): ?>
                        <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='<?= base_url('adresse/defaut/'.$adresse['id']) ?>'">Définir comme défaut</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Supprimer cette adresse ?')) window.location.href='<?= base_url('adresse/supprimer/'.$adresse['id']) ?>'">Supprimer</button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune adresse supplémentaire enregistrée.</p>
    <?php endif; ?>
    <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?= base_url('adresse/ajouter') ?>'">Ajouter une adresse supplémentaire</button>
</main>

<?= $this->include('layouts/footer') ?>
