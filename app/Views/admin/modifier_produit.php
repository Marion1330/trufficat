<?= $this->include('layouts/header') ?>

<div class="admin-container">
    <div class="admin-sidebar">
        <div class="admin-profile">
            <img src="<?= base_url('images/admin_avatar.png') ?>" alt="Admin" class="admin-avatar" onerror="this.src='<?= base_url('images/placeholder.png') ?>'">
            <h3>Administrateur</h3>
            <p><?= session('email') ?? 'admin@trufficat.com' ?></p>
        </div>
        
        <nav class="admin-nav">
            <ul>
                <li><a href="<?= base_url('admin') ?>"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a></li>
                <li class="active"><a href="<?= base_url('admin/produits') ?>"><i class="fas fa-box-open"></i> Produits</a></li>
                <li><a href="<?= base_url('admin/clients') ?>"><i class="fas fa-users"></i> Clients</a></li>
                <li><a href="<?= base_url('admin/commandes') ?>"><i class="fas fa-shopping-cart"></i> Commandes</a></li>
                <li><a href="<?= base_url('admin/categories') ?>"><i class="fas fa-tags"></i> Catégories</a></li>
                <li><a href="<?= base_url('admin/parametres') ?>"><i class="fas fa-cog"></i> Paramètres</a></li>
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
                                        <img src="<?= base_url('images/' . esc($produit['image'])) ?>" alt="<?= esc($produit['nom']) ?>" class="product-image-preview">
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

<style>
/* Styles pour le tableau de bord administrateur */
.admin-container {
    display: flex;
    min-height: calc(100vh - 180px);
    background-color: #f7f9fc;
}

.admin-sidebar {
    width: 280px;
    background-color: #F2C078;
    color: #4A3A2D;
    box-shadow: 2px 0 5px rgba(0,0,0,0.05);
    flex-shrink: 0;
}

.admin-profile {
    padding: 25px 20px;
    text-align: center;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

.admin-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    background-color: #fff;
    padding: 3px;
    border: 2px solid #D97B29;
    margin-bottom: 10px;
}

.admin-profile h3 {
    margin: 0 0 5px;
    font-size: 18px;
    color: #4A3A2D;
}

.admin-profile p {
    margin: 0;
    font-size: 14px;
    color: #6B3F1D;
    opacity: 0.8;
}

.admin-nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.admin-nav li {
    margin-bottom: 2px;
}

.admin-nav a {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    color: #4A3A2D;
    text-decoration: none;
    transition: all 0.3s;
    font-weight: 500;
}

.admin-nav a i {
    margin-right: 10px;
    width: 20px;
    text-align: center;
}

.admin-nav li.active a,
.admin-nav a:hover {
    background-color: #D97B29;
    color: white;
}

.admin-content {
    flex: 1;
    padding: 25px;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e0e0e0;
}

.admin-header h1 {
    margin: 0;
    font-size: 24px;
    color: #D97B29;
    display: flex;
    align-items: center;
}

.admin-header h1 i {
    margin-right: 10px;
}

.admin-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.admin-btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 15px;
    background-color: #D97B29;
    color: white;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.admin-btn i {
    margin-right: 8px;
}

.admin-btn.primary {
    background-color: #D97B29;
}

.admin-btn.primary:hover {
    background-color: #B45B19;
}

.admin-btn.secondary {
    background-color: #6B3F1D;
}

.admin-btn.secondary:hover {
    background-color: #4A3A2D;
}

/* Formulaire d'édition */
.edit-form-container {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    padding: 25px;
}

.admin-form {
    width: 100%;
}

.form-grid {
    display: grid;
    grid-template-columns: 3fr 2fr;
    gap: 30px;
}

.form-column {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    margin-bottom: 0;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #4A3A2D;
}

.required {
    color: #d9534f;
}

.form-control {
    width: 300px;
    padding: 10px 15px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.3s;
}

.form-control:focus {
    border-color: #D97B29;
    outline: none;
}

textarea.form-control {
    resize: vertical;
    min-height: 120px;
}

.checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 5px;
}

.checkbox-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.checkbox-item input[type="checkbox"] {
    width: 16px;
    height: 16px;
}

/* Gestion des images */
.image-upload-container {
    margin-top: 10px;
}

.current-image {
    margin-bottom: 15px;
    padding: 15px;
    background-color: #FFF8F0;
    border-radius: 8px;
    text-align: center;
}

.product-image-preview {
    max-width: 100%;
    max-height: 200px;
    object-fit: contain;
    margin-bottom: 10px;
}

.custom-file-upload {
    border: 2px dashed #e0e0e0;
    border-radius: 8px;
    padding: 25px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
    margin-bottom: 10px;
}

.custom-file-upload:hover {
    border-color: #D97B29;
}

.file-input {
    display: none;
}

.file-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.file-label i {
    font-size: 32px;
    color: #D97B29;
    margin-bottom: 10px;
}

.file-label span {
    font-weight: 500;
    color: #6B3F1D;
}

.file-info {
    margin-top: 10px;
    font-size: 14px;
    color: #777;
}

.form-help {
    margin-top: 5px;
    font-size: 12px;
    color: #888;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #f0f0f0;
}

/* Responsive */
@media (max-width: 992px) {
    .admin-container {
        flex-direction: column;
    }
    
    .admin-sidebar {
        width: 100%;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .admin-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .admin-actions {
        margin-top: 15px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const animalSelect = document.getElementById('animal');
    const categorieSelect = document.getElementById('categorie');
    const saveurSelect = document.getElementById('saveur');

    // Fonction pour mettre à jour l'affichage des catégories selon l'animal
    function updateCategories() {
        const animal = animalSelect.value;
        const chienCategories = document.querySelectorAll('.chien-categories');
        const chatCategories = document.querySelectorAll('.chat-categories');

        if (animal === 'chien') {
            chienCategories.forEach(cat => cat.style.display = '');
            chatCategories.forEach(cat => cat.style.display = 'none');
        } else {
            chienCategories.forEach(cat => cat.style.display = 'none');
            chatCategories.forEach(cat => cat.style.display = '');
        }
    }

    // Fonction pour gérer l'activation du sélecteur de saveur
    function updateSaveurSelect() {
        const categorie = categorieSelect.value;
        const alimentationCategories = [
            'alimentation',
            'alimentation-sans-cereales',
            'alimentation-bio',
            'croquettes',
            'croquettes-sterilise',
            'boites-sachets',
            'friandises'
        ];

        saveurSelect.disabled = !alimentationCategories.includes(categorie);
        if (saveurSelect.disabled) {
            saveurSelect.value = '';
        }
    }

    // Écouter les changements
    animalSelect.addEventListener('change', updateCategories);
    categorieSelect.addEventListener('change', updateSaveurSelect);

    // Initialiser l'état au chargement
    updateCategories();
    updateSaveurSelect();

    // Gestion de l'upload d'image
    const fileInput = document.getElementById('image');
    const fileInfo = document.querySelector('.file-info');
    
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const fileName = this.files[0].name;
            fileInfo.textContent = fileName;
            
            // Prévisualisation optionnelle
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.className = 'product-image-preview';
                
                const container = document.querySelector('.current-image');
                if (container) {
                    container.innerHTML = '';
                    container.appendChild(preview);
                    container.appendChild(document.createElement('p')).textContent = 'Nouvelle image: ' + fileName;
                } else {
                    const newContainer = document.createElement('div');
                    newContainer.className = 'current-image';
                    newContainer.appendChild(preview);
                    newContainer.appendChild(document.createElement('p')).textContent = 'Nouvelle image: ' + fileName;
                    
                    const uploadContainer = document.querySelector('.image-upload-container');
                    uploadContainer.insertBefore(newContainer, uploadContainer.firstChild);
                }
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            fileInfo.textContent = 'Aucun fichier sélectionné';
        }
    });
});
</script>

<?= $this->include('layouts/footer') ?>
