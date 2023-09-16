<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once ("connexion.php");
    $ID = $_SESSION['user_eteelo_app']['ID_Utilisateur'];
    $Utilisateur = $pdo->query('SELECT * FROM utilisateur WHERE ID_Utilisateur='.$ID);
    $Utilisateurs = $Utilisateur->fetch();
    $ecole=$pdo->query("SELECT * FROM etablissement WHERE ID_Etablissement=".$Utilisateurs['ID_Etablissement']);
    $ecoles=$ecole->fetch();
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();
?>
<!DOCTYPE html>
<html lang="fr-FR">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Profile | <?php echo $app_infos['Design_App']; ?></title>
    <!-- CSS files -->
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="notifica/css/alertify.min.css" rel="stylesheet">
    <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <link href="./dist/css/demo.min.css" rel="stylesheet"/>
    <link href="images/icon.png" rel="icon">
    <link href="images/icon.png" rel="apple-touch-icon">
  </head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" style="overflow: hidden;">
    <div class="page">
      <div class="page-wrapper">
        <div class="container-xl">
          <!-- Page title -->
          <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  
                </div>
                <h2 class="page-title">
                  Profile
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-12 col-md-auto ms-auto d-print-none">
                <div class="btn-list">
<!--                   <span class="d-none d-sm-inline">
                    <a href="#" class="btn btn-white">
                      New view
                    </a>
                  </span> -->
<!--                   <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                    Download SVG icon from http://tabler-icons.io/i/plus
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Create new report
                  </a> -->
<!--                   <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                    Download SVG icon from http://tabler-icons.io/i/plus
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                  </a> -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-deck row-cards">
              <div class="col-md-6 col-lg-4">
              </div>
              <div class="col-md-6 col-lg-4">
                <div class="card">
                  <div class="card-body p-4 text-center">
                  <form id="ProfilForm" method="post" action="" enctype="multipart/form-data">
                  <input id="id_user" type="hidden" name="id_user" value="<?php echo($ID); ?>">
                  <input id="token" type="hidden" name="token" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                  <input class="form-control" id="mimg" type="file" name="mimg" style="display: none;" accept=".jpg, .jpeg, .png">
                    <a href="#" id="mapercu" title="Changer la photo">
                    <span class="avatar avatar-xl mb-3 avatar-rounded" style="background-image: url(<?php if($Utilisateurs['Photo']==''){if($Utilisateurs['ID_Profil']==1){echo('images/photo_femme.jpg');}else{echo('images/photo.jpg');}}else{ echo('images/profil/'.$Utilisateurs['Photo']);} ?>); border: 1px solid #DEE2E6;" id="miamge"><?php if($Utilisateurs['Etat']==1){echo("<img src='images/connecte.gif' style='width: 12px; height: 12px; margin-top: 85px; margin-left: 78px'>");} ?></span></a>
                    <h3 class="m-0 mb-1"><!-- <a href="#"> --><?php echo $Utilisateurs['Prenom'].' '.$Utilisateurs['Nom']; ?></h3>
                    <div class="text-muted"><?php echo $Utilisateurs['Statut']; ?></div>
                    <?php if($Utilisateurs['Statut']!='Admin'){ ?>
                    <div class="mt-3">
                      <span class="badge bg-purple-lt">Ecole: <?php echo ($ecoles['Design_Etablissement']); ?></span>
                    </div>
                    <?php } ?>
                    <div class="mt-3">
                    <input id="submit" type="submit" name="submit" style="display: none;">
                    <button type="button" class="btn btn-primary" id="affmodal">Modifier le mot de passe</button>
                    </div>
                  </form>
                  </div>
                  <?php if($Utilisateurs['Email']!='' || $Utilisateurs['Tel']){ ?>
                  <div class="d-flex" style="font-size:11px">
                    <?php if($Utilisateurs['Email']!=''){ ?>
                    <a href="mailto:<?php echo $Utilisateurs['Email']; ?>" class="card-btn"><!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="5" width="18" height="14" rx="2" /><polyline points="3 7 12 13 21 7" /></svg>
                      <?php echo $Utilisateurs['Email']; ?></a>
                      <?php } if($Utilisateurs['Tel']){ ?>
                    <a href="tel:<?php echo '243'.$Utilisateurs['Tel']; ?>" class="card-btn"><!-- Download SVG icon from http://tabler-icons.io/i/phone -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>
                      <?php echo '243'.$Utilisateurs['Tel']; ?></a>
                      <?php } ?>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="ModalPassword" class="modal fade" data-backdrop="static">
        <div class="modal-dialog modal-sm" style="margin-top: 100px; border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialoguepassword()">&times;</button> -->
                    <h4 class="modal-title">Modification</h4>
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok" type="hidden" name="tok" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="col-lg-12">Ancien mot de passe *</div>
                    <div class="col-lg-12"><input type="password" name="ancien" id="ancien" class="form-control" style="margin-top: 1%" value="" required autofocus="autofocus"></div>
                    <div class="col-lg-12">Nouveau mot de passe *</div>
                    <div class="col-lg-12"><input type="password" name="nouveau" id="nouveau" class="form-control" style="margin-top: 1%" value="" required></div>
                    <div class="col-lg-12">Confirmez le nouveau mot de passe *</div>
                    <div class="col-lg-12"><input type="password" name="nouveau2" id="nouveau2" class="form-control" style="margin-top: 1%" value="" required></div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enregpassword">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialoguepassword()">Annuler</button>
            </div>
            </div>
        </div>
    </div>
    <script src="./dist/libs/apexcharts/dist/apexcharts.min.js" defer></script>
    <script src="./dist/libs/jsvectormap/dist/js/jsvectormap.min.js" defer></script>
    <script src="./dist/libs/jsvectormap/dist/maps/world.js" defer></script>
    <script src="./dist/libs/jsvectormap/dist/maps/world-merc.js" defer></script>
    <script src="plugins/toastr/toastr.min.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="notifica/alertify.min.js"></script>
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js" defer></script>
    <script src="./dist/js/demo.min.js" defer></script>


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

                    $('#miamge').css('background-image', 'url(images/loading.gif');
                    images = e.target.result;
                    demo()
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

    $('#affmodal').click(function(){
      // e.preventDefault();
      $("#ModalPassword").modal('show');
      $('#ancien').val('');
      $('#nouveau').val('');
      $('#nouveau2').val('');
      $('#ancien').focus();
    })

    $('#mapercu').click(function(e){
      e.preventDefault();
      $('#mimg').click();
    })
        $('#mimg').change(function(){
         readURL(this);
     })



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
                             // alertify.success('Modification éffectuée');
                             $('#miamge').css('background-image', 'url('+images+')');
                             // $('#miamge').attr('src', images);
                             Toast.fire({
                                icon: 'success',
                                title: 'Modification éffectuée'
                             })
                         }else{
                            alertify.alert(ret);
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
                alertify.alert('',"Veuillez saisir un nouveau mot de passe différent de l'ancien svp!");  
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
                                alertify.success("L'opération a réussi");
                                $("#ModalPassword").modal('hide');
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Modification éffectuée'
                                })
                            }else if(ret==2){
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>',"l'ancien mot de passe n'est pas correct");  
                            }
                        }
                    });
            }
        }
    });

  });
  // $(document).ready(function(){
  //     alertify.alert('Bonjour');
  // })
</script>
</body>
</html>
