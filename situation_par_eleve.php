<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    $ecole=$pdo->query("SELECT * FROM etablissement ORDER BY Design_Etablissement");
    $annee=$pdo->query("SELECT * FROM annee ORDER BY ID_Annee");
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
    <title>Situation de paiement par élève | <?php echo $app_infos['Design_App']; ?></title>
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
                Situation de paiement par élève
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-12">
                <div class="row" style="border-bottom: 1px solid #EEEEEE; padding-bottom: 20px">
                    <div class="col-md-2" style="<?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'display: none';} ?>">
                      <div class="form-group ">
                        <label for="ecole" class="control-label col-lg-12" style="text-align: left;">Ecole *</label>
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-sm-12">
                                <select name="ecole" class="form-control" id="ecole" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ echo 'disabled';} ?>>
                                    <option value="">--</option>
                                    <?php while($ecoles=$ecole->fetch()){ ?>
                                    <option value="<?php echo($ecoles['ID_Etablissement']) ?>" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1 && $ecoles['ID_Etablissement']==$_SESSION['user_eteelo_app']['ID_Etablissement']){ echo 'selected';}else if(isset($_GET['Ecole']) && $_GET['Ecole']!='' && $_GET['Ecole']==$ecoles['ID_Etablissement']){echo 'selected';} ?>><?php echo(stripslashes($ecoles['Design_Etablissement'])) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group ">
                        <label for="classe" class="control-label col-lg-12" style="text-align: left;">Classe *</label>
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-sm-12">
                                <select name="classe" class="form-control" id="classe">
                                    <option value="" id="add_classe">--</option>
                                </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group ">
                        <label for="annee" class="control-label col-lg-12" style="text-align: left;">Année scolaire *</label>
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
                    <div class="col-md-3">
                      <div class="form-group ">
                        <label for="frais" class="control-label col-lg-12" style="text-align: left;">Elève * </label>
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="eleve" id="eleve">
                                <input type="hidden" name="ID_Inscription" id="ID_Inscription">
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
            <iframe src="Dashio/accueil.php" style="width: 100%; height: 1500px; border: none;" id="iframe"></iframe>
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
    listeleve=[]; 
    function recheche_eleve(){
        $.ajax({
          url:"recherche_eleve.php",
          type:'post',
          dataType:"json",
          data:{Ecole:$('#ecole').val(), Annee:$('#annee').val(), Classe:$('#classe').val()},
          success:function(donnee){
              listeleve.length=0;
              $.map(donnee,function(objet){
                  listeleve.push({
                      value:objet.Nom,
                      desc:objet.ID_Inscription
                  });
              });
          }
        });
    }
    $(document).ready(function() {
            $.ajax({
                url:'recharge_list.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val(), liste:"frais"},
                success:function(ret){
                    $('#add_type').nextAll().remove();
                    $('#add_type').after(ret);
                }
            });
            $.ajax({
                url:'recherche_classe.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_classe').nextAll().remove();
                    $('#add_classe').after(ret);
                }
            });
    });
    $('#ecole').change(function(){
        if($('#ecole').val()!=''){
            $.ajax({
                url:'recharge_list.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val(), liste:"frais"},
                success:function(ret){
                    $('#add_type').nextAll().remove();
                    $('#add_type').after(ret);
                }
            });
            $.ajax({
                url:'recherche_classe.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_classe').nextAll().remove();
                    $('#add_classe').after(ret);
                    $('#classe').focus();
                }
            });
        }
    })
    $('#classe').change(function(){
        recheche_eleve();
        $('#eleve').val('');
        $('#ID_Inscription').val('');
        $('#annee').focus();
    })
    $('#annee').change(function(){
        $('#eleve').focus();
    })

    
    $('#eleve').autocomplete({source:function(request,response){
        var resultat=$.ui.autocomplete.filter(listeleve,request.term);
        response(resultat.slice(0,15));
        },
        select:function(event,ui){
            $('#ID_Inscription').val(ui.item.desc);
            $('#btn_afficher').focus();
        }
    });

    $('#btn_afficher').click(function(){
        if($('#classe').val()!='' && $('#annee').val()!='' && $('#ID_Inscription').val()!=''){
            $('#iframe').attr('src', "situation_par_eleve_pdf.php?classe="+$('#classe').val()+'&annee='+$('#annee').val()+'&frais='+$('#frais').val()+'&ecole='+$('#ecole').val()+'&eleve='+$('#ID_Inscription').val());
        }else{
            alertify.alert('<?php echo $app_infos['Design_App']; ?>', "Veuillez selectionner la classe, l'année scolaire et l'élève svp!");
            $('#classe').focus();
        }
    })

    $('#btn_exporter').click(function(){
        if($('#classe').val()!='' && $('#annee').val()!='' && $('#ID_Inscription').val()!=''){
            $('#iframe').attr('src', "situation_par_eleve_excel.php?classe="+$('#classe').val()+'&annee='+$('#annee').val()+'&frais='+$('#frais').val()+'&ecole='+$('#ecole').val()+'&eleve='+$('#ID_Inscription').val());
        }else{
            alertify.alert('<?php echo $app_infos['Design_App']; ?>', "Veuillez selectionner la classe, l'année scolaire et l'élève svp!");
            $('#classe').focus();
        }
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