    document.addEventListener('DOMContentLoaded', function() {
      var slideIndex = 0;
      var slides = document.getElementById('carouselSlide').children;

      function moveSlide(n) {
        slideIndex += n;
        if (slideIndex >= slides.length) {
          slideIndex = 0;
        } else if (slideIndex < 0) {
          slideIndex = slides.length - 1;
        }
        for (var i = 0; i < slides.length; i++) {
          slides[i].style.display = 'none';
        }
        slides[slideIndex].style.display = 'block';
      }

      moveSlide(0); // Show the first slide

      setInterval(function() { moveSlide(1); }, 3000); // Move to next slide every 1.5 seconds
    });



