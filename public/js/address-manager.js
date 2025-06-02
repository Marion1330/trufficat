// Gestionnaire de sélection d'adresses avec API
document.addEventListener('DOMContentLoaded', function() {
    const paysSelect = document.getElementById('pays');
    const departementSelect = document.getElementById('departement');
    
    // Cache pour éviter les appels API répétés
    let cacheAPI = {
        departementsFrance: null
    };
    
    // Liste des pays européens livrables (sauf France qui utilise l'API)
    const paysStatiques = {
        'Allemagne': [
            'Bade-Wurtemberg', 'Bavière', 'Berlin', 'Brandebourg', 'Brême', 'Hambourg', 'Hesse', 'Mecklembourg-Poméranie-Occidentale', 
            'Basse-Saxe', 'Rhénanie-du-Nord-Westphalie', 'Rhénanie-Palatinat', 'Sarre', 'Saxe', 'Saxe-Anhalt', 'Schleswig-Holstein', 'Thuringe'
        ],
        'Belgique': [
            'Anvers', 'Brabant flamand', 'Brabant wallon', 'Bruxelles-Capitale', 'Flandre occidentale', 'Flandre orientale', 'Hainaut', 
            'Liège', 'Limbourg', 'Luxembourg', 'Namur'
        ],
        'Espagne': [
            'Andalousie', 'Aragon', 'Asturies', 'Îles Baléares', 'Pays basque', 'Îles Canaries', 'Cantabrie', 'Castille-et-León', 
            'Castille-La Manche', 'Catalogne', 'Estrémadure', 'Galice', 'Madrid', 'Murcie', 'Navarre', 'La Rioja', 'Communauté valencienne'
        ],
        'Italie': [
            'Abruzzes', 'Basilicate', 'Calabre', 'Campanie', 'Émilie-Romagne', 'Frioul-Vénétie Julienne', 'Latium', 'Ligurie', 'Lombardie', 
            'Marches', 'Molise', 'Piémont', 'Pouilles', 'Sardaigne', 'Sicile', 'Toscane', 'Trentin-Haut-Adige', 'Ombrie', 'Vallée d\'Aoste', 'Vénétie'
        ],
        'Luxembourg': ['Luxembourg'],
        'Pays-Bas': [
            'Drenthe', 'Flevoland', 'Frise', 'Gueldre', 'Groningue', 'Limbourg', 'Brabant-Septentrional', 'Hollande-Septentrionale', 
            'Overijssel', 'Utrecht', 'Zélande', 'Hollande-Méridionale'
        ],
        'Suisse': [
            'Argovie', 'Appenzell Rhodes-Extérieures', 'Appenzell Rhodes-Intérieures', 'Bâle-Campagne', 'Bâle-Ville', 'Berne', 'Fribourg', 
            'Genève', 'Glaris', 'Grisons', 'Jura', 'Lucerne', 'Neuchâtel', 'Nidwald', 'Obwald', 'Saint-Gall', 'Schaffhouse', 'Schwyz', 
            'Soleure', 'Thurgovie', 'Tessin', 'Uri', 'Valais', 'Vaud', 'Zoug', 'Zurich'
        ]
    };

    // Récupérer les départements français via l'API Gouv.fr
    async function chargerDepartementsFrancais() {
        if (cacheAPI.departementsFrance) {
            return cacheAPI.departementsFrance;
        }

        try {
            // Afficher un message de chargement
            departementSelect.innerHTML = '<option value="">Chargement des départements...</option>';
            departementSelect.disabled = true;

            const response = await fetch('https://geo.api.gouv.fr/departements');
            
            if (!response.ok) {
                throw new Error(`Erreur API: ${response.status}`);
            }
            
            const departements = await response.json();
            
            // Transformer les données de l'API en format utilisable
            cacheAPI.departementsFrance = departements
                .map(dept => dept.nom)
                .sort(); // Trier alphabétiquement
            
            return cacheAPI.departementsFrance;
            
        } catch (error) {
            console.error('Erreur lors du chargement des départements:', error);
            
            // Fallback : utiliser les données en dur en cas d'erreur API
            cacheAPI.departementsFrance = [
                'Ain', 'Aisne', 'Allier', 'Alpes-de-Haute-Provence', 'Hautes-Alpes', 'Alpes-Maritimes', 'Ardèche', 'Ardennes', 'Ariège', 'Aube', 
                'Aude', 'Aveyron', 'Bouches-du-Rhône', 'Calvados', 'Cantal', 'Charente', 'Charente-Maritime', 'Cher', 'Corrèze', 'Corse-du-Sud', 
                'Haute-Corse', 'Côte-d\'Or', 'Côtes-d\'Armor', 'Creuse', 'Dordogne', 'Doubs', 'Drôme', 'Eure', 'Eure-et-Loir', 'Finistère', 
                'Gard', 'Haute-Garonne', 'Gers', 'Gironde', 'Hérault', 'Ille-et-Vilaine', 'Indre', 'Indre-et-Loire', 'Isère', 'Jura', 
                'Landes', 'Loir-et-Cher', 'Loire', 'Haute-Loire', 'Loire-Atlantique', 'Loiret', 'Lot', 'Lot-et-Garonne', 'Lozère', 'Maine-et-Loire', 
                'Manche', 'Marne', 'Haute-Marne', 'Mayenne', 'Meurthe-et-Moselle', 'Meuse', 'Morbihan', 'Moselle', 'Nièvre', 'Nord', 
                'Oise', 'Orne', 'Pas-de-Calais', 'Puy-de-Dôme', 'Pyrénées-Atlantiques', 'Hautes-Pyrénées', 'Pyrénées-Orientales', 'Bas-Rhin', 
                'Haut-Rhin', 'Rhône', 'Haute-Saône', 'Saône-et-Loire', 'Sarthe', 'Savoie', 'Haute-Savoie', 'Paris', 'Seine-Maritime', 
                'Seine-et-Marne', 'Yvelines', 'Deux-Sèvres', 'Somme', 'Tarn', 'Tarn-et-Garonne', 'Var', 'Vaucluse', 'Vendée', 'Vienne', 
                'Haute-Vienne', 'Vosges', 'Yonne', 'Territoire de Belfort', 'Essonne', 'Hauts-de-Seine', 'Seine-Saint-Denis', 'Val-de-Marne', 
                'Val-d\'Oise', 'Guadeloupe', 'Martinique', 'Guyane', 'La Réunion', 'Mayotte'
            ];
            
            return cacheAPI.departementsFrance;
        }
    }

    // Initialiser le sélecteur de pays
    function initialiserPays() {
        paysSelect.innerHTML = '<option value="">Sélectionnez un pays</option>';
        
        // Ajouter la France en premier
        const optionFrance = document.createElement('option');
        optionFrance.value = 'France';
        optionFrance.textContent = 'France';
        paysSelect.appendChild(optionFrance);
        
        // Ajouter les autres pays
        Object.keys(paysStatiques).forEach(function(nomPays) {
            const option = document.createElement('option');
            option.value = nomPays;
            option.textContent = nomPays;
            paysSelect.appendChild(option);
        });
    }

    // Mettre à jour les départements en fonction du pays sélectionné
    async function mettreAJourDepartements() {
        const paysSelectionne = paysSelect.value;
        departementSelect.innerHTML = '<option value="">Sélectionnez un département</option>';
        
        if (!paysSelectionne) {
            departementSelect.disabled = true;
            return;
        }

        if (paysSelectionne === 'France') {
            // Utiliser l'API pour la France
            const departements = await chargerDepartementsFrancais();
            
            departements.forEach(function(departement) {
                const option = document.createElement('option');
                option.value = departement;
                option.textContent = departement;
                departementSelect.appendChild(option);
            });
            
            departementSelect.disabled = false;
            
        } else if (paysStatiques[paysSelectionne]) {
            // Utiliser les données statiques pour les autres pays
            paysStatiques[paysSelectionne].forEach(function(departement) {
                const option = document.createElement('option');
                option.value = departement;
                option.textContent = departement;
                departementSelect.appendChild(option);
            });
            
            departementSelect.disabled = false;
        } else {
            departementSelect.disabled = true;
        }
    }

    // Initialiser les sélecteurs
    if (paysSelect && departementSelect) {
        initialiserPays();
        
        // Définir les valeurs initiales si elles existent
        if (paysSelect.dataset.valeur) {
            paysSelect.value = paysSelect.dataset.valeur;
            mettreAJourDepartements().then(() => {
                if (departementSelect.dataset.valeur) {
                    departementSelect.value = departementSelect.dataset.valeur;
                }
            });
        }
        
        // Ajouter l'écouteur d'événement
        paysSelect.addEventListener('change', mettreAJourDepartements);
    }
}); 