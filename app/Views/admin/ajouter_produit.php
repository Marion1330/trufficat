<?= $this->include('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url('css/ajouter_produit.css') ?>">

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
            <h1><i class="fas fa-plus-circle"></i> Ajouter un produit</h1>
            <div class="admin-actions">
                <a href="<?= base_url('admin/produits') ?>" class="admin-btn secondary"><i class="fas fa-arrow-left"></i> Retour aux produits</a>
            </div>
        </div>
        
        <div class="edit-form-container">
            <form action="<?= base_url('admin/produit/ajouter') ?>" method="post" enctype="multipart/form-data" class="admin-form">
                <div class="form-grid">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="nom">Nom du produit <span class="required">*</span></label>
                            <input type="text" id="nom" name="nom" required class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description <span class="required">*</span></label>
                            <textarea id="description" name="description" rows="5" required class="form-control"></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="prix">Prix (€) <span class="required">*</span></label>
                                <input type="number" id="prix" name="prix" step="0.01" min="0" required class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="stock">Stock <span class="required">*</span></label>
                                <input type="number" id="stock" name="stock" value="0" min="0" required class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="animal">Animal <span class="required">*</span></label>
                            <select id="animal" name="animal" required class="form-control">
                                <option value="">Sélectionner...</option>
                                <option value="chien">Chien</option>
                                <option value="chat">Chat</option>
                            </select>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="categorie">Catégorie</label>
                                <select id="categorie" name="categorie" class="form-control">
                                    <option value="">Sélectionner...</option>
                                    <!-- Catégories pour chien -->
                                    <optgroup label="Alimentation" class="chien-categories" style="display: none;">
                                        <option value="alimentation">Alimentation</option>
                                        <option value="alimentation-sans-cereales">Alimentation sans céréales</option>
                                        <option value="alimentation-bio">Alimentation Bio</option>
                                        <option value="croquettes">Croquettes</option>
                                        <option value="croquettes-sterilise">Croquettes pour chiens stérilisés</option>
                                        <option value="boites-sachets">Boites et sachets</option>
                                        <option value="friandises">Friandises</option>
                                    </optgroup>
                                    <optgroup label="Hygiène et soins" class="chien-categories" style="display: none;">
                                        <option value="hygiene-soins">Hygiène et soins</option>
                                        <option value="antiparasitaires">Produits antiparasitaires</option>
                                        <option value="entretien-poil">Entretien du poil</option>
                                        <option value="sacs-proprete">Sacs de propreté</option>
                                    </optgroup>
                                    <optgroup label="Accessoires" class="chien-categories" style="display: none;">
                                        <option value="gamelles">Gamelles</option>
                                    </optgroup>
                                    <optgroup label="Niche et couchage" class="chien-categories" style="display: none;">
                                        <option value="paniers-coussins">Paniers et coussins</option>
                                        <option value="niches-chenils">Niches et chenils</option>
                                    </optgroup>
                                    <optgroup label="Transport" class="chien-categories" style="display: none;">
                                        <option value="caisses-transport">Caisses et sacs de transport</option>
                                        <option value="accessoires-voyage">Accessoires de voyage</option>
                                    </optgroup>
                                    <optgroup label="Sellerie" class="chien-categories" style="display: none;">
                                        <option value="laisses">Laisses</option>
                                        <option value="laisses-enrouleur">Laisses à enrouleur</option>
                                        <option value="colliers">Colliers</option>
                                        <option value="harnais">Harnais</option>
                                        <option value="muselieres">Muselières</option>
                                    </optgroup>
                                    <option value="jouets" class="chien-categories" style="display: none;">Jouets</option>

                                    <!-- Catégories pour chat -->
                                    <optgroup label="Alimentation" class="chat-categories" style="display: none;">
                                        <option value="alimentation">Alimentation</option>
                                        <option value="alimentation-sans-cereales">Alimentation sans céréales</option>
                                        <option value="alimentation-bio">Alimentation Bio</option>
                                        <option value="croquettes">Croquettes</option>
                                        <option value="croquettes-sterilise">Croquettes pour chats stérilisés</option>
                                        <option value="boites-sachets">Boites et sachets</option>
                                        <option value="friandises">Friandises</option>
                                    </optgroup>
                                    <optgroup label="Hygiène et soins" class="chat-categories" style="display: none;">
                                        <option value="hygiene-soins">Hygiène et soins</option>
                                        <option value="antiparasitaires">Produits antiparasitaires</option>
                                        <option value="litieres">Litières</option>
                                        <option value="bacs-litiere">Bacs à litière</option>
                                        <option value="accessoires-litieres">Accessoires de litières</option>
                                        <option value="maison-toilette">Maison de toilette</option>
                                        <option value="entretien-poil">Entretien du poil</option>
                                    </optgroup>
                                    <optgroup label="Couchage" class="chat-categories" style="display: none;">
                                        <option value="hamac">Hamac</option>
                                        <option value="niche-cabane">Niche et cabane</option>
                                        <option value="panier-coussin">Panier et coussin</option>
                                    </optgroup>
                                    <optgroup label="Transport" class="chat-categories" style="display: none;">
                                        <option value="sac-transport">Sac de transport</option>
                                        <option value="caisse-transport">Caisse de transport</option>
                                    </optgroup>
                                    <optgroup label="Accessoires" class="chat-categories" style="display: none;">
                                        <option value="gamelles">Gamelles</option>
                                        <option value="sellerie">Sellerie</option>
                                        <option value="chatieres">Chatières</option>
                                    </optgroup>
                                    <optgroup label="Jouets et griffoirs" class="chat-categories" style="display: none;">
                                        <option value="jouets">Jouets</option>
                                        <option value="arbres-griffoirs">Arbres à chat & griffoirs</option>
                                    </optgroup>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="marque">Marque</label>
                                <select id="marque" name="marque" class="form-control">
                                    <option value="">Sélectionner...</option>
                                    <option value="Royal Canin">Royal Canin</option>
                                    <option value="Purina">Purina</option>
                                    <option value="True Origins Wild">True Origins Wild</option>
                                    <option value="Sheba">Sheba</option>
                                    <option value="CATXTREME">CATXTREME</option>
                                    <option value="Nutriva Nature Plus">Nutriva Nature Plus</option>
                                    <option value="Edgard & Cooper">Edgard & Cooper</option>
                                    <option value="Animalis">Animalis</option>
                                    <option value="Leeby">Leeby</option>
                                    <option value="Ferplast">Ferplast</option>
                                    <option value="Beaphar">Beaphar</option>
                                    <option value="Paradisio">Paradisio</option>
                                    <option value="Bobby">Bobby</option>
                                    <option value="Trixie">Trixie</option>
                                    <option value="Turgo">Turgo</option>
                                    <option value="Flexi">Flexi</option>
                                    <option value="Gotoo">Gotoo</option>
                                    <option value="Nath Veterinary Diet">Nath Veterinary Diet</option>
                                    <option value="Yarrah">Yarrah</option>
                                    <option value="Weenect">Weenect</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="age">Âge</label>
                                <select id="age" name="age" class="form-control">
                                    <option value="">Sélectionner...</option>
                                    <option value="junior">Junior</option>
                                    <option value="adulte">Adulte</option>
                                    <option value="senior">Senior</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="sterilise">Animal stérilisé</label>
                                <select id="sterilise" name="sterilise" class="form-control">
                                    <option value="">Non applicable</option>
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="saveur">Saveur</label>
                                <select id="saveur" name="saveur" class="form-control" disabled>
                                    <option value="">Sélectionner...</option>
                                    <option value="Poulet">Poulet</option>
                                    <option value="Boeuf">Boeuf</option>
                                    <option value="Saumon">Saumon</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="is_vedette">Produit en vedette</label>
                                <select id="is_vedette" name="is_vedette" class="form-control">
                                    <option value="0" selected>Non</option>
                                    <option value="1">Oui</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="image">Image du produit</label>
                        <div class="image-upload-container">
                            <div class="custom-file-upload">
                                <input type="file" id="image" name="image" class="file-input">
                                <label for="image" class="file-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Sélectionner une image</span>
                                </label>
                                <p class="file-info">Aucun fichier sélectionné</p>
                            </div>
                            <p class="form-help">Formats acceptés: JPG, PNG. Taille max: 2MB</p>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="admin-btn primary"><i class="fas fa-save"></i> Ajouter le produit</button>
                    <a href="<?= base_url('admin/produits') ?>" class="admin-btn secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
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
