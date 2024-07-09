<?php
    require_once('connexion.php');
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();
    $Logo="images/network.png";
 ?>

<!DOCTYPE html>
<html lang="fr-FR">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Connexion | <?php echo $app_infos['Design_App']; ?></title>
  <!-- Favicons -->
  <link href="<?php echo $Logo; ?>" rel="icon">
  <link href="<?php echo $Logo; ?>" rel="apple-touch-icon">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link href="notifica/css/alertify.min.css" rel="stylesheet">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<style>
    #monid {
        /*background: white;*/
        background-image: url("<?php echo $Logo; ?>");
        background-size: 250px;
        background-repeat: no-repeat;
        background-position: center;
    }
    .mydiv {
        opacity: 1 !important;
    }
</style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b><?php echo $app_infos['Design_App']; ?></b></a>
  </div>
<!--   <center>
  <img src="<?php echo $Logo; ?>" style="position: float">
  </center> -->
  <!-- /.login-logo -->
  <div class="card" id="monid">
    <div class="card-body login-card-body" style="opacity: 0.9;">
      <p class="login-box-msg"></p>

      <form action="" method="post" id="LoginForm">
        <div id="mlogin">
        <div class="input-group mb-3 mydiv">
          <input type="login" class="form-control" placeholder="Login" style="border-radius: 0" id="login">
          <div class="input-group-append">
            <div class="input-group-text" style="border-radius: 0">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3 mydiv">
          <input type="password" class="form-control" placeholder="Mot de passe" style="border-radius: 0" id="password">
          <div class="input-group-append">
            <div class="input-group-text" style="border-radius: 0">
              <a href="#" style="margin-right: 10px" title="Afficher" id="btn_afficher"><i class="fas fa-eye" id="myicon"></i></a>
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row mydiv" style="margin-bottom: 10px">
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block" style="border-radius: 5px" id="connecter">Se connecter</button>
          </div>
          <!-- /.col -->
          <div class="col-6">
            <button type="button" class="btn btn-danger btn-block" style="border-radius: 5px" id="annuler">Annuler</button>
          </div>
          <!-- /.col -->
        </div>
      </div>
<!--         <div class="input-group mb-3" style="display: none;" id="mcbarre">
          <input type="password" class="form-control" placeholder="Scannez votre code-barres" style="border-radius: 0" id="codebarre">
          <div class="input-group-append">
            <div class="input-group-text" style="border-radius: 0">
              <span class="fas fa-barcode"></span>
            </div>
          </div>
        </div> -->
      </form>

      <!-- <div class="social-auth-links text-center mb-3"> -->
        <!-- <p>- OU -</p> -->
        <!-- <input type="button" name="connect" id="connect" value="Se connecter par code-barres" class="btn btn-block btn-primary" style="border-radius: 0"> -->
<!--         <a href="#" class="btn btn-block btn-primary" style="border-radius: 0" id="connect">
          <i class="fab fa-facebook mr-2"></i> Se connecter par code-barre
        </a> -->
<!--         <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a> -->
      <!-- </div> -->
      <!-- /.social-auth-links -->

<!--       <p class="mb-1">
        <a href="../accueil">Retour à l'accueil</a>
      </p> -->
<!--       <p class="mb-0" style="margin-top: 20px">
        <center>
        Vous n'êtes pas ecore enregistré ? <a href="enregistrement" class="text-center">S'enregistrer</a>
        </center>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="notifica/alertify.min.js"></script>
