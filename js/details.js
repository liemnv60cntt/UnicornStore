var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      if(slides[i] != null)
        slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      if(dots[i] != null)
        dots[i].className = dots[i].className.replace(" active", "");
  }
  if(slides[slideIndex-1] != null)
    slides[slideIndex-1].style.display = "block";
  if(dots[slideIndex-1] != null)
    dots[slideIndex-1].className += " active";
}