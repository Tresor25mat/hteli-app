<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    $utilisateur=$pdo->query("SELECT * FROM utilisateur WHERE ID_Utilisateur!=1");
    $type_site=$pdo->query("SELECT * FROM type_site");
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();
?>
<!DOCTYPE html>
<html lang="fr-FR">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Janitorials, Facilities & Alarms | <?php echo $app_infos['Design_App']; ?></title>
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
      #btn_afficher:hover{
         border: 2px solid #D9DBDE;
      }
      #btn_afficher:focus{
         border: 2px solid #D9DBDE;
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
                Janitorials, Facilities & Alarms
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
                    <div class="col-md-<?php if($_SESSION['user_eteelo_app']['ID_Statut']==3){ echo '2';}else{echo '1';} ?>">
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
                    <div class="col-md-<?php if($_SESSION['user_eteelo_app']['ID_Statut']==3){ echo '2';}else{echo '1';} ?>">
                      <div class="form-group ">
                        <label for="SiteType" class="control-label col-lg-12" style="text-align: left;">Type of site </label>
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-sm-12">
                                <select name="SiteType" class="form-control" id="SiteType">
                                    <option value="">--</option>
                                    <?php while($type_sites=$type_site->fetch()){ ?>
                                    <option value="<?php echo($type_sites['ID_Type']) ?>" <?php if(isset($_GET['SiteType']) && $_GET['SiteType']!='' && $type_sites['ID_Type']==$_GET['SiteType']){echo 'selected'; } ?>><?php echo(stripslashes($type_sites['Design_Type'])); ?></option>
                                    <?php } ?>
                                </select>
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
                    <div class="col-md-3" style='margin-top: 20px; margin-bottom: 20px;'>
                      <button class="btn btn-default" type="button" id="btn_afficher" style="height: 32px; border-radius: 0; margin-top: 2px"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col-12 col-md-auto ms-auto d-print-none" style="margin-top: 18px">
                        <div class="btn-list">
                        <a href="#" id="btn_ajouter" class="btn btn-primary d-sm-inline-block" title="Nouveau rapport">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="font-weight: bold;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                            Nouveau rapport
                        </a>
                        </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
            <iframe src="" style="width: 100%; height: 2300px; border: none; padding-left: 12px; padding-right: 12px" id="iframe"></iframe>
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
        let dateRapport = $('#dateRapport').val();
        dateRap = dateRapport.replace(/\//g, "-");
        $('#iframe').attr('src', "table_janitorial.php?User="+$('#utilisateur').val()+'&siteId='+$('#siteId').val()+'&SiteType='+$('#SiteType').val()+'&dateRapport='+dateRap);
    });
    $('#btn_afficher').click(function(){
        let dateRapport = $('#dateRapport').val();
        dateRap = dateRapport.replace(/\//g, "-");
        $('#iframe').attr('src', "table_janitorial.php?User="+$('#utilisateur').val()+'&siteId='+$('#siteId').val()+'&SiteType='+$('#SiteType').val()+'&dateRapport='+dateRap);
    })
    $('#utilisateur').change(function(){
        if($('#utilisateur').val()!=''){
            $('#btn_afficher').focus();
        }
    });
    $('#SiteType').change(function(){
        if($('#SiteType').val()!=''){
            $('#btn_afficher').focus();
        }
    });

  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

    $('#btn_ajouter').click(function(e){
      e.preventDefault();
      let dateRapport = $('#dateRapport').val();
      dateRap = dateRapport.replace(/\//g, "-");
      window.location.replace('ajouter_rapport_janitorial.php?User='+$('#utilisateur').val()+'&siteId='+$('#siteId').val()+'&SiteType='+$('#SiteType').val()+'&dateRapport='+dateRap);
    })

  });
  $(function(){
        $(".date").datepicker({closeText:'fermer',prevText:'&#x3c;Préc',nextText:'Suiv&#x3e;',currentText:'Courant',dateFormat:"dd/mm/yy", minDate: "01/01/1990",monthNames:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aoùt","Septembre","Octobre","Novembre","Décembre"],monthNamesShort:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],dayNamesMin:["Dim","Lun","Mar","Mer","Jeu","Ven","Sam"], changeMonth: true, changeYear: true,onSelect: function(value, date) {
            date.dpDiv.find('.ui-datepicker-current-day a')
            .css('background-color', '#FE5000').css({"z-index":99999999999999});}
        });
    });
    </script>
</body>