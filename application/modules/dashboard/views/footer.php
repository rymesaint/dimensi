<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>    
    
</div>
</main>

<footer class="page-footer grey darken-3">
  <div class="footer-copyright">
    <div class="container">
    © 2015 Copyright <?php echo $app_name ?>
    </div>
  </div>
</footer>

<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/materialize.min.js"></script>
<script>
  $( document ).ready(function(){
    $(".dropdown-button").dropdown();
    $('.collapsible').collapsible({
        accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
      });
  })
</script>
</body>
</html>