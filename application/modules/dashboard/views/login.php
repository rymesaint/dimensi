<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="description" content="Portal Dimensi Login">
  <meta name="author" content="Isna Nur Azis">
  <meta name="keyword" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title ?></title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">

  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/plugins/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/plugins/simple-line-icons.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/plugins/animate.min.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/plugins/icheck/skins/flat/aero.css"/>
  <link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet">
  <!-- end: Css -->

  <link rel="shortcut icon" href="<?php echo base_url() ?>assets/img/logomi.png">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>

    <body id="mimin" class="dashboard form-signin-wrapper">

      <div class="container">
        <form class="form-signin">
          <div class="panel periodic-login">
              <div class="panel-body text-center">
                  <p class="element-name"><?php echo $title ?></p>
                  <p class="element-name"><?php echo $app_name ?></p>

                  <i class="icons icon-arrow-down"></i>

                  <div class="result"></div>
                  <div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <input type="text" name="username" id="username" class="form-text" required>
                    <span class="bar"></span>
                    <label>Pengguna</label>
                  </div>
                  <div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <input type="password" name="password" id="password" class="form-text" required>
                    <span class="bar"></span>
                    <label>Kata Sandi</label>
                  </div>
                  <label class="pull-left">
                  <input type="checkbox" class="icheck pull-left" name="checkbox1"/> Ingat Aku
                  </label>
                  <input type="submit" class="btn col-md-12" onclick="tryLogin()" value="Masuk"/>
              </div>
          </div>
        </form>

      </div>

      <!-- end: Content -->
      <!-- start: Javascript -->
      <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
      <script src="<?php echo base_url() ?>assets/js/jquery.ui.min.js"></script>
      <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>

      <script src="<?php echo base_url() ?>assets/js/plugins/moment.min.js"></script>
      <script src="<?php echo base_url() ?>assets/js/plugins/icheck.min.js"></script>

      <!-- custom -->
      <script src="<?php echo base_url() ?>assets/js/main.js"></script>
      <script type="text/javascript">
        function tryLogin(){
          var user = $("#username").val(),
              pass = $("#password").val();
          $.ajax({
            url: '<?php echo base_url() ?>dashboard/users/auth/',
            type: 'POST',
            data: "username="+user+"&password="+pass,
            success:function(data){
              $(".result").html(data);
            },
            error:function(){}
          });
        }
      </script>
      <script type="text/javascript">
       $(document).ready(function(){
         $('input').iCheck({
          checkboxClass: 'icheckbox_flat-aero',
          radioClass: 'iradio_flat-aero'
        });
       });
     </script>
     <!-- end: Javascript -->
   </body>
   </html>