<?php
session_start();
$_SESSION['last_activity'] = time();
if (empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app'] == false) {
    header("location: connection");
}
require_once ('connexion.php');
$ID = Securite::bdd($_GET['ID']);
$province = $pdo->query("SELECT * FROM province WHERE ID_Prov=".$ID);
$provinces = $province->fetch();
$pay = $pdo->query("SELECT * FROM pays ORDER BY Design_Pays");
$app_info = $pdo->query("SELECT * FROM app_infos");
$app_infos = $app_info->fetch();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Saisie d'une province | <?php echo $app_infos['Design_App']; ?></title>
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
      .btn-default:hover{
         border: 1px solid #D9DBDE;
      }
      .btn-default:focus{
         border: 1px solid #D9DBDE;
      }
      .alertify .ajs-dialog {
        top: 15%;
        transform: translateY(-50%);
        margin: auto;
    }
    .ui-autocomplete{
        background-color:#CCC ! important;
        z-index: 10000;
        width: 200px
      }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" style="overflow-x: hidden;">
    <div class="page">
      <div class="page-wrapper">
        <div class="container-xl">
          <!-- Page title -->
          <input type="hidden" name="Pays" id="Pays" value="<?php if (isset($_GET['Pays']) && $_GET['Pays'] != '') {
              echo $_GET['Pays'];
          } ?>">
          <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  
                </div>
              </div>
              <!-- Page title actions -->
              <div class="col-12 col-md-auto ms-auto d-print-none">
                <div class="btn-list">
