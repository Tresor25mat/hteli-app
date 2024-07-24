<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    $query="SELECT * FROM table_rapport_rectifier INNER JOIN site ON table_rapport_rectifier.ID_Site=site.ID_Site INNER JOIN province ON site.ID_Prov=province.ID_Prov WHERE table_rapport_rectifier.ID_Rapport!=0";
    if(isset($_GET['User']) && $_GET['User']!=''){
        $query.=" AND table_rapport_rectifier.ID_Utilisateur=".$_GET['User'];
    }
    if(isset($_GET['RectifierMake']) && $_GET['RectifierMake']!=''){
        $query.=" AND table_rapport_rectifier.ID_Rectifier_Make=".$_GET['RectifierMake'];
    }
    if(isset($_GET['siteId']) && $_GET['siteId']!=''){
        $query.=" AND UCASE(site.Site_ID) LIKE '%".strtoupper($_GET['siteId'])."%'";
    }
    if(isset($_GET['dateRapport']) && $_GET['dateRapport']!=''){
        $query.=" AND table_rapport_rectifier.Date_Rapport='".date('Y-m-d', strtotime($_GET['dateRapport']))."'";
    }
    $query.=" ORDER BY table_rapport_rectifier.Date_Rapport";
    $req=$pdo->query($query);
    $Total=$req->rowCount();
    $totalparpage=10;
    $pagesTotales=ceil($Total/$totalparpage);
    if (isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page']<=$pagesTotales) {
        $_GET['page'] = intval($_GET['page']);
        $pageCourante=$_GET['page'];
    } else{
        $pageCourante=1;
    }
    $depart=($pageCourante-1)*$totalparpage;
    $query.=" LIMIT ".$depart.",".$totalparpage;
    $selection=$pdo->query($query);
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();
    $Nbr=0;
?>
<!DOCTYPE html>
<html lang="fr-FR">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Sites | <?php echo $app_infos['Design_App']; ?></title>
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
      #btn_download:hover {
            border: 2px solid #F5F7FB;
            background-color: #F5F7FB;
      }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" style="overflow-y: hidden;">
    <div class="page">
      <div class="page-wrapper">
      <div class="text-muted mt-1">

<?php if($Total!=0){ 
        if($totalparpage<$Total){
            if($depart+$totalparpage<$Total){

    ?>
        Affiche de <?php echo $depart+1; ?> à <?php echo $depart+$totalparpage; ?> sur <?php echo $Total; ?> enregistrements
        <?php }else{ ?>
            Affiche de <?php echo $depart+1; ?> à <?php echo $Total; ?> sur <?php echo $Total; ?> enregistrements
<?php }}else{ ?>
    Affiche de <?php echo $depart+1; ?> à <?php echo $Total; ?> sur <?php echo $Total; ?> enregistrements
<?php }}else{ ?>
    Affiche de 0 à 0 sur 0 enregistrements
<?php } ?>

