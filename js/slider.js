var slides = document.querySelectorAll('.slide__box');
var i = 0;

setInterval(function() {
    slides.forEach(function(slide) {
        slide.style.display = 'none';
    });
    if (slides[i]) {
        slides[i].style.display = 'block';
    }
    i = (i + 1) % slides.length; // Dynamically handle the number of slides
}, 4000);