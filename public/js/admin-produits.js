// Admin produits functionality
window.TrufficatAdminProduits = {
    sortSelect: null,
    tbody: null,
    searchInput: null,
    
    init: function() {
        document.addEventListener('DOMContentLoaded', () => {
            this.sortSelect = document.querySelector('.sort-select');
            this.tbody = document.querySelector('.products-table tbody');
            this.searchInput = document.getElementById('searchInput');
            
            this.setupEventListeners();
        });
    },
    
    setupEventListeners: function() {
        // Event listener pour le tri
        if (this.sortSelect && this.tbody) {
            this.sortSelect.addEventListener('change', (e) => {
                const value = e.target.value;
                if (!value) return;
                
                const parts = value.split('_');
                const sortBy = parts[0];
                const direction = parts[1] || 'asc';
                
                console.log('Tri par:', sortBy, 'Direction:', direction);
                this.sortTable(sortBy, direction);
            });
        }
        
        // Event listener pour la recherche
        if (this.searchInput && this.tbody) {
            let searchTimeout;
            
            this.searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                const query = e.target.value.trim().toLowerCase();
                
                searchTimeout = setTimeout(() => {
                    this.filterProducts(query);
                }, 300);
            });
        }
    },
    
    sortTable: function(sortBy, direction) {
        const rows = Array.from(this.tbody.querySelectorAll('tr'));
        
        const sortFunctions = {
            name: (a, b) => a.querySelector('.td-name').textContent.localeCompare(b.querySelector('.td-name').textContent),
            price: (a, b) => {
                const priceTextA = a.querySelector('.td-price').textContent.replace(/[€\s]/g, '').replace(',', '.');
                const priceTextB = b.querySelector('.td-price').textContent.replace(/[€\s]/g, '').replace(',', '.');
                const priceA = parseFloat(priceTextA) || 0;
                const priceB = parseFloat(priceTextB) || 0;
                return priceA - priceB;
            },
            stock: (a, b) => {
                const stockTextA = a.querySelector('.td-stock .stock-badge').textContent.trim();
                const stockTextB = b.querySelector('.td-stock .stock-badge').textContent.trim();
                const stockA = stockTextA === 'Rupture' ? 0 : parseInt(stockTextA) || 0;
                const stockB = stockTextB === 'Rupture' ? 0 : parseInt(stockTextB) || 0;
                return stockA - stockB;
            },
            category: (a, b) => a.querySelector('.td-category').textContent.localeCompare(b.querySelector('.td-category').textContent),
            brand: (a, b) => a.querySelector('.td-brand').textContent.localeCompare(b.querySelector('.td-brand').textContent),
            age: (a, b) => {
                const ageOrder = { 'Junior': 1, 'Adulte': 2, 'Sénior': 3, '-': 4 };
                const ageA = ageOrder[a.querySelector('.td-age').textContent.trim()] || 4;
                const ageB = ageOrder[b.querySelector('.td-age').textContent.trim()] || 4;
                return ageA - ageB;
            },
            flavor: (a, b) => a.querySelector('.td-flavor').textContent.localeCompare(b.querySelector('.td-flavor').textContent),
            featured: (a, b) => {
                const featuredA = a.querySelector('.td-featured .vedette-badge') ? 1 : 0;
                const featuredB = b.querySelector('.td-featured .vedette-badge') ? 1 : 0;
                return featuredA - featuredB;
            },
            created: (a, b) => {
                const getCreatedDate = (el) => {
                    const dateText = el.querySelector('.date-created').textContent;
                    const match = dateText.match(/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})/);
                    if (!match) return new Date(0);
                    const [, day, month, year, hours, minutes] = match;
                    return new Date(year, month - 1, day, hours, minutes);
                };
                return getCreatedDate(a) - getCreatedDate(b);
            },
            updated: (a, b) => {
                const getUpdatedDate = (el) => {
                    const dateText = el.querySelector('.date-updated').textContent;
                    const match = dateText.match(/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})/);
                    if (!match) return new Date(0);
                    const [, day, month, year, hours, minutes] = match;
                    return new Date(year, month - 1, day, hours, minutes);
                };
                return getUpdatedDate(a) - getUpdatedDate(b);
            }
        };

        if (sortFunctions[sortBy]) {
            rows.sort((a, b) => {
                let result = sortFunctions[sortBy](a, b);
                return direction === 'desc' ? -result : result;
            });

            // Réinsérer les lignes triées
            rows.forEach(row => this.tbody.appendChild(row));
        }
    },
    
    filterProducts: function(query) {
        const rows = this.tbody.querySelectorAll('tr');
        
        rows.forEach(row => {
            const searchableText = [
                row.querySelector('.td-name').textContent,
                row.querySelector('.td-description').textContent,
                row.querySelector('.td-category').textContent,
                row.querySelector('.td-brand').textContent,
                row.querySelector('.td-age').textContent,
                row.querySelector('.td-flavor').textContent
            ].join(' ').toLowerCase();
            
            if (query === '' || searchableText.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
}; 