// Slider functionality
let slideIndex = 0;
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');

function showSlide(index) {
    if (index >= slides.length) {
        slideIndex = 0;
    } else if (index < 0) {
        slideIndex = slides.length - 1;
    }
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';
        dots[i].classList.remove('active');
    }
    slides[slideIndex].style.display = 'block';
    dots[slideIndex].classList.add('active');
}

function moveSlide(n) {
    showSlide(slideIndex += n);
}

function currentSlide(n) {
    showSlide(slideIndex = n - 1);
}

function autoSlide() {
    showSlide(slideIndex += 1);
    setTimeout(autoSlide, 3000);
}

showSlide(slideIndex);
autoSlide();








