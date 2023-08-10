<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    if($_SESSION['user_eteelo_app']['Statut']=='Vendeur' || $_SESSION['user_eteelo_app']['Statut']=='Chef_Escale'){
        $vol=$pdo->query("SELECT * FROM table_vol INNER JOIN table_vol_date ON table_vol.ID_Vol=table_vol_date.ID_Vol INNER JOIN table_aeroport ON table_vol_date.ID_Aeroport_Depart=table_aeroport.ID_Aeroport INNER JOIN agence_ville ON table_aeroport.ID_Ville=agence_ville.ID_Ville WHERE YEARWEEK(table_vol_date.Date_Vol)=YEARWEEK(NOW()) AND agence_ville.ID_Agence=".$_SESSION['user_eteelo_app']['ID_Agence']." AND table_vol.Active=1 ORDER BY table_vol.ID_Jour");
    }else{
        $vol=$pdo->query("SELECT * FROM table_vol INNER JOIN table_vol_date ON table_vol.ID_Vol=table_vol_date.ID_Vol WHERE YEARWEEK(table_vol_date.Date_Vol)=YEARWEEK(NOW()) AND table_vol.Active=1 ORDER BY table_vol.ID_Jour");
    }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <script src="js/jquery.slimscroll.min.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="overflow-x: hidden;  padding-top: 10px">
<div class="wrapper">


  <!-- Content Wrapper. Contains page content -->
  <!-- <div class="content-wrapper"> -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="row">
                <div class="inner col-md-7">
                  <h3 style="margin-top: 10px; margin-left: 10px; font-size: 22px">ADT</h3>

                  <h6 style="margin-left: 10px; font-weight: bold; font-size: 14px" id="montant_adulte">0,00 USD</h6>
                </div>
                <div class="icon col-md-5">
                    <img src="images/male-adulte.png" style="width: 80px; margin-left: 28px; margin-top: 10px; margin-bottom: 10px; opacity: 0.3;">
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="row">
                <div class="inner col-md-7">
                  <h3 style="margin-top: 10px; margin-left: 10px; font-size: 22px">CHD</h3>

                  <h6 style="margin-left: 10px; font-weight: bold; font-size: 14px" id="montant_enfant">0,00 USD</h6>
                </div>
                <div class="icon col-md-5">
                    <img src="images/male-enfant.png" style="width: 80px; margin-left: 28px; margin-top: 10px; margin-bottom: 10px; opacity: 0.3;">
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="row">
                <div class="inner col-md-7">
                  <h3 style="margin-top: 10px; margin-left: 10px; font-size: 22px">INF</h3>

                  <h6 style="margin-left: 10px; font-weight: bold; font-size: 14px" id="montant_bebe">0,00 USD</h6>
                </div>
                <div class="icon col-md-5">
                    <img src="images/male-bebe.png" style="width: 80px; margin-left: 28px; margin-top: 10px; margin-bottom: 10px; opacity: 0.3;">
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="row">
                <div class="inner col-md-7">
                  <h3 style="margin-top: 10px; margin-left: 10px; font-size: 22px">TOTAL</h3>

                  <h6 style="margin-left: 10px; font-weight: bold; font-size: 14px" id="montant_total">0,00 USD</h6>
                </div>
                <div class="icon col-md-5">
                    <img src="images/dollar.png" style="width: 80px; margin-top: 29px; margin-bottom: 29px; opacity: 0.3;">
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <section class="col-lg-8 connectedSortable" style="border: 1px solid #0076C8; padding: 20px; overflow-y: scroll; margin-bottom: 20px; height: 550px">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th><h6 style="font-weight: bold; font-size: 14px;">Jour</h6></th>
                                        <th><h6 style="font-weight: bold; font-size: 14px;">Date du vol</h6></th>
                                        <th><h6 style="font-weight: bold; font-size: 14px;">Départ</h6></th>
                                        <th><h6 style="font-weight: bold; font-size: 14px;">Arrivée</h6></th>
                                        <th><h6 style="font-weight: bold; font-size: 14px;">Numéro vol</h6></th>
                                        <th><h6 style="font-weight: bold; font-size: 14px;">Heure départ</h6></th>
                                        <th><h6 style="font-weight: bold; font-size: 14px;">Heure arrivée</h6></th>
                                        <th><h6 style="font-weight: bold; font-size: 14px;">Capacité</h6></th>
                                    </tr>
                                </thead>
                                <tbody id="MaTable">
    <?php while($vols=$vol->fetch()){ 
            $depart=$pdo->query("SELECT * FROM ville INNER JOIN table_aeroport ON ville.ID_Ville=table_aeroport.ID_Ville WHERE table_aeroport.ID_Aeroport=".$vols['ID_Aeroport_Depart']);
            $departs=$depart->fetch();
            $arrivee=$pdo->query("SELECT * FROM ville INNER JOIN table_aeroport ON ville.ID_Ville=table_aeroport.ID_Ville WHERE table_aeroport.ID_Aeroport=".$vols['ID_Aeroport_Arrivee']);
            $arrivees=$arrivee->fetch();
            $avion=$pdo->query("SELECT * FROM avion WHERE ID_Avion=".$vols['ID_Avion']);
            $avions=$avion->fetch();
            $jour=$pdo->query("SELECT * FROM table_jour WHERE ID_Jour=".$vols['ID_Jour']);
            $jours=$jour->fetch();
            $place_disponible=$pdo->query("SELECT COUNT(*) AS Nbr FROM table_passager_vol INNER JOIN table_vente ON table_passager_vol.ID_Vente=table_vente.ID_Vente INNER JOIN table_client ON table_vente.ID_Client=table_client.ID_Client INNER JOIN table_vol_date ON table_passager_vol.ID_Vol_Date=table_vol_date.ID_Vol_Date WHERE table_vol_date.ID_Vol=".$vols['ID_Vol']." AND table_vente.Statut!=0 AND table_client.ID_Cat_Passager!=3 AND table_vol_date.Heure_Arrivee>='".$vols['Heure_Arrivee']."'");
            $place_disponibles=$place_disponible->fetch();
        ?>
        <tr class="odd gradeX">
            <td><h6 style="color: RGB(42,100,150); font-size: 14px;"><center><?php echo stripslashes($jours['Design_Jour']); ?></center></h6></td>
            <td><h6 style="color: RGB(42,100,150); font-size: 14px;"><center><?php echo date('d/m/Y', strtotime($vols['Date_Vol'])); ?></center></h6></td>
            <td><h6 style="color: RGB(42,100,150); font-size: 14px;"><center><?php echo stripslashes($departs['Cod_Ville']); ?></center></h6></td>
            <td><h6 style="color: RGB(42,100,150); font-size: 14px;"><center><?php echo stripslashes($arrivees['Cod_Ville']); ?></center></h6></td>
            <td><h6 style="color: RGB(42,100,150); font-size: 14px;"><center><?php echo stripslashes($vols['Num_Vol']); ?></center></h6></td>
            <td><h6 style="color: RGB(42,100,150); font-size: 14px;"><center><?php echo date('H:i', strtotime($vols['Heure_Depart'])); ?></center></h6></td>
            <td><h6 style="color: RGB(42,100,150); font-size: 14px;"><center><?php echo date('H:i', strtotime($vols['Heure_Arrivee'])); ?></center></h6></td>
            <td><h6 style="color: RGB(42,100,150); font-size: 14px;"><center><?php echo sprintf('%02d', $place_disponibles['Nbr']).'/'.sprintf('%02d', $vols['Nombre_Places']); ?></center></h6></td>
        </tr>
    <?php } ?>
