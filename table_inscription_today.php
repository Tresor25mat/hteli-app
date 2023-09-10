<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    $query="SELECT eleve.*, classe.*, annee.*, inscription.*, categorie_eleve.*, inscription.Date_Enreg AS mydate FROM eleve INNER JOIN inscription ON eleve.ID_Eleve=inscription.ID_Eleve INNER JOIN classe ON classe.ID_Classe=inscription.ID_Classe INNER JOIN annee ON annee.ID_Annee=inscription.ID_Annee INNER JOIN table_option ON table_option.ID_Option=classe.ID_Option INNER JOIN section ON section.ID_Section=table_option.ID_Section INNER JOIN categorie_eleve ON inscription.ID_Cat_Eleve=categorie_eleve.ID_Categorie WHERE eleve.ID_Eleve!=''";
    if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){
        $query.=" AND section.ID_Etablissement=".$_GET['Ecole'];
    }
    if(isset($_GET['Annee']) && $_GET['Annee']!=''){
        $query.=" AND annee.ID_Annee =".$_GET['Annee']; 
    }
    if(isset($_GET['Classe']) && $_GET['Classe']!=''){
        $query.=" AND inscription.ID_Classe =".$_GET['Classe']; 
    }
    if(isset($_GET['Eleve']) && $_GET['Eleve']!=''){
        $query.=" AND (UCASE(Prenom_Eleve) LIKE '%".strtoupper($_GET['Eleve'])."%' OR UCASE(Nom_Eleve) LIKE '%".strtoupper($_GET['Eleve'])."%' OR UCASE(Pnom_Eleve) LIKE '%".strtoupper($_GET['Eleve'])."%')";
    }
    $query.=" AND inscription.Date_Enreg like '".date("Y-m-d")."%' ORDER BY Nom_Eleve, Pnom_Eleve";
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
    $liste_ecole=$pdo->query("SELECT * FROM etablissement ORDER BY Design_Etablissement");
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
    <title>Inscriptions | <?php echo $app_infos['Design_App']; ?></title>
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

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" style="overflow: hidden;">
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
            <input type="hidden" name="ID_Enseignant" id="ID_Enseignant">
            <input type="hidden" name="ID_Etab" id="ID_Etab" value="<?php if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){echo $_GET['Ecole']; } ?>">
            <input type="hidden" name="Enseignant" id="Enseignant" value="<?php if(isset($_GET['Enseignant']) && $_GET['Enseignant']!=''){echo $_GET['Enseignant']; } ?>">
                <!-- <div class="col-md-12 col-lg-12"> -->
                    <!-- <div class="panel panel-default"> -->
                        <!-- <div class="panel-body"> -->
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Noms</th>
                                        <th>Sexe</th>
                                        <th>Classe</th>
                                        <th>Catégorie</th>
                                        <th>Date d'inscription</th>
                                    </tr>
                                </thead>
                                <tbody id="MaTable">
    <?php while($selections=$selection->fetch()){$Nbr++; ?>
        <tr class="odd gradeX" style="background: transparent;">
            <td style="width: 80px; "><center><?php echo sprintf('%02d', $Nbr); ?></center></td>
            <td><!-- <center> --><?php echo strtoupper(stripslashes($selections['Nom_Eleve'].' '.$selections['Pnom_Eleve'].' '.$selections['Prenom_Eleve'])); ?></td>
            <td><!-- <center> --><?php if($selections['Sexe']=='M'){echo 'Masculin';}else{echo 'Féminin';} ?></td>
            <td><!-- <center> --><?php echo strtoupper($selections['Design_Classe']); ?></td>
            <td><!-- <center> --><?php echo strtoupper($selections['Design_Categorie']); ?></td>
            <td><!-- <center> --><?php echo date('d/m/Y H:i:s', strtotime($selections['mydate'])); ?></td>
        </tr>
    <?php } ?>
