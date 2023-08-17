<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connection");
    }
    require_once('connexion.php');
    $ID = $_GET['ID'];
    $Utilisateur = $pdo->query('SELECT * FROM utilisateur WHERE ID_Utilisateur='.$ID);
    $Utilisateurs = $Utilisateur->fetch();
    $profil=$pdo->query("SELECT * FROM profil ORDER BY ID_Profil");
    $ecole=$pdo->query("SELECT * FROM etablissement ORDER BY Design_Etablissement");
    if($_SESSION['user_eteelo_app']['ID_Statut']==1){
      $statut=$pdo->query("SELECT * FROM statut_user ORDER BY ID_Statut");
    }else if($_SESSION['user_eteelo_app']['ID_Statut']==3){
      $statut=$pdo->query("SELECT * FROM statut_user WHERE ID_Statut!=1 AND ID_Statut!=2 ORDER BY ID_Statut");
    }else{
      $statut=$pdo->query("SELECT * FROM statut_user WHERE ID_Statut!=1 ORDER BY ID_Statut");
    }
    $module=$pdo->query("SELECT * FROM module ORDER BY Design_Module");
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Ajouter utilisateur | <?php echo $app_infos['Design_App']; ?></title>
    <!-- CSS files -->
    <!-- DataTables CSS -->
    <link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    <!-- <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link href="notifica/css/alertify.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="vendor/jquery/jquery-ui.min.css" />
    <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <link href="./dist/css/demo.min.css" rel="stylesheet"/>
    <link href="images/icon.png" rel="icon">
    <link href="images/icon.png" rel="apple-touch-icon">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <style>
      .mylink:hover{
          font-weight: bold;
          text-decoration: none;
      }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" style="overflow-x: hidden;">
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
                  Modification utilisateur
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
                  <a href="#" id="retour_table" class="btn btn-primary d-sm-inline-block" title="Retour">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-reply" viewBox="0 0 16 16">
                      <path d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z"/>
                    </svg>
                    Retour
                  </a>
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
            <div class="row row-cards">
              <div class="col-md-12">
                <div class="card">
                  <ul class="nav nav-tabs l0" data-bs-toggle="tabs">
                    <li class="nav-item">
                      <a href="#tabs-home-12" id="a0" class="nav-link active" data-bs-toggle="tab">Informations</a>
                    </li>
                    <!-- <li class="nav-item l1 disabled">
                      <a href="#" class="nav-link " id="a1" data-bs-toggle="tab">Picture</a>
                    </li> -->
