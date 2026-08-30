
<script src="assets/js/jquery.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script><!-- Swiper -->
<script src="assets/js/dz.carousel.js"></script><!-- Swiper -->
<script src="assets/js/settings.js"></script>
<script src="assets/js/custom.js"></script>
<script>
    new WOW().init();
    
    var wow = new WOW(
    {
      boxClass:     'wow',      // animated element css class (default is wow)
      animateClass: 'animated', // animation css class (default is animated)
      offset:       50,          // distance to the element when triggering the animation (default is 0)
      mobile:       false       // trigger animations on mobile devices (true is default)
  });
    wow.init(); 
</script>
<script>
  $(document).ready(function() {
    $('.mySelect').select2();
  });
</script>
<!-- <script>
    $(".stepper").TouchSpin();
</script> -->
</body>


</html>