</body>
</html>
<script type="text/javascript">
    var waitingDialog = waitingDialog || (function ($) {
    'use strict';

    // Creating modal dialog's DOM
    var $dialog = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
        '<div class="modal-dialog modal-m">' +
        '<div class="modal-content">' +
            '<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
            '<div class="modal-body">' +
                '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
            '</div>' +
        '</div></div></div>');

    return {
        /**
         * Opens our dialog
         * @param message Custom message
         * @param options Custom options:
         *                options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
         *                options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
         */
        show: function (message, options) {
            // Assigning defaults
            if (typeof options === 'undefined') {
                options = {};
            }
            if (typeof message === 'undefined') {
                message = 'Loading';
            }
            var settings = $.extend({
                dialogSize: 'm',
                progressType: '',
                onHide: null // This callback runs after the dialog was hidden
            }, options);

            // Configuring dialog
            $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
            $dialog.find('.progress-bar').attr('class', 'progress-bar');
            if (settings.progressType) {
                $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
            }
            $dialog.find('h3').text(message);
            // Adding callbacks
            if (typeof settings.onHide === 'function') {
                $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
                    settings.onHide.call($dialog);
                });
            }
            // Opening dialog
            $dialog.modal();
        },
        /**
         * Closes dialog
         */
        hide: function () {
            $dialog.modal('hide');
        }
    };

    })(jQuery);
  $('#annuler').click(function(){
      $('#login').val('');
      $('#password').val('');
      $('#login').focus();
  })
  $('#btn_afficher').click(function(e){
      e.preventDefault();
      if($(this).attr('title')=='Afficher'){
          $('#password').attr('type', 'text');
          $('#btn_afficher').attr('title', 'Masquer');
          $('#myicon').attr('class', 'fas fa-times');
      }else{
          $('#password').attr('type', 'password');
          $('#btn_afficher').attr('title', 'Afficher');
          $('#myicon').attr('class', 'fas fa-eye');
      }
  })
  $('#connect').click(function(e){
    e.preventDefault();
    if($('#connect').val()=='Se connecter par code-barres'){
        $('#mlogin').slideUp('slow', function(){
            $('#codebarre').val('');
            $('#codebarre').focus();
            $('#connect').val('Se connecter par login et mot de passe');
        });
        $('#mcbarre').slideDown('slow');
      }else{
        $('#mlogin').slideDown('slow', function(){
            $('#login').val('');
            $('#password').val('');
            $('#login').focus();
            $('#connect').val('Se connecter par code-barres');
        });
        $('#mcbarre').slideUp('fast');
      }
  })
  $('#LoginForm').submit(function(e){
      e.preventDefault();
      if($('#login').val()!="" && $('#password').val()!=""){
    
          $.ajax({
                url:'connexion_user.php',
                type:'post',
                beforeSend:function(){
                    waitingDialog.show('Veuillez patienter svp!');
                },
                dataType:'text', 
                data:{login:$('#login').val(), password:$('#password').val()},
                success:function(ret){
                    waitingDialog.hide();
                    if (ret==1){
                        window.location.replace("accueil?theme=light");
                    }else if (ret==2){
                        alertify.alert("<?php echo $app_infos['Design_App']; ?>","Authentification incorrecte, assurez-vous que vos identifiants sont corrects ou veuillez contacter l'Administrateur.", function(){$('#login').focus(); $('#login').select();});                 
                    }else if (ret==3){
                        alertify.alert("<?php echo $app_infos['Design_App']; ?>","Ce compte utilisateur est désactivé, veuillez contacter l'Administrateur.", function(){$('#login').select(); $('#login').focus();});                   
                    }else if (ret==4){
                        alertify.alert("<?php echo $app_infos['Design_App']; ?>","L'école de cet utilisateur est désactivé, veuillez contacter l'Administrateur.", function(){$('#login').focus(); $('#login').select();});                                
                    }else{
                        alertify.alert("<?php echo $app_infos['Design_App']; ?>",ret);                  
                    }
                }
            });
                                  
        }else{
            alertify.alert("<?php echo $app_infos['Design_App']; ?>","Veuillez préciser votre login et mot de passe");
        }
  })
    $('#codebarre').change(function(){
        $.ajax({
                url:'connexion_user_cod_barre.php',
                type:'post',
                beforeSend:function(){
                    waitingDialog.show('Veuillez patienter svp!');
                },
                dataType:'text', 
                data:{codebarre:$('#codebarre').val()},
                success:function(ret){
                    if (ret==1){
                        window.location.replace("accueil?theme=light");
                    }else if (ret==2){
                        waitingDialog.hide();
                        alertify.alert("<?php echo $app_infos['Design_App']; ?>","Authentification incorrecte, assurez-vous que la touche Maj est activée ou veuillez contacter l'Administrateur.", function(){$('#codebarre').val(''); $('#codebarre').focus();});              
                    }else if (ret==3){
                        waitingDialog.hide();
                        alertify.alert("<?php echo $app_infos['Design_App']; ?>","Ce compte utilisateur est désactivé, veuillez contacter l'Administrateur.", function(){$('#codebarre').select();$('#codebarre').focus();});                   
                    }else if (ret==4){
                        waitingDialog.hide();
                        alertify.alert("<?php echo $app_infos['Design_App']; ?>","Cet utilisateur n'est pas autorisé", function(){$('#login').focus(); $('#login').select();});                                
                    }else{
                        waitingDialog.hide();
                        alertify.alert("<?php echo $app_infos['Design_App']; ?>",ret);                  
                    }
                }
            });  
    })
</script>
