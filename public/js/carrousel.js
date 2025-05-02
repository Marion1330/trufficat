document.addEventListener('DOMContentLoaded', () => {
    const carrousel = document.getElementById('carrousel');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    prevBtn.addEventListener('click', () => {
        carrousel.scrollBy({ left: -300, behavior: 'smooth' });
    });

    nextBtn.addEventListener('click', () => {
        carrousel.scrollBy({ left: 300, behavior: 'smooth' });
    });
});
