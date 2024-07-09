<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    $utilisateur=$pdo->query("SELECT * FROM utilisateur WHERE ID_Utilisateur!=1");
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();
?>
<!DOCTYPE html>
<html lang="fr-FR">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Rectifier & Storage Battery Maintenance | <?php echo $app_infos['Design_App']; ?></title>
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
    <link rel="stylesheet" type="text/css" href="vendor/jquery/jquery-ui.min.css" />
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
      .mybtn:hover{
         border: 2px solid #D9DBDE;
      }
      .mybtn:focus{
         border: 2px solid #D9DBDE;
      }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" style="overflow-x: hidden;">
    <div class="page">
      <div class="page-wrapper">
        <div class="container-xl">
          <!-- Page title -->
          <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  
                </div>
                <h2 class="page-title">
                Rectifier & Storage Battery Maintenance
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-12">
                <div class="row" style="border-bottom: 1px solid #EEEEEE; padding-bottom: 20px">
                <div class="col-md-2" style="<?php if($_SESSION['user_eteelo_app']['ID_Statut']==3){ echo 'display: none';} ?>">
                      <div class="form-group ">
                        <label for="utilisateur" class="control-label col-lg-12" style="text-align: left;">Utilisateur </label>
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-sm-12">
                                <select name="utilisateur" class="form-control" id="utilisateur" <?php if($_SESSION['user_eteelo_app']['ID_Statut']==3){ echo 'disabled';} ?>>
                                    <option value="">--</option>
                                    <?php while($utilisateurs=$utilisateur->fetch()){ ?>
                                    <option value="<?php echo($utilisateurs['ID_Utilisateur']) ?>" <?php if($_SESSION['user_eteelo_app']['ID_Statut']==3 && $utilisateurs['ID_Utilisateur']==$_SESSION['user_eteelo_app']['ID_Utilisateur']){ echo 'selected';}else if(isset($_GET['User']) && $_GET['User']!='' && $utilisateurs['ID_Utilisateur']==$_GET['User']){echo 'selected'; } ?>><?php echo(stripslashes($utilisateurs['Prenom'].' '.$utilisateurs['Nom'])) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group ">
                        <label for="siteId" class="control-label col-lg-12" style="text-align: left;">Site ID </label>
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="siteId" id="siteId" value="<?php if(isset($_GET['siteId']) && $_GET['siteId']!=''){echo $_GET['siteId']; } ?>">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group ">
                        <label for="dateRapport" class="control-label col-lg-12" style="text-align: left;">Date </label>
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-sm-12">
                                <input type="text" class="form-control date" name="dateRapport" id="dateRapport" value="<?php if(isset($_GET['dateRapport']) && $_GET['dateRapport']!=''){echo date('d/m/Y', strtotime($_GET['dateRapport'])); } ?>">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-1" style='margin-top: 20px; margin-bottom: 20px; margin-right: 20px'>
                      <button class="btn btn-default mybtn" type="button" id="btn_afficher" style="height: 32px; border-radius: 0; margin-top: 2px"><i class="fa fa-file-pdf-o" style="margin-right: 5px"></i>Aperçu</button>
                    </div>
                    <div class="col-md-2" style='margin-top: 20px; margin-bottom: 20px;'>
                      <button class="btn btn-default mybtn" type="button" id="btn_exporter" style="height: 32px; border-radius: 0; margin-top: 2px"><i class="fa fa-file-excel-o" style="margin-right: 5px"></i>Exporter vers Excel</button>
                    </div>
                  </div>


              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
            <iframe src="Dashio/accueil.php" style="width: 100%; height: 2302px; border: none;" id="iframe"></iframe>
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
    $('#utilisateur').change(function(){
        if($('#utilisateur').val()!=''){
            $('#btn_afficher').focus();
        }
    });

    $('#btn_afficher').click(function(){
        let dateRapport = $('#dateRapport').val();
        dateRap = dateRapport.replace(/\//g, "-");
        $('#iframe').attr('src', "rapport_rectifier_pdf.php?User="+$('#utilisateur').val()+'&siteId='+$('#siteId').val()+'&dateRapport='+dateRap);
})

$('#btn_exporter').click(function(){
    let dateRapport = $('#dateRapport').val();
        dateRap = dateRapport.replace(/\//g, "-");
        $('#iframe').attr('src', "rapport_rectifier_excel.php?User="+$('#utilisateur').val()+'&siteId='+$('#siteId').val()+'&dateRapport='+dateRap);
})

    $(function(){
            $(".date").datepicker({closeText:'fermer',prevText:'&#x3c;Préc',nextText:'Suiv&#x3e;',currentText:'Courant',dateFormat:"dd/mm/yy", minDate: "01/01/1990",monthNames:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aoùt","Septembre","Octobre","Novembre","Décembre"],monthNamesShort:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],dayNamesMin:["Dim","Lun","Mar","Mer","Jeu","Ven","Sam"], changeMonth: true, changeYear: true,onSelect: function(value, date) {
            date.dpDiv.find('.ui-datepicker-current-day a')
            .css('background-color', '#FE5000').css({"z-index":100});
            }
        });
    });
    </script>
</body>