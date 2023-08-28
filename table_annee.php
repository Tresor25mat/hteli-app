<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    $query="SELECT * FROM annee ORDER BY ID_Annee";
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
    $annee=$pdo->query($query);
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
    <title>Année scolaire | <?php echo $app_infos['Design_App']; ?></title>
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
                <h2 class="page-title">
                Année scolaire
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-12 col-md-auto ms-auto d-print-none">
                <input type="hidden" name="ID_Annee" id="ID_Annee">
                <div class="btn-list">
<!--                   <span class="d-none d-sm-inline">
                    <a href="#" class="btn btn-white">
                      New view
                    </a>
                  </span> -->
                  <a href="#" id="btn_ajouter" class="btn btn-primary d-sm-inline-block" title="Ajouter une année">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="font-weight: bold;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Ajouter une année
                  </a>
<!--                   <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                    Download SVG icon from http://tabler-icons.io/i/plus
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                  </a> -->
                </div>
              </div>
            </div>
          </div>
        </div>
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
                <!-- <div class="col-md-12 col-lg-12"> -->
                    <!-- <div class="panel panel-default"> -->
                        <!-- <div class="panel-body"> -->
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Année</th>
                                        <th>Active</th>
                                        <th>Opérations</th>
                                    </tr>
                                </thead>
                                <tbody id="MaTable">
    <?php while($annees=$annee->fetch()){$Nbr++; ?>
        <tr class="odd gradeX" style="background: transparent;">
            <td style="width: 80px; "><center><?php echo sprintf('%02d', $Nbr); ?></center></td>
            <td><!-- <center> --><?php echo strtoupper(stripslashes($annees['Libelle_Annee'])); ?></td>
            <td><center><?php if ($annees['Encours']==1){echo 'Année en cours';}else{ echo '<a class="btn btn-success" style="width:30px; margin-right: 5px; border-radius: 0;" href="activer_annee.php?ID='.$annees['ID_Annee'].'&token='.$_SESSION['user_eteelo_app']['token'].'" title="Définir comme année en cours" style="margin-right: 5px"><i class="fa fa-check fa-fw"></i></a>';} ?></center></td>
            <td style="padding-left: 250px"><!-- <center> -->
                <a href="#" onclick="Function_Modifier(<?php echo($annees['ID_Annee']); ?>, '<?php echo (stripslashes($annees['Libelle_Annee'])); ?>')" title="Modifier" style="margin-right: 5px; width: 25px; border-radius: 0;" class="btn btn-primary"><i class="fa fa-edit fa-fw"></i></a>
                <?php if($annees['Encours']!=1){ ?>
                <a style="width: 25px; border-radius: 0;" class="btn btn-danger" href="javascript: alertify.confirm('Voulez-vous vraiment supprimer cette année?\n Toutes les informations concernant cette année seront supprimées!').set('onok',function(closeEvent){window.location.replace('suppr_annee.php?ID=<?php echo($annees['ID_Annee']) ?>&token=<?php echo($_SESSION['user_eteelo_app']['token']) ?>');alertify.success('suppression éffectuée');}).set('oncancel',function(closeEvent){alertify.error('suppression annulée');}).set({title:''},{labels:{ok:'Oui', cancel:'Annuler'}});" title="Supprimer"><i class="fa fa-trash-o fa-fw"></i></a><!-- </center>-->
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
                                    echo '<li class="page-item"><a class="page-link" href="table_annee.php?page='.$page.'"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>Previous</a></li>';
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
                                        echo '<li class="page-item"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="table_annee.php?page='.$pageNexte.'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="table_annee.php?page='.$pageTrois.'">'.$pageTrois.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    }else if($pageCourante==2){
                                        echo '<li class="page-item"><a class="page-link" href="table_annee.php?page='.$pagePrecedente.'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_annee.php?page='.$pageNexte.'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    }else if($pageCourante==$pagesAvantTotales){
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_annee.php?page='.$pagePrecedente.'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_annee.php?page='.$pageNexte.'">'.$pageNexte.'</a></li>';
                                    }else if($pageCourante==$pagesTotales){
                                            echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_annee.php?page='.$pageAvantPrecedente.'">'.$pageAvantPrecedente.'</a></li><li class="page-item"><a class="page-link" href="table_annee.php?page='.$pagePrecedente.'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li>';
                                    }else{
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_annee.php?page='.$pagePrecedente.'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_annee.php?page='.$pageNexte.'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>'; 
                                    }
                                }else{
                                    for ($i=1; $i <= $pagesTotales ; $i++) { 
                                        if ($i==$pageCourante) {
                                            echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                                        }else{
                                            echo '<li class="page-item"><a class="page-link" href="table_annee.php?page='.$i.'">'.$i.'</a></li>';
                                        }
                                    } 
                                }
                                if($pagesTotales>$pageCourante){
                                    $page=$pageCourante+1;
                                    echo '<li class="page-item"><a class="page-link" href="table_annee.php?page='.$page.'">Next<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg></a></li>';
                                }else{
                                    echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Next<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg></a></li>';
                                }

                            ?>
              </ul>
            </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="ModalAjout" class="modal fade" data-backdrop="static" style="margin-top: 100px">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nouvelle année</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok" type="hidden" name="tok" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="col-lg-12">Année *</div>
                    <div class="col-lg-12"><input type="text" name="Design" id="Design" class="form-control" style="margin-top: 1%;" value="" required></div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enregistrer">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialogue()">Annuler</button>
            </div>
            </div>
        </div>
    </div>
    <div id="ModalModif" class="modal fade" data-backdrop="static" style="margin-top: 100px">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modification année</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueModEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok" type="hidden" name="tok" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="col-lg-12">Année *</div>
                    <div class="col-lg-12"><input type="text" name="Design_mod" id="Design_mod" class="form-control" style="margin-top: 1%;" value="" required></div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enregistrermod">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialogueMod()">Annuler</button>
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
    <script type="text/javascript" src="notifica/alertify.min.js"></script>
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js" defer></script>
    <script src="./dist/js/demo.min.js" defer></script>
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

    <script>
        $(document).ready(function() {
            // $("#ModalAjoutPoint").modal('show');
            // $('#dataTables-example').DataTable({
            //     responsive: true
            // });
        });
  function fermerDialogue(){
        $("#ModalAjout").modal('hide');
  }
  function fermerDialogueMod(){
        $("#ModalModif").modal('hide');
  }
  function Function_Modifier(a, b){
      $("#ModalModif").modal('show');
      $('#ID_Annee').val(a);
      $('#Design_mod').val(b);
      $('#Design_mod').focus();
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
      $('#Design').val('');
      $('#Design').focus();
    })


    $('#enregistrer').click(function(){
        if($('#Design').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!');
                $('#Design').focus();
        }else{
                $.ajax({
                        url:'enreg_annee.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {Design:$('#Design').val(), token:$('#tok').val()},
                        success:function(ret){
                            if(ret==1){
                                alertify.success("L'opération a réussi");
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Enregistrement éffectué'
                                })
                                window.location.replace('table_annee.php');
                            }else if(ret==2){
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Cette année existe déjà'); 
                            }else{
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>',ret); 
                            }
                        }
                    });
        }
    });
    $('#enregistrermod').click(function(){
        if($('#Design_mod').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!');
                $('#Design_mod').focus();
        }else{
                $.ajax({
                        url:'edit_annee.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {Design:$('#Design_mod').val(), token:$('#tok').val(), ID:$('#ID_Annee').val()},
                        success:function(ret){
                            if(ret==1){
                                alertify.success("L'opération a réussi");
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Modification éffectuée'
                                })
                                window.location.replace('table_annee.php');
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