</tbody>
                            </table>
                            <div class="d-flex mt-4">
              <ul class="pagination ms-auto">
                                <?php 
                                if($pageCourante>1){
                                    $page=$pageCourante-1;
                                    echo '<li class="page-item"><a class="page-link" href="table_inscription.php?page='.$page.'&Ecole='.$_GET['Ecole'].'&Annee='.$_GET['Annee'].'&Classe='.$_GET['Classe'].'&Eleve='.$_GET['Eleve'].'"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>Previous</a></li>';
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
                                        echo '<li class="page-item"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="table_inscription.php?page='.$pageNexte.'&Ecole='.$_GET['Ecole'].'&Annee='.$_GET['Annee'].'&Classe='.$_GET['Classe'].'&Eleve='.$_GET['Eleve'].'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="table_inscription.php?page='.$pageTrois.'&Ecole='.$_GET['Ecole'].'&Annee='.$_GET['Annee'].'&Classe='.$_GET['Classe'].'&Eleve='.$_GET['Eleve'].'">'.$pageTrois.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    }else if($pageCourante==2){
                                        echo '<li class="page-item"><a class="page-link" href="table_inscription.php?page='.$pagePrecedente.'&Ecole='.$_GET['Ecole'].'&Annee='.$_GET['Annee'].'&Classe='.$_GET['Classe'].'&Eleve='.$_GET['Eleve'].'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_inscription.php?page='.$pageNexte.'&Ecole='.$_GET['Ecole'].'&Annee='.$_GET['Annee'].'&Classe='.$_GET['Classe'].'&Eleve='.$_GET['Eleve'].'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    }else if($pageCourante==$pagesAvantTotales){
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_inscription.php?page='.$pagePrecedente.'&Ecole='.$_GET['Ecole'].'&Annee='.$_GET['Annee'].'&Classe='.$_GET['Classe'].'&Eleve='.$_GET['Eleve'].'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_inscription.php?page='.$pageNexte.'&Ecole='.$_GET['Ecole'].'&Annee='.$_GET['Annee'].'&Classe='.$_GET['Classe'].'&Eleve='.$_GET['Eleve'].'">'.$pageNexte.'</a></li>';
                                    }else if($pageCourante==$pagesTotales){
                                            echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_inscription.php?page='.$pageAvantPrecedente.'&Ecole='.$_GET['Ecole'].'&Annee='.$_GET['Annee'].'&Classe='.$_GET['Classe'].'&Eleve='.$_GET['Eleve'].'">'.$pageAvantPrecedente.'</a></li><li class="page-item"><a class="page-link" href="table_inscription.php?page='.$pagePrecedente.'&Ecole='.$_GET['Ecole'].'&Annee='.$_GET['Annee'].'&Classe='.$_GET['Classe'].'&Eleve='.$_GET['Eleve'].'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li>';
                                    }else{
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_inscription.php?page='.$pagePrecedente.'&Ecole='.$_GET['Ecole'].'&Annee='.$_GET['Annee'].'&Classe='.$_GET['Classe'].'&Eleve='.$_GET['Eleve'].'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_inscription.php?page='.$pageNexte.'&Ecole='.$_GET['Ecole'].'&Annee='.$_GET['Annee'].'&Classe='.$_GET['Classe'].'&Eleve='.$_GET['Eleve'].'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>'; 
                                    }
                                }else{
                                    for ($i=1; $i <= $pagesTotales ; $i++) { 
                                        if ($i==$pageCourante) {
                                            echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                                        }else{
                                            echo '<li class="page-item"><a class="page-link" href="table_inscription.php?page='.$i.'&Ecole='.$_GET['Ecole'].'&Annee='.$_GET['Annee'].'&Classe='.$_GET['Classe'].'&Eleve='.$_GET['Eleve'].'">'.$i.'</a></li>';
                                        }
                                    } 
                                }
                                if($pagesTotales>$pageCourante){
                                    $page=$pageCourante+1;
                                    echo '<li class="page-item"><a class="page-link" href="table_inscription.php?page='.$page.'&Ecole='.$_GET['Ecole'].'&Annee='.$_GET['Annee'].'&Classe='.$_GET['Classe'].'&Eleve='.$_GET['Eleve'].'">Next<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg></a></li>';
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
                    <h4 class="modal-title">Modification d'un(e) enseignant(e)</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok" type="hidden" name="tok" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="row">
                        <div class="col-6" style="<?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'display: none';} ?>">
                            <div class="col-lg-12">Ecole *</div>
                            <select name="liste_ecole" class="form-control" id="liste_ecole" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ echo 'disabled';} ?>>
                                <option value="">--</option>
                                <?php while($liste_ecoles=$liste_ecole->fetch()){ ?>
                                <option value="<?php echo($liste_ecoles['ID_Etablissement']) ?>" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1 && $liste_ecoles['ID_Etablissement']==$_SESSION['user_eteelo_app']['ID_Etablissement']){ echo 'selected';} ?>><?php echo(stripslashes($liste_ecoles['Design_Etablissement'])) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <div class="col-lg-12">Nom *</div>
                            <div class="col-lg-12"><input type="text" name="nom_ens" id="nom_ens" class="form-control" style="margin-top: 1%;" value="" required></div>
                        </div>
                        <div class="col-6">
                            <div class="col-lg-12">Post-nom </div>
                            <div class="col-lg-12"><input type="text" name="pnom_ens" id="pnom_ens" class="form-control" style="margin-top: 1%;" value=""></div>
                        </div>
                        <div class="col-6">
                            <div class="col-lg-12">Prénom *</div>
                            <div class="col-lg-12"><input type="text" name="prenom_ens" id="prenom_ens" class="form-control" style="margin-top: 1%;" value="" required></div>
                        </div>
                        <div class="col-6">
                            <div class="col-lg-12">Sexe *</div>
                            <select name="sexe" class="form-control" id="sexe">
                                <option value="">--</option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <div class="col-lg-12">Téléphone </div>
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="afficher_code" style="border-top-right-radius: 0; border-bottom-right-radius: 0; border-right: none; margin-top: 2px;">243</span>
                                    </div>
                                    <input type="text" name="telephone" id="telephone" class="form-control" style="margin-top: 1%;" value="">
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
        $("#ModalMod").modal('hide');
  }
  function Function_Modifier(a, b, c, d, e, f, g){
      $("#ModalMod").modal('show');
      $('#ID_Enseignant').val(a);
      $('#liste_ecole').val(b);
      $('#nom_ens').val(c);
      $('#pnom_ens').val(d);
      $('#prenom_ens').val(e);
      $('#sexe').val(f);
      $('#telephone').val(g);
      $('#nom_ens').focus();
  }

  $('#sexe').change(function(){
        if($('#sexe').val()!=''){
            $('#telephone').focus();
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
        if($('#nom_ens').val()=='' || $('#liste_ecole').val()=='' || $('#prenom_ens').val()=='' || $('#sexe').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!');
                $('#Design').focus();
        }else{
                $.ajax({
                        url:'edit_enseignant.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {Nom:$('#nom_ens').val(), Pnom:$('#pnom_ens').val(), Prenom:$('#prenom_ens').val(), Sexe:$('#sexe').val(), Tel:$('#telephone').val(), token:$('#tok').val(), ID_Enseignant:$('#ID_Enseignant').val()},
                        success:function(ret){
                            if(ret==1){
                                alertify.success("L'opération a réussi");
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Modification éffectuée'
                                })
                                window.location.replace('table_inscription.php?Ecole='+$('#ID_Etab').val()+"&Enseignant="+$('#Enseignant').val());
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