<?php
session_start();
$_SESSION['last_activity'] = time();
if (empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app'] == false) {
    header("location: connection");
}
require_once ('connexion.php');
$ID = $_GET['ID'];
$req_rapport = $pdo->query("SELECT * FROM table_rapport_journalier_new INNER JOIN site ON table_rapport_journalier_new.ID_Site=site.ID_Site INNER JOIN province ON site.ID_Prov=province.ID_Prov WHERE table_rapport_journalier_new.ID_Rapport=" . $ID);
$rapports = $req_rapport->fetch();
$province = $pdo->query("SELECT * FROM province INNER JOIN site ON province.ID_Prov=site.ID_Prov ORDER BY Design_Prov");
$titre = $pdo->query("SELECT * FROM table_titre_new ORDER BY ID_Titre");
$app_info = $pdo->query("SELECT * FROM app_infos");
$app_infos = $app_info->fetch();
$Numero_titre = 0;
$Numero_stitre = 0;
$Nombre_Total = 0;
$prov = "";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Modification d'un rapport | <?php echo $app_infos['Design_App']; ?></title>
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
          <input type="hidden" name="User" id="User" value="<?php if (isset($_GET['User']) && $_GET['User'] != '') {
              echo $_GET['User'];
          } ?>">
            <input type="hidden" name="nocTicket" id="nocTicket" value="<?php if (isset($_GET['nocTicket']) && $_GET['nocTicket'] != '') {
                echo $_GET['nocTicket'];
            } ?>">
            <input type="hidden" name="siteId" id="siteId" value="<?php if (isset($_GET['siteId']) && $_GET['siteId'] != '') {
                echo $_GET['siteId'];
            } ?>">
            <input type="hidden" name="dateRapport" id="dateRapport" value="<?php if (isset($_GET['dateRapport']) && $_GET['dateRapport'] != '') {
                echo $_GET['dateRapport'];
            } ?>">
          <!-- <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">
              <div class="col">
                Page pre-title
                <div class="page-pretitle">
                  
                </div>
                <h2 class="page-title">
                Modification d'un rapport
                </h2>
              </div>
              Page title actions
              <div class="col-12 col-md-auto ms-auto d-print-none">
                <div class="btn-list">
                </div>
              </div>
            </div>
          </div> -->
        </div>
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-cards">
              <div class="col-md-12">
                <div class="card">
                  <ul class="nav nav-tabs l0" data-bs-toggle="tabs" style="display: none">
                    <li class="nav-item">
                      <a href="#tabs-home-12" id="a0" class="nav-link active" data-bs-toggle="tab">Modification d'un élève</a>
                    </li>
                    <li class="nav-item l1 disabled">
                      <a href="#tabs-home-13" class="nav-link " id="a1" data-bs-toggle="tab">Importation</a>
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
                                      <div class="col-md-3" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="province" class="control-label col-lg-12" style="text-align: left;">Province *</label>
                                          <div class="col-lg-12">
                                            <select name="province" id="province" class="form-control ">
                                              <option value="">--</option>
                                              <?php while ($provinces = $province->fetch()) {
                                                  if ($prov != $provinces['ID_Prov']) {
                                                      $prov = $provinces['ID_Prov'];
                                                      ?>
                                                      <option value="<?php echo ($provinces['ID_Prov']); ?>" <?php if ($provinces['ID_Prov'] == $rapports['ID_Prov']) {
                                                            echo 'selected';
                                                        } ?>><?php echo strtoupper($provinces['Design_Prov']); ?></option>
                                                  <?php }
                                              } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                            <label for="site" class="control-label col-lg-12" style="text-align: left;">Site ID & Name *</label>
                                            <input type="text" name="site" id="site" class="form-control" value="<?php echo strtoupper(stripslashes($rapports['Site_ID'] . ' - ' . $rapports['Site_Name'])); ?>">
                                            <input type="hidden" name="ID_Site" id="ID_Site" value="<?php echo ($rapports['ID_Site']) ?>">
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="noc_ticket" class="control-label col-lg-12" style="text-align: left;">Noc Ticket *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="noc_ticket" type="text" name="noc_ticket" value="<?php echo strtoupper(stripslashes($rapports['Noc_Ticket'])); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="date_rapport" class="control-label col-lg-12" style="text-align: left;">Date *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control date" id="date_rapport" type="text" name="date_rapport" value="<?= date('d/m/Y', strtotime($rapports['Date_Rapport'])); ?>">
                                            <input type="hidden" name="daterap" id="daterap" value="<?= date('Y-m-d', strtotime($rapports['Date_Rapport'])); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pm_type" class="control-label col-lg-12" style="text-align: left;">PM type *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="pm_type" type="text" name="pm_type" value="<?php echo strtoupper(stripslashes($rapports['PM_Type'])); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="run_hour" class="control-label col-lg-12" style="text-align: left;">Run Hour *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="run_hour" type="text" name="run_hour" value="<?php echo strtoupper(stripslashes($rapports['Run_Hour'])); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="dc_load" class="control-label col-lg-12" style="text-align: left;">DC Load *</label>
                                          <div class="col-lg-12">
                                              <input class="form-control" id="dc_load" type="text" name="dc_load" value="<?php echo strtoupper(stripslashes($rapports['DC_Load'])); ?>">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                          </div>
                                    <div class="row" style="margin-top: 10px; padding-bottom: 10px">
                                            <div class="col-lg-12">
                                              <div class="pull-right">
                                                  <button class="btn btn-primary" type="button" id="btn_next">Suivant</button>
                                                  <button class="btn btn-danger" type="button" id="btn_annuler">Annuler</button>
                                              </div>
                                            </div>
                                        </div>
                          </form>
                      </div>
                      <div class="tab-pane" id="tabs-home-13">
                         <div class="row">
                            <?php while ($titres = $titre->fetch()) {
                                $table_stitre = $pdo->query("SELECT * FROM table_sous_titre_new WHERE ID_Titre=" . $titres['ID_Titre']);
                                ?>
                                <div class="col-12" style="text-align: center">
                                        <input id="token" type="hidden" name="token" value="<?php echo ($_SESSION['user_eteelo_app']['token']); ?>">
                                        <span style="font-weight: bold;"><?php echo stripslashes(strtoupper($titres['Code_Titre'] . '. ' . $titres['Design_Titre'])); ?></span>
                                        <div class="row">
                                            <?php while ($table_stitres = $table_stitre->fetch()) {
                                                $Nombre = 1;
                                                $Numero_titre = $titres['Code_Titre'];
                                                $Numero_stitre = $table_stitres['Code_Sous_Titre'];
                                                ?>
                                                <div class="col-12" style="text-align: center; border-top: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                                    <span><?php echo stripslashes(strtoupper($titres['Code_Titre'] . '.' . $table_stitres['Code_Sous_Titre'] . '. ' . $table_stitres['Design_Sous_Titre'])); ?></span>
                                                    <div class="row">
                                                    <?php while ($Nombre <= $table_stitres['Nombre_Photo']) {
                                                        $Nombre++;
                                                        $Nombre_Total++;
                                                        $photo = $pdo->query("SELECT * FROM table_photo_rapport_new INNER JOIN table_titre_rapport_new ON table_titre_rapport_new.ID_Titre_Rapport=table_photo_rapport_new.ID_Titre_Rapport WHERE table_titre_rapport_new.ID_Rapport=" . $rapports['ID_Rapport'] . " AND table_titre_rapport_new.ID_Sous_Titre=" . $table_stitres['ID_Sous_Titre'] . " AND table_photo_rapport_new.Indice_Photo=" . $Nombre_Total);
                                                        ?>
                                                            <div class="col-sm-3" style="border-top: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px; margin-bottom: 5px">
                                                              <form class="PicturesForm" id="PicturesForm_<?php echo $Nombre_Total; ?>" method="post" action="" enctype="multipart/form-data">
                                                                <input type="hidden" name="ID_Rapport_<?php echo $Nombre_Total; ?>" class="ID_Rapport" value="<?php echo ($rapports['ID_Rapport']); ?>">
                                                                <input id="token_<?php echo $Nombre_Total; ?>" type="hidden" name="token_<?php echo $Nombre_Total; ?>" value="<?php echo ($_SESSION['user_eteelo_app']['token']); ?>">
                                                                <input type="hidden" class="ID_Titre" name="ID_Titre_<?php echo $Nombre_Total; ?>" id="ID_Titre" value="<?php echo $table_stitres['ID_Sous_Titre']; ?>">
                                                                <input class="form-control fichier_image" id="fichier_image_<?php echo $Nombre_Total; ?>" type="file" name="fichier_image_<?php echo $Nombre_Total; ?>" style="display: none;" accept=".jpg, .jpeg, .png">
                                                                <div style="border: 2px solid RGB(234,234,234); height: 200px">
                                                                    <input type="hidden" name="Indice" value="<?php echo $Nombre_Total; ?>">
                                                                    <a href="#" class="btn_choisir_image" id="mapercu_<?php echo $Nombre_Total; ?>" indice="<?php echo $Nombre_Total; ?>" title="Choisir l'image">
                                                                    <img src="<?php if ($photos = $photo->fetch()) {
                                                                        echo 'images/rapports/' . $photos['Photo'];
                                                                    } else {
                                                                        echo 'images/picture.png';
                                                                    } ?>" style="height: 180px; margin-top: 10px" id="miamge_<?php echo $Nombre_Total; ?>" class="miamge">
                                                                    </a>
                                                                </div>
                                                                <input id="btn_submit_<?php echo $Nombre_Total; ?>" type="submit" name="btn_submit_<?php echo $Nombre_Total; ?>" value="btn_submit_<?php echo $Nombre_Total; ?>" style="display: none">
                                                              </form>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                </div>
                            <?php } ?>
                            <div class="col-12" style="text-align: center; border-top: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span><?php echo $Numero_titre . '.' . ($Numero_stitre + 1) . '. '; ?>ISSUE</span>
                            <div class="row">
                                <div class="col-12" style="text-align: center; border-top: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                    <textarea name="description" class="form-control" id="description" cols="30" rows="6"><?php echo stripslashes($rapports['Description']); ?></textarea>
                                </div>
                            </div>
                            </div>
                         </div>
                         <div class="row" style="margin-top: 10px; padding-bottom: 10px">
                                            <div class="col-lg-12">
                                              <div class="pull-right">
                                                  <button class="btn btn-primary" type="button" id="btn_enregistrer">Enregistrer</button>
                                                  <button class="btn btn-danger" type="button" id="btn_annuler_tout">Annuler</button>
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

    listSites=[];
    idimg="";
    indice="";
    function recheche_site(){
        $.ajax({
          url:"recherche_site.php",
          type:'post',
          dataType:"json",
          data:{Province:$('#province').val()},
          success:function(donnee){
            listSites.length=0;
              $.map(donnee,function(objet){
                listSites.push({
                      value:objet.Design,
                      desc:objet.ID_Site
                  });
              });
          }
        });
    }

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        async function demo() {
            await sleep(2000);
            // $('#btn_submit').click();
            // $('#'+idimg).attr('src', images);
        }

         function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#'+idimg).attr('src', 'images/loading.gif');
                    $('#btn_submit_'+indice).click();
                    images = e.target.result;
                    demo()
                }
                reader.readAsDataURL(input.files[0]);
            }
        }


    $('.btn_choisir_image').click(function(e){
        e.preventDefault();
        $('#fichier_image_'+$(this).attr('indice')).click();
        idimg="miamge_"+$(this).attr('indice');
        indice=$(this).attr('indice');
    })

    $('.fichier_image').change(function(){
         readURL(this);
    })

    $(document).ready(function(){
        recheche_site();
    })
    $('#btn_next').click(function(){
        if($('#province').val()=='' ||  $('#site').val()=='' || $('#noc_ticket').val()=='' || $('#date_rapport').val()=='' || $('#pm_type').val()=='' || $('#run_hour').val()=='' || $('#dc_load').val()==''){
          alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!', function(){$('#libelle').focus();});
        }else{
                // alertify.alert('Salut');
                let daterapport = $('#date_rapport').val();
                daterap = daterapport.replace(/\//g, "-");
                $('#daterap').val(daterap);
                $.ajax({
                    url:'edit_rapport_new.php',
                    type:'post',
                    dataType:'text', 
                    data:{Province:$('#province').val(), ID_Rapport:$('.ID_Rapport').val(), Site:$('#ID_Site').val(), Noc_ticket:$('#noc_ticket').val(), Daterap:$('#daterap').val(), PM_type:$('#pm_type').val(), Run_hour:$('#run_hour').val(), DC_load:$('#dc_load').val(), token:$('#token').val()},
                    success:function(ret){
                        $('.l1').removeClass('disabled').addClass('Active');
                        $('#a1').tab('show');
                    }
                });
                // $('.l1').removeClass('disabled').addClass('Active');
                // $('#a1').tab('show');
        }
    })
    $('#site').autocomplete({source:function(request,response){
        var resultat=$.ui.autocomplete.filter(listSites,request.term);
        response(resultat.slice(0,15));
        },
        select:function(event,ui){
            $('#ID_Site').val(ui.item.desc);
            $('#noc_ticket').focus();
        }
    });


    $('#province').change(function(){
        if($('#province').val()!=''){
            recheche_site();
            $('#site').val('').focus();
        }
    })


    $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });


    $('.PicturesForm').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                    url:'enreg_picture_new.php',
                    type:'post',
                    beforeSend:function(){
                        waitingDialog.show('Veuillez patienter svp!');
                    },
                    dataType:'text',
                    data: formData,
                    processData: false,
                    cache: false,
                    contentType: false,
                    success:function(retour){
                        const stret = retour;
                        const valeuret = stret.split(',');
                        waitingDialog.hide();
                        if(valeuret[0]==2){
                            alertify.alert('<?php echo $app_infos['Design_App']; ?>',"L'extension de l'image ne correspond pas!");
                            $('#fichier_image_'+idimg).val('');
                            $('#'+idimg).attr('src', 'images/picture.png');
                        }else if(valeuret[0]==3){
                            alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Le téléchargement de l'image a échoué!");
                            $('#fichier_image_'+idimg).val('');
                            $('#'+idimg).attr('src', 'images/picture.png');
                        }else if(valeuret[0]==1){
                            $('#'+idimg).attr('src', images);
                            Toast.fire({
                                icon: 'success',
                                title: 'Upload éffectué'
                            })
                            // let dateRapport = $('#dateRapport').val();
                            // dateRap = dateRapport.replace(/\//g, "-");
                            // window.location.replace('table_rapport_new.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&nocTicket='+$('#nocTicket').val()+'&dateRapport='+dateRap);
                        }else{
                            alertify.alert(retour);
                            $('#fichier_image_'+idimg).val('');
                            $('#'+idimg).attr('src', 'images/picture.png');
                        }
                    }
                });
          })



          $('#btn_enregistrer').click(function(){
            $.ajax({
                    url:'enreg_description_new.php',
                    type:'post',
                    beforeSend:function(){
                        waitingDialog.show('Veuillez patienter svp!');
                    },
                    dataType:'text', 
                    data:{ID_Rapport:$('.ID_Rapport').val(), description:$('#description').val(), token:$('#token').val()},
                    success:function(ret){
                        if(ret==1){
                            Toast.fire({
                                  icon: 'success',
                                  title: 'Enregistré'
                            })
                            let dateRapport = $('#dateRapport').val();
                            dateRap = dateRapport.replace(/\//g, "-");
                            window.location.replace('table_rapport_new.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&nocTicket='+$('#nocTicket').val()+'&dateRapport='+dateRap);
                        }
                    }
            });
         })
  })

    // $('#retour_table').click(function(e){
    //     $.ajax({
    //         url:'annuler_rapport.php',
    //         type:'post',
    //         dataType:'html', 
    //         data:{Rapport:$('.ID_Rapport').val(), token:$('#token').val()},
    //         success:function(ret){
    //         }
    //     });
    //     e.preventDefault();
    //     let dateRapport = $('#dateRapport').val();
    //     dateRap = dateRapport.replace(/\//g, "-");
    //     window.location.replace('table_rapport_new.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&nocTicket='+$('#nocTicket').val()+'&dateRapport='+dateRap);
    // })
    $('#btn_annuler').click(function(){
        let dateRapport = $('#dateRapport').val();
        dateRap = dateRapport.replace(/\//g, "-");
        window.location.replace('table_rapport_new.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&nocTicket='+$('#nocTicket').val()+'&dateRapport='+dateRap);
    });
    $('#btn_annuler_tout').click(function(){
        let dateRapport = $('#dateRapport').val();
        dateRap = dateRapport.replace(/\//g, "-");
        window.location.replace('table_rapport_new.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&nocTicket='+$('#nocTicket').val()+'&dateRapport='+dateRap);
    })
    $(function(){
        $(".date").datepicker({closeText:'fermer',prevText:'&#x3c;Préc',nextText:'Suiv&#x3e;',currentText:'Courant',dateFormat:"dd/mm/yy", minDate: "01/01/1990",monthNames:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aoùt","Septembre","Octobre","Novembre","Décembre"],monthNamesShort:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],dayNamesMin:["Dim","Lun","Mar","Mer","Jeu","Ven","Sam"], changeMonth: true, changeYear: true,onSelect: function(value, date) {
            date.dpDiv.find('.ui-datepicker-current-day a')
            .css('background-color', '#FE5000').css({"z-index":99999999999999});}
        });
    });
    </script>
</body>