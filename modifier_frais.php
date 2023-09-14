<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connection");
    }
    require_once('connexion.php');
    $ID=$_GET['ID'];
    $frai=$pdo->query("SELECT * FROM frais INNER JOIN classe_frais ON frais.ID_Frais=classe_frais.ID_Frais inner join table_option on classe_frais.ID_Option=table_option.ID_Option inner join niveau on classe_frais.ID_Niveau=niveau.ID_Niveau inner join taux_change on frais.ID_Taux=taux_change.ID_Taux inner join type_frais on frais.ID_Type_Frais=type_frais.ID_Type_Frais inner join annee on frais.ID_Annee=annee.ID_Annee inner join section on table_option.ID_Section=section.ID_Section inner join categorie_eleve on classe_frais.ID_Cat_Eleve=categorie_eleve.ID_Categorie where classe_frais.ID_Classe_Frais=".$ID);
    $frais=$frai->fetch();
    $repartition=$pdo->query("SELECT COUNT(*) AS NOMBRE FROM tranche_frais WHERE ID_Frais=".$frais['ID_Frais']);
    $repartitions=$repartition->fetch();
    $ecole=$pdo->query("SELECT * FROM etablissement ORDER BY Design_Etablissement");
    $liste_ecole=$pdo->query("SELECT * FROM etablissement ORDER BY Design_Etablissement");
    if($_SESSION['user_eteelo_app']['ID_Statut']!=1){
        $compte_debit=$pdo->query("SELECT * FROM compte INNER JOIN categorie_compte ON compte.ID_Categorie=categorie_compte.ID_Categorie WHERE compte.ID_Nature=8 AND compte.ID_Etablissement=".$_SESSION['user_eteelo_app']['ID_Etablissement']);
        $compte_credit=$pdo->query("SELECT * FROM compte INNER JOIN categorie_compte ON compte.ID_Categorie=categorie_compte.ID_Categorie WHERE compte.ID_Etablissement=".$_SESSION['user_eteelo_app']['ID_Etablissement']." AND (compte.ID_Nature=2 OR compte.ID_Nature=3)");
    }
    $niveau=$pdo->query("SELECT * FROM niveau ORDER BY ID_Niveau");
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Modifier frais | <?php echo $app_infos['Design_App']; ?></title>
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

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" style="overflow: hidden;">
    <div class="page">
      <div class="page-wrapper">
        <div class="container-xl">
          <!-- Page title -->
          <input type="hidden" name="ID_Etab" id="ID_Etab" value="<?php if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){echo $_GET['Ecole']; } ?>">
          <input type="hidden" name="Liste_Opt" id="Liste_Opt" value="<?php if(isset($_GET['Option']) && $_GET['Option']!=''){echo $_GET['Option']; } ?>">
          <input type="hidden" name="Liste_Niv" id="Liste_Niv" value="<?php if(isset($_GET['Niveau']) && $_GET['Niveau']!=''){echo $_GET['Niveau']; } ?>">
          <div class="page-header d-print-none">
            <div class="row g-2 align-items-center" style="margin-top: -40px">
              <div class="col">
                <!-- Page pre-title -->
                <!-- <div class="page-pretitle">
                  
                </div> -->
                <h2 class="page-title">
                Modifier frais
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
<!--                   <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                    Download SVG icon from http://tabler-icons.io/i/plus
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                  </a> -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body" style="margin-top: -5px">
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
                    <form id="FormFrais" method="post" action="" enctype="multipart/form-data">
                    <div class="tab-content">
                      <div class="tab-pane active show" id="tabs-home-12">
                                    <div class="row" style="margin-bottom: 10px; border-bottom: 1px solid #EEEEEE">
                                      <div class="col-md-2" style="margin-bottom: 10px; <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'display: none';} ?>">
                                        <div class="form-group ">
                                          <label for="ecole" class="control-label col-lg-12" style="text-align: left;">Ecole *</label>
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
                                      <div class="col-md-3" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="type_frais" class="control-label col-lg-12" style="text-align: left;">Désignation *</label>
                                          <div class="col-lg-12">
                                            <div class="input-group">
                                                    <input type="hidden" name="ID_Frais" id="ID_Frais" value="<?php echo $frais['ID_Frais'] ?>">
                                                    <input type="hidden" name="ID_Classe_Frais" id="ID_Classe_Frais" value="<?php echo $frais['ID_Classe_Frais'] ?>">
                                                    <input type="hidden" name="ID_Type" id="ID_Type" value="<?php echo $frais['ID_Type_Frais'] ?>">
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
                                      <div class="col-md-3" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="option" class="control-label col-lg-12" style="text-align: left;">Option *</label>
                                          <div class="col-lg-12">
                                                <input type="hidden" name="ID_Option" id="ID_Option" value="<?php echo $frais['ID_Option'] ?>">
                                                <select name="option" class="form-control" id="option">
                                                    <option value="" id="add_option">--</option>
                                                </select>
                                            </div> 
                                          </div>
                                        </div>
                                      <!-- </div>
                                    <div class="row" style="border-bottom: 1px solid #EEEEEE"> -->
                                      <div class="col-md-2" style="margin-bottom: 10px;">
                                        <div class="form-group ">
                                          <label for="niveau" class="control-label col-lg-12" style="text-align: left;">Classe *</label>
                                          <div class="col-lg-12">
                                          <select name="niveau" class="form-control" id="niveau">
                                                <option value="">--</option>
                                                <?php while($niv=$niveau->fetch()){ ?>
                                                <option value="<?php echo($niv['ID_Niveau']) ?>" <?php if($niv['ID_Niveau']==$frais['ID_Niveau']){echo 'selected';} ?>><?php echo(stripslashes($niv['Design_Niveau'])) ?></option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="categorie" class="control-label col-lg-12" style="text-align: left;">Catégorie *</label>
                                          <div class="col-lg-12">
                                                <input type="hidden" name="ID_Cat" id="ID_Cat" value="<?php echo $frais['ID_Cat_Eleve'] ?>">
                                                <select name="categorie" class="form-control" id="categorie">
                                                    <option value="" id="add_categorie">--</option>
                                                </select>
                                            </div> 
                                          </div>
                                        </div>
                                      <div class="col-md-1" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="devise" class="control-label col-lg-12" style="text-align: left;">Devise *</label>
                                          <div class="col-lg-12">
                                                <input type="hidden" name="ID_Taux" id="ID_Taux" value="<?php echo $frais['ID_Taux'] ?>">
                                                <select name="devise" class="form-control" id="devise">
                                                    <option value="" id="add_devise">--</option>
                                                </select>
                                            </div> 
                                          </div>
                                        </div>
                                        <div class="col-md-1" style="margin-bottom: 10px;">
                                        <div class="form-group ">
                                          <label for="montant" class="control-label col-lg-12" style="text-align: left;">Montant *</label>
                                          <div class="col-lg-12">
                                                <input type="number" class="form-control" step="any" name="montant" id="montant" value="<?php echo(number_format($frais['Montant_Frais'], 2, '.', '')); ?>">
                                            </div> 
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row" style="marging-bottom: 20px; border-bottom: 1px solid #EEEEEE">
                                        <div class="form-group col-3" style="padding-top: 5px">
                                            <div class="col-3">
                                                <input type="checkbox" name="btn_check_tranches" style="border-radius: 0; width:17px; height:17px; " id="btn_check_tranches" <?php if($repartitions['NOMBRE']!=0){echo 'checked';} ?> value="<?php if($repartitions['NOMBRE']!=0){echo '1';}else{echo '0';} ?>">
                                            </div>
                                            <label for="btn_check_tranches" class="control-label" style="text-align: left; margin-top: 3px;">Répartition en tranches</label>
                                        </div>
                                    </div>
                                    <div class="row" style="marging-bottom: 20px; border-bottom: 1px solid #EEEEEE; <?php if($repartitions['NOMBRE']==0){echo 'display: none';} ?>" id="div_tranche">
                                        <div class="form-group col-3" style="margin-bottom: 5px; padding-top: 15px">
                                          <label for="design_tranche" class="control-label col-lg-12" style="text-align: left;">Désignation *</label>
                                          <div class="col-lg-12">
                                                <input type="text" class="form-control" name="design_tranche" id="design_tranche">
                                            </div> 
                                          </div>
                                          <div class="col-3" style="margin-bottom: 5px; padding-top: 15px">
                                        <div class="form-group ">
                                          <label for="montant_tranche" class="control-label col-lg-12" style="text-align: left;">Montant *</label>
                                          <div class="col-lg-12">
                                                <input type="number" class="form-control" step="any" name="montant_tranche" id="montant_tranche">
                                            </div> 
                                          </div>
                                        </div>
                                        <div class="col-2" style="margin-bottom: 5px; padding-top: 35px">
                                            <button class="btn btn-primary" type="button" id="btn_ajouter" style="width: 100%">Ajouter</button>
                                        </div>
                                        <div class="col-12" style="margin-bottom: 10px;">
                                            <iframe src="" style="width: 100%; height: 180px;border: 1px solid #EEEEEE; margin-top: 20px" id="iframe_tranche"></iframe>
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
    <div id="ModalAjout" class="modal fade" data-backdrop="static" style="margin-top: 100px">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nouvelle catégorie</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok" type="hidden" name="tok" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="col-lg-12" style="<?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'display: none';} ?>">Ecole *</div>
                    <div class="col-lg-12" style="<?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'display: none';} ?>">
                    <select name="liste_ecole" class="form-control" id="liste_ecole" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ echo 'disabled';} ?>>
                        <option value="">--</option>
                        <?php while($liste_ecoles=$liste_ecole->fetch()){ ?>
                        <option value="<?php echo($liste_ecoles['ID_Etablissement']) ?>" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1 && $liste_ecoles['ID_Etablissement']==$_SESSION['user_eteelo_app']['ID_Etablissement']){ echo 'selected';} ?>><?php echo(stripslashes($liste_ecoles['Design_Etablissement'])) ?></option>
                        <?php } ?>
                    </select>
                    </div>
                    <div class="col-lg-12">Désignation *</div>
                    <div class="col-lg-12"><input type="text" name="Design" id="Design" class="form-control" style="margin-top: 1%;" value="" required></div>
                    <div class="col-lg-12">Compte debit *</div>
                    <select name="compte_debit" class="form-control" id="compte_debit">
                        <option value="" id="ajouter_compte_debit">--</option>
                        <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ while($compte_debits=$compte_debit->fetch()){ ?>
                        <option value="<?php echo($compte_debits['ID_Compte']) ?>"><?php echo(stripslashes($compte_debits['Cod_Categorie'].$compte_debits['Cod_Compte'].' '.$compte_debits['Design_Compte'])) ?></option>
                        <?php }} ?>
                    </select>
                    <div class="col-lg-12">Compte credit *</div>
                    <select name="compte_credit" class="form-control" id="compte_credit">
                        <option value="" id="ajouter_compte_credit">--</option>
                        <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ while($compte_credits=$compte_credit->fetch()){ ?>
                        <option value="<?php echo($compte_credits['ID_Compte']) ?>"><?php echo(stripslashes($compte_credits['Cod_Categorie'].$compte_credits['Cod_Compte'].' '.$compte_credits['Design_Compte'])) ?></option>
                        <?php }} ?>
                    </select>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enregistrer">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialogue()">Annuler</button>
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
        if($('#ecole').val()!=''){
            $.ajax({
                url:'recherche_type_frais.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val(), ID_Type:$('#ID_Type').val()},
                success:function(ret){
                    $('#addtype_frais').nextAll().remove();
                    $('#addtype_frais').after(ret);
                }
            });
            $.ajax({
                url:'recherche_option.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val(), ID_Option:$('#ID_Option').val()},
                success:function(ret){
                    $('#add_option').nextAll().remove();
                    $('#add_option').after(ret);
                }
            });
            $.ajax({
                url:'recherche_cat_eleve.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val(), ID_Cat:$('#ID_Cat').val()},
                success:function(ret){
                    $('#add_categorie').nextAll().remove();
                    $('#add_categorie').after(ret);
                }
            });
            $.ajax({
                url:'recherche_devises.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val(), ID_Taux:$('#ID_Taux').val()},
                success:function(ret){
                    $('#add_devise').nextAll().remove();
                    $('#add_devise').after(ret);
                }
            });
        }
        $('#iframe_tranche').attr('src', 'table_tranche_frais.php?Frais='+$('#ID_Frais').val());
    })
    $('#btn_ajouter').click(function(){
        if($('#design_tranche').val()=='' || $('#montant_tranche').val()==''){
            alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Veuillez saisir une désignation et un montant svp!",function(){
                  $('#design_tranche').focus();
                });
        }else if($('#type_frais').val()=='' || $('#option').val()=='' || $('#devise').val()=='' || $('#montant').val()==''){
            alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Veuillez saisir toutes les informations du frais svp!",function(){
                  $('#type_frais').focus();
                });
        }else{
            $.ajax({
                url:'insert_update_tranche_frais.php',
                type:'post',
                dataType:'text', 
                data:{Ecole:$('#ecole').val(), Type_frais:$('#type_frais').val(), Option:$('#option').val(), Devise:$('#devise').val(), Montant:$('#montant').val(), Design_Tranche:$('#design_tranche').val(), Montant_Tranche:$('#montant_tranche').val(), token:$('#token').val(), Frais:$('#ID_Frais').val()},
                success:function(ret){
                    if(ret==1){
                        $('#design_tranche').val('').focus();
                        $('#montant_tranche').val('');
                        $('#iframe_tranche').attr('src', 'table_tranche_frais.php?Frais='+$('#ID_Frais').val());
                    }else if(ret==2){
                        alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Cette désignation existe déjà!");
                    }else if(ret==3){
                        alertify.alert('<?php echo $app_infos['Design_App']; ?>',"La somme de toutes les tranches est supérieure au montant frais!");
                    }else if(ret==4){
                        alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Le montant de la tranches est supérieur au montant frais!");
                    }else{
                        alertify.alert('<?php echo $app_infos['Design_App']; ?>', ret);
                    }
                }
            });
        }
    })
    $('#type_frais').change(function() {
        if($('#type_frais').val()!=''){
            $('#option').focus();
        }
    })
    $('#option').change(function() {
        if($('#option').val()!=''){
            $('#devise').focus();
        }
    })
    $('#devise').change(function() {
        if($('#devise').val()!=''){
            $('#montant').focus();
        }
    })
    $('#categorie').change(function() {
        if($('#categorie').val()!=''){
            $('#devise').focus();
        }
    })
    $('#niveau').change(function() {
        if($('#niveau').val()!=''){
            $('#categorie').focus();
        }
    })
    $('#liste_ecole').change(function(){
        if($('#liste_ecole').val()!=''){
            $.ajax({
                url:'recherche_compte_debit.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#liste_ecole').val()},
                success:function(ret){
                    $('#ajouter_compte_debit').nextAll().remove();
                    $('#ajouter_compte_debit').after(ret);
                }
            });
            $.ajax({
                url:'recherche_compte_credit.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#liste_ecole').val()},
                success:function(ret){
                    $('#ajouter_compte_credit').nextAll().remove();
                    $('#ajouter_compte_credit').after(ret);
                }
            });
            $('#Design').focus();
        }
    })
    $('#btn_check_all_categories').click(function(){
        if($('#btn_check_all_categories').val()==0){
            $('#categorie').attr('disabled', true);
            $('#categorie').val('');
            $('#btn_check_all_categories').val(1);
            $('#check_all_categories').val(1);
        }else{
            $('#categorie').attr('disabled', false);
            $('#categorie').val('').focus();
            $('#btn_check_all_categories').val(0);
            $('#check_all_categories').val(0);
        }
    })
    $('#btn_check_all_classes').click(function(){
        if($('#btn_check_all_classes').val()==0){
            $('#niveau').attr('disabled', true);
            $('#niveau').val('');
            $('#btn_check_all_classes').val(1);
            $('#check_all_classes').val(1);
        }else{
            $('#niveau').attr('disabled', false);
            $('#niveau').val('').focus();
            $('#btn_check_all_classes').val(0);
            $('#check_all_classes').val(0);
        }
    })
    $('#btn_check_tranches').click(function(){
        if($('#btn_check_tranches').val()==0){
            $('#div_tranche').slideDown('slow', function(){
                $('#design_tranche').focus();
            });
            $('#btn_check_tranches').val(1);
        }else{
            $('#div_tranche').slideUp('slow', function(){
                $('#design_tranche').val('');
                $('#montant_tranche').val('');
            });
            $('#btn_check_tranches').val(0);
        }
    })
    $('#compte_debit').change(function(){
        if($('#compte_debit').val()!=''){
            $('#compte_credit').focus();
        }
    })
    $('#compte_credit').change(function(){
        if($('#compte_credit').val()!=''){
            $('#enregistrer').focus();
        }
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


        $('#FormFrais').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            // formData.append('content', CKEDITOR.instances['descript'].getData());
          if($('#type_frais').val()=='' || $('#option').val()=='' || $('#devise').val()=='' || $('#montant').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Veuillez remplir tous les champs obligatoires svp!",function(){
                  $('#type_frais').focus();
                });
          }else if($('#check_all_classes').val()==0 && $('#niveau').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Vous devez choisir une classe svp!",function(){
                  $('#niveau').focus();
                });
          }else if($('#check_all_categories').val()==0 && $('#categorie').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Vous devez choisir la catégorie d'élève svp!",function(){
                  $('#categorie').focus();
                });
          }else{
            $.ajax({
                    url:'edit_frais.php',
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
                             $('#iframe').attr('src','table_frais_to_day.php?Ecole='+$('#ID_Etab').val());
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
        window.location.replace('table_frais.php?Ecole='+$('#ID_Etab').val()+'&Option='+$('#Liste_Opt').val()+'&Niveau='+$('#Liste_Niv').val());
    })

    function fermerDialogue(){
        $("#ModalAjout").modal('hide');
    }
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

    $('#ajouter_type_frais').click(function(e){
      e.preventDefault();
      $("#ModalAjout").modal('show');
      $('#compte_debit').val('');
      $('#compte_credit').val('');
      $('#Design').val('');
      $('#Design').focus();
      if($('#liste_ecole').val()!=''){
            $.ajax({
                url:'recherche_compte_debit.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#liste_ecole').val()},
                success:function(ret){
                    $('#ajouter_compte_debit').nextAll().remove();
                    $('#ajouter_compte_debit').after(ret);
                }
            });
            $.ajax({
                url:'recherche_compte_credit.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#liste_ecole').val()},
                success:function(ret){
                    $('#ajouter_compte_credit').nextAll().remove();
                    $('#ajouter_compte_credit').after(ret);
                }
            });
            $('#Design').focus();
        }
    })
    $('#enregistrer').click(function(){
        if($('#Design').val()=='' || $('#liste_ecole').val()=='' || $('#compte_debit').val()=='' || $('#compte_credit').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!');
                $('#Design').focus();
        }else{
                $.ajax({
                        url:'enreg_categorie_frais.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'html',
                        data: {Design:$('#Design').val(), Compte_Debit:$('#compte_debit').val(), Compte_Credit:$('#compte_credit').val(), Ecole:$('#liste_ecole').val(), token:$('#tok').val()},
                        success:function(ret){
                            if(ret==2){
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Cette désignation existe déjà'); 
                            }else{
                                $('#addtype_frais').nextAll().remove();
                                $('#addtype_frais').after(ret);
                                fermerDialogue();
                                $('#option').focus();
                            }
                        }
                    });
        }
    });
  });
    </script>
</body>