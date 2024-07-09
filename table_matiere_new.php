<?php
session_start();
$_SESSION['last_activity'] = time();
if (empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app'] == false) {
    header("location: connexion");
}
require_once ('connexion.php');
$query = "SELECT * FROM table_titre_new WHERE ID_Titre!=0";
if (isset($_GET['titleName']) && $_GET['titleName'] != '') {
    $query .= " AND UCASE(Design_Titre) LIKE '%" . strtoupper($_GET['titleName']) . "%'";
}
$query .= " ORDER BY Code_Titre";
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
?>
<!DOCTYPE html>
<html lang="fr-FR">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Table des matières | <?php echo $app_infos['Design_App']; ?></title>
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
      .alertify .ajs-dialog {
        top: 15%;
        transform: translateY(-50%);
        margin: auto;
      }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" style="overflow-y: hidden;">
    <div class="page">
      <div class="page-wrapper">
      <div class="text-muted mt-1">

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
        <div class="page-body">
          <div class="container-xl" style="border: 1px solid #E6E7E9">
            <div class="row row-deck row-cards">
            <input type="hidden" name="ID_Titre" id="ID_Titre">
            <input type="hidden" name="ID_STitre" id="ID_STitre">
            <input type="hidden" name="titleName" id="titleName" value="<?php if (isset($_GET['titleName']) && $_GET['titleName'] != '') {
                echo $_GET['titleName'];
            } ?>">
                <!-- <div class="col-md-12 col-lg-12"> -->
                    <!-- <div class="panel panel-default"> -->
                        <!-- <div class="panel-body"> -->
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Titre</th>
                                        <th>Nombre des photos</th>
                                        <th>Opérations</th>
                                    </tr>
                                </thead>
                                <tbody id="MaTable">
    <?php while ($selections = $selection->fetch()) {
        $table_stitre = $pdo->query("SELECT * FROM table_sous_titre_new WHERE ID_Titre=" . $selections['ID_Titre']);
        ?>
            <tr class="odd gradeX" style="background: transparent;">
                <td style="width: 80px; font-weight: bold"><center><?php echo $selections['Code_Titre'] . '.'; ?></center></td>
                <td style="width: 500px; font-weight: bold"><!-- <center> --><?php echo strtoupper(stripslashes($selections['Design_Titre'])); ?></td>
                <td style="width: 80px; "></td>
                <td style="padding-left: 120px; ">
                    <?php if ($_SESSION['user_eteelo_app']['ID_Statut'] == 1 || $_SESSION['user_eteelo_app']['ID_Statut'] == 2) { ?>
                        <a href="#" onclick="Function_Ajouter(<?php echo ($selections['ID_Titre']); ?>)" title="Ajouter un sous-titre" style="margin-right: 5px; width: 25px; border-radius: 0;" class="btn btn-success"><i class="fa fa-plus fa-fw"></i></a>
                        <a href="#" onclick="Function_Modifier(<?php echo ($selections['ID_Titre']); ?>, '<?php echo (stripslashes($selections['Design_Titre'])); ?>')" title="Modifier" style="margin-right: 5px; width: 25px; border-radius: 0;" class="btn btn-primary"><i class="fa fa-edit fa-fw"></i></a>
                    <?php }
                    if ($_SESSION['user_eteelo_app']['ID_Statut'] == 1) { ?>
                        <a style="width: 25px; border-radius: 0;" class="btn btn-danger" href="javascript: alertify.confirm('Voulez-vous vraiment supprimer cet enregistrement?\n Toutes les informations concernant cet enregistrement seront supprimées!').set('onok',function(closeEvent){window.location.replace('suppr_titre_new.php?ID=<?php echo ($selections['ID_Titre']) ?>&token=<?php echo ($_SESSION['user_eteelo_app']['token']) ?>&titleName=<?php if (isset($_GET['titleName']) && $_GET['titleName'] != '') {
                                echo $_GET['titleName'];
                            } ?>');alertify.success('suppression éffectuée');}).set('oncancel',function(closeEvent){alertify.error('suppression annulée');}).set({title:''},{labels:{ok:'Oui', cancel:'Annuler'}});" title="Supprimer"><i class="fa fa-trash-o fa-fw"></i></a>
                    <?php } ?>
                </td>
            </tr>
            <?php while ($table_stitres = $table_stitre->fetch()) { ?>
                    <tr class="odd gradeX" style="background: transparent;">
                    <td style="width: 80px; "><center><?php echo $selections['Code_Titre'] . '.' . $table_stitres['Code_Sous_Titre'] . '.'; ?></center></td>
                    <td style="width: 500px; "><!-- <center> --><?php echo strtoupper(stripslashes($table_stitres['Design_Sous_Titre'])); ?></td>
                    <td style="width: 80px; "><center><?php echo $table_stitres['Nombre_Photo']; ?></center></td>
                    <td style="padding-left: 120px; ">
                        <?php if ($_SESSION['user_eteelo_app']['ID_Statut'] == 1 || $_SESSION['user_eteelo_app']['ID_Statut'] == 2) { ?>
                            <a href="#" onclick="Function_Modifier_Stitre(<?php echo ($table_stitres['ID_Sous_Titre']); ?>, <?php echo ($selections['ID_Titre']); ?>, '<?php echo (stripslashes($table_stitres['Design_Sous_Titre'])); ?>', <?php echo ($table_stitres['Nombre_Photo']); ?>)" title="Modifier" style="margin-right: 5px; width: 25px; border-radius: 0;" class="btn btn-primary"><i class="fa fa-edit fa-fw"></i></a>
                        <?php }
                        if ($_SESSION['user_eteelo_app']['ID_Statut'] == 1) { ?>
                            <a style="width: 25px; border-radius: 0;" class="btn btn-danger" href="javascript: alertify.confirm('Voulez-vous vraiment supprimer cet enregistrement?\n Toutes les informations concernant cet enregistrement seront supprimées!').set('onok',function(closeEvent){window.location.replace('suppr_stitre_new.php?ID=<?php echo ($table_stitres['ID_Sous_Titre']) ?>&token=<?php echo ($_SESSION['user_eteelo_app']['token']) ?>&titleName=<?php if (isset($_GET['titleName']) && $_GET['titleName'] != '') {
                                    echo $_GET['titleName'];
                                } ?>');alertify.success('suppression éffectuée');}).set('oncancel',function(closeEvent){alertify.error('suppression annulée');}).set({title:''},{labels:{ok:'Oui', cancel:'Annuler'}});" title="Supprimer"><i class="fa fa-trash-o fa-fw"></i></a>
                        <?php } ?>
                    </td>
                </tr>
        <?php }
    } ?>
