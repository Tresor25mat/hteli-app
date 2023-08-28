<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    $ecole=$pdo->query("SELECT * FROM etablissement ORDER BY Design_Etablissement");
    $liste_ecole=$pdo->query("SELECT * FROM etablissement ORDER BY Design_Etablissement");
    $niveau=$pdo->query("SELECT * FROM niveau ORDER BY ID_Niveau");
    $liste_niveau=$pdo->query("SELECT * FROM niveau ORDER BY ID_Niveau");
    $annee=$pdo->query("SELECT * FROM annee ORDER BY ID_Annee");
    if($_SESSION['user_eteelo_app']['ID_Statut']!=1){
        $liste_option=$pdo->query("SELECT * FROM table_option INNER JOIN section ON table_option.ID_Section=section.ID_Section WHERE section.ID_Etablissement=".$_SESSION['user_eteelo_app']['ID_Etablissement']." ORDER BY Design_Option");
    }
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
    <title>Frais | <?php echo $app_infos['Design_App']; ?></title>
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
                    Frais
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-12">
                <div class="row" style="border-bottom: 1px solid #EEEEEE; padding-bottom: 20px">
                    <div class="col-md-2" style="<?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'display: none';} ?>">
                      <div class="form-group ">
                        <label for="classe" class="control-label col-lg-12" style="text-align: left;">Ecole </label>
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-sm-12">
                                <select name="ecole" class="form-control" id="ecole" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ echo 'disabled';} ?>>
                                    <option value="">--</option>
                                    <?php while($ecoles=$ecole->fetch()){ ?>
                                    <option value="<?php echo($ecoles['ID_Etablissement']) ?>" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1 && $ecoles['ID_Etablissement']==$_SESSION['user_eteelo_app']['ID_Etablissement']){ echo 'selected';} ?>><?php echo(stripslashes($ecoles['Design_Etablissement'])) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group ">
                        <label for="classe" class="control-label col-lg-12" style="text-align: left;">Section </label>
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-sm-12">
                                <select name="option" class="form-control" id="option">
                                    <option value="" id="add_option">--</option>
                                </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group ">
                        <label for="classe" class="control-label col-lg-12" style="text-align: left;">Niveau </label>
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-sm-12">
                                <select name="niveau" class="form-control" id="niveau">
                                    <option value="">--</option>
                                    <?php while($niv=$niveau->fetch()){ ?>
                                    <option value="<?php echo($niv['ID_Niveau']) ?>"><?php echo(stripslashes($niv['Design_Niveau'])) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group ">
                        <label for="classe" class="control-label col-lg-12" style="text-align: left;">Année </label>
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-sm-12">
                                <select name="annee" class="form-control" id="annee">
                                    <option value="">--</option>
                                    <?php while($annees=$annee->fetch()){ ?>
                                    <option value="<?php echo($annees['ID_Annee']) ?>" <?php if($annees['Encours']==1){echo 'selected';} ?>><?php echo(stripslashes($annees['Libelle_Annee'])) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2" style='margin-top: 20px; margin-bottom: 20px;'>
                      <button class="btn btn-default" type="button" id="btn_afficher" style="height: 32px; border-radius: 0; margin-top: 2px"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col-12 col-md-auto ms-auto d-print-none" style="margin-top: 18px">
                        <div class="btn-list">
                        <a href="#" id="btn_ajouter" class="btn btn-primary d-sm-inline-block" title="Ajouter un frais">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="font-weight: bold;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                            Ajouter un frais
                        </a>
                        </div>
                    </div>
                  </div>


              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
            <iframe src="" style="width: 100%; height: 1500px; border: none;" id="iframe"></iframe>
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
        $.ajax({
                url:'recherche_option.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_option').nextAll().remove();
                    $('#add_option').after(ret);
                }
            });
            $.ajax({
              url:"recherche_enseignant.php",
              type:'post',
              dataType:"json",
              data:{Ecole:$('#ecole').val()},
              success:function(donnee){
                  listeEnseignant.length=0;
                  $.map(donnee,function(objet){
                    listeEnseignant.push({
                          value:objet.Nom,
                          desc:objet.ID_Enseignant
                      });
                  });
              }
            });
            $('#iframe').attr('src', "table_frais.php?Ecole="+$('#ecole').val()+"&Option="+$('#option').val()+"&Niveau="+$('#niveau').val()+"&Annee="+$('#annee').val());
    });
    $('#ecole').change(function(){
        if($('#ecole').val()!=''){
            $.ajax({
                url:'recherche_option.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_option').nextAll().remove();
                    $('#add_option').after(ret);
                    $('#option').focus();
                }
            });
        }
    })
    $('#option').change(function(){
        if($('#option').val()!=''){
            $('#niveau').focus();
        }
    })
    $('#niveau').change(function(){
        if($('#niveau').val()!=''){
            $('#btn_afficher').focus();
        }
    })
    $('#btn_afficher').click(function(){
        $('#iframe').attr('src', "table_frais.php?Ecole="+$('#ecole').val()+"&Option="+$('#option').val()+"&Niveau="+$('#niveau').val()+"&Annee="+$('#annee').val());
    })
    $('#btn_ajouter').click(function(e){
        e.preventDefault();
        window.location.replace('ajouter_frais.php?Ecole='+$('#ecole').val()+"&Option="+$('#option').val()+"&Niveau="+$('#niveau').val()+"&Annee="+$('#annee').val()); 
    })
    </script>
</body>