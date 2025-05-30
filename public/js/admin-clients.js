// Admin clients functionality
window.TrufficatAdminClients = {
    config: {},
    searchInput: null,
    tableRows: null,
    
    init: function(config) {
        this.config = config;
        document.addEventListener('DOMContentLoaded', () => {
            this.searchInput = document.getElementById('searchInput');
            this.tableRows = document.querySelectorAll('.products-table tbody tr');
            
            this.setupEventListeners();
        });
    },
    
    setupEventListeners: function() {
        if (this.searchInput) {
            this.searchInput.addEventListener('input', (e) => {
                this.filterClients(e.target.value);
            });
        }
    },
    
    filterClients: function(searchTerm) {
        const term = searchTerm.toLowerCase();
        
        this.tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(term) ? '' : 'none';
        });
    },
    
    confirmerSuppression: function(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce client ?')) {
            window.location.href = this.config.deleteUrl + id;
        }
    }
};

// Fonction globale pour la compatibilité avec les boutons onclick
function confirmerSuppression(id) {
    window.TrufficatAdminClients.confirmerSuppression(id);
} 