</tbody>
                            </table>
                            <div class="d-flex mt-4">
              <ul class="pagination ms-auto">
                                <?php
                                if ($pageCourante > 1) {
                                    $page = $pageCourante - 1;
                                    echo '<li class="page-item"><a class="page-link" href="table_matiere_new.php?page=' . $page . '&titleName=' . $_GET['titleName'] . '"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>Previous</a></li>';
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
                                        echo '<li class="page-item"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="table_matiere_new.php?page=' . $pageNexte . '&titleName=' . $_GET['titleName'] . '">' . $pageNexte . '</a></li><li class="page-item"><a class="page-link" href="table_matiere_new.php?page=' . $pageTrois . '&titleName=' . $_GET['titleName'] . '">' . $pageTrois . '</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    } else if ($pageCourante == 2) {
                                        echo '<li class="page-item"><a class="page-link" href="table_matiere_new.php?page=' . $pagePrecedente . '&titleName=' . $_GET['titleName'] . '">' . $pagePrecedente . '</a></li><li class="page-item active"><a class="page-link" href="#">' . $pageCourante . '</a></li><li class="page-item"><a class="page-link" href="table_matiere_new.php?page=' . $pageNexte . '&titleName=' . $_GET['titleName'] . '">' . $pageNexte . '</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    } else if ($pageCourante == $pagesAvantTotales) {
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_matiere_new.php?page=' . $pagePrecedente . '&titleName=' . $_GET['titleName'] . '">' . $pagePrecedente . '</a></li><li class="page-item active"><a class="page-link" href="#">' . $pageCourante . '</a></li><li class="page-item"><a class="page-link" href="table_matiere_new.php?page=' . $pageNexte . '&titleName=' . $_GET['titleName'] . '">' . $pageNexte . '</a></li>';
                                    } else if ($pageCourante == $pagesTotales) {
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_matiere_new.php?page=' . $pageAvantPrecedente . '&titleName=' . $_GET['titleName'] . '">' . $pageAvantPrecedente . '</a></li><li class="page-item"><a class="page-link" href="table_matiere_new.php?page=' . $pagePrecedente . '&titleName=' . $_GET['titleName'] . '">' . $pagePrecedente . '</a></li><li class="page-item active"><a class="page-link" href="#">' . $pageCourante . '</a></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_matiere_new.php?page=' . $pagePrecedente . '&titleName=' . $_GET['titleName'] . '">' . $pagePrecedente . '</a></li><li class="page-item active"><a class="page-link" href="#">' . $pageCourante . '</a></li><li class="page-item"><a class="page-link" href="table_matiere_new.php?page=' . $pageNexte . '&titleName=' . $_GET['titleName'] . '">' . $pageNexte . '</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    }
                                } else {
                                    for ($i = 1; $i <= $pagesTotales; $i++) {
                                        if ($i == $pageCourante) {
                                            echo '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
                                        } else {
                                            echo '<li class="page-item"><a class="page-link" href="table_matiere_new.php?page=' . $i . '&titleName=' . $_GET['titleName'] . '">' . $i . '</a></li>';
                                        }
                                    }
                                }
                                if ($pagesTotales > $pageCourante) {
                                    $page = $pageCourante + 1;
                                    echo '<li class="page-item"><a class="page-link" href="table_matiere_new.php?page=' . $page . '&titleName=' . $_GET['titleName'] . '">Next<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg></a></li>';
                                } else {
                                    echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Next<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg></a></li>';
                                }

                                ?>
              </ul>
            </div>
                        <!-- </div> -->
                    <!-- </div> -->
                    <!-- /.panel -->
                <!-- </div> -->

            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="ModalModTitre" class="modal fade" data-backdrop="static" style="margin-top: 100px">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modification d'un titre</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok" type="hidden" name="tok" value="<?php echo ($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-lg-12">Désignation *</div>
                            <div class="col-lg-12">
                                <!-- <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="border-top-right-radius: 0; border-bottom-right-radius: 0; border-right: none; margin-top: 5px; height: 37px"><i class="fa fa-map-marker"></i></span>
                                    </div> -->
                                    <input type="text" name="designTitre" id="designTitre" class="form-control" style="margin-top: 1%; height: 37px" value="">
                                <!-- </div>  -->
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enregistrertitre">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialoguetitre()">Annuler</button>
            </div>
            </div>
        </div>
    </div>
    <div id="ModalAjoutSTitre" class="modal fade" data-backdrop="static" style="margin-top: 70px">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nouveau sous titre</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok" type="hidden" name="tok" value="<?php echo ($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-lg-12">Désignation *</div>
                            <div class="col-lg-12">
                                <!-- <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="border-top-right-radius: 0; border-bottom-right-radius: 0; border-right: none; margin-top: 5px; height: 37px"><i class="fa fa-map-marker"></i></span>
                                    </div> -->
                                    <input type="text" name="designSTitre" id="designSTitre" class="form-control" style="margin-top: 1%; height: 37px" value="">
                                <!-- </div>  -->
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-lg-12">Nombre des photos *</div>
                            <div class="col-lg-12">
                                <!-- <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="border-top-right-radius: 0; border-bottom-right-radius: 0; border-right: none; margin-top: 5px; height: 37px"><i class="fa fa-map-marker"></i></span>
                                    </div> -->
                                    <input type="number" name="NombrePhoto" id="NombrePhoto" class="form-control" style="margin-top: 1%; height: 37px" min="0" max="10" step="1">
                                <!-- </div>  -->
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enregistrerstitre">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialoguestitre()">Annuler</button>
            </div>
            </div>
        </div>
    </div>
    <div id="ModalModSTitre" class="modal fade" data-backdrop="static" style="margin-top: 70px">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modification sous titre</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok" type="hidden" name="tok" value="<?php echo ($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-lg-12">Désignation *</div>
                            <div class="col-lg-12">
                                <!-- <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="border-top-right-radius: 0; border-bottom-right-radius: 0; border-right: none; margin-top: 5px; height: 37px"><i class="fa fa-map-marker"></i></span>
                                    </div> -->
                                    <input type="text" name="designSTitreMod" id="designSTitreMod" class="form-control" style="margin-top: 1%; height: 37px" value="">
                                <!-- </div>  -->
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-lg-12">Nombre des photos *</div>
                            <div class="col-lg-12">
                                <!-- <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="border-top-right-radius: 0; border-bottom-right-radius: 0; border-right: none; margin-top: 5px; height: 37px"><i class="fa fa-map-marker"></i></span>
                                    </div> -->
                                    <input type="number" name="NombrePhotoMod" id="NombrePhotoMod" class="form-control" style="margin-top: 1%; height: 37px" min="0" max="10" step="1">
                                <!-- </div>  -->
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enregistrermodstitre">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialoguemodstitre()">Annuler</button>
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
    $(document).ready(function() {
    });
  function fermerDialoguetitre(){
        $("#ModalModTitre").modal('hide');
  }
  function fermerDialoguestitre(){
        $("#ModalAjoutSTitre").modal('hide');
  }
  function fermerDialoguemodstitre(){
        $("#ModalModSTitre").modal('hide');
  }
  function Function_Ajouter(a){
      $("#ModalAjoutSTitre").modal('show');
      $('#ID_Titre').val(a);
      $('#NombrePhoto').val('')
      $('#designSTitre').val('').focus();
  }
  function Function_Modifier_Stitre(a, b, c, d){
      $("#ModalModSTitre").modal('show');
      $('#ID_STitre').val(a);
      $('#ID_Titre').val(b);
      $('#NombrePhotoMod').val(d)
      $('#designSTitreMod').val(c).focus();
  }
  function Function_Modifier(a, b){
      $("#ModalModTitre").modal('show');
      $('#ID_Titre').val(a);
      $('#designTitre').val(b).focus();
  }

  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

    $('#enregistrertitre').click(function(){
        if($('#designTitre').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez saisir le titre svp!');
                $('#designTitre').focus();
        }else{
                $.ajax({
                        url:'edit_titre_new.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {Design:$('#designTitre').val(), token:$('#tok').val(), ID_Titre:$('#ID_Titre').val()},
                        success:function(ret){
                            if(ret==1){
                                alertify.success("L'opération a réussi");
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Modification éffectuée'
                                })
                                window.location.replace('table_matiere_new.php?titleName='+$('#titleName').val());
                            }else if(ret==2){
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Cette désignation existe déjà'); 
                            }else{
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>',ret); 
                            }
                        }
                    });
        }
    });
    $('#enregistrerstitre').click(function(){
        if($('#designSTitre').val()=='' || $('#NombrePhoto').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez saisir le sous titre et le nombre des photos svp!');
                $('#designSTitre').focus();
        }else{
                $.ajax({
                        url:'enreg_stitre_new.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {Design:$('#designSTitre').val(), Nombre:$('#NombrePhoto').val(), token:$('#tok').val(), ID_Titre:$('#ID_Titre').val()},
                        success:function(ret){
                            if(ret==1){
                                alertify.success("L'opération a réussi");
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Enregistrement éffectué'
                                })
                                window.location.replace('table_matiere_new.php?titleName='+$('#titleName').val());
                            }else if(ret==2){
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Cette désignation existe déjà'); 
                            }else{
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>',ret); 
                            }
                        }
                    });
        }
    });
    $('#enregistrermodstitre').click(function(){
        if($('#designSTitreMod').val()=='' || $('#NombrePhotoMod').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez saisir le sous titre et le nombre des photos svp!');
                $('#designSTitreMod').focus();
        }else{
                $.ajax({
                        url:'edit_stitre_new.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {Design:$('#designSTitreMod').val(), Nombre:$('#NombrePhotoMod').val(), token:$('#tok').val(), ID_STitre:$('#ID_STitre').val()},
                        success:function(ret){
                            if(ret==1){
                                alertify.success("L'opération a réussi");
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Modification éffectuée'
                                })
                                window.location.replace('table_matiere_new.php?titleName='+$('#titleName').val());
                            }else if(ret==2){
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Cette désignation existe déjà'); 
                            }else{
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>',ret); 
                            }
                        }
                    });
        }
    });
  });
    </script>
</body>