<!--                   <span class="d-none d-sm-inline">
                    <a href="#" class="btn btn-white">
                      New view
                    </a>
                  </span> -->
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
                  <ul class="nav nav-tabs l0" data-bs-toggle="tabs" style="display: none">
                    <li class="nav-item">
                      <a href="#tabs-home-12" id="a0" class="nav-link active" data-bs-toggle="tab"></a>
                    </li>
                    <!-- <li class="nav-item ms-auto">
                      <a href="#tabs-settings-7" class="nav-link" title="Settings" data-bs-toggle="tab">Download SVG icon from http://tabler-icons.io/i/settings
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><circle cx="12" cy="12" r="3" /></svg>
                      </a>
                    </li> -->
                  </ul>
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="tab-pane active show" id="tabs-home-12">
                      <form id="RapportForm" method="post" action="" enctype="multipart/form-data">
                          <div class="row" style="margin-bottom: 5px; border-bottom: 1px solid #EEEEEE;">
                                <div class="col-md-12" style="margin-bottom: 5px">
                                    <div class="row">
                                      <div class="col-md-6" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="list_pays" class="control-label col-lg-12" style="text-align: left;">Pays *</label>
                                          <div class="col-lg-12">

                                            <div class="input-group">
                                                            <!-- <div class="input-group-btn">
                                                              <a href="#" class="btn btn-default" title="Afficher" id="afficher_modep" style="border-top-right-radius: 0; height: 38px; border-bottom-right-radius: 0; border: 1px solid #D9DBDE"><i class="fa fa-eye" id="micon"></i></a>
                                                            </div> -->
                                                <input id="token" type="hidden" name="token" value="<?php echo ($_SESSION['user_eteelo_app']['token']); ?>">
                                                <input id="ID_Prov" type="hidden" name="ID_Prov" value="<?php echo ($ID); ?>">
                                                <select name="list_pays" id="list_pays" class="form-control " <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'disabled'; } ?>>
                                                <option value="" id="add_pays">--</option>
                                                <?php while ($pays = $pay->fetch()) { ?>
                                                            <option value="<?php echo ($pays['ID_Pays']); ?>" <?php if($provinces['ID_Pays']==$pays['ID_Pays']){echo 'selected'; } ?>><?php echo ($pays['Design_Pays']); ?></option>
                                                    <?php } ?>
                                                </select>
                                                <div class="input-group-btn" style="<?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'display: none'; } ?>">
                                                    <a href="#" title="Ajouter un pays" class="btn btn-primary" id="ajouter_pays" style="height: 38px; border-top-left-radius: 0; border-bottom-left-radius: 0"><i class="fa fa-plus"></i></a>
                                                </div>
                                            </div> 
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                            <label for="design" class="control-label col-lg-12" style="text-align: left;">Désignation *</label>
                                            <input type="text" name="design" id="design" class="form-control" value="<?= stripslashes($provinces['Design_Prov']) ?>">
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                          </div>
                                    <div class="row" style="margin-top: 10px; padding-bottom: 10px">
                                            <div class="col-lg-12">
                                              <div class="pull-right">
                                                  <button class="btn btn-primary" type="button" id="btn_enregistrer">Enregistrer</button>
                                                  <button class="btn btn-danger" type="button" id="btn_annuler">Annuler</button>
                                              </div>
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
        </div>
      </div>
    </div>
    <div id="ModalPays" class="modal fade" data-backdrop="static" style="margin-top: 100px">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter un pays</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group ">
                                <label for="design_pays" class="control-label col-lg-12" style="text-align: left;">Désignation *</label>
                                <input type="text" name="design_pays" id="design_pays" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group ">
                                <label for="code_pays" class="control-label col-lg-12" style="text-align: left;">Code pays (Ex:243) *</label>
                                <input type="text" name="code_pays" id="code_pays" class="form-control">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="enreg_pays">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialoguePays()">Annuler</button>
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

    function fermerDialoguePays(){
        $("#ModalPays").modal('hide');
    }
    $('#ajouter_pays').click(function(e){
      e.preventDefault();
      $("#ModalPays").modal('show');
      $('#design_pays').val('');
      $('#code_pays').val('');
      $('#design_pays').focus();
    })


    $(document).ready(function(){
        
    })
    $('#enreg_pays').click(function(){
        if($('#design_pays').val()=='' ||  $('#code_pays').val()==''){
          alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!', function(){$('#design_pays').focus();});
        }else{
                $.ajax({
                    url:'enreg_pays.php',
                    type:'post',
                    dataType:'text', 
                    data:{Design:$('#design_pays').val(), Code:$('#code_pays').val(), token:$('#token').val()},
                    success:function(ret){
                        if(ret==2){
                            alertify.alert('<?php echo $app_infos['Design_App']; ?>','Ce pays existe déjà !', function(){$('#design_pays').focus();});
                        }else{
                            $('#add_pays').nextAll().remove();
                            $('#add_pays').after(ret);
                            $("#ModalPays").modal('hide');
                            $('#design').val('').focus();
                        }
                    }
                });
                // $('.l1').removeClass('disabled').addClass('Active');
                // $('#a1').tab('show');
        }
    })

    $('#list_pays').change(function(){
        if($('#list_pays').val()!=''){
            $('#design').val('').focus();
        }
    })

    $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

        $('#btn_enregistrer').click(function(){
            if($('#list_pays').val()=='' ||  $('#design').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!', function(){$('#design').focus();});
            }else{
                $.ajax({
                    url:'edit_province.php',
                    type:'post',
                    beforeSend:function(){
                        waitingDialog.show('Veuillez patienter svp!');
                    },
                    dataType:'text', 
                    data:{Pays:$('#list_pays').val(), Design:$('#design').val(), ID:$('#ID_Prov').val(), token:$('#token').val()},
                    success:function(ret){
                        if(ret==1){
                            Toast.fire({
                                  icon: 'success',
                                  title: 'Enregistré'
                            })
                            window.location.replace('table_province.php?Pays='+$('#Pays').val());
                        }else if(ret==2){
                            alertify.alert('<?php echo $app_infos['Design_App']; ?>','Cette ville existe déjà !', function(){$('#design').focus();});
                        }
                    }
                });
            }
        })
  })

    $('#btn_annuler').click(function(){
        window.location.replace('table_province.php?Pays='+$('#Pays').val());
    });

    </script>
</body>