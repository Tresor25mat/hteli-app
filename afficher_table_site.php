<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    $province=$pdo->query("SELECT * FROM province INNER JOIN site ON province.ID_Prov=site.ID_Prov ORDER BY Design_Prov");
    $liste_province=$pdo->query("SELECT * FROM province ORDER BY Design_Prov");
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();
    $prov="";
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
                  Sites
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-12">
                <div class="row" style="border-bottom: 1px solid #EEEEEE; padding-bottom: 20px">
                    <div class="col-md-2">
                      <div class="form-group ">
                        <label for="province" class="control-label col-lg-12" style="text-align: left;">Province </label>
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-sm-12">
                                <select name="province" class="form-control" id="province">
                                    <option value="">--</option>
                                    <?php while($provinces=$province->fetch()){ 
                                        if($prov!=$provinces['ID_Prov']){ 
                                            $prov=$provinces['ID_Prov'];
                                      ?>
                                    <option value="<?php echo($provinces['ID_Prov']) ?>"><?php echo(stripslashes(strtoupper($provinces['Design_Prov']))); ?></option>
                                    <?php }} ?>
                                </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group ">
                        <label for="siteName" class="control-label col-lg-12" style="text-align: left;">Site Name </label>
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="siteName" id="siteName">
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
                                <input type="text" class="form-control" name="siteId" id="siteId">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-1" style='margin-top: 20px; margin-bottom: 20px; margin-right: 20px'>
                      <button class="btn btn-default" type="button" id="btn_afficher" style="height: 32px; border-radius: 0; margin-top: 2px;"><i class="fa fa-search" style="margin-right: 5px"></i>Filtrer</button>
                    </div>
                    <div class="col-md-2" style='margin-top: 20px; margin-bottom: 20px;'>
                      <button class="btn btn-default mybtn" type="button" id="btn_exporter" style="height: 32px; border-radius: 0; margin-top: 2px"><i class="fa fa-file-excel-o" style="margin-right: 5px"></i>Exporter vers Excel</button>
                    </div>
                    <div class="col-12 col-md-auto ms-auto d-print-none" style="margin-top: 18px">
                        <div class="btn-list">
                        <a href="#" id="btn_ajouter" class="btn btn-primary d-sm-inline-block" title="Ajouter un site">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="font-weight: bold;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                            Ajouter un site
                        </a>
                        </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
            <iframe src="" style="width: 100%; height: 1500px; border: none; padding-left: 12px; padding-right: 12px" id="iframe"></iframe>
        </div>
      </div>
    </div>
    <div id="ModalAjout" class="modal fade" data-backdrop="static" style="margin-top: 100px">
        <div class="modal-dialog" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nouveau site</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok" type="hidden" name="tok" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                    <input type="hidden" name="ID_Agent" id="ID_Agent">
                    <div class="row">
                        <div class="col-6">
                            <div class="col-lg-12">Province *</div>
                            <select name="liste_province" class="form-control" id="liste_province">
                                <option value="">--</option>
                                <?php while($liste_provinces=$liste_province->fetch()){ ?>
                                <option value="<?php echo($liste_provinces['ID_Prov']) ?>"><?php echo(stripslashes(strtoupper($liste_provinces['Design_Prov']))) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <div class="col-lg-12">Site ID *</div>
                            <div class="col-lg-12"><input type="text" name="site_id" id="site_id" class="form-control" style="margin-top: 1%;" value="" required></div>
                        </div>
                        <div class="col-6">
                            <div class="col-lg-12">Site Name *</div>
                            <div class="col-lg-12"><input type="text" name="site_name" id="site_name" class="form-control" style="margin-top: 1%;" value="" required></div>
                        </div>
                        <div class="col-6">
                            <div class="col-lg-12">FME Name </div>
                            <div class="col-lg-12"><input type="text" name="agent" id="agent" class="form-control" style="margin-top: 1%;" value=""></div>
                        </div>
                        <div class="col-12">
                            <div class="col-lg-12">Localisation </div>
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="border-top-right-radius: 0; border-bottom-right-radius: 0; border-right: none; margin-top: 5px; height: 37px"><i class="fa fa-map-marker"></i></span>
                                    </div>
                                    <input type="text" name="localisation" id="localisation" class="form-control" style="margin-top: 1%; height: 37px" value="">
                                </div> 
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enregistrer">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialogue()">Annuler</button>
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
    listeAgent=[];
    function actualiser_agent(){
        $.ajax({
              url:"recherche_agent.php",
              type:'post',
              dataType:"json",
              success:function(donnee){
                  listeAgent.length=0;
                  $.map(donnee,function(objet){
                    listeAgent.push({
                          value:objet.Nom,
                          desc:objet.ID_Agent
                      });
                  });
              }
        });
    }
    $(document).ready(function() {
        actualiser_agent();
        $('#iframe').attr('src', "table_site.php?Province="+$('#province').val()+'&siteName='+$('#siteName').val()+'&siteId='+$('#siteId').val());
    });
    $('#agent').autocomplete({source:function(request,response){
        var resultat=$.ui.autocomplete.filter(listeAgent,request.term);
        response(resultat.slice(0,15));
        },
        select:function(event,ui){
            $('#ID_Agent').val(ui.item.desc);
            $('#localisation').focus();
        }
    });
    $('#province').change(function(){
        if($('#province').val()!=''){
            $('#btn_afficher').focus();
        }
    })
    $('#liste_province').change(function(){
        if($('#liste_province').val()!=''){
            $('#site_id').focus();
        }
    })
    $('#btn_afficher').click(function(){
        $('#iframe').attr('src', "table_site.php?Province="+$('#province').val()+'&siteName='+$('#siteName').val()+'&siteId='+$('#siteId').val());
    })
    $('#btn_exporter').click(function(){
        $('#iframe').attr('src', "liste_site_excel.php?Province="+$('#province').val()+'&siteName='+$('#siteName').val()+'&siteId='+$('#siteId').val());
})
    function fermerDialogue(){
        $("#ModalAjout").modal('hide');
    }
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
      $('#liste_province').val('');
      $('#ID_Agent').val('');
      $('#site_id').val('');
      $('#site_name').val('');
      $('#agent').val('');
      $('#localisation').val('');
      $('#liste_province').focus();
    })
    $('#enregistrer').click(function(){
        if($('#liste_province').val()=='' || $('#site_id').val()=='' || $('#site_name').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!');
                $('#liste_province').focus();
        }else{
                $.ajax({
                        url:'enreg_site.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {Province:$('#liste_province').val(), Site_ID:$('#site_id').val(), Site_Name:$('#site_name').val(), ID_Agent:$('#ID_Agent').val(), Agent:$('#agent').val(), Localisation:$('#localisation').val(), token:$('#tok').val()},
                        success:function(ret){
                            if(ret==1){
                                alertify.success("L'opération a réussi");
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Enregistrement éffectué'
                                })
                                $('#iframe').attr('src', "table_site.php?Province="+$('#province').val()+'&siteName='+$('#siteName').val()+'&siteId='+$('#siteId').val());
                                fermerDialogue();
                                actualiser_agent();
                            }else if(ret==2){
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Ce site existe déjà'); 
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