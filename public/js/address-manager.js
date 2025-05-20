// Gestionnaire de sélection d'adresses
document.addEventListener('DOMContentLoaded', function() {
    const paysSelect = document.getElementById('pays');
    const departementSelect = document.getElementById('departement');
    
    // Liste des pays européens livrables
    const pays = {
        'France': [
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
        ],
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

    // Initialiser le sélecteur de pays
    function initialiserPays() {
        paysSelect.innerHTML = '<option value="">Sélectionnez un pays</option>';
        
        Object.keys(pays).forEach(function(nomPays) {
            const option = document.createElement('option');
            option.value = nomPays;
            option.textContent = nomPays;
            paysSelect.appendChild(option);
        });
    }

    // Mettre à jour les départements en fonction du pays sélectionné
    function mettreAJourDepartements() {
        const paysSelectionne = paysSelect.value;
        departementSelect.innerHTML = '<option value="">Sélectionnez un département</option>';
        
        if (paysSelectionne && pays[paysSelectionne]) {
            pays[paysSelectionne].forEach(function(departement) {
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
            mettreAJourDepartements();
            
            if (departementSelect.dataset.valeur) {
                departementSelect.value = departementSelect.dataset.valeur;
            }
        }
        
        // Ajouter l'écouteur d'événement
        paysSelect.addEventListener('change', mettreAJourDepartements);
    }
}); 