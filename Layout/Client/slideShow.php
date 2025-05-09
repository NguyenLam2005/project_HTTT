<div class="slide__box">
        <img src="./img/slide/slide00.jpg" alt="" class = "slide active_slide">
        <img src="./img/slide/slide07.png" alt="" class = "slide">
        <img src="./img/slide/slide05.avif" alt="" class = "slide">
        <img src="./img/slide/slide02.png" alt="" class = "slide">
        <img src="./img/slide/slide03.png" alt="" class = "slide">
    </div>
    <script>
        let currentIndex = 0;
        const slides = document.querySelectorAll(".slide__box .slide");
        const totalSlides = slides.length;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle("active_slide", i === index);
            });
        }

        setInterval(() => {
            currentIndex = (currentIndex + 1) % totalSlides;
            showSlide(currentIndex);
        }, 4000);

    </script>