</div>
        <div class="page-body">
          <div class="container-xl" style="border: 1px solid #E6E7E9">
            <div class="row row-deck row-cards">
            <input type="hidden" name="User" id="User" value="<?php if(isset($_GET['User']) && $_GET['User']!=''){echo $_GET['User']; } ?>">
            <input type="hidden" name="RectifierMake" id="RectifierMake" value="<?php if(isset($_GET['RectifierMake']) && $_GET['RectifierMake']!=''){echo $_GET['RectifierMake']; } ?>">
            <input type="hidden" name="siteId" id="siteId" value="<?php if(isset($_GET['siteId']) && $_GET['siteId']!=''){echo $_GET['siteId']; } ?>">
            <input type="hidden" name="dateRapport" id="dateRapport" value="<?php if(isset($_GET['dateRapport']) && $_GET['dateRapport']!=''){echo $_GET['dateRapport']; } ?>">
                <!-- <div class="col-md-12 col-lg-12"> -->
                    <!-- <div class="panel panel-default"> -->
                        <!-- <div class="panel-body"> -->
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Site ID & Name</th>
                                        <th>Province</th>
                                        <th>Work Order No</th>
                                        <th>Date</th>
                                        <th>Time In</th>
                                        <th>Time Out</th>
                                        <th>Opérations</th>
                                    </tr>
                                </thead>
                                <tbody id="MaTable">
    <?php while($selections=$selection->fetch()){$Nbr++; ?>
        <tr class="odd gradeX" style="background: transparent;">
            <td style="width: 80px; "><center><?php echo sprintf('%02d', $Nbr); ?></center></td>
            <td><!-- <center> --><?php echo strtoupper(stripslashes($selections['Site_ID'].' - '.$selections['Site_Name'])); ?></td>
            <td><!-- <center> --><?php echo strtoupper(stripslashes($selections['Design_Prov'])); ?></td>
            <td><!-- <center> --><?php echo strtoupper(stripslashes($selections['Num_Work_Order'])); ?></td>
            <td><!-- <center> --><?php echo date('d/m/Y', strtotime($selections['Date_Rapport'])); ?></td>
            <td><!-- <center> --><?php echo date('H:i', strtotime($selections['Time_In'])); ?></td>
            <td><!-- <center> --><?php echo date('H:i', strtotime($selections['Time_Out'])); ?></td>
            <td><center>
                <?php if($selections['Fichier']!=''){ ?><a href="documents/<?php echo($selections['Fichier']) ?>" id="btn_download" title="Télécharger la pièce jointe" style="margin-right: 5px; width: 30px; border-radius: 0; border: 2px solid #DEE0E6" class="btn btn-default" download><i class="fa fa-download fa-fw"></i></a><?php } ?>
                <a href="rectifier_and_storage_battery_maintenance_checklist.php?Rapport=<?php echo($selections['ID_Rapport']) ?>" title="Imprimer" style="margin-right: 5px; width: 30px; border-radius: 0" class="btn btn-success"><i class="fa fa-print fa-fw"></i></a>
                <a href="modifier_rapport_rectifier.php?ID=<?php echo($selections['ID_Rapport']) ?>&User=<?php if(isset($_GET['User']) && $_GET['User']!=''){echo $_GET['User']; } ?>&siteId=<?php if(isset($_GET['siteId']) && $_GET['siteId']!=''){echo $_GET['siteId']; } ?>&RectifierMake=<?php if(isset($_GET['RectifierMake']) && $_GET['RectifierMake']!=''){echo $_GET['RectifierMake']; } ?>&dateRapport=<?php if(isset($_GET['dateRapport']) && $_GET['dateRapport']!=''){echo $_GET['dateRapport']; } ?>" title="Modifier" style="margin-right: 5px; width: 25px; border-radius: 0;" class="btn btn-primary"><i class="fa fa-edit fa-fw"></i></a>
                <?php if($_SESSION['user_eteelo_app']['ID_Statut']==1){ ?>
                <a style="width: 25px; border-radius: 0;" class="btn btn-danger" href="javascript: alertify.confirm('Voulez-vous vraiment supprimer cet enregistrement?\n Toutes les informations concernant cet enregistrement seront supprimées!').set('onok',function(closeEvent){window.location.replace('suppr_rapport_rectifier.php?ID=<?php echo($selections['ID_Rapport']) ?>&token=<?php echo($_SESSION['user_eteelo_app']['token']) ?>&User=<?php if(isset($_GET['User']) && $_GET['User']!=''){echo $_GET['User']; } ?>&siteId=<?php if(isset($_GET['siteId']) && $_GET['siteId']!=''){echo $_GET['siteId']; } ?>&RectifierMake=<?php if(isset($_GET['RectifierMake']) && $_GET['RectifierMake']!=''){echo $_GET['RectifierMake']; } ?>&dateRapport=<?php if(isset($_GET['dateRapport']) && $_GET['dateRapport']!=''){echo $_GET['dateRapport']; } ?>&Fichier=<?php echo($selections['Fichier']) ?>');alertify.success('suppression éffectuée');}).set('oncancel',function(closeEvent){alertify.error('suppression annulée');}).set({title:''},{labels:{ok:'Oui', cancel:'Annuler'}});" title="Supprimer"><i class="fa fa-trash-o fa-fw"></i></a></center>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</tbody>
                            </table>
                            <div class="d-flex mt-4">
              <ul class="pagination ms-auto">
                                <?php 
                                if($pageCourante>1){
                                    $page=$pageCourante-1;
                                    echo '<li class="page-item"><a class="page-link" href="table_rapport_rectifier.php?page='.$page.'&User='.$_GET['User'].'&siteId='.$_GET['siteId'].'&RectifierMake='.$_GET['RectifierMake'].'&dateRapport='.$_GET['dateRapport'].'"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>Previous</a></li>';
                                }else{
                                    echo '<li class="page-item disabled"><a class="page-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>Previous</a></li>';
                                }
                                if($pagesTotales>3){
                                    $pagePrecedente=$pageCourante-1;
                                    $pageNexte=$pageCourante+1;
                                    $pageTrois=$pageCourante+2;
                                    $pageAvantPrecedente=$pageCourante-2;
                                    $pagesAvantTotales=$pagesTotales-1;
                                    if($pageCourante==1){
                                        echo '<li class="page-item"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="table_rapport_rectifier.php?page='.$pageNexte.'&User='.$_GET['User'].'&siteId='.$_GET['siteId'].'&RectifierMake='.$_GET['RectifierMake'].'&dateRapport='.$_GET['dateRapport'].'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="table_rapport_rectifier.php?page='.$pageTrois.'&User='.$_GET['User'].'&siteId='.$_GET['siteId'].'&RectifierMake='.$_GET['RectifierMake'].'&dateRapport='.$_GET['dateRapport'].'">'.$pageTrois.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    }else if($pageCourante==2){
                                        echo '<li class="page-item"><a class="page-link" href="table_rapport_rectifier.php?page='.$pagePrecedente.'&User='.$_GET['User'].'&siteId='.$_GET['siteId'].'&RectifierMake='.$_GET['RectifierMake'].'&dateRapport='.$_GET['dateRapport'].'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_rapport_rectifier.php?page='.$pageNexte.'&User='.$_GET['User'].'&siteId='.$_GET['siteId'].'&RectifierMake='.$_GET['RectifierMake'].'&dateRapport='.$_GET['dateRapport'].'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    }else if($pageCourante==$pagesAvantTotales){
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_rapport_rectifier.php?page='.$pagePrecedente.'&User='.$_GET['User'].'&siteId='.$_GET['siteId'].'&RectifierMake='.$_GET['RectifierMake'].'&dateRapport='.$_GET['dateRapport'].'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_rapport_rectifier.php?page='.$pageNexte.'&User='.$_GET['User'].'&siteId='.$_GET['siteId'].'&RectifierMake='.$_GET['RectifierMake'].'&dateRapport='.$_GET['dateRapport'].'">'.$pageNexte.'</a></li>';
                                    }else if($pageCourante==$pagesTotales){
                                            echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_rapport_rectifier.php?page='.$pageAvantPrecedente.'&User='.$_GET['User'].'&siteId='.$_GET['siteId'].'&RectifierMake='.$_GET['RectifierMake'].'&dateRapport='.$_GET['dateRapport'].'">'.$pageAvantPrecedente.'</a></li><li class="page-item"><a class="page-link" href="table_rapport_rectifier.php?page='.$pagePrecedente.'&User='.$_GET['User'].'&siteId='.$_GET['siteId'].'&RectifierMake='.$_GET['RectifierMake'].'&dateRapport='.$_GET['dateRapport'].'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li>';
                                    }else{
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_rapport_rectifier.php?page='.$pagePrecedente.'&User='.$_GET['User'].'&siteId='.$_GET['siteId'].'&RectifierMake='.$_GET['RectifierMake'].'&dateRapport='.$_GET['dateRapport'].'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_rapport_rectifier.php?page='.$pageNexte.'&User='.$_GET['User'].'&siteId='.$_GET['siteId'].'&RectifierMake='.$_GET['RectifierMake'].'&dateRapport='.$_GET['dateRapport'].'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>'; 
                                    }
                                }else{
                                    for ($i=1; $i <= $pagesTotales ; $i++) { 
                                        if ($i==$pageCourante) {
                                            echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                                        }else{
                                            echo '<li class="page-item"><a class="page-link" href="table_rapport_rectifier.php?page='.$i.'&User='.$_GET['User'].'&siteId='.$_GET['siteId'].'&RectifierMake='.$_GET['RectifierMake'].'&dateRapport='.$_GET['dateRapport'].'">'.$i.'</a></li>';
                                        }
                                    } 
                                }
                                if($pagesTotales>$pageCourante){
                                    $page=$pageCourante+1;
                                    echo '<li class="page-item"><a class="page-link" href="table_rapport_rectifier.php?page='.$page.'&User='.$_GET['User'].'&siteId='.$_GET['siteId'].'&RectifierMake='.$_GET['RectifierMake'].'&dateRapport='.$_GET['dateRapport'].'">Next<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg></a></li>';
                                }else{
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