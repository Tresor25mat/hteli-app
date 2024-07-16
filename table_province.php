<?php
session_start();
$_SESSION['last_activity'] = time();
if (empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app'] == false) {
    header("location: connexion");
}
require_once ('connexion.php');
$query = "SELECT * FROM province INNER JOIN pays ON province.ID_Pays=pays.ID_Pays WHERE province.ID_Prov!=0";
if (isset($_GET['Pays']) && $_GET['Pays'] != '') {
    $query .= " AND province.ID_Pays=" . $_GET['Pays'];
}
$query .= " ORDER BY province.Design_Prov";
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
    <title>Provinces | <?php echo $app_infos['Design_App']; ?></title>
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
            <input type="hidden" name="Pays" id="Pays" value="<?php if (isset($_GET['Pays']) && $_GET['Pays'] != '') {
                echo $_GET['Pays'];
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
                <!-- <div class="col-md-12 col-lg-12"> -->
                    <!-- <div class="panel panel-default"> -->
                        <!-- <div class="panel-body"> -->
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Province</th>
                                        <th>Pays</th>
                                        <th>Opérations</th>
                                    </tr>
                                </thead>
                                <tbody id="MaTable">
    <?php while ($selections = $selection->fetch()) {
        $Nbr++;
        ?>
            <tr class="odd gradeX" style="background: transparent;">
                <td style="width: 80px; "><center><?php echo sprintf('%02d', $Nbr); ?></center></td>
                <td><!-- <center> --><?php echo strtoupper(stripslashes($selections['Design_Prov'])); ?></td>
                <td><!-- <center> --><?php echo strtoupper(stripslashes($selections['Design_Pays'])); ?></td>
                <td><center>
                    <a href="modifier_province.php?ID=<?php echo ($selections['ID_Prov']) ?>&Pays=<?php if (isset($_GET['Pays']) && $_GET['Pays'] != '') {
                          echo $_GET['Pays'];
                      } ?>" title="Modifier" style="margin-right: 5px; width: 25px; border-radius: 0;" class="btn btn-primary"><i class="fa fa-edit fa-fw"></i></a>
                    <?php if ($_SESSION['user_eteelo_app']['ID_Statut'] == 1) { ?>
                        <a style="width: 25px; border-radius: 0;" class="btn btn-danger" href="javascript: alertify.confirm('Voulez-vous vraiment supprimer cet enregistrement?\n Toutes les informations concernant cet enregistrement seront supprimées!').set('onok',function(closeEvent){window.location.replace('suppr_province.php?ID=<?php echo ($selections['ID_Prov']) ?>&token=<?php echo ($_SESSION['user_eteelo_app']['token']) ?>&Pays=<?php if (isset($_GET['Pays']) && $_GET['Pays'] != '') {
                                echo $_GET['Pays'];
                            } ?>');alertify.success('suppression éffectuée');}).set('oncancel',function(closeEvent){alertify.error('suppression annulée');}).set({title:''},{labels:{ok:'Oui', cancel:'Annuler'}});" title="Supprimer"><i class="fa fa-trash-o fa-fw"></i></a></center>
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
                                    echo '<li class="page-item"><a class="page-link" href="table_province.php?page=' . $page . '&Pays=' . $_GET['Pays'] . '"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>Previous</a></li>';
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
                                        echo '<li class="page-item"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="table_province.php?page=' . $pageNexte . '&Pays=' . $_GET['Pays'] . '">' . $pageNexte . '</a></li><li class="page-item"><a class="page-link" href="table_province.php?page=' . $pageTrois . '&Pays=' . $_GET['Pays'] . '">' . $pageTrois . '</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    } else if ($pageCourante == 2) {
                                        echo '<li class="page-item"><a class="page-link" href="table_province.php?page=' . $pagePrecedente . '&Pays=' . $_GET['Pays'] . '">' . $pagePrecedente . '</a></li><li class="page-item active"><a class="page-link" href="#">' . $pageCourante . '</a></li><li class="page-item"><a class="page-link" href="table_province.php?page=' . $pageNexte . '&Pays=' . $_GET['Pays'] . '">' . $pageNexte . '</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    } else if ($pageCourante == $pagesAvantTotales) {
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_province.php?page=' . $pagePrecedente . '&Pays=' . $_GET['Pays'] . '">' . $pagePrecedente . '</a></li><li class="page-item active"><a class="page-link" href="#">' . $pageCourante . '</a></li><li class="page-item"><a class="page-link" href="table_province.php?page=' . $pageNexte . '&Pays=' . $_GET['Pays'] . '">' . $pageNexte . '</a></li>';
                                    } else if ($pageCourante == $pagesTotales) {
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_province.php?page=' . $pageAvantPrecedente . '&Pays=' . $_GET['Pays'] . '">' . $pageAvantPrecedente . '</a></li><li class="page-item"><a class="page-link" href="table_province.php?page=' . $pagePrecedente . '&Pays=' . $_GET['Pays'] . '">' . $pagePrecedente . '</a></li><li class="page-item active"><a class="page-link" href="#">' . $pageCourante . '</a></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_province.php?page=' . $pagePrecedente . '&Pays=' . $_GET['Pays'] . '">' . $pagePrecedente . '</a></li><li class="page-item active"><a class="page-link" href="#">' . $pageCourante . '</a></li><li class="page-item"><a class="page-link" href="table_province.php?page=' . $pageNexte . '&Pays=' . $_GET['Pays'] . '">' . $pageNexte . '</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    }
                                } else {
                                    for ($i = 1; $i <= $pagesTotales; $i++) {
                                        if ($i == $pageCourante) {
                                            echo '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
                                        } else {
                                            echo '<li class="page-item"><a class="page-link" href="table_province.php?page=' . $i . '&Pays=' . $_GET['Pays'] . '">' . $i . '</a></li>';
                                        }
                                    }
                                }
                                if ($pagesTotales > $pageCourante) {
                                    $page = $pageCourante + 1;
                                    echo '<li class="page-item"><a class="page-link" href="table_province.php?page=' . $page . '&Pays=' . $_GET['Pays'] . '">Next<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg></a></li>';
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
    </script>
</body>