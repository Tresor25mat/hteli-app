<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    $ID=$_GET['ID'];
    $req_rapport=$pdo->query("SELECT * FROM table_rapport_journalier INNER JOIN site ON table_rapport_journalier.ID_Site=site.ID_Site INNER JOIN province ON site.ID_Prov=province.ID_Prov WHERE table_rapport_journalier.ID_Rapport=".$ID);
    $rapports=$req_rapport->fetch();
    $titre=$pdo->query("SELECT * FROM table_titre ORDER BY Code_Titre");
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();
?>
<!DOCTYPE html>
<html lang="fr-FR">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Affichage rapport | <?php echo $app_infos['Design_App']; ?></title>
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
        <div class="container-xl">
          <!-- Page title -->
          <input type="hidden" name="User" id="User" value="<?php if(isset($_GET['User']) && $_GET['User']!=''){echo $_GET['User']; } ?>">
            <input type="hidden" name="nocTicket" id="nocTicket" value="<?php if(isset($_GET['nocTicket']) && $_GET['nocTicket']!=''){echo $_GET['nocTicket']; } ?>">
            <input type="hidden" name="siteId" id="siteId" value="<?php if(isset($_GET['siteId']) && $_GET['siteId']!=''){echo $_GET['siteId']; } ?>">
            <input type="hidden" name="dateRapport" id="dateRapport" value="<?php if(isset($_GET['dateRapport']) && $_GET['dateRapport']!=''){echo $_GET['dateRapport']; } ?>">
          <!-- <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">
              <div class="col">
                Page pre-title
                <div class="page-pretitle">
                  
                </div>
                <h2 class="page-title">
                  Affichage rapport
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
            <div class="col-md-4" style="border: 1px solid #E6E7E9; padding: 10px">
                <div class="card">
                  <div class="card-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                      <thead>
                          <tr style="display: none">
                              <th>#</th>
                              <th>Titre</th>
                          </tr>
                      </thead>
                      <tbody id="MaTable">
                      <?php while($titres=$titre->fetch()){ 
                        $sous_titre=$pdo->query("SELECT * FROM table_sous_titre WHERE ID_Titre=".$titres['ID_Titre']." ORDER BY Code_Sous_Titre");
                        while($sous_titres=$sous_titre->fetch()){ 
                      ?>
                      <tr class="odd gradeX" style="background: transparent; cursor: pointer;" onclick="afficher_image(<?php echo ($sous_titres['ID_Sous_Titre']); ?>, <?php echo ($ID); ?>)">
                          <td style="width: 80px; "><center><?php echo $titres['Code_Titre'].'.'.$sous_titres['Code_Sous_Titre'].'.'; ?></center></td>
                          <td style="width: 500px; "><!-- <center> --><?php echo strtoupper(stripslashes($sous_titres['Design_Sous_Titre'])); ?></td>
                      </tr>
                    <?php }} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-8" style="border: 1px solid #E6E7E9; padding: 10px">
                <div class="card">
                  <div class="card-body">
                  <iframe src="afficher_image.php?ID=<?php echo $ID; ?>" style="width: 100%; height: 800px; border: none; background-color: #FFFFFF" id="iframe"></iframe>
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
    $(document).ready(function() {
    });
    $('#retour_table').click(function(e){
        e.preventDefault();
        let dateRapport = $('#dateRapport').val();
        dateRap = dateRapport.replace(/\//g, "-");
        window.location.replace('table_rapport.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&nocTicket='+$('#nocTicket').val()+'&dateRapport='+dateRap);
    })
    function afficher_image(a, b){
        $('#iframe').attr('src', 'afficher_image.php?ID='+b+'&Titre='+a);
    }
    </script>
</body>