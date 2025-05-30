<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/modifier_produit.css') ?>">

<div class="admin-container">
    <div class="admin-sidebar">
        <div class="admin-profile">
            <h3>Administrateur</h3>
        </div>
        
        <nav class="admin-nav">
            <ul>
                <li><a href="<?= base_url('admin') ?>"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a></li>
                <li class="active"><a href="<?= base_url('admin/produits') ?>"><i class="fas fa-box-open"></i> Produits</a></li>
                <li><a href="<?= base_url('admin/clients') ?>"><i class="fas fa-users"></i> Clients</a></li>
                <li><a href="<?= base_url('admin/commandes') ?>"><i class="fas fa-shopping-cart"></i> Commandes</a></li>
            </ul>
        </nav>
    </div>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1><i class="fas fa-edit"></i> Modifier le produit</h1>
            <div class="admin-actions">
                <a href="<?= base_url('admin/produits') ?>" class="admin-btn secondary"><i class="fas fa-arrow-left"></i> Retour aux produits</a>
            </div>
        </div>
        
        <div class="edit-form-container">
            <form action="<?= base_url('admin/produit/modifier/' . esc($produit['id'])) ?>" method="post" enctype="multipart/form-data" class="admin-form">
                <div class="form-grid">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="nom">Nom du produit <span class="required">*</span></label>
                            <input type="text" id="nom" name="nom" value="<?= esc($produit['nom']) ?>" required class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description <span class="required">*</span></label>
                            <textarea id="description" name="description" rows="5" required class="form-control"><?= esc($produit['description']) ?></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="prix">Prix (€) <span class="required">*</span></label>
                                <input type="number" id="prix" name="prix" value="<?= isset($produit['prix']) ? number_format($produit['prix'], 2, '.', '') : '' ?>" step="0.01" min="0" required class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="stock">Stock <span class="required">*</span></label>
                                <input type="number" id="stock" name="stock" value="<?= isset($produit['stock']) ? $produit['stock'] : 0 ?>" min="0" required class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="animal">Animal <span class="required">*</span></label>
                            <select id="animal" name="animal" required class="form-control">
                                <option value="chien" <?= $produit['animal'] == 'chien' ? 'selected' : '' ?>>Chien</option>
                                <option value="chat" <?= $produit['animal'] == 'chat' ? 'selected' : '' ?>>Chat</option>
                            </select>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="categorie">Catégorie</label>
                                <select id="categorie" name="categorie" class="form-control">
                                    <option value="">Sélectionner...</option>
                                    <!-- Catégories pour chien -->
                                    <optgroup label="Alimentation" class="chien-categories" style="display: none;">
                                        <option value="alimentation" <?= isset($produit['categorie']) && $produit['categorie'] == 'alimentation' ? 'selected' : '' ?>>Alimentation</option>
                                        <option value="alimentation-sans-cereales" <?= isset($produit['categorie']) && $produit['categorie'] == 'alimentation-sans-cereales' ? 'selected' : '' ?>>Alimentation sans céréales</option>
                                        <option value="alimentation-bio" <?= isset($produit['categorie']) && $produit['categorie'] == 'alimentation-bio' ? 'selected' : '' ?>>Alimentation Bio</option>
                                        <option value="croquettes" <?= isset($produit['categorie']) && $produit['categorie'] == 'croquettes' ? 'selected' : '' ?>>Croquettes</option>
                                        <option value="croquettes-sterilise" <?= isset($produit['categorie']) && $produit['categorie'] == 'croquettes-sterilise' ? 'selected' : '' ?>>Croquettes pour chiens stérilisés</option>
                                        <option value="boites-sachets" <?= isset($produit['categorie']) && $produit['categorie'] == 'boites-sachets' ? 'selected' : '' ?>>Boites et sachets</option>
                                        <option value="friandises" <?= isset($produit['categorie']) && $produit['categorie'] == 'friandises' ? 'selected' : '' ?>>Friandises</option>
                                    </optgroup>
                                    <optgroup label="Hygiène et soins" class="chien-categories" style="display: none;">
                                        <option value="hygiene-soins" <?= isset($produit['categorie']) && $produit['categorie'] == 'hygiene-soins' ? 'selected' : '' ?>>Hygiène et soins</option>
                                        <option value="antiparasitaires" <?= isset($produit['categorie']) && $produit['categorie'] == 'antiparasitaires' ? 'selected' : '' ?>>Produits antiparasitaires</option>
                                        <option value="entretien-poil" <?= isset($produit['categorie']) && $produit['categorie'] == 'entretien-poil' ? 'selected' : '' ?>>Entretien du poil</option>
                                        <option value="sacs-proprete" <?= isset($produit['categorie']) && $produit['categorie'] == 'sacs-proprete' ? 'selected' : '' ?>>Sacs de propreté</option>
                                    </optgroup>
                                    <optgroup label="Accessoires" class="chien-categories" style="display: none;">
                                        <option value="gamelles" <?= isset($produit['categorie']) && $produit['categorie'] == 'gamelles' ? 'selected' : '' ?>>Gamelles</option>
                                    </optgroup>
                                    <optgroup label="Niche et couchage" class="chien-categories" style="display: none;">
                                        <option value="paniers-coussins" <?= isset($produit['categorie']) && $produit['categorie'] == 'paniers-coussins' ? 'selected' : '' ?>>Paniers et coussins</option>
                                        <option value="niches-chenils" <?= isset($produit['categorie']) && $produit['categorie'] == 'niches-chenils' ? 'selected' : '' ?>>Niches et chenils</option>
                                    </optgroup>
                                    <optgroup label="Transport" class="chien-categories" style="display: none;">
                                        <option value="caisses-transport" <?= isset($produit['categorie']) && $produit['categorie'] == 'caisses-transport' ? 'selected' : '' ?>>Caisses et sacs de transport</option>
                                        <option value="accessoires-voyage" <?= isset($produit['categorie']) && $produit['categorie'] == 'accessoires-voyage' ? 'selected' : '' ?>>Accessoires de voyage</option>
                                    </optgroup>
                                    <optgroup label="Sellerie" class="chien-categories" style="display: none;">
                                        <option value="laisses" <?= isset($produit['categorie']) && $produit['categorie'] == 'laisses' ? 'selected' : '' ?>>Laisses</option>
                                        <option value="laisses-enrouleur" <?= isset($produit['categorie']) && $produit['categorie'] == 'laisses-enrouleur' ? 'selected' : '' ?>>Laisses à enrouleur</option>
                                        <option value="colliers" <?= isset($produit['categorie']) && $produit['categorie'] == 'colliers' ? 'selected' : '' ?>>Colliers</option>
                                        <option value="harnais" <?= isset($produit['categorie']) && $produit['categorie'] == 'harnais' ? 'selected' : '' ?>>Harnais</option>
                                        <option value="muselieres" <?= isset($produit['categorie']) && $produit['categorie'] == 'muselieres' ? 'selected' : '' ?>>Muselières</option>
                                    </optgroup>
                                    <option value="jouets" class="chien-categories" style="display: none;" <?= isset($produit['categorie']) && $produit['categorie'] == 'jouets' ? 'selected' : '' ?>>Jouets</option>

                                    <!-- Catégories pour chat -->
                                    <optgroup label="Alimentation" class="chat-categories" style="display: none;">
                                        <option value="alimentation" <?= isset($produit['categorie']) && $produit['categorie'] == 'alimentation' ? 'selected' : '' ?>>Alimentation</option>
                                        <option value="alimentation-sans-cereales" <?= isset($produit['categorie']) && $produit['categorie'] == 'alimentation-sans-cereales' ? 'selected' : '' ?>>Alimentation sans céréales</option>
                                        <option value="alimentation-bio" <?= isset($produit['categorie']) && $produit['categorie'] == 'alimentation-bio' ? 'selected' : '' ?>>Alimentation Bio</option>
                                        <option value="croquettes" <?= isset($produit['categorie']) && $produit['categorie'] == 'croquettes' ? 'selected' : '' ?>>Croquettes</option>
                                        <option value="croquettes-sterilise" <?= isset($produit['categorie']) && $produit['categorie'] == 'croquettes-sterilise' ? 'selected' : '' ?>>Croquettes pour chats stérilisés</option>
                                        <option value="boites-sachets" <?= isset($produit['categorie']) && $produit['categorie'] == 'boites-sachets' ? 'selected' : '' ?>>Boites et sachets</option>
                                        <option value="friandises" <?= isset($produit['categorie']) && $produit['categorie'] == 'friandises' ? 'selected' : '' ?>>Friandises</option>
                                    </optgroup>
                                    <optgroup label="Hygiène et soins" class="chat-categories" style="display: none;">
                                        <option value="hygiene-soins" <?= isset($produit['categorie']) && $produit['categorie'] == 'hygiene-soins' ? 'selected' : '' ?>>Hygiène et soins</option>
                                        <option value="antiparasitaires" <?= isset($produit['categorie']) && $produit['categorie'] == 'antiparasitaires' ? 'selected' : '' ?>>Produits antiparasitaires</option>
                                        <option value="litieres" <?= isset($produit['categorie']) && $produit['categorie'] == 'litieres' ? 'selected' : '' ?>>Litières</option>
                                        <option value="bacs-litiere" <?= isset($produit['categorie']) && $produit['categorie'] == 'bacs-litiere' ? 'selected' : '' ?>>Bacs à litière</option>
                                        <option value="accessoires-litieres" <?= isset($produit['categorie']) && $produit['categorie'] == 'accessoires-litieres' ? 'selected' : '' ?>>Accessoires de litières</option>
                                        <option value="maison-toilette" <?= isset($produit['categorie']) && $produit['categorie'] == 'maison-toilette' ? 'selected' : '' ?>>Maison de toilette</option>
                                        <option value="entretien-poil" <?= isset($produit['categorie']) && $produit['categorie'] == 'entretien-poil' ? 'selected' : '' ?>>Entretien du poil</option>
                                    </optgroup>
                                    <optgroup label="Couchage" class="chat-categories" style="display: none;">
                                        <option value="hamac" <?= isset($produit['categorie']) && $produit['categorie'] == 'hamac' ? 'selected' : '' ?>>Hamac</option>
                                        <option value="niche-cabane" <?= isset($produit['categorie']) && $produit['categorie'] == 'niche-cabane' ? 'selected' : '' ?>>Niche et cabane</option>
                                        <option value="panier-coussin" <?= isset($produit['categorie']) && $produit['categorie'] == 'panier-coussin' ? 'selected' : '' ?>>Panier et coussin</option>
                                    </optgroup>
                                    <optgroup label="Transport" class="chat-categories" style="display: none;">
                                        <option value="sac-transport" <?= isset($produit['categorie']) && $produit['categorie'] == 'sac-transport' ? 'selected' : '' ?>>Sac de transport</option>
                                        <option value="caisse-transport" <?= isset($produit['categorie']) && $produit['categorie'] == 'caisse-transport' ? 'selected' : '' ?>>Caisse de transport</option>
                                    </optgroup>
                                    <optgroup label="Accessoires" class="chat-categories" style="display: none;">
                                        <option value="gamelles" <?= isset($produit['categorie']) && $produit['categorie'] == 'gamelles' ? 'selected' : '' ?>>Gamelles</option>
                                        <option value="sellerie" <?= isset($produit['categorie']) && $produit['categorie'] == 'sellerie' ? 'selected' : '' ?>>Sellerie</option>
                                        <option value="chatieres" <?= isset($produit['categorie']) && $produit['categorie'] == 'chatieres' ? 'selected' : '' ?>>Chatières</option>
                                    </optgroup>
                                    <optgroup label="Jouets et griffoirs" class="chat-categories" style="display: none;">
                                        <option value="jouets" <?= isset($produit['categorie']) && $produit['categorie'] == 'jouets' ? 'selected' : '' ?>>Jouets</option>
                                        <option value="arbres-griffoirs" <?= isset($produit['categorie']) && $produit['categorie'] == 'arbres-griffoirs' ? 'selected' : '' ?>>Arbres à chat & griffoirs</option>
                                    </optgroup>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="marque">Marque</label>
                                <select id="marque" name="marque" class="form-control">
                                    <option value="">Sélectionner...</option>
                                    <option value="Royal Canin" <?= isset($produit['marque']) && $produit['marque'] == 'Royal Canin' ? 'selected' : '' ?>>Royal Canin</option>
                                    <option value="Purina" <?= isset($produit['marque']) && $produit['marque'] == 'Purina' ? 'selected' : '' ?>>Purina</option>
                                    <option value="True Origins Wild" <?= isset($produit['marque']) && $produit['marque'] == 'True Origins Wild' ? 'selected' : '' ?>>True Origins Wild</option>
                                    <option value="Sheba" <?= isset($produit['marque']) && $produit['marque'] == 'Sheba' ? 'selected' : '' ?>>Sheba</option>
                                    <option value="CATXTREME" <?= isset($produit['marque']) && $produit['marque'] == "CATXTREME" ? 'selected' : '' ?>>CATXTREME</option>
                                    <option value="Edgard & Cooper" <?= isset($produit['marque']) && $produit['marque'] == "Edgard & Cooper" ? 'selected' : '' ?>>Edgard & Cooper</option>
                                    <option value="Ferplast" <?= isset($produit['marque']) && $produit['marque'] == "Ferplast" ? 'selected' : '' ?>>Ferplast</option>
                                    <option value="Beaphar" <?= isset($produit['marque']) && $produit['marque'] == "Beaphar" ? 'selected' : '' ?>>Beaphar</option>
                                    <option value="Paradisio" <?= isset($produit['marque']) && $produit['marque'] == "Paradisio" ? 'selected' : '' ?>>Paradisio</option>
                                    <option value="Bobby" <?= isset($produit['marque']) && $produit['marque'] == "Bobby" ? 'selected' : '' ?>>Bobby</option>   
                                    <option value="Trixie" <?= isset($produit['marque']) && $produit['marque'] == "Trixie" ? 'selected' : '' ?>>Trixie</option>
                                    <option value="Turgo" <?= isset($produit['marque']) && $produit['marque'] == "Turgo" ? 'selected' : '' ?>>Turgo</option>
                                    <option value="Flexi" <?= isset($produit['marque']) && $produit['marque'] == "Flexi" ? 'selected' : '' ?>>Flexi</option>
                                    <option value="Gotoo" <?= isset($produit['marque']) && $produit['marque'] == "Gotoo" ? 'selected' : '' ?>>Gotoo</option>
                                    <option value="Nath Veterinary Diet" <?= isset($produit['marque']) && $produit['marque'] == "Nath Veterinary Diet" ? 'selected' : '' ?>>Nath Veterinary Diet</option>
                                    <option value="Yarrah" <?= isset($produit['marque']) && $produit['marque'] == "Yarrah" ? 'selected' : '' ?>>Yarrah</option>
                                    <option value="Weenect" <?= isset($produit['marque']) && $produit['marque'] == "Weenect" ? 'selected' : '' ?>>Weenect</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="age">Âge</label>
                                <select id="age" name="age" class="form-control">
                                    <option value="">Sélectionner...</option>
                                    <option value="junior" <?= isset($produit['age']) && $produit['age'] == 'junior' ? 'selected' : '' ?>>Junior</option>
                                    <option value="adulte" <?= isset($produit['age']) && $produit['age'] == 'adulte' ? 'selected' : '' ?>>Adulte</option>
                                    <option value="senior" <?= isset($produit['age']) && $produit['age'] == 'senior' ? 'selected' : '' ?>>Senior</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="sterilise">Animal stérilisé</label>
                                <select id="sterilise" name="sterilise" class="form-control">
                                    <option value="">Non applicable</option>
                                    <option value="1" <?= isset($produit['sterilise']) && $produit['sterilise'] ? 'selected' : '' ?>>Oui</option>
                                    <option value="0" <?= isset($produit['sterilise']) && !$produit['sterilise'] ? 'selected' : '' ?>>Non</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="saveur">Saveur</label>
                                <select id="saveur" name="saveur" class="form-control" disabled>
                                    <option value="">Sélectionner...</option>
                                    <option value="Poulet" <?= isset($produit['saveur']) && $produit['saveur'] == 'Poulet' ? 'selected' : '' ?>>Poulet</option>
                                    <option value="Boeuf" <?= isset($produit['saveur']) && $produit['saveur'] == 'Boeuf' ? 'selected' : '' ?>>Boeuf</option>
                                    <option value="Saumon" <?= isset($produit['saveur']) && $produit['saveur'] == 'Saumon' ? 'selected' : '' ?>>Saumon</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="is_vedette">Produit en vedette</label>
                                <select id="is_vedette" name="is_vedette" class="form-control">
                                    <option value="0" <?= !isset($produit['is_vedette']) || !$produit['is_vedette'] ? 'selected' : '' ?>>Non</option>
                                    <option value="1" <?= isset($produit['is_vedette']) && $produit['is_vedette'] ? 'selected' : '' ?>>Oui</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    
                        
                        <div class="form-group">
                            <label for="image">Image du produit</label>
                            <div class="image-upload-container">
                                <?php if (!empty($produit['image'])): ?>
                                    <div class="current-image">
                                        <img src="<?= base_url(esc($produit['image'])) ?>" alt="<?= esc($produit['nom']) ?>" class="product-image-preview">
                                        <p>Image actuelle: <?= esc($produit['image']) ?></p>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="custom-file-upload">
                                    <input type="file" id="image" name="image" class="file-input">
                                    <label for="image" class="file-label">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span>Sélectionner une nouvelle image</span>
                                    </label>
                                    <p class="file-info">Aucun fichier sélectionné</p>
                                </div>
                                <p class="form-help">Formats acceptés: JPG, PNG. Taille max: 2MB</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="admin-btn primary"><i class="fas fa-save"></i> Enregistrer les modifications</button>
                    <a href="<?= base_url('admin/produits') ?>" class="admin-btn secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url('js/admin-form-produit.js') ?>"></script>
<script>
// Initialiser le formulaire de produit
window.TrufficatAdminFormProduit.init();
</script>

<?= $this->include('layouts/footer') ?>
