document.addEventListener('DOMContentLoaded', () => {
    /** === CARROUSEL PRODUITS VEDETTES === **/
    const carrousel = document.querySelector('.carrousel');
    const btnLeft = document.querySelector('.carrousel-btn.left');
    const btnRight = document.querySelector('.carrousel-btn.right');
    const scrollAmount = 270;

    // Gestion des boutons "Ajouter au panier"
    document.querySelectorAll('.btn-add-to-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            
            fetch(baseUrl + 'index.php/panier/ajouter', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `produit_id=${productId}&quantite=1`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = baseUrl + 'index.php/panier';
                } else {
                    alert(data.message || 'Une erreur est survenue lors de l\'ajout au panier');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de l\'ajout au panier. Veuillez réessayer.');
            });
        });
    });

    if (carrousel && btnLeft && btnRight) {
        btnLeft.addEventListener('click', () => {
            carrousel.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });

        btnRight.addEventListener('click', () => {
            carrousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });

        let isMouseDown = false;
        let startX, scrollLeft;

        carrousel.addEventListener('mousedown', (e) => {
            isMouseDown = true;
            startX = e.pageX - carrousel.offsetLeft;
            scrollLeft = carrousel.scrollLeft;
        });

        carrousel.addEventListener('mouseup', () => {
            isMouseDown = false;
        });

        carrousel.addEventListener('mousemove', (e) => {
            if (!isMouseDown) return;
            e.preventDefault();
            const x = e.pageX - carrousel.offsetLeft;
            const walk = (x - startX) * 3;
            carrousel.scrollLeft = scrollLeft - walk;
        });

        carrousel.addEventListener('touchstart', (e) => {
            isMouseDown = true;
            startX = e.touches[0].pageX - carrousel.offsetLeft;
            scrollLeft = carrousel.scrollLeft;
        });

        carrousel.addEventListener('touchend', () => {
            isMouseDown = false;
        });

        carrousel.addEventListener('touchmove', (e) => {
            if (!isMouseDown) return;
            const x = e.touches[0].pageX - carrousel.offsetLeft;
            const walk = (x - startX) * 3;
            carrousel.scrollLeft = scrollLeft - walk;
        });
    }

    /** === CARROUSEL PUB === **/
    const pubCarousel = document.querySelector('.pub-carousel');
    const pubSlides = document.querySelectorAll('.pub-slide');
    const prevBtn = document.querySelector('.pub-prev');
    const nextBtn = document.querySelector('.pub-next');
    let currentIndex = 0;

    if (pubCarousel && pubSlides.length > 0 && prevBtn && nextBtn) {
        function showSlide(index) {
            if (index >= pubSlides.length) currentIndex = 0;
            else if (index < 0) currentIndex = pubSlides.length - 1;
            else currentIndex = index;

            pubCarousel.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        prevBtn.addEventListener('click', () => showSlide(currentIndex - 1));
        nextBtn.addEventListener('click', () => showSlide(currentIndex + 1));
        setInterval(() => showSlide(currentIndex + 1), 5000);
    }
});
