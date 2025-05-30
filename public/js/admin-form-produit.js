// Admin form produit functionality
window.TrufficatAdminFormProduit = {
    animalSelect: null,
    categorieSelect: null,
    saveurSelect: null,
    fileInput: null,
    fileInfo: null,
    
    init: function() {
        document.addEventListener('DOMContentLoaded', () => {
            this.animalSelect = document.getElementById('animal');
            this.categorieSelect = document.getElementById('categorie');
            this.saveurSelect = document.getElementById('saveur');
            this.fileInput = document.getElementById('image');
            this.fileInfo = document.querySelector('.file-info');
            
            this.setupEventListeners();
            this.initializeState();
        });
    },
    
    setupEventListeners: function() {
        // Écouter les changements d'animal
        if (this.animalSelect) {
            this.animalSelect.addEventListener('change', () => this.updateCategories());
        }
        
        // Écouter les changements de catégorie
        if (this.categorieSelect) {
            this.categorieSelect.addEventListener('change', () => this.updateSaveurSelect());
        }
        
        // Écouter les changements de fichier
        if (this.fileInput && this.fileInfo) {
            this.fileInput.addEventListener('change', (e) => this.handleFileUpload(e));
        }
    },
    
    // Fonction pour mettre à jour l'affichage des catégories selon l'animal
    updateCategories: function() {
        const animal = this.animalSelect.value;
        const chienCategories = document.querySelectorAll('.chien-categories');
        const chatCategories = document.querySelectorAll('.chat-categories');

        if (animal === 'chien') {
            chienCategories.forEach(cat => cat.style.display = '');
            chatCategories.forEach(cat => cat.style.display = 'none');
        } else {
            chienCategories.forEach(cat => cat.style.display = 'none');
            chatCategories.forEach(cat => cat.style.display = '');
        }
    },
    
    // Fonction pour gérer l'activation du sélecteur de saveur
    updateSaveurSelect: function() {
        const categorie = this.categorieSelect.value;
        const alimentationCategories = [
            'alimentation',
            'alimentation-sans-cereales',
            'alimentation-bio',
            'croquettes',
            'croquettes-sterilise',
            'boites-sachets',
            'friandises'
        ];

        this.saveurSelect.disabled = !alimentationCategories.includes(categorie);
        if (this.saveurSelect.disabled) {
            this.saveurSelect.value = '';
        }
    },
    
    // Gestion de l'upload d'image
    handleFileUpload: function(e) {
        if (e.target.files && e.target.files[0]) {
            const fileName = e.target.files[0].name;
            this.fileInfo.textContent = fileName;
            
            // Prévisualisation
            const reader = new FileReader();
            reader.onload = (event) => {
                const preview = document.createElement('img');
                preview.src = event.target.result;
                preview.className = 'product-image-preview';
                
                let container = document.querySelector('.current-image');
                if (container) {
                    container.innerHTML = '';
                    container.appendChild(preview);
                    const p = document.createElement('p');
                    p.textContent = 'Nouvelle image: ' + fileName;
                    container.appendChild(p);
                } else {
                    const newContainer = document.createElement('div');
                    newContainer.className = 'current-image';
                    newContainer.appendChild(preview);
                    const p = document.createElement('p');
                    p.textContent = 'Nouvelle image: ' + fileName;
                    newContainer.appendChild(p);
                    
                    const uploadContainer = document.querySelector('.image-upload-container');
                    uploadContainer.insertBefore(newContainer, uploadContainer.firstChild);
                }
            };
            reader.readAsDataURL(e.target.files[0]);
        } else {
            this.fileInfo.textContent = 'Aucun fichier sélectionné';
        }
    },
    
    // Initialiser l'état au chargement
    initializeState: function() {
        this.updateCategories();
        this.updateSaveurSelect();
    }
}; 