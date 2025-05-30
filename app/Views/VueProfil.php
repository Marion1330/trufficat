<?= $this->include('layouts/header') ?>

<main class="form-container">
    <h1>Mon compte</h1>
    <p><strong>Nom :</strong> <?= esc($user['nomcompte']) ?></p>
    <p><strong>Prénom :</strong> <?= esc($user['prenomcompte']) ?></p>
    <p><strong>Email :</strong> <?= esc($user['email']) ?></p>
    <p><strong>Téléphone :</strong> <?= esc($user['telephone']) ?></p>
    <div class="profil-btns">
        <button type="button" class="btn btn-secondary btn-sm" onclick="window.location.href='<?= base_url('changer-mot-de-passe') ?>'">Changer le mot de passe</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?= base_url('profil/modifier-infos') ?>'">Modifier mes informations</button>
    </div>

    <hr>

    <h3>Mon adresse par défaut <span class="badge-defaut">défaut</span></h3>
    <?php if ($adresseDefaut): ?>
    <div class="adresse-bloc">
            <p><strong>Nom :</strong> <?= esc($adresseDefaut['nom']) ?></p>
            <p><strong>Prénom :</strong> <?= esc($adresseDefaut['prenom']) ?></p>
            <p><strong>Téléphone :</strong> <?= esc($adresseDefaut['telephone']) ?></p>
            <p><strong>Adresse :</strong> <?= esc($adresseDefaut['adresse']) ?></p>
            <p><strong>Complément :</strong> <?= esc($adresseDefaut['complement']) ?></p>
            <p><strong>Ville :</strong> <?= esc($adresseDefaut['ville']) ?></p>
            <p><strong>Code postal :</strong> <?= esc($adresseDefaut['code_postal']) ?></p>
            <p><strong>Département :</strong> <?= esc($adresseDefaut['departement'] ?? '') ?></p>
            <p><strong>Pays :</strong> <?= esc($adresseDefaut['pays']) ?></p>
        <div class="adresse-btns">
                <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?= base_url('profil/modifier-adresse-defaut') ?>'">Modifier l'adresse</button>
            </div>
        </div>
    <?php else: ?>
        <div class="adresse-bloc">
            <p><em>Aucune adresse par défaut définie.</em></p>
            <div class="adresse-btns">
                <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?= base_url('adresse/creer-defaut') ?>'">Créer une adresse par défaut</button>
        </div>
    </div>
    <?php endif; ?>

    <hr>

    <h3>Mes adresses supplémentaires</h3>
    <?php if ($adressesSupplementaires): ?>
        <?php foreach ($adressesSupplementaires as $adresse): ?>
                <div class="adresse-bloc">
                    <p><strong>Nom :</strong> <?= esc($adresse['nom']) ?></p>
                    <p><strong>Prénom :</strong> <?= esc($adresse['prenom']) ?></p>
                    <p><strong>Téléphone :</strong> <?= esc($adresse['telephone']) ?></p>
                    <p><strong>Adresse :</strong> <?= esc($adresse['adresse']) ?></p>
                    <p><strong>Complément :</strong> <?= esc($adresse['complement']) ?></p>
                    <p><strong>Ville :</strong> <?= esc($adresse['ville']) ?></p>
                    <p><strong>Code postal :</strong> <?= esc($adresse['code_postal']) ?></p>
                    <p><strong>Département :</strong> <?= esc($adresse['departement']) ?></p>
                    <p><strong>Pays :</strong> <?= esc($adresse['pays']) ?></p>
                
                    <div class="adresse-btns">
                        <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?= base_url('adresse/modifier/'.$adresse['id']) ?>'">Modifier</button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?= base_url('adresse/defaut/'.$adresse['id']) ?>'">Définir par défaut</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Supprimer cette adresse ?')) window.location.href='<?= base_url('adresse/supprimer/'.$adresse['id']) ?>'">Supprimer</button>
                    </div>
                </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune adresse supplémentaire enregistrée.</p>
    <?php endif; ?>
    <div class="adresse-btns">
        <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?= base_url('adresse/ajouter') ?>'">Ajouter une adresse supplémentaire</button>
    </div>
</main>

<?= $this->include('layouts/footer') ?>
