<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_slj_wings']) || $_SESSION['logged_slj_wings']==false){
        header("location: connexion");
    }
    require_once ("connexion.php");
    $ID = $_SESSION['user_slj_wings']['ID_Utilisateur'];
    $Utilisateur = $pdo->query('SELECT * FROM utilisateur WHERE ID_Utilisateur='.$ID);
    $Utilisateurs = $Utilisateur->fetch();
    $Logo="images/avion.png";
    $agence=$pdo->query("SELECT * FROM agence WHERE ID_Agence=".$Utilisateurs['ID_Agence']);
    $agences=$agence->fetch();
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();
?>
<!DOCTYPE HTML>
<html>
<head>
<title><?php echo $app_infos['Design_App']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $app_infos['Design_App']; ?>" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="css/style-profil.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<script src="js/jquery.min.js"> </script>
<!-- Mainly scripts -->
<script src="js/jquery.metisMenu.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="notifica/alertify.min.js"></script>
<link href="images/logo.png" rel="icon">
<link href="images/logo.png" rel="apple-touch-icon">
<link href="notifica/css/alertify.min.css" rel="stylesheet">
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Custom and plugin javascript -->
<link href="css/custom.css" rel="stylesheet">
<script src="js/custom.js"></script>
<script src="js/screenfull.js"></script>
<style type="text/css">
    #miamge:hover{
      /*border-color: RGB(29,118,228);*/
      opacity: 0.7
    }
    #miamge{
      border-color: RGB(234,234,234);
      border-width: 3px;
      /*opacity: 0.7*/
    }
      .profile{
          background: url(<?php echo $Logo; ?>)no-repeat;
          background-size: 250px;
          background-position: center;
      }
</style>
</head>

<body>
		 <!-- <div id="page-wrapper" class="gray-bg dashbard-1"> -->
       <!-- <div class="content-main"> -->

 	 <!--gallery-->
 	 <div class=" profile">

		<div class="profile-bottom col-lg-12">
			<!-- <h3><i class="fa fa-user"></i>Profil</h3> -->
			<div class="profile-bottom-top">
			<div class="col-md-3 profile-bottom-img">
				<a href="#" id="mapercu" title="Changer l'avatar">
				<img src="<?php if($Utilisateurs['Photo']==''){if($Utilisateurs['ID_Profil']==1){echo('images/photo_femme.jpg');}else{echo('images/photo.jpg');}}else{ echo('images/profil/'.$Utilisateurs['Photo']);} ?>" class="img-circle" style="margin-bottom: 10px; width: 140px; height: 140px; border: 1px solid RGB(232,232,232)" id="miamge">
				</a>
			</div>
                  <form id="ProfilForm" method="post" action="" enctype="multipart/form-data">
                  <center>
                  <input id="id_user" type="hidden" name="id_user" value="<?php echo($ID); ?>">
                  <input id="token" type="hidden" name="token" value="<?php echo($_SESSION['user_slj_wings']['token']); ?>">
                  <input class="form-control " id="mimg" type="file" name="mimg" style="display: none;" accept=".jpg, .jpeg, .png">
                  <p>
                    <input id="submit" type="submit" name="submit" style="display: none;">
                  </p>
                  </center>
                </form>
			<div class="col-md-9 profile-text">
				<h6 style="color:#363636; font-weight: 200;"><?php echo $Utilisateurs['Prenom'].' '.$Utilisateurs['Nom']; ?></h6>
				<table>
				<tr><td style="color:#363636; font-weight: bold;">Login</td>  
				<td style="color:#363636; font-weight: bold;">:</td>  
				<td style="color:#363636; font-weight: bold;"><?php echo $Utilisateurs['Login']; ?></td></tr>
				<tr>
				<td style="color:#363636; font-weight: bold;">Téléphone</td>
				<td style="color:#363636; font-weight: bold;">:</td>
				<td style="color:#363636; font-weight: bold;"><?php echo $Utilisateurs['Tel']; ?></td>
				</tr>
				<tr>
				<td style="color:#363636; font-weight: bold;">Email</td>
				<td style="color:#363636; font-weight: bold;"> :</td>
				<td style="color:#363636; font-weight: bold;"><?php echo $Utilisateurs['Email']; ?></td>
				</tr>
				<tr>
				<td style="color:#363636; font-weight: bold;">Statut</td>
				<td style="color:#363636; font-weight: bold;"> :</td>
				<td style="color:#363636; font-weight: bold;"><?php echo $Utilisateurs['Statut']; ?></td>
				</tr>
                <?php if($Utilisateurs['Statut']=='Vendeur'){ ?>
                <tr>
                <td style="color:#363636; font-weight: bold;">Agence</td>
                <td style="color:#363636; font-weight: bold;"> :</td>
                <td style="color:#363636; font-weight: bold;"><?php echo stripslashes($agences['Design_Agence']); ?></td>
                </tr>
                <tr>
                <td style="color:#363636; font-weight: bold;">Fond disponible</td>
                <td style="color:#363636; font-weight: bold;"> :</td>
                <td style="color:#363636; font-weight: bold;"><?php echo number_format($agences['Fonds_disponible'], 2, ',', ' ').' USD'; ?></td>
                </tr> 
                <?php } ?>
				</table>
			</div>
			<div class="clearfix"></div>
			</div>
			<div class="profile-btn">
          <div class="row" style="padding-top: 10px">
              <div class='<?php if($Utilisateurs['Statut']=='Admin' || $Utilisateurs['Statut']=='User_Finance'){echo("col-md-6");}else{echo("col-md-9");} ?>'>
                
              </div>
              <div class="col-md-3" style="margin-bottom: 10px">
                <center>
                <button type="button" id="affmodal" class="btn btn-primary form-control" style="border-radius: 20px; font-family: sans-serif; margin-bottom: 10px">Changer le mot de passe</button>
                </center>
              </div>
              <?php if($Utilisateurs['Statut']=='Admin' || $Utilisateurs['Statut']=='User_Finance'){ ?>
              <div class="col-md-3">
                <center>
                <button type="button" id="envoyer_rapport" class="btn btn-success form-control" style="border-radius: 20px; font-family: sans-serif;">Envoyer le rapport synthèse</button>
                </center>
              </div>
              <?php } ?>
          </div>
                
                

           <div class="clearfix"></div>
			</div>
			
		</div>
	</div>
    <div id="ModalPassword" class="modal fade" data-backdrop="static" style="margin-top: 100px">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialoguepassword()">&times;</button>
                    <h4 class="modal-title">Mot de passe</h4>
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok" type="hidden" name="tok" value="<?php echo($_SESSION['user_slj_wings']['token']); ?>">
                    <div class="col-lg-12">Ancien *</div>
                    <div class="col-lg-12"><input type="password" name="ancien" id="ancien" class="form-control" style="margin-top: 1%" value="" required autofocus="autofocus"></div>
                    <div class="col-lg-12">Nouveau *</div>
                    <div class="col-lg-12"><input type="password" name="nouveau" id="nouveau" class="form-control" style="margin-top: 1%" value="" required></div>
                    <div class="col-lg-12">Confirmez nouveau *</div>
                    <div class="col-lg-12"><input type="password" name="nouveau2" id="nouveau2" class="form-control" style="margin-top: 1%" value="" required></div>
                    </form>
                </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="enregpassword" style="border-radius: 20px">Enregistrer</button>
                <button class="btn btn-danger" onclick="fermerDialoguepassword()" style="border-radius: 20px">Annuler</button>
            </div>
            </div>
        </div>
    </div>
	<!--//gallery-->
		<!---->

		<!-- </div> -->
		<!-- </div> -->
