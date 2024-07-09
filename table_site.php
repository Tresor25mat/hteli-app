<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    $query="SELECT * FROM site INNER JOIN province ON site.ID_Prov=province.ID_Prov WHERE site.ID_Site!=0";
    if(isset($_GET['Province']) && $_GET['Province']!=''){
        $query.=" AND site.ID_Prov=".$_GET['Province'];
    }
    if(isset($_GET['siteName']) && $_GET['siteName']!=''){
        $query.=" AND UCASE(site.Site_Name) LIKE '%".strtoupper($_GET['siteName'])."%'";
    }
    if(isset($_GET['siteId']) && $_GET['siteId']!=''){
        $query.=" AND UCASE(site.Site_ID) LIKE '%".strtoupper($_GET['siteId'])."%'";
    }
    $query.=" ORDER BY site.Site_ID, site.Site_Name";
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
    $liste_province=$pdo->query("SELECT * FROM province ORDER BY Design_Prov");
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
            <input type="hidden" name="ID_Site" id="ID_Site">
            <input type="hidden" name="province" id="province" value="<?php if(isset($_GET['Province']) && $_GET['Province']!=''){echo $_GET['Province']; } ?>">
            <input type="hidden" name="siteName" id="siteName" value="<?php if(isset($_GET['siteName']) && $_GET['siteName']!=''){echo $_GET['siteName']; } ?>">
            <input type="hidden" name="siteId" id="siteId" value="<?php if(isset($_GET['siteId']) && $_GET['siteId']!=''){echo $_GET['siteId']; } ?>">
                <!-- <div class="col-md-12 col-lg-12"> -->
                    <!-- <div class="panel panel-default"> -->
                        <!-- <div class="panel-body"> -->
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Site ID & Name</th>
                                        <th>Province</th>
                                        <th>FME Name</th>
                                        <th>Opérations</th>
                                    </tr>
                                </thead>
                                <tbody id="MaTable">
    <?php while($selections=$selection->fetch()){
        $fme=$pdo->query("SELECT * FROM agent WHERE ID_Agent=".$selections['ID_Agent']);
        $fmes=$fme->fetch();
        $Nbr++; 
    ?>
        <tr class="odd gradeX" style="background: transparent;">
            <td style="width: 80px; "><center><?php echo sprintf('%02d', $Nbr); ?></center></td>
            <td><!-- <center> --><?php echo stripslashes($selections['Site_ID'].' - '.$selections['Site_Name']); ?></td>
            <td><!-- <center> --><?php echo stripslashes($selections['Design_Prov']); ?></td>
            <td><!-- <center> --><?php echo stripslashes($fmes['Nom_Agent']); ?></td>
            <td><center>
                <?php if($_SESSION['user_eteelo_app']['ID_Statut']==1 || $_SESSION['user_eteelo_app']['ID_Statut']==2){ ?>
                <a href="#" onclick="Function_Modifier(<?php echo($selections['ID_Site']); ?>, <?php echo($selections['ID_Prov']); ?>, <?php echo($selections['ID_Agent']); ?>, '<?php echo (stripslashes($selections['Site_ID'])); ?>', '<?php echo ($selections['Site_Name']); ?>', '<?php echo (stripslashes($selections['Localisation'])); ?>', '<?php echo strtoupper(stripslashes($fmes['Nom_Agent'])); ?>')" title="Modifier" style="margin-right: 5px; width: 25px; border-radius: 0;" class="btn btn-primary"><i class="fa fa-edit fa-fw"></i></a>
                <?php } if($_SESSION['user_eteelo_app']['ID_Statut']==1){ ?>
                <a style="width: 25px; border-radius: 0;" class="btn btn-danger" href="javascript: alertify.confirm('Voulez-vous vraiment supprimer cet enregistrement?\n Toutes les informations concernant cet enregistrement seront supprimées!').set('onok',function(closeEvent){window.location.replace('suppr_site.php?ID=<?php echo($selections['ID_Site']) ?>&token=<?php echo($_SESSION['user_eteelo_app']['token']) ?>&Province=<?php if(isset($_GET['Province']) && $_GET['Province']!=''){echo $_GET['Province']; } ?>&siteName=<?php if(isset($_GET['siteName']) && $_GET['siteName']!=''){echo $_GET['siteName']; } ?>&siteId=<?php if(isset($_GET['siteId']) && $_GET['siteId']!=''){echo $_GET['siteId']; } ?>');alertify.success('suppression éffectuée');}).set('oncancel',function(closeEvent){alertify.error('suppression annulée');}).set({title:''},{labels:{ok:'Oui', cancel:'Annuler'}});" title="Supprimer"><i class="fa fa-trash-o fa-fw"></i></a></center>
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
                                    echo '<li class="page-item"><a class="page-link" href="table_site.php?page='.$page.'&Province='.$_GET['Province'].'&siteName='.$_GET['siteName'].'&siteId='.$_GET['siteId'].'"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>Previous</a></li>';
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
                                        echo '<li class="page-item"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="table_site.php?page='.$pageNexte.'&Province='.$_GET['Province'].'&siteName='.$_GET['siteName'].'&siteId='.$_GET['siteId'].'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="table_site.php?page='.$pageTrois.'&Province='.$_GET['Province'].'&siteName='.$_GET['siteName'].'&siteId='.$_GET['siteId'].'">'.$pageTrois.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    }else if($pageCourante==2){
                                        echo '<li class="page-item"><a class="page-link" href="table_site.php?page='.$pagePrecedente.'&Province='.$_GET['Province'].'&siteName='.$_GET['siteName'].'&siteId='.$_GET['siteId'].'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_site.php?page='.$pageNexte.'&Province='.$_GET['Province'].'&siteName='.$_GET['siteName'].'&siteId='.$_GET['siteId'].'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    }else if($pageCourante==$pagesAvantTotales){
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_site.php?page='.$pagePrecedente.'&Province='.$_GET['Province'].'&siteName='.$_GET['siteName'].'&siteId='.$_GET['siteId'].'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_site.php?page='.$pageNexte.'&Province='.$_GET['Province'].'&siteName='.$_GET['siteName'].'&siteId='.$_GET['siteId'].'">'.$pageNexte.'</a></li>';
                                    }else if($pageCourante==$pagesTotales){
                                            echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_site.php?page='.$pageAvantPrecedente.'&Province='.$_GET['Province'].'&siteName='.$_GET['siteName'].'&siteId='.$_GET['siteId'].'">'.$pageAvantPrecedente.'</a></li><li class="page-item"><a class="page-link" href="table_site.php?page='.$pagePrecedente.'&Province='.$_GET['Province'].'&siteName='.$_GET['siteName'].'&siteId='.$_GET['siteId'].'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li>';
                                    }else{
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_site.php?page='.$pagePrecedente.'&Province='.$_GET['Province'].'&siteName='.$_GET['siteName'].'&siteId='.$_GET['siteId'].'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_site.php?page='.$pageNexte.'&Province='.$_GET['Province'].'&siteName='.$_GET['siteName'].'&siteId='.$_GET['siteId'].'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>'; 
                                    }
                                }else{
                                    for ($i=1; $i <= $pagesTotales ; $i++) { 
                                        if ($i==$pageCourante) {
                                            echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                                        }else{
                                            echo '<li class="page-item"><a class="page-link" href="table_site.php?page='.$i.'&Province='.$_GET['Province'].'&siteName='.$_GET['siteName'].'&siteId='.$_GET['siteId'].'">'.$i.'</a></li>';
                                        }
                                    } 
                                }
                                if($pagesTotales>$pageCourante){
                                    $page=$pageCourante+1;
                                    echo '<li class="page-item"><a class="page-link" href="table_site.php?page='.$page.'&Province='.$_GET['Province'].'&siteName='.$_GET['siteName'].'&siteId='.$_GET['siteId'].'">Next<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg></a></li>';
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
    <div id="ModalMod" class="modal fade" data-backdrop="static" style="margin-top: 100px">
        <div class="modal-dialog" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modification d'un site</h4>
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
                                    <input type="text" name="localisation" id="localisation" class="form-control" style="margin-top: 1%;" value="">
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
    });
  function fermerDialogue(){
        $("#ModalMod").modal('hide');
  }
  function Function_Modifier(a, b, c, d, e, f, g){
      $("#ModalMod").modal('show');
      $('#ID_Site').val(a);
      $('#liste_province').val(b);
      $('#ID_Agent').val(c);
      $('#site_id').val(d);
      $('#site_name').val(e);
      $('#agent').val(g);
      $('#localisation').val(f);
      $('#liste_province').focus();
  }
  $('#agent').autocomplete({source:function(request,response){
        var resultat=$.ui.autocomplete.filter(listeAgent,request.term);
        response(resultat.slice(0,15));
        },
        select:function(event,ui){
            $('#ID_Agent').val(ui.item.desc);
            $('#localisation').focus();
        }
  });
  $('#liste_province').change(function(){
        if($('#liste_province').val()!=''){
            $('#site_id').focus();
        }
  })


  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

    $('#enregistrer').click(function(){
        if($('#liste_province').val()=='' || $('#site_id').val()=='' || $('#site_name').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!');
                $('#liste_province').focus();
        }else{
                $.ajax({
                        url:'edit_site.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {Province:$('#liste_province').val(), Site_ID:$('#site_id').val(), Site_Name:$('#site_name').val(), ID_Agent:$('#ID_Agent').val(), Agent:$('#agent').val(), Localisation:$('#localisation').val(), token:$('#tok').val(), ID_Site:$('#ID_Site').val()},
                        success:function(ret){
                            if(ret==1){
                                alertify.success("L'opération a réussi");
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Modification éffectuée'
                                })
                                window.location.replace('table_site.php?Province='+$('#province').val()+'&siteName='+$('#siteName').val()+'&siteId='+$('#siteId').val());
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