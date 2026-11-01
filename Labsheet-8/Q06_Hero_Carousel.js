// Question 6: Create an interactive hero carousel showcasing client products and services using JavaScript and CSS transitions.

document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.carousel-slide');
    const nextBtn = document.getElementById('nextSlideBtn');
    const prevBtn = document.getElementById('prevSlideBtn');
    let currentSlide = 0;

    function updateCarousel(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove('active');
            slide.style.opacity = '0';
            slide.style.transition = 'opacity 0.6s ease-in-out';
            if (i === index) {
                slide.classList.add('active');
                slide.style.opacity = '1';
            }
        });
    }

    if (nextBtn && prevBtn) {
        nextBtn.addEventListener('click', () => {
            currentSlide = (currentSlide + 1) % slides.length;
            updateCarousel(currentSlide);
        });

        prevBtn.addEventListener('click', () => {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            updateCarousel(currentSlide);
        });

        // Auto-play interval
        setInterval(() => {
            currentSlide = (currentSlide + 1) % slides.length;
            updateCarousel(currentSlide);
        }, 5000);
    }
});
