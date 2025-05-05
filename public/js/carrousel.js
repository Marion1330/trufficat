document.addEventListener('DOMContentLoaded', () => {
    // Sélectionner les éléments nécessaires
    const carrousel = document.querySelector('.carrousel');
    const btnLeft = document.querySelector('.carrousel-btn.left');
    const btnRight = document.querySelector('.carrousel-btn.right');
    
    // Définir la quantité de scroll (largeur d'une carte + marge)
    const scrollAmount = 270; // largeur d'une carte + marge (ajustable)

    // Fonction pour faire défiler le carrousel vers la gauche
    btnLeft.addEventListener('click', () => {
        carrousel.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });

    // Fonction pour faire défiler le carrousel vers la droite
    btnRight.addEventListener('click', () => {
        carrousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });

    // Gestion du drag & drop (fonction tactile ou souris)
    let isMouseDown = false;
    let startX, scrollLeft;

    // Lorsque l'utilisateur appuie sur le carrousel
    carrousel.addEventListener('mousedown', (e) => {
        isMouseDown = true;
        startX = e.pageX - carrousel.offsetLeft;
        scrollLeft = carrousel.scrollLeft;
    });

    // Lorsque l'utilisateur relâche le bouton de la souris
    carrousel.addEventListener('mouseup', () => {
        isMouseDown = false;
    });

    // Lorsque l'utilisateur déplace la souris
    carrousel.addEventListener('mousemove', (e) => {
        if (!isMouseDown) return;
        e.preventDefault();
        const x = e.pageX - carrousel.offsetLeft;
        const walk = (x - startX) * 3; // Le facteur '3' ajuste la vitesse du défilement
        carrousel.scrollLeft = scrollLeft - walk;
    });

    // Si l'utilisateur touche (sur mobile)
    carrousel.addEventListener('touchstart', (e) => {
        isMouseDown = true;
        startX = e.touches[0].pageX - carrousel.offsetLeft;
        scrollLeft = carrousel.scrollLeft;
    });

    // Lorsque l'utilisateur arrête de toucher
    carrousel.addEventListener('touchend', () => {
        isMouseDown = false;
    });

    // Lorsque l'utilisateur fait glisser avec son doigt
    carrousel.addEventListener('touchmove', (e) => {
        if (!isMouseDown) return;
        const x = e.touches[0].pageX - carrousel.offsetLeft;
        const walk = (x - startX) * 3; // Le facteur '3' ajuste la vitesse du défilement
        carrousel.scrollLeft = scrollLeft - walk;
    });
});

