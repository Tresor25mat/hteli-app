<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    $ecole=$pdo->query("SELECT * FROM etablissement ORDER BY Design_Etablissement");
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
    <title>ecoles | <?php echo $app_infos['Design_App']; ?></title>
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
                  Ecoles
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-12 col-md-auto ms-auto d-print-none">
                <input type="hidden" name="ID_Etablissement" id="ID_Etablissement">
                <div class="btn-list">
<!--                   <span class="d-none d-sm-inline">
                    <a href="#" class="btn btn-white">
                      New view
                    </a>
                  </span> -->
                  <a href="#" id="ajouter_ecole" class="btn btn-primary d-sm-inline-block" title="Ajouter une école">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="font-weight: bold;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Ajouter une école
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
                                        <th>Désignation</th>
                                        <th>Active</th>
                                        <th>Opérations</th>
                                    </tr>
                                </thead>
                                <tbody id="MaTable">
    <?php while($ecoles=$ecole->fetch()){$Nbr++; ?>
        <tr class="odd gradeX" style="background: transparent;">
            <td style="width: 80px; "><center><?php echo sprintf('%02d', $Nbr); ?></center></td>
            <td><!-- <center> --><?php echo strtoupper(stripslashes($ecoles['Design_Etablissement'])); ?></td>
            <td><center><?php if ($ecoles['Active']==1){echo '<a class="btn btn-info" style="width:25px; margin-right: 5px; border-radius: 0;" href="desactiver_ecole.php?ID='.$ecoles['ID_Etablissement'].'&token='.$_SESSION['user_eteelo_app']['token'].'" title="Désactiver" style="margin-right: 5px"><i class="fa fa-ban fa-fw"></i></a>';}else{ echo '<a class="btn btn-info" style="width:30px; margin-right: 5px; border-radius: 0;" href="activer_ecole.php?ID='.$ecoles['ID_Etablissement'].'&token='.$_SESSION['user_eteelo_app']['token'].'" title="Activer" style="margin-right: 5px"><i class="fa fa-check fa-fw"></i></a>';} ?></center></td>
            <td><center>
                <a href="#" onclick="Function_Modifier(<?php echo($ecoles['ID_Etablissement']); ?>, '<?php echo (stripslashes($ecoles['Design_Etablissement'])); ?>')" title="Modifier" style="margin-right: 5px; width: 25px; border-radius: 0;" class="btn btn-primary"><i class="fa fa-edit fa-fw"></i></a>
                <a style="width: 25px; border-radius: 0;" class="btn btn-danger" href="javascript: alertify.confirm('Voulez-vous vraiment supprimer cette école?\n Toutes les informations concernant cette école seront supprimés!').set('onok',function(closeEvent){window.location.replace('suppr_ecole.php?ID=<?php echo($ecoles['ID_Etablissement']) ?>&token=<?php echo($_SESSION['user_eteelo_app']['token']) ?>');alertify.success('suppression éffectuée');}).set('oncancel',function(closeEvent){alertify.error('suppression annulée');}).set({title:''},{labels:{ok:'Oui', cancel:'Annuler'}});" title="Supprimer"><i class="fa fa-trash-o fa-fw"></i></a></center>
            </td>
        </tr>
    <?php } ?>
</tbody>
                            </table>
                        <!-- </div> -->
                    <!-- </div> -->
                    <!-- /.panel -->
                <!-- </div> -->

            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="ModalAjoutEcole" class="modal fade" data-backdrop="static">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nouvelle école</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok" type="hidden" name="tok" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="col-lg-12">Désignation *</div>
                    <div class="col-lg-12"><input type="text" name="Design_Etablissement" id="Design_Etablissement" class="form-control" style="margin-top: 1%; height: 45px" value="" required></div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enregecole">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialogueEcole()">Annuler</button>
            </div>
            </div>
        </div>
    </div>
    <div id="ModalModifEcole" class="modal fade" data-backdrop="static">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modification école</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueModEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok" type="hidden" name="tok" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="col-lg-12">Désignation *</div>
                    <div class="col-lg-12"><input type="text" name="Design_Etablissement_mod" id="Design_Etablissement_mod" class="form-control" style="margin-top: 1%; height: 45px" value="" required></div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enregecole_mod">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialogueModEcole()">Annuler</button>
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
  function fermerDialogueEcole(){
        $("#ModalAjoutEcole").modal('hide');
  }
  function fermerDialogueModEcole(){
        $("#ModalModifEcole").modal('hide');
  }
  function Function_Modifier(a, b){
      $("#ModalModifEcole").modal('show');
      $('#ID_Etablissement').val(a);
      $('#Design_Etablissement_mod').val(b);
      $('#Design_Etablissement_mod').focus();
  }
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

    $('#ajouter_ecole').click(function(e){
      e.preventDefault();
      $("#ModalAjoutEcole").modal('show');
      $('#Design_Etablissement').val('');
      $('#Design_Etablissement').focus();
    })


    $('#enregecole').click(function(){
        if($('#Design_Etablissement').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!');
                $('#Design_Etablissement').focus();
        }else{
                $.ajax({
                        url:'Enreg_Ecole.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {Design:$('#Design_Etablissement').val(), token:$('#tok').val()},
                        success:function(ret){
                            if(ret==1){
                                alertify.success("L'opération a réussi");
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Enregistrement éffectué'
                                })
                                window.location.replace('table_ecole.php');
                            }else if(ret==2){
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Cette désignation existe déjà'); 
                            }else{
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>',ret); 
                            }
                        }
                    });
        }
    });
    $('#enregecole_mod').click(function(){
        if($('#Design_Etablissement_mod').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!');
                $('#Design_Etablissement_mod').focus();
        }else{
                $.ajax({
                        url:'Edit_Ecole.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {Design:$('#Design_Etablissement_mod').val(), token:$('#tok').val(), ID:$('#ID_Etablissement').val()},
                        success:function(ret){
                            if(ret==1){
                                alertify.success("L'opération a réussi");
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Modification éffectuée'
                                })
                                window.location.replace('table_ecole.php');
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