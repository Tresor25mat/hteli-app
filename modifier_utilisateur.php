<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_slj_wings']) || $_SESSION['logged_slj_wings']==false){
        header("location: connexion");
    }
    require_once ("connexion.php");
    $ID = $_GET['ID'];
    $Utilisateur = $pdo->query('SELECT * FROM utilisateur WHERE ID_Utilisateur='.$ID);
    $Utilisateurs = $Utilisateur->fetch();
    $profil=$pdo->query("SELECT * FROM profil ORDER BY ID_Profil");
    $agence=$pdo->query("SELECT * FROM agence ORDER BY Design_Agence");
    $statut=$pdo->query("SELECT * FROM table_statut WHERE Design_Statut !='User_Checkin' ORDER BY ID_Statut");
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php echo $app_infos['Design_App']; ?>">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="<?php echo $app_infos['Design_App']; ?>">
  <title><?php echo $app_infos['Design_App']; ?></title>

  <!-- Favicons -->
  <link href="images/avion.png" rel="icon">
  <link href="images/avion.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="css/zabuto_calendar.css">
  <link rel="stylesheet" type="text/css" href="lib/gritter/css/jquery.gritter.css" />
  <link rel="stylesheet" type="text/css" href="vendor/jquery/jquery-ui.min.css" />
  <!-- Custom styles for this template -->
  <!-- <link href="css/style-2.css" rel="stylesheet"> -->
  <link href="css/style-responsive.css" rel="stylesheet">
  <link href="notifica/css/alertify.min.css" rel="stylesheet">
  <script src="lib/chart-master/Chart.js"></script>
  <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
  <script type="text/javascript" src="notifica/alertify.min.js"></script>
  <script src="js/jquery.slimscroll.min.js"></script>
  <style>
      .ui-autocomplete{
          background-color:#CCC ! important;
      }
      .bcg-logo{
          height: 250px;
          /*position: fixed;*/
          background: url(images/avion.png)no-repeat;
          background-size: 250px;
          background-position: center;
          /*background-position: 50% 90%*/
      }
    .miamge:hover{
      /*border-color: RGB(29,118,228);*/
      opacity: 0.7
    }
/*.form-control {
    font-size: 17px;
}*/
  </style>

</head>

<body>

   <div class=" profile">

    <div class="profile-bottom col-lg-12">

  <section id="container">
