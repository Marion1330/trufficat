// Accueil functionality
window.TrufficatAccueil = {
    config: {},
    currentSlide: 0,
    slides: null,
    totalSlides: 0,
    
    init: function(config) {
        this.config = config;
        this.setupEventListeners();
        this.initCarousels();
    },
    
    setupEventListeners: function() {
        document.addEventListener('DOMContentLoaded', () => {
            this.setupAddToCartButtons();
            this.setupPublicityCarousel();
            this.setupProductCarousel();
        });
    },
    
    setupAddToCartButtons: function() {
        // Gestion de l'ajout au panier
        const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const productId = button.getAttribute('data-product-id');
                
                // Ajouter au panier via AJAX
                fetch(this.config.addToCartUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `produit_id=${productId}&quantite=1`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Rediriger vers le panier après ajout
                        window.location.href = this.config.panierUrl;
                    } else {
                        console.error('Erreur lors de l\'ajout au panier:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
            });
        });
    },
    
    setupPublicityCarousel: function() {
        // Carrousel de publicités
        this.slides = document.querySelectorAll('.pub-slide');
        this.totalSlides = this.slides.length;
        
        if (this.totalSlides === 0) return;
        
        // Auto-play
        setInterval(() => this.nextSlide(), 5000);
        
        // Boutons de navigation
        const nextBtn = document.querySelector('.pub-next');
        const prevBtn = document.querySelector('.pub-prev');
        
        if (nextBtn) nextBtn.addEventListener('click', () => this.nextSlide());
        if (prevBtn) prevBtn.addEventListener('click', () => this.prevSlide());
    },
    
    setupProductCarousel: function() {
        // Carrousel de produits vedettes
        const carrousel = document.querySelector('.carrousel');
        const leftBtn = document.querySelector('.carrousel-btn.left');
        const rightBtn = document.querySelector('.carrousel-btn.right');
        
        if (carrousel && leftBtn && rightBtn) {
            leftBtn.addEventListener('click', () => {
                carrousel.scrollBy({ left: -300, behavior: 'smooth' });
            });
            
            rightBtn.addEventListener('click', () => {
                carrousel.scrollBy({ left: 300, behavior: 'smooth' });
            });
        }
    },
    
    initCarousels: function() {
        // Initialiser l'état du carrousel de publicités
        if (this.totalSlides > 0) {
            this.showSlide(0);
        }
    },
    
    showSlide: function(index) {
        const carousel = document.querySelector('.pub-carousel');
        if (carousel) {
            carousel.style.transform = `translateX(-${index * 100}%)`;
        }
    },
    
    nextSlide: function() {
        this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        this.showSlide(this.currentSlide);
    },
    
    prevSlide: function() {
        this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        this.showSlide(this.currentSlide);
    }
}; 