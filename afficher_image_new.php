<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connection");
    }
    require_once('connexion.php');
    $ID=$_GET['ID'];
    if(isset($_GET['Titre']) && $_GET['Titre']!=''){
        $Titre=$_GET['Titre'];
        $table_stitre=$pdo->query("SELECT * FROM table_sous_titre_new INNER JOIN table_titre_new ON table_sous_titre_new.ID_Titre=table_titre_new.ID_Titre WHERE table_sous_titre_new.ID_Sous_Titre=".$Titre);
    }else{
        $table_stitre=$pdo->query("SELECT * FROM table_sous_titre_new INNER JOIN table_titre_new ON table_sous_titre_new.ID_Titre=table_titre_new.ID_Titre");
    }
    $table_stitres=$table_stitre->fetch();
    $photo=$pdo->query("SELECT * FROM table_photo_rapport_new INNER JOIN table_titre_rapport_new ON table_titre_rapport_new.ID_Titre_Rapport=table_photo_rapport_new.ID_Titre_Rapport WHERE table_titre_rapport_new.ID_Rapport=".$ID." AND table_titre_rapport_new.ID_Sous_Titre=".$table_stitres['ID_Sous_Titre']);
    $selection=$pdo->query("SELECT * FROM table_photo_rapport_new INNER JOIN table_titre_rapport_new ON table_titre_rapport_new.ID_Titre_Rapport=table_photo_rapport_new.ID_Titre_Rapport WHERE table_titre_rapport_new.ID_Rapport=".$ID." AND table_titre_rapport_new.ID_Sous_Titre=".$table_stitres['ID_Sous_Titre']);
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();

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
    <link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css">
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
    .btn-default:hover{
         border: 1px solid #D9DBDE;
      }
      .btn-default:focus{
         border: 1px solid #D9DBDE;
      }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" style="overflow-x: hidden; ; background-color: #FFFFFF">
    <div class="page">
      <div class="page-wrapper">
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
                      <div class="tab-pane active show" id="tabs-home-13">
                      <form id="PicturesForm" method="post" action="" enctype="multipart/form-data">
                         <input id="token" type="hidden" name="token" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                         <div class="row">
                            <div class="col-12" style="text-align: center; border-bottom: 1px solid #E6E7E9; padding-bottom: 10px; margin-bottom: 10px">
                                <span style="font-weight: bold;"><?php echo stripslashes(strtoupper($table_stitres['Code_Titre'].'.'.$table_stitres['Code_Sous_Titre'].'. '.$table_stitres['Design_Sous_Titre'])); ?></span>
                                <div class="row">

                                <?php if($selections=$selection->fetch()){ while($photos=$photo->fetch()){ ?>
                                    <div class="col-sm-4" style="border-top: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px; margin-bottom: 5px">
                                        <div style="border: 2px solid RGB(234,234,234); height: 200px">
                                            <a href="<?php echo 'images/rapports/'.$photos['Photo']; ?>" class="view-project" data-fancybox="gallery" data-caption="<?php echo $photos['Photo']; ?>">
                                            <img src="<?php echo 'images/rapports/'.$photos['Photo']; ?>" style="height: 170px; margin-top: 10px" class="miamge"></a></br>
                                            <span style="font-size: 9px; padding-top: 10px; font-weight: bold; padding-bottom: 10px"><?php echo $photos['Photo']; ?><a href="<?php echo 'images/rapports/'.$photos['Photo']; ?>" style="margin-left: 5px" title="Télécharger" download><i class="fa fa-download"></i></a><?php if($_SESSION['user_eteelo_app']['ID_Statut']==1){ ?><a href="supprimer_photo_new.php?Photo=<?php echo $photos['ID_Photo']; ?>&IMG=<?php echo 'images/rapports/'.$photos['Photo']; ?>&token=<?php echo($_SESSION['user_eteelo_app']['token']) ?>&ID=<?php if(isset($_GET['ID']) && $_GET['ID']!=''){echo $_GET['ID']; } ?>&Titre=<?php if(isset($_GET['Titre']) && $_GET['Titre']!=''){echo $_GET['Titre']; } ?>" style="margin-left: 5px" title="Supprimer"><i class="fa fa-trash-o"></i></a><?php } ?></span>         
                                        </div>
                                    </div>
                                <?php }}else{ ?>
                                    <div class="col-sm-4">
                                    </div>
                                    <div class="col-sm-4" style="border-top: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px; margin-bottom: 5px">
                                        <div style="border: 2px solid RGB(234,234,234); height: 200px">
                                                        <!-- <a href="#" class="btn_choisir_image" title="Choisir l'image"> -->
                                            <img src="<?php echo 'images/po-picture.jpg'; ?>" style="height: 170px; margin-top: 10px" class="miamge"></br>
                                            <span style="font-size: 11px; padding-top: 10px; font-weight: bold; padding-bottom: 10px">Pas d'images disponibles</span>
                                                        <!-- </a> -->
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                    </div>
                                <?php } ?>
                                </div>
                            </div>
                         </div>
                         <div class="row" style="margin-top: 10px; padding-bottom: 10px">
                                            <div class="col-lg-12">
                                              <div class="pull-right">
                                                  <a href="ajouter_photo_new.php?ID=<?php echo $ID; ?>&Titre=<?php if(isset($_GET['Titre']) && $_GET['Titre']!=''){echo $_GET['Titre']; } ?>" class="btn btn-default" title="Ajouter des photos">Ajouter des photos</a>
                                                  <!-- <button class="btn btn-danger" type="button" id="btn_annuler_tout">Annuler</button> -->
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
    <script src="./dist/libs/apexcharts/dist/apexcharts.min.js" defer></script>
    <script src="./dist/libs/jsvectormap/dist/js/jsvectormap.min.js" defer></script>
    <script src="./dist/libs/jsvectormap/dist/maps/world.js" defer></script>
    <script src="./dist/libs/jsvectormap/dist/maps/world-merc.js" defer></script>
    <script src="plugins/toastr/toastr.min.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="vendor/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="notifica/alertify.min.js"></script>
    <script type="text/javascript" src="fancybox/jquery.fancybox.min.js"></script>
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

    $(function(){
        $(".date").datepicker({closeText:'fermer',prevText:'&#x3c;Préc',nextText:'Suiv&#x3e;',currentText:'Courant',dateFormat:"dd/mm/yy", minDate: "01/01/1990",monthNames:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aoùt","Septembre","Octobre","Novembre","Décembre"],monthNamesShort:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],dayNamesMin:["Dim","Lun","Mar","Mer","Jeu","Ven","Sam"], changeMonth: true, changeYear: true,onSelect: function(value, date) {
            date.dpDiv.find('.ui-datepicker-current-day a')
            .css('background-color', '#FE5000').css({"z-index":99999999999999});}
        });
    });
    </script>
</body>