<!--     <section id="main-content">
      <section class="wrapper"> -->
        <!-- FORM VALIDATION -->
        <div class="row mt">
            <div class="row" style="padding: 20px; margin-bottom: 30px; border-bottom: 1px solid #DEE2E6">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding-top: 10px;">
                    <a href="table_utilisateur.php" class="btn btn-primary form-control mybtn" style="border-radius: 20px; margin-left: 0; margin-bottom: 10px">Retour</a>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12"></div>
                <!-- /.col-lg-12 -->
            </div>
          <div class="col-lg-12" style="margin-top: 10px">
            <!-- <h2 class="page-header" style="padding-left: 5px; color: black">Nouvel utilisateur</h2> -->
                    <ul class="nav nav-tabs" style="margin-top: -20px;">
                        <li class="active" id="l0"><a href="#informations"  id="a0" data-toggle="tab" style="border-radius: 0">Informations</a>
                        </li><!--informations-->
                        <li class="disabled l1"><a href="#" id="a1" data-toggle="tab" style="border-radius: 0">Images</a>
                                </li><!--images-->
                    </ul>
              <form class="cmxform form-horizontal style-form" id="UtilisateurForm" method="post" action="" enctype="multipart/form-data">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="informations" style="border: 1px solid RGB(238,238,238); padding-left: 30px; padding-top: 10px; padding-right: 30px">
                                    <div class="row">
                                      <div class="col-md-4">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left">Prénom *</label>
                                          <div class="col-lg-10">
                                            <input id="id_user" type="hidden" name="id_user" value="<?php echo($ID); ?>">
                                            <input id="token" type="hidden" name="token" value="<?php echo($_SESSION['user_slj_wings']['token']); ?>">
                                            <input class="form-control " id="prenom" type="text" name="prenom" value="<?php echo(stripslashes($Utilisateurs['Prenom'])); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left">Nom *</label>
                                          <div class="col-lg-10">
                                            <input class="form-control " id="nom" type="text" name="nom" value="<?php echo(stripslashes($Utilisateurs['Nom'])); ?>">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-md-4">
                                        <div class="form-group ">
                                          <label for="profil" class="control-label col-lg-12" style="text-align: left">Profil *</label>
                                          <div class="col-lg-10">
                                            <select name="profil" id="profil" class="form-control ">
                                              <option value="">--</option>
                                              <?php while ($profils=$profil->fetch()) { ?>
                                                <option value="<?php echo $profils['ID_Profil']; ?>" <?php if($profils['ID_Profil']==$Utilisateurs['ID_Profil']){echo "selected"; }?>><?php echo stripslashes($profils['Design_Profil']); ?></option>
                                              <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left">Téléphone *</label>
                                          <div class="col-lg-10">
                                            <input class="form-control " id="tel" type="text" name="tel" placeholder="EX:24381xxxxxxx" value="<?php echo($Utilisateurs['Tel']); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left">Email</label>
                                          <div class="col-lg-10">
                                            <input class="form-control " id="mail" type="text" name="mail" value="<?php echo($Utilisateurs['Email']); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left">Statut *</label>
                                          <div class="col-lg-10">
                                            <select name="statut" id="statut" class="form-control ">
                                              <option value="">--</option>
                                              <?php while($statuts=$statut->fetch()){ ?>
                                              <option value="<?php echo ($statuts['Design_Statut']); ?>" <?php if($statuts['Design_Statut']==$Utilisateurs['Statut']){echo "selected"; }?>><?php echo ($statuts['Design_Statut']); ?></option>
                                              <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left">agence *</label>
                                          <div class="col-lg-10">
                                            <select name="agence" id="agence" class="form-control "  <?php if($Utilisateurs['Statut']!='Vendeur' && $Utilisateurs['Statut']!='Chef_Escale'){echo 'disabled="disabled"'; }?>>
                                              <option value="">--</option>
                                              <?php while($agences=$agence->fetch()){ ?>
                                              <option value="<?php echo($agences['ID_Agence']); ?>" <?php if($agences['ID_Agence']==$Utilisateurs['ID_Agence']){echo "selected"; }?>><?php echo stripslashes($agences['Design_Agence']); ?></option>
                                              <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left">Login *</label>
                                          <div class="col-lg-10">
                                            <input class="form-control " id="login" type="text" name="login" value="<?php echo($Utilisateurs['Login']); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left">Mot de passe *</label>
                                          <div class="col-lg-10">
                                              <div class="input-group">
                                                <div class="input-group-btn">
                                                  <a href="#" class="btn btn-default" title="Afficher" id="afficher_modep" style="border-radius: 0"><i class="fa fa-adn" id="micon"></i></a>
                                                </div>
                                                <input class="form-control " id="password" type="password" name="password">
                                                <div class="input-group-btn">
                                                <button type="button" class="btn btn-primary" id="generer_modep">Générer</button>
                                                </div>
                                              </div> 
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                        <div class="row" style="margin-top: 10px; border-top: 1px solid #E7E7E7; padding: 10px">
                                            <div class="col-lg-12">
                                              <div class="pull-right">
                                                  <button class="btn btn-primary" type="button" id="btn_next" style="border-radius: 20px">Suivant</button>
                                                  <button class="btn btn-danger" type="button" id="btn_annuler" style="border-radius: 20px">Annuler</button>
                                              </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="tab-pane fade" id="images" style="border: 1px solid RGB(238,238,238); padding-left: 30px; padding-top: 10px; padding-right: 30px">
                                    <div class="row">
                                      <div class="col-md-2">
                                    <div class="form-group ">
                                      <label for="curl" class="control-label col-lg-12" style="text-align: left">Avatar</label>
                                      <div class="col-lg-10">
                                        <input class="form-control " id="mimg" type="file" name="mimg" style="display: none;" accept=".jpg, .jpeg, .png">
                                        <a href="#" id="mapercu" title="Choisir un avatar">
                                        <img src="<?php if($Utilisateurs['Photo']==''){if($Utilisateurs['ID_Profil']==1){echo('images/photo_femme.jpg');}else{echo('images/photo.jpg');}}else{ echo('images/profil/'.$Utilisateurs['Photo']);} ?>" style="width: 150px; height: 150px; border: 2px solid RGB(234,234,234); border-radius: 0" id="miamge" class="miamge">
                                        </a>
                                      </div>
                                    </div>
                                    </div>
                                    </div>
                                        <div class="row" style="margin-top: 10px; border-top: 1px solid #E7E7E7; padding: 10px">
                                            <div class="col-lg-12">
                                              <div class="pull-right">
                                                  <button class="btn btn-primary" type="submit" id="btn_enregistrer" style="border-radius: 20px">Enregistrer</button>
                                                  <button class="btn btn-danger" type="button" id="btn_annuler_tout" style="border-radius: 20px">Annuler</button>
                                              </div>
                                            </div>
                                        </div>
                                </div>

                            </div>
                            <div class="bcg-logo"></div>

            </form>
            <!-- /form-panel -->
          </div>
          <!-- /col-lg-12 -->
        </div>
  </section>
          </div>
          <!-- /col-lg-12 -->
        </div>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
  <!-- <script src="lib/jquery.scrollTo.min.js"></script> -->
  <script src="vendor/jquery/jquery-ui.min.js"></script>
  <script src="js/jquery.nicescroll.js"></script>
  <!--common script for all pages-->
  <script src="js/scripts.js"></script>
  <!--script for this page-->
  <script src="lib/form-validation-script.js"></script>

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

$(document).ready(function(){

})

          function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        async function demo() {
            await sleep(2000);
            $('#miamge').attr('src', images);
        }
         function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#miamge').attr('src', 'images/unnamed (3).gif');
                    images = e.target.result;
                    demo()
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    $('#afficher_modep').click(function(e){
        e.preventDefault();
        if($('#afficher_modep').attr('title')=='Afficher'){
            $('#password').attr('type', 'text');
            $('#afficher_modep').attr('title', 'Masquer');
            $('#micon').attr('class', 'fa fa-times');
        }else{
            $('#password').attr('type', 'password');
            $('#afficher_modep').attr('title', 'Afficher');
            $('#micon').attr('class', 'fa fa-adn'); 
        }
    })
    $('#btn_next').click(function(){
        if($('#prenom').val()=='' || $('#nom').val()=='' || $('#profil').val()=='' || $('#login').val()=='' || $('#tel').val()==''){
          alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!', function(){$('#prenom').focus();});
        }else{
            $('#a1').attr('href','#images');
            $('.l1').removeClass('disabled').addClass('Active');
            $('#a1').tab('show');
            // $('#entreprise').focus();
        }
    })
    $('#mapercu').click(function(e){
      e.preventDefault();
      $('#mimg').click();
    })

    $('#mimg').change(function(){
         readURL(this);
     })

    $('#mail').change(function(){
        $.ajax({
            url:'validationmail.php',
            type:'post',
            dataType:'text',
            data: {Mail:$('#mail').val()},
            success:function(ret){
                if(ret==1){
                    $('#mail').css('border-color', 'RGB(234,234,234)');
                    $('#btn_next').attr('disabled', false);
                }else if(ret==2){
                    alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Veuillez saisir une adresse mail valide svp!", function(){
                      $('#mail').css('border-color', 'RGB(215,76,71)');
                      $('#mail').val($('#mail').val());
                      $('#btn_next').attr('disabled', true);
                      $('#mail').focus();
                    });
                }
            }
        }); 
    })

        $('#UtilisateurForm').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                    url:'edit_utilisateur.php',
                    type:'post',
                    beforeSend:function(){
                        waitingDialog.show('Veuillez patienter svp!');
                    },
                    dataType:'text',
                    data: formData,
                    processData: false,
                    cache: false,
                    contentType: false,
                    success:function(ret){
                         waitingDialog.hide();
                         if(ret==2){
                             alertify.alert('<?php echo $app_infos['Design_App']; ?>',"L'extension de l'image ne correspond pas à une image!");
                         }else if(ret==3){
                             alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Le téléchargement de l'image a échoué!");
                         }else if(ret==1){
                             alertify.success('Enregistrement éffectué');
                             window.location.replace('table_utilisateur.php');
                         }else{
                            alertify.alert(ret);
                         }

                    }
                });
          })
          $('#nom').blur(function(){
            $.ajax({
                    url:'count_utilisateur.php',
                    type:'post',
                    dataType:'text',
                    success:function(ret){
                        var str = $('#prenom').val()+'.'+$('#nom').val()+ret;
                        var res = str.toLowerCase().replace(/ /g, "");
                        $('#login').val(res);
                        // $('#password').val('1234');
                    }
                });
          })
          $('#generer_modep').click(function(){
            $.ajax({
                    url:'generer_modep.php',
                    type:'post',
                    dataType:'text',
                    success:function(ret){
                        $('#password').val(ret);
                    }
                });
          })
          $('#profil').change(function(){
            $('#tel').focus();
            if($('#profil').val()==1){
                $('#miamge').attr('src', 'images/photo_femme.jpg');
            }else{
                $('#miamge').attr('src', 'images/photo.jpg');
            }
          })
          $('#statut').change(function(){
              if($('#statut').val()=='Vendeur' || $('#statut').val()=='Chef_Escale'){
                  $('#agence').attr('disabled', false);
                  $('#agence').val('');
                  $('#agence').focus();
              }else{
                  $('#agence').attr('disabled', true);
                  $('#agence').val('');
                  $('#password').focus();
              }
          })
          $('#agence').change(function(){
              $('#password').focus();
          })             
    $('#btn_annuler').click(function(){
        window.location.replace('table_utilisateur.php');
    })
    $('#btn_annuler_tout').click(function(){
        window.location.replace('table_utilisateur.php');
    })
</script>