</tbody>
                            </table>
          </section>
          <section class="col-lg-4 connectedSortable" style="margin-bottom: 20px">
            <div class="row">
              <div class="col-lg-12">
                <div style="border: 1px solid #0076C8; height: 87px;">
                  <center>
                  <h2 style="font-weight: bold; margin-top: 25px; font-size: 30px" id="mytime">00:00:00</h2>
                  </center>
                </div>
              </div>
              <div class="col-lg-12" id="calendrier">
                
              </div>
            </div>
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  <!-- </div> -->
  <!-- /.content-wrapper -->
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="js/jquery.nicescroll.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="js/scripts.js"></script>
<script src="dist/js/demo.js"></script>
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        rappel();
        $('#dataTables-example').DataTable({
            responsive: true
        });
        calendrier();
    });
    function somme_montant_adulte(){
        $.get("somme_montant_adulte.php", function(ret) {
            $('#montant_adulte').text(ret);
        });
    }
    function somme_montant_enfant(){
        $.get("somme_montant_enfant.php", function(ret) {
            $('#montant_enfant').text(ret);
        });
    }
    function somme_montant_bebe(){
        $.get("somme_montant_bebe.php", function(ret) {
            $('#montant_bebe').text(ret);
        });
    }
    function somme_montant_total(){
        $.get("somme_montant_total.php", function(ret) {
            $('#montant_total').text(ret);
        });
    }
    function calendrier(){
        $.get("calendrier.php", function(ret) {
            $('#calendrier').html(ret);
        });
    }
    function heure(){
        $.get("select_time.php", function(ret) {
            $('#mytime').text(ret);
        });
    }
    function rappel(){
      somme_montant_adulte();
      somme_montant_enfant();
      somme_montant_bebe();
      somme_montant_total();
      heure();
    }
    setInterval(rappel,1000);
</script>
</body>
</html>
