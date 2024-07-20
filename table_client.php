<?php
session_start();
$_SESSION['last_activity'] = time();
if (empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app'] == false) {
    header("location: connexion");
}
require_once ('connexion.php');
$query = "SELECT * FROM client ORDER BY Design_Client";
$req = $pdo->query($query);
$Total = $req->rowCount();
$totalparpage = 10;
$pagesTotales = ceil($Total / $totalparpage);
if (isset($_GET['page']) and !empty($_GET['page']) and $_GET['page'] > 0 and $_GET['page'] <= $pagesTotales) {
    $_GET['page'] = intval($_GET['page']);
    $pageCourante = $_GET['page'];
} else {
    $pageCourante = 1;
}
$depart = ($pageCourante - 1) * $totalparpage;
$query .= " LIMIT " . $depart . "," . $totalparpage;
$selection = $pdo->query($query);
$app_info = $pdo->query("SELECT * FROM app_infos");
$app_infos = $app_info->fetch();
$Nbr = 0;
?>
<!DOCTYPE html>
<html lang="fr-FR">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Clients | <?php echo $app_infos['Design_App']; ?></title>
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
    <link href="notifica/css/alertify.min.css" rel="stylesheet">
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
        top: 12%;
        transform: translateY(-50%);
        margin: auto;
    }
    .mapercu:hover {
        opacity: 0.7;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="page">
      <div class="page-wrapper">
        <div class="container-xl">
          <!-- Page title -->
          <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <h2 class="page-title">
                Clients
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
                  <a href="#" id="btn_ajouter" class="btn btn-primary d-sm-inline-block" title="Ajouter">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="font-weight: bold;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Ajouter
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
        <div class="text-muted mt-1" style="padding-left: 12px; padding-right: 12px">

<?php if ($Total != 0) {
    if ($totalparpage < $Total) {
        if ($depart + $totalparpage < $Total) {

            ?>
                    Affiche de <?php echo $depart + 1; ?> à <?php echo $depart + $totalparpage; ?> sur <?php echo $Total; ?> enregistrements
                <?php } else { ?>
                        Affiche de <?php echo $depart + 1; ?> à <?php echo $Total; ?> sur <?php echo $Total; ?> enregistrements
        <?php }
    } else { ?>
            Affiche de <?php echo $depart + 1; ?> à <?php echo $Total; ?> sur <?php echo $Total; ?> enregistrements
    <?php }
} else { ?>
        Affiche de 0 à 0 sur 0 enregistrements
<?php } ?>

</div>
        <div class="page-body" style="padding-left: 12px; padding-right: 12px">
          <div class="container-xl" style="border: 1px solid #E6E7E9">
            <div class="row row-deck row-cards">
                <!-- <div class="col-md-12 col-lg-12"> -->
                    <!-- <div class="panel panel-default"> -->
                        <!-- <div class="panel-body"> -->
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Désignation</th>
                                        <th>Opérations</th>
                                    </tr>
                                </thead>
                                <tbody id="MaTable">
    <?php while ($selections = $selection->fetch()) {
        $Nbr++; ?>
            <tr class="odd gradeX" style="background: transparent;">
                <td style="width: 80px; "><center><?php echo sprintf('%02d', $Nbr); ?></center></td>
                <td><!-- <center> --><?php echo strtoupper(stripslashes($selections['Design_Client'])); ?></td>
                <td style="padding-left: 250px"><!-- <center> -->
                    <a href="#" onclick="Function_Modifier(<?php echo ($selections['ID_Cient']); ?>, '<?php echo (stripslashes($selections['Design_Client'])); ?>', '<?php echo (stripslashes($selections['Logo'])); ?>', '<?php echo (stripslashes($selections['Description'])); ?>')" title="Modifier" style="margin-right: 5px; width: 25px; border-radius: 0;" class="btn btn-primary"><i class="fa fa-edit fa-fw"></i></a>
                    <?php if ($_SESSION['user_eteelo_app']['ID_Statut'] == 1) { ?>
                        <a style="width: 25px; border-radius: 0;" class="btn btn-danger" href="javascript: alertify.confirm('Voulez-vous vraiment supprimer cette désignation ?\n Toutes les informations concernant cette désignation seront supprimées!').set('onok',function(closeEvent){window.location.replace('suppr_client.php?ID=<?php echo ($selections['ID_Cient']) ?>&token=<?php echo ($_SESSION['user_eteelo_app']['token']) ?>&IMG=<?php echo ($selections['Logo']) ?>');alertify.success('suppression éffectuée');}).set('oncancel',function(closeEvent){alertify.error('suppression annulée');}).set({title:''},{labels:{ok:'Oui', cancel:'Annuler'}});" title="Supprimer"><i class="fa fa-trash-o fa-fw"></i></a><!-- </center>-->
                    <?php } ?>
                </td>
            </tr>
    <?php } ?>
</tbody>
                            </table>
                            <div class="d-flex mt-4">
              <ul class="pagination ms-auto">
                                <?php
                                if ($pageCourante > 1) {
                                    $page = $pageCourante - 1;
                                    echo '<li class="page-item"><a class="page-link" href="table_client.php?page=' . $page . '"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>Previous</a></li>';
                                } else {
                                    echo '<li class="page-item disabled"><a class="page-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>Previous</a></li>';
                                }
                                if ($pagesTotales > 3) {
                                    $pagePrecedente = $pageCourante - 1;
                                    $pageNexte = $pageCourante + 1;
                                    $pageTrois = $pageCourante + 2;
                                    $pageAvantPrecedente = $pageCourante - 2;
                                    $pagesAvantTotales = $pagesTotales - 1;
                                    if ($pageCourante == 1) {
                                        echo '<li class="page-item"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="table_client.php?page=' . $pageNexte . '">' . $pageNexte . '</a></li><li class="page-item"><a class="page-link" href="table_client.php?page=' . $pageTrois . '">' . $pageTrois . '</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    } else if ($pageCourante == 2) {
                                        echo '<li class="page-item"><a class="page-link" href="table_client.php?page=' . $pagePrecedente . '">' . $pagePrecedente . '</a></li><li class="page-item active"><a class="page-link" href="#">' . $pageCourante . '</a></li><li class="page-item"><a class="page-link" href="table_client.php?page=' . $pageNexte . '">' . $pageNexte . '</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    } else if ($pageCourante == $pagesAvantTotales) {
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_client.php?page=' . $pagePrecedente . '">' . $pagePrecedente . '</a></li><li class="page-item active"><a class="page-link" href="#">' . $pageCourante . '</a></li><li class="page-item"><a class="page-link" href="table_client.php?page=' . $pageNexte . '">' . $pageNexte . '</a></li>';
                                    } else if ($pageCourante == $pagesTotales) {
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_client.php?page=' . $pageAvantPrecedente . '">' . $pageAvantPrecedente . '</a></li><li class="page-item"><a class="page-link" href="table_client.php?page=' . $pagePrecedente . '">' . $pagePrecedente . '</a></li><li class="page-item active"><a class="page-link" href="#">' . $pageCourante . '</a></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_client.php?page=' . $pagePrecedente . '">' . $pagePrecedente . '</a></li><li class="page-item active"><a class="page-link" href="#">' . $pageCourante . '</a></li><li class="page-item"><a class="page-link" href="table_client.php?page=' . $pageNexte . '">' . $pageNexte . '</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    }
                                } else {
                                    for ($i = 1; $i <= $pagesTotales; $i++) {
                                        if ($i == $pageCourante) {
                                            echo '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
                                        } else {
                                            echo '<li class="page-item"><a class="page-link" href="table_client.php?page=' . $i . '">' . $i . '</a></li>';
                                        }
                                    }
                                }
                                if ($pagesTotales > $pageCourante) {
                                    $page = $pageCourante + 1;
                                    echo '<li class="page-item"><a class="page-link" href="table_client.php?page=' . $page . '">Next<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg></a></li>';
                                } else {
                                    echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Next<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg></a></li>';
                                }

                                ?>
              </ul>
            </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="ModalAjout" class="modal fade" data-backdrop="static" style="margin-top: 100px">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
            <form method="post" action="" id="form_ajout" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">Ajout client</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                    <input id="tok" type="hidden" name="tok" value="<?php echo ($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="col-lg-12">Désignation *</div>
                    <div class="col-lg-12"><input type="text" name="Design" id="Design" class="form-control" style="margin-top: 1%;" value="" required></div>
                    <div class="col-lg-12">Description </div>
                    <div class="col-lg-12"><textarea name="Description" id="Description" class="form-control" style="margin-top: 1%; height: 90px"></textarea></div>
                    <div class="col-lg-12">Logo *</div>
                    <div class="col-lg-12">
                        <!-- <input type="hidden" name="photo" id="photo" value=""> -->
                        <input class="form-control " id="mimg" type="file" name="mimg" style="display: none;" accept=".jpg, .jpeg, .png">
                        <div style="width: 340px; height: 110px; border: 2px solid RGB(234,234,234); border-radius: 5px; justify-content: center; align-items: center; display: flex">
                            <a href="#" class="mapercu" id="mapercu" title="Choisir l'image">
                                <img src="images/template.png" id="miamge" class="miamge" style="border-radius: 2px">
                            </a>
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="enregistrer">Enregistrer</button>
                <button type="button"  class="btn btn-danger" onclick="fermerDialogue()">Annuler</button>
            </div>
            </form>
            </div>
        </div>
    </div>
    <div id="ModalModif" class="modal fade" data-backdrop="static" style="margin-top: 100px">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
        <div class="modal-content">
            <form method="post" action="" id="form_mod" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">Modification client</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                    <input type="hidden" name="ID_Cient" id="ID_Cient">
                    <input id="tok_mod" type="hidden" name="tok_mod" value="<?php echo ($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="col-lg-12">Désignation *</div>
                    <div class="col-lg-12"><input type="text" name="Design_mod" id="Design_mod" class="form-control" style="margin-top: 1%;" value="" required></div>
                    <div class="col-lg-12">Description </div>
                    <div class="col-lg-12"><textarea name="Description_mod" id="Description_mod" class="form-control" style="margin-top: 1%; height: 90px"></textarea></div>
                    <div class="col-lg-12">Logo </div>
                    <div class="col-lg-12">
                        <!-- <input type="hidden" name="photo" id="photo" value=""> -->
                        <input class="form-control " id="mimg_mod" type="file" name="mimg_mod" style="display: none;" accept=".jpg, .jpeg, .png">
                        <div style="width: 340px; height: 110px; border: 2px solid RGB(234,234,234); border-radius: 5px; justify-content: center; align-items: center; display: flex">
                            <a href="#" class="mapercu" id="mapercu_mod" title="Changer l'image">
                                <img src="images/template.png" id="miamge_mod" class="miamge" style="border-radius: 2px">
                            </a>
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="enregistrer">Enregistrer</button>
                <button type="button"  class="btn btn-danger" onclick="fermerDialogue_mod()">Annuler</button>
            </div>
            </form>
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
    $(document).ready(function() {

    });

  function fermerDialogue(){
        $("#ModalAjout").modal('hide');
  }
  function fermerDialogue_mod(){
        $("#ModalModif").modal('hide');
  }
  function Function_Modifier(a, b, c, d){
      $("#ModalModif").modal('show');
      $('#ID_Cient').val(a);
      $('#Design_mod').val(b);
      $('#miamge_mod').attr('src','images/client/'+c);
      $('#Description_mod').val(d);
      $('#Design_mod').focus();
  }

  function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        async function demo() {
            await sleep(2000);
            $('.miamge').attr('src', images);
        }

         function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('.miamge').attr('src', 'images/loading.gif');
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
  $('#mapercu_mod').click(function(e){
        e.preventDefault();
        $('#mimg_mod').click();
    })
    $('#mimg_mod').change(function(){
         readURL(this);
    })

  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

    $('#btn_ajouter').click(function(e){
      e.preventDefault();
      $("#ModalAjout").modal('show');
      $('#mimg').val('');
      $('#miamge').attr('src','images/template.png');
      $('#Description').val('');
      $('#Design').val('');
      $('#Design').focus();
    })


    $('#form_ajout').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        if($('#Design').val()=='' || $('#mimg').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!');
                $('#Design').focus();
        }else{
            $.ajax({
                    url:'enreg_client.php',
                    type:'post',
                    beforeSend:function(){
                        waitingDialog.show('Veuillez patienter...');
                    },
                    dataType:'text',
                    data: formData,
                    processData: false,
                    cache: false,
                    contentType: false,
                    success:function(ret){
                         waitingDialog.hide();
                         if(ret==2){
                             alertify.alert('<?php echo $app_infos['Design_App']; ?>',"L'extension de l'image ne correspond pas !");
                         }else if(ret==3){
                             alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Le téléchargement de l'image a échoué !");
                         }else if(ret==1){
                             Toast.fire({
                                icon: 'success',
                                title: 'Enregistré'
                             })
                             window.location.replace('table_client.php');
                         }else{
                            alertify.alert(ret);
                         }

                    }
                });
        }
    });

    $('#form_mod').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        if($('#Design_mod').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!');
                $('#Design_mod').focus();
        }else{
            $.ajax({
                    url:'edit_client.php',
                    type:'post',
                    beforeSend:function(){
                        waitingDialog.show('Veuillez patienter...');
                    },
                    dataType:'text',
                    data: formData,
                    processData: false,
                    cache: false,
                    contentType: false,
                    success:function(ret){
                         waitingDialog.hide();
                         if(ret==2){
                             alertify.alert('<?php echo $app_infos['Design_App']; ?>',"L'extension de l'image ne correspond pas !");
                         }else if(ret==3){
                             alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Le téléchargement de l'image a échoué !");
                         }else if(ret==1){
                             Toast.fire({
                                icon: 'success',
                                title: 'Enregistré'
                             })
                             window.location.replace('table_client.php');
                         }else{
                            alertify.alert(ret);
                         }

                    }
                });
        }
    });





  });
    </script>
</body>