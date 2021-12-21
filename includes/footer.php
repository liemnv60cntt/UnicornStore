</div>
<!-- Footer -->
<div class="mt-auto">
    <div class="container-fluid bg-footer-1 p-4">
      <div class="container">
        <div class="row">
          <div class="col-sm-4 col-6 text-center">
            <h5>Store &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
            <div class="text-start mx-auto" style="max-width: 10em;">
              <i class='fas fa-store' style='font-size:15px'> Unicorn Store</i><br>
              <i class='fas fa-phone-alt' style='font-size:15px;'> 0967771211</i><br>
              <i class='fas fa-envelope-open' style='font-size:15px'> unicorn@gmail.com</i>
            </div>
          </div>
          <div class="col-sm-4 col-6 text-center">
            <h5>About us &nbsp;&nbsp;&nbsp;&nbsp;</h5>
            <div class="text-start mx-auto" style="max-width: 6em;">
              <a href="#" class="about-color">About us</a><br>
              <a href="#" class="about-color">Support</a><br>
              <a href="#" class="about-color">Feedback</a><br>
              <a href="#" class="about-color">Help</a>
            </div>
          </div>
          <div class="col-sm-4 text-center">
            <h5>Contact &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
            <div class="text-start mx-auto" style="max-width: 10em;">
              <i class='fab fa-facebook' style='font-size:24px'></i>
              <i class='fab fa-instagram' style='font-size:24px'></i>
              <i class='fab fa-twitter' style='font-size:24px'></i>
              <i class='fab fa-pinterest-p' style='font-size:24px'></i>
              <i class='fab fa-youtube' style='font-size:24px'></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="bg-footer-2 text-center text-white-50 p-3">
      Powered by Nguyen Van Liem - Sweetsoft
    </div>

  </div>


  <script>
    // When the user scrolls down 80px from the top of the document, resize the navbar's padding and the logo's font size
    window.onscroll = function() {
      scrollFunction()
    };

    function scrollFunction() {
      if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
        document.getElementById("navbar").style.padding = "0px 0px";
        document.getElementById("logo-img").style.width = "50px";
      } else {
        document.getElementById("navbar").style.padding = "20px 10px";
        document.getElementById("logo-img").style.width = "80px";
      }
    }
  </script>
  <script>

  document.addEventListener('click',function(e){
    // Hamburger menu
    if(e.target.classList.contains('hamburger-toggle')){
      e.target.children[0].classList.toggle('active');
    }
  })   
        
  </script>
  <script>
    function limitNum(){
      var n = Math.round(document.getElementById('quantity_detail').value,10);
      var remain = Math.round(document.getElementById('remain_detail').value,10);
      document.getElementById('quantity_detail').value = n
      // console.log(remain);
      if(!n){
        document.getElementById('quantity_detail').value = 1;
      }
      if(n>remain){
        document.getElementById('quantity_detail').value = remain;
      }
      if(n<1){
        document.getElementById('quantity_detail').value = 1;
      }
      return;
    }
    function upOrDown(isUp) {
      var g = parseInt(document.getElementById('quantity_detail').value,10);
      var r = parseInt(document.getElementById('remain_detail').value,10);
      g = isUp ? (++g > r ? r : g) : (--g < 1 ? 1 : g)
      document.getElementById('quantity_detail').value = g;
      return;
    }
  </script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
  <script src="./js/sidebar.js"></script>
  <script src="./js/details.js"></script>
  <script src="./js/rating.js"></script>
  <script src="./js/404.js"></script>
  <script src="./js/cart.js"></script>
</body>

</html>