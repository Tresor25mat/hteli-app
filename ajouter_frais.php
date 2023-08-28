<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connection");
    }
    require_once('connexion.php');
    $ecole=$pdo->query("SELECT * FROM etablissement ORDER BY Design_Etablissement");
    $liste_ecole=$pdo->query("SELECT * FROM etablissement ORDER BY Design_Etablissement");
    $niveau=$pdo->query("SELECT * FROM niveau ORDER BY ID_Niveau");
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Ajouter frais | <?php echo $app_infos['Design_App']; ?></title>
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
          <input type="hidden" name="ID_Etab" id="ID_Etab" value="<?php if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){echo $_GET['Ecole']; } ?>">
          <input type="hidden" name="Liste_Opt" id="Liste_Opt" value="<?php if(isset($_GET['Option']) && $_GET['Option']!=''){echo $_GET['Option']; } ?>">
          <input type="hidden" name="Liste_Niv" id="Liste_Niv" value="<?php if(isset($_GET['Niveau']) && $_GET['Niveau']!=''){echo $_GET['Niveau']; } ?>">
          <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  
                </div>
                <h2 class="page-title">
                Ajouter frais
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
                  <!-- <ul class="nav nav-tabs l0" data-bs-toggle="tabs">
                    <li class="nav-item">
                      <a href="#tabs-home-12" id="a0" class="nav-link active" data-bs-toggle="tab">Informations</a>
                    </li>
                    <li class="nav-item l1 disabled">
                      <a href="#" class="nav-link " id="a1" data-bs-toggle="tab">Picture</a>
                    </li>
                    <li class="nav-item ms-auto">
                      <a href="#tabs-settings-7" class="nav-link" title="Settings" data-bs-toggle="tab">Download SVG icon from http://tabler-icons.io/i/settings
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><circle cx="12" cy="12" r="3" /></svg>
                      </a>
                    </li>
                  </ul> -->
                  <div class="card-body">
                    <form id="CompteForm" method="post" action="" enctype="multipart/form-data">
                    <div class="tab-content">
                      <div class="tab-pane active show" id="tabs-home-12">
                                    <div class="row" style="margin-bottom: 10px; border-bottom: 1px solid #EEEEEE">
                                      <div class="col-md-4" style="margin-bottom: 10px; <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'display: none';} ?>">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">Ecole *</label>
                                          <div class="col-lg-12">
                                          <input id="token" type="hidden" name="token" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                                          <input id="ID_Etablissement" type="hidden" name="ID_Etablissement" value="<?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ echo $_SESSION['user_eteelo_app']['ID_Etablissement'];} ?>">
                                          <select name="ecole" class="form-control" id="ecole" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ echo 'disabled';} ?>>
                                                <option value="">--</option>
                                                <?php while($ecoles=$ecole->fetch()){ ?>
                                                <option value="<?php echo($ecoles['ID_Etablissement']) ?>" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1 && $ecoles['ID_Etablissement']==$_SESSION['user_eteelo_app']['ID_Etablissement']){ echo 'selected';} ?>><?php echo(stripslashes($ecoles['Design_Etablissement'])) ?></option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">Désignation *</label>
                                          <div class="col-lg-12">
                                            <div class="input-group">
                                                    <select name="type_frais" class="form-control" id="type_frais">
                                                        <option value="" id="addtype_frais">--</option>
                                                    </select>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-primary" id="ajouter_type_frais" style="height: 38px; border-top-left-radius: 0; border-bottom-left-radius: 0"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div> 
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">Option *</label>
                                          <div class="col-lg-12">
                                                <select name="option" class="form-control" id="option">
                                                    <option value="" id="add_option">--</option>
                                                </select>
                                            </div> 
                                          </div>
                                        </div>
                                      </div>
                                    <div class="row" style="border-bottom: 1px solid #EEEEEE">
                                      <div class="col-md-4" style="margin-bottom: 10px;">
                                        <div class="form-group ">
                                        <input type="checkbox" name="btn_check_all_categories" style="border-radius: 0; width:17px; height:17px;" id="btn_check_all_categories" checked>
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">Toutes les classes (*)</label>
                                          <div class="col-lg-12">
                                          <select name="niveau" class="form-control" id="niveau">
                                                <option value="">--</option>
                                                <?php while($niv=$niveau->fetch()){ ?>
                                                <option value="<?php echo($niv['ID_Niveau']) ?>"><?php echo(stripslashes($niv['Design_Niveau'])) ?></option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <input type="checkbox" name="btn_check_all_categories" style="border-radius: 0; width:17px; height:17px;" id="btn_check_all_categories" checked>
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">Toutes les catégories (*)</label>
                                          <div class="col-lg-12">
                                                <select name="categorie" class="form-control" id="categorie">
                                                    <option value="" id="add_categorie">--</option>
                                                </select>
                                            </div> 
                                          </div>
                                        </div>
                                      <div class="col-md-2" style="margin-bottom: 10px; padding-top: 21px">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">Devise *</label>
                                          <div class="col-lg-12">
                                                <select name="devise" class="form-control" id="devise">
                                                    <option value="" id="add_devise">--</option>
                                                </select>
                                            </div> 
                                          </div>
                                        </div>
                                        <div class="col-md-2" style="margin-bottom: 10px; padding-top: 21px">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">Montant *</label>
                                          <div class="col-lg-12">
                                                <input type="number" class="form-control" step="any" name="montant" id="montant">
                                            </div> 
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row" style="marging-bottom: 20px">
                                        <div class="form-group col-4" style="padding-top: 15px">
                                          <div class="form-group ">
                                              <div class="col-4">
                                                  <input type="checkbox" name="btn_check_tranches" style="border-radius: 0; width:17px; height:17px; " id="btn_check_tranches">
                                              </div>
                                              <label for="curl" class="control-label" style="text-align: left; margin-top: 3px;">Répartition en tranches</label>
                                          </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row" style="margin-top: 10px; padding-bottom: 10px">
                                            <div class="col-lg-12">
                                              <div class="pull-right">
                                                  <button class="btn btn-primary" type="submit" id="btn_enregistrer">Enregistrer</button>
                                                  <button class="btn btn-danger" type="button" id="btn_annuler">Annuler</button>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="form-panel" style="border-top: solid 1px RGB(231,231,231);">
                                            <iframe src="" style="width: 100%; height: 1000px;border: none; margin-top: 20px" id="iframe"></iframe>  
                                        <!-- /form-panel -->
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
    <div id="ModalCategorie" class="modal fade" data-backdrop="static" style="margin-top: 100px">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueCategorie()">&times;</button> -->
                    <h4 class="modal-title">Ajouter catégorie</h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">Code *</div>
                    <div class="col-lg-12"><input type="number" name="code_categorie" id="code_categorie" class="form-control" style="margin-top: 1%;" min="0" step="1" maxlength="2"></div>
                    <div class="col-lg-12">Désignation *</div>
                    <div class="col-lg-12"><input type="text" name="design_categorie" id="design_categorie" class="form-control" style="margin-top: 1%;"></div>
                </div>
            <div class="modal-footer">
                <button  class="btn btn-primary" id="btn_enreg_categorie">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialogueCategorie()">Annuler</button>
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
    $(document).ready(function(){

    })

    $('#ecole').change(function(){
        if($('#ecole').val()!=''){
            $.ajax({
                url:'recherche_type_frais.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#addtype_frais').nextAll().remove();
                    $('#addtype_frais').after(ret);
                    $('#type_frais').focus();
                }
            });
            $.ajax({
                url:'recherche_option.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_option').nextAll().remove();
                    $('#add_option').after(ret);
                }
            });
            $.ajax({
                url:'recherche_cat_eleve.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_categorie').nextAll().remove();
                    $('#add_categorie').after(ret);
                }
            });
            $.ajax({
                url:'recherche_devises.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_devise').nextAll().remove();
                    $('#add_devise').after(ret);
                }
            });
            $('#ID_Etablissement').val($('#ecole').val());
        }
    })
    function fermerDialogueCategorie(){
            $("#ModalCategorie").modal('hide');
        };
    $('#ajouter_categorie').click(function(e){
      e.preventDefault();
      if($('#ecole').val()!=''){
          $("#ModalCategorie").modal('show');
          $('#code_categorie').val('');
          $('#design_categorie').val('');
          $('#code_categorie').focus();
      }else{
        alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Veuillez choisir une école svp!");
      }
    })
    $('#btn_enreg_categorie').click(function(){
        if($('#code_categorie').val()=='' || $('#design_categorie').val()==''){
            alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Veuillez saisir le code et la désignation svp!");
        }else{
                $.ajax({
                    url:'enreg_cat_compte.php',
                    type:'post',
                    dataType:'text', 
                    data:{Code:$('#code_categorie').val(), Design:$('#design_categorie').val(), Ecole:$('#ID_Etablissement').val(), token:$('#token').val()},
                    success:function(ret){
                        // alertify.alert('<?php echo $app_infos['Design_App']; ?>', ret);
                        if(ret==2){
                            alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Ce code existe déjà!");
                        }else{
                            alertify.success("L'opération a réussi");
                            $('#add_categorie').nextAll().remove();
                            $('#add_categorie').after(ret);
                            $('#afficher_code').text($('#code_categorie').val());
                            $("#ModalCategorie").modal('hide');
                            $('#numero_compte').val('');
                            $('#numero_compte').focus()
                        }
                    }
                });
        }
    })
        $('#CompteForm').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            // formData.append('content', CKEDITOR.instances['descript'].getData());
          if($('#design').val()=='' || $('#numero_compte').val()=='' || $('#categorie').val()=='' || $('#nature').val()=='' || $('#ecole').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Veuillez remplir tous les champs obligatoires svp!",function(){
                  $('#categorie').focus();
                })
          }else{
            $.ajax({
                    url:'enreg_compte.php',
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
                          if(ret==1){
                             alertify.success('Enregistrement éffectué');
                             $('#iframe').attr('src','select_compte_today.php?Ecole='+$('#ID_Etab').val());
                             $('#btn_annuler').click();
                         }else if(ret==2){
                            alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Le numéro entré existe déjà!');
                         }else{
                            alertify.alert('<?php echo $app_infos['Design_App']; ?>', ret);
                         }

                    }
                });
          }
          })
    $('#categorie').change(function(){
        if($('#categorie').val()!=''){
            $.ajax({
                url:'select_categorie.php',
                type:'post',
                dataType:'text', 
                data:{categorie:$('#categorie').val()},
                success:function(ret){
                    $('#afficher_code').text(ret);
                    $('#numero_compte').val('');
                    $('#numero_compte').focus()
                }
            });
        }
    })  
    $('#btn_annuler').click(function(){
        $('#numero_compte').val('');
        $('#design').val('');
        $('#categorie').val('');
        $('#nature').val('');
        $('#afficher_code').text('');
        $('#categorie').focus();
    })
    $('#retour_table').click(function(e){
        e.preventDefault();
        window.location.replace('afficher_table_frais.php?Ecole='+$('#ID_Etab').val()+'&Option='+$('#Liste_Opt').val()+'&Niveau='+$('#Liste_Niv').val());
    })
    </script>
</body>