<!--                     <li class="nav-item ms-auto">
                      <a href="#tabs-settings-7" class="nav-link" title="Settings" data-bs-toggle="tab">Download SVG icon from http://tabler-icons.io/i/settings
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><circle cx="12" cy="12" r="3" /></svg>
                      </a>
                    </li> -->
                  </ul>
                  <div class="card-body">
                    <form id="UtilisateurForm" method="post" action="" enctype="multipart/form-data">
                    <div class="tab-content">
                      <div class="tab-pane active show" id="tabs-home-12">
                                    <div class="row" style="margin-bottom: 10px; border-bottom: 1px solid #EEEEEE">
                                    <div class="col-md-10" style="margin-bottom: 10px">
                                    <div class="row">
                                      <div class="col-md-4" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">Prenom *</label>
                                          <div class="col-lg-12">
                                            <input id="id_user" type="hidden" name="id_user" value="<?php echo($ID); ?>">
                                            <input id="token" type="hidden" name="token" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                                            <input class="form-control " id="prenom" type="text" name="prenom" value="<?php echo(stripslashes($Utilisateurs['Prenom'])); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">Nom *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control " id="nom" type="text" name="nom" value="<?php echo(stripslashes($Utilisateurs['Nom'])); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="profil" class="control-label col-lg-12" style="text-align: left;">Profile *</label>
                                          <div class="col-lg-12">
                                            <select name="profil" id="profil" class="form-control ">
                                              <option value="">--</option>
                                              <?php while($profils=$profil->fetch()){ ?>
                                              <option value="<?php echo($profils['ID_Profil'])?>" <?php if($profils['ID_Profil']==$Utilisateurs['ID_Profil']){echo "selected"; }?>><?php echo strtoupper($profils['Design_Profil']); ?></option>
                                              <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">Téléphone</label>
                                          <div class="col-lg-12">
                                              <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text" id="afficher_code" style="border-top-right-radius: 0; border-bottom-right-radius: 0; border-right: none; height: 38px">243</span>
                                                </div>
                                                <input class="form-control " id="tel" type="text" name="tel" value="<?php echo($Utilisateurs['Tel']); ?>">
                                              </div> 
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">E-mail </label>
                                          <div class="col-lg-12">
                                            <input class="form-control " id="mail" type="text" name="mail" value="<?php echo($Utilisateurs['Email']); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">Statut *</label>
                                          <div class="col-lg-12">
                                            <select name="statut" id="statut" class="form-control ">
                                              <option value="">--</option>
                                              <?php while($statuts=$statut->fetch()){ ?>
                                              <option value="<?php echo($statuts['ID_Statut'])?>" <?php if($statuts['ID_Statut']==$Utilisateurs['ID_Statut']){echo "selected"; }?>><?php echo(strtoupper($statuts['Design_Statut'])); ?></option>
                                              <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">Login *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control " id="login" type="text" name="login" value="<?php echo($Utilisateurs['Login']); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">Mot de passe *</label>
                                          <div class="col-lg-12">
                                                        <div class="input-group">
                                                            <div class="input-group-btn">
                                                              <a href="#" class="btn btn-default" title="Afficher" id="afficher_modep" style="border-top-right-radius: 0; height: 38px; border-bottom-right-radius: 0; border: 1px solid #D9DBDE"><i class="fa fa-eye" id="micon"></i></a>
                                                            </div>
                                                            <input class="form-control " id="password" type="password" name="password" style="height: 38px">
                                                            <div class="input-group-btn">
                                                              <button type="button" class="btn btn-primary" id="generer_modep" style="height: 38px; border-top-left-radius: 0; border-bottom-left-radius: 0">Générer</button>
                                                            </div>
                                                        </div> 
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 10px;">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;"> </label>
                                          <div class="col-lg-12" style="border: 1px solid #D9DBDE; border-radius: 4px; height: 38px">
                                          </div>
                                        </div>
                                      </div>
                                      </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 10px">
                                    <div class="form-group ">
                                      <label for="curl" class="control-label col-lg-12" style="text-align: left;">Picture</label>
                                      <div class="col-lg-12">
                                        <input class="form-control " id="mimg" type="file" name="mimg" style="display: none;" accept=".jpg, .jpeg, .png">
                                        <a href="#" id="mapercu" title="Choisir l'image">
                                        <img src="<?php if($Utilisateurs['Photo']==''){if($Utilisateurs['ID_Profil']==1){echo('images/photo_femme.jpg');}else{echo('images/photo.jpg');}}else{ echo('images/profil/'.$Utilisateurs['Photo']);} ?>" style="width: 150px; height: 150px; border: 2px solid RGB(234,234,234); border-radius: 0" id="miamge" class="miamge">
                                        </a>
                                      </div>
                                    </div>
                                    </div>
                                    </div>

                                    <div class="row" style="margin-bottom: 10px; border-bottom: 1px solid #EEEEEE; <?php if($Utilisateurs['ID_Statut']==1){ echo 'display: none';} ?>" id="privileges">
                                    <div class="col-md-10" style="margin-bottom: 10px">
                                    <div class="row">
                                      <div class="col-md-4" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">Ecole *</label>
                                          <div class="col-lg-12">
                                            <select name="ecole" id="ecole" class="form-control " <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ echo 'disabled';} ?>>
                                              <option value="">--</option>
                                              <?php while($ecoles=$ecole->fetch()){ ?>
                                              <option value="<?php echo($ecoles['ID_Etablissement'])?>" <?php if($ecoles['ID_Etablissement']==$Utilisateurs['ID_Etablissement']){echo "selected"; }?>><?php echo strtoupper($ecoles['Design_Etablissement']); ?></option>
                                              <?php } ?>
                                            </select>
                                            <input id="ID_Etablissement" type="hidden" name="ID_Etablissement" value="<?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ echo $_SESSION['user_eteelo_app']['ID_Etablissement'];} ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">Module *</label>
                                          <div class="col-lg-12">
                                                        <div class="input-group">
                                                        <select name="module" id="module" class="form-control ">
                                                        <option value="">--</option>
                                                        <?php while($modules=$module->fetch()){ ?>
                                                        <option value="<?php echo($modules['Id_Module'])?>"><?php echo strtoupper($modules['Design_Module']); ?></option>
                                                        <?php } ?>
                                                        </select>
                                                            <div class="input-group-btn">
                                                              <button type="button" class="btn btn-primary" id="ajouter_module" style="height: 38px; border-top-left-radius: 0; border-bottom-left-radius: 0"><i class="fa fa-arrow-right"></i></button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="modules" id="modules">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 10px;">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;"> </label>
                                          <div class="col-lg-12" style="border: 1px solid #D9DBDE; border-radius: 4px; height: 38px; font-size: 11px; padding-left: 5px; padding-right: 5px" id="mydiv">
                                          </div>
                                        </div>
                                      </div>
                                      </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 10px">

                                    </div>
                                    </div>


                                    <div class="row" style="margin-top: 10px; padding-bottom: 10px">
                                            <div class="col-lg-12">
                                              <div class="pull-right">
                                                  <button class="btn btn-primary" type="submit" id="btn_enregistrer">Enregistrer</button>
                                                  <button class="btn btn-danger" type="button" id="btn_annuler_tout">Annuler</button>
                                              </div>
                                            </div>
                                        </div>
                                <!-- </div> -->
                      </div>
                    </div>
                  </form>
                  </div>
                </div>
              </div>
            </div>
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
    <script src="vendor/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="notifica/alertify.min.js"></script>
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js" defer></script>
    <script src="./dist/js/demo.min.js" defer></script>
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

    <script>
    var waitingDialog = waitingDialog || (function ($) {
    'use strict';

    // Creating modal dialog's DOM
    var $dialog = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
        '<div class="modal-dialog modal-m">' +
        '<div class="modal-content">' +
            '<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
            '<div class="modal-body">' +
                '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%; background: #0189BD"></div></div>' +
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
    let modules = [];
    $(document).ready(function(){
        $.ajax({
            url:'charger_module.php',
            type:'post',
            dataType:'text',
            data:{ID:$('#id_user').val()},
            success:function(retour){
              // modules = JSON.parse(retour);
              for(var i in retour) {
                  if(!isNaN(parseFloat(retour[i]))){
                      console.log('Valeur: ' + i);
                      modules.push(retour[i]);
                  }
              }
              // $.map(retour,function(i){
              //   modules.push(i);
              // });
              // alertify.alert('<?php echo $app_infos['Design_App']; ?>','Tableau: ' + modules);
              //   modules = [retour.replace(/[[\]]/g,'')];
                $.ajax({
                      url:'ajout_module.php',
                      type:'post',
                      dataType:'text',
                      data:{Modules:modules},
                      success:function(ret){
                          $('#mydiv').html(ret);
                          $('#modules').val(modules);
                          $('#module').val('');
                      }
              });
            }
        });
    })

    $('#module').change(function(){
        if($('#module').val()!=''){
            $('#ajouter_module').focus();
        }
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
                    $('#miamge').attr('src', 'images/loading.gif');
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
            $('#micon').attr('class', 'fa fa-eye'); 
        }
    })

    $('#ecole').change(function() {
        if($('#ecole').val()=='') {
          alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez selectionner une école svp!', function(){$('#ecole').focus();});
        }else{
          $('#module').val('').focus();
          $('#ID_Etablissement').val($('#ecole').val());
        }
    })

    $('#ajouter_module').click(function(){
        if($('#module').val()==''){
            alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez selectionner un module svp!', function(){$('#module').focus();});
        }else{
          if (!modules.includes($('#module').val())) {
              modules.push($('#module').val());
              $.ajax({
                      url:'ajout_module.php',
                      type:'post',
                      dataType:'text',
                      data:{Modules:modules},
                      success:function(ret){
                          $('#mydiv').html(ret);
                          $('#modules').val(modules);
                          $('#module').val('').focus();
                      }
              });
          }else{
            alertify.alert('<?php echo $app_infos['Design_App']; ?>','Ce module existe déjà !', function(){$('#module').val('').focus();});
          }
        }
    });

    function delete_module(mod){
            let newModules = []
            modules.forEach(m => {
                if(m != mod){
                    newModules.push(m)
                    return
                }
            })
            modules = newModules
            // alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Modules :' + modules.length);
            $.ajax({
                      url:'ajout_module.php',
                      type:'post',
                      dataType:'text',
                      data:{Modules:modules},
                      success:function(ret){
                          $('#mydiv').html(ret);
                          $('#modules').val(modules);
                          $('#module').val('');
                      }
              });
    }

          $('#profil').change(function(){
            $('#tel').focus();
            if($('#mimg').val()==''){
              if($('#profil').val()==1){
                  $('#miamge').attr('src', 'images/photo_femme.jpg');
              }else{
                  $('#miamge').attr('src', 'images/photo.jpg');
              }
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
                    alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Please enter a valid email address!", function(){
                      $('#mail').css('border-color', 'RGB(215,76,71)');
                      $('#mail').val($('#mail').val());
                      $('#btn_next').attr('disabled', true);
                      $('#mail').focus();
                    });
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
                        $('#password').val('1234');
                    }
                });
          })
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

        $('#UtilisateurForm').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);

            if($('#prenom').val()=='' || $('#profil').val()=='' || $('#login').val()=='' || $('#nom').val()=='' || $('#statut').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!', function(){$('#prenom').focus();});
            }else if($('#statut').val()!=1 && (modules.length==0 || $('#ecole').val()=='')){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez choisir l\'école et les modules svp!', function(){$('#ecole').focus();});
            }else{
                $.ajax({
                    url:'edit_utilisateur.php',
                    type:'post',
                    beforeSend:function(){
                        waitingDialog.show('Please wait!');
                    },
                    dataType:'text',
                    data: formData,
                    processData: false,
                    cache: false,
                    contentType: false,
                    success:function(ret){
                         waitingDialog.hide();
                         if(ret==2){
                             alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Image extension does not match an image!");
                         }else if(ret==3){
                             alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Image upload failed!");
                         }else if(ret==1){
                             Toast.fire({
                                icon: 'success',
                                title: 'Enregistré'
                             })
                             window.location.replace('table_utilisateur.php');
                         }else{
                            alertify.alert(ret);
                         }

                    }
                });
            }
          })
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
          $('#statut').change(function(){
                if($('#statut').val()!=''){
                      if($('#statut').val()==1){
                          $('#privileges').slideUp('slow');
                      }else{
                        $('#privileges').slideDown('slow');
                      }
                      $('#login').focus();
                }
          })             
    $('#btn_annuler').click(function(){
        window.location.replace('table_utilisateur.php');
    })
    $('#retour_table').click(function(e){
        e.preventDefault();
        window.location.replace('table_utilisateur.php');
    })
    $('#btn_annuler_tout').click(function(){
      window.location.replace('table_utilisateur.php');
    })
    </script>
</body>