<!--scrolling js-->
  <script src="js/jquery.nicescroll.js"></script>
  <script src="js/scripts.js"></script>
  <!--//scrolling js-->
  <script src="js/bootstrap.min.js"> </script>
</body>

</html>
<script type="text/javascript">

    var waitingDialog = waitingDialog || (function ($) {
    'use strict';

    // Creating modal dialog's DOM
    var $dialog = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
        '<div class="modal-dialog">' +
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
    // $(document).ready(function(){
    //     $('.profile').css("background", "url(<?php echo $Logo; ?>)no-repeat")
          // background: url()no-repeat;
          // background-size: 250px;
          // background-position: center;
      // })
    // })
    $('#affmodal').click(function(e){
      e.preventDefault();
      $("#ModalPassword").modal('show');
      $('#ancien').val('');
      $('#nouveau').val('');
      $('#nouveau2').val('');
      $('#ancien').focus();
    })
        function fermerDialoguepassword(){
            $("#ModalPassword").modal('hide');
        };
          function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        async function demo() {
            await sleep(2000);
            $('#submit').click();
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
    $('#mapercu').click(function(e){
      e.preventDefault();
      $('#mimg').click();
    })
        $('#mimg').change(function(){
         readURL(this);
     })

  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

        $('#ProfilForm').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                    url:'edit_profil.php',
                    type:'post',
                    // beforeSend:function(){
                    //     waitingDialog.show('Veuillez patienter svp!');
                    // },
                    dataType:'text',
                    data: formData,
                    processData: false,
                    cache: false,
                    contentType: false,
                    success:function(ret){
                         waitingDialog.hide();
                          if(ret==2){
                             alertify.alert('<?php echo $app_infos['Design_App']; ?>',"L'extension de l'image ne correspond pas!");
                          }else if(ret==3){
                             alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Le téléchargement de l'image a échoué!");
                           }else if(ret==1){
                             Toast.fire({
                                icon: 'success',
                                title: 'Modification éffectuée'
                             })
                             $('#miamge').attr('src', images);
                         }else{
                            alertify.alert('<?php echo $app_infos['Design_App']; ?>', ret);
                         }

                    }
                });
          })

    $('#enregpassword').click(function(){
        if($('#ancien').val()=='' || $('#nouveau').val()=='' || $('#nouveau2').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!');
                $('#ancien').focus();
        }else{
            if($('#nouveau').val()!=$('#nouveau2').val()){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez confirmer le même nouveau mot de passe svp!');
            }else if($('#ancien').val()==$('#nouveau').val()){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Veuillez saisir un nouveau mot de passe différent de l'ancien svp!");  
            }else{
                $.ajax({
                        url:'EnregModep.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {Ancienpass:$('#ancien').val(), Nouveaupass:$('#nouveau').val(), Nouveaupass2:$('#nouveau2').val(), token:$('#tok').val()},
                        success:function(ret){
                            if(ret==1){
                             Toast.fire({
                                icon: 'success',
                                title: 'Modification éffectuée'
                             })
                                $("#ModalPassword").modal('hide');
                            }else if(ret==2){
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>',"l'ancien mot de passe n'est pas correct");  
                            }
                        }
                    });
            }
        }
    });


    $('#envoyer_rapport').click(function(){
                $.ajax({
                        url:'envoyer_rapport_mail.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        success:function(ret){
                            if(ret==1){
                             Toast.fire({
                                icon: 'success',
                                title: 'Message envoyé'
                             })
                          }else{
                              alertify.alert(ret);
                          }
                        }
                    });
    